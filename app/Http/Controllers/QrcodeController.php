<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Batch;
use App\Models\Product;
use App\Models\Qrcode;
use App\Jobs\ProcessCsvFile;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Bus;
use Illuminate\Support\Facades\Auth;
use App\Jobs\ExportDataToCSV;
use App\Models\SystemAlert;
use Illuminate\Support\Facades\Cache;
class QrcodeController extends Controller
{
    public function index(Request $request)
    {
        $query = Qrcode::query()->with('product', 'batch');

        // Apply filters
        if ($request->products_search) {
            $query->whereHas('product', function ($q) use ($request) {
                $q->where('name', 'like', '%' . $request->product_search . '%');
            });
        }

        if ($request->qrcode_search) {
            $query->where('code_data', 'like', '%' . $request->qrcode_search . '%');
        }

        if ($request->products_assigned) {
            $query->whereNotNull('product_id');
        }

        // Apply pagination
        $qrdatas = $query->paginate(10);
        $qr_count = Qrcode::count();

        $qractiveCount = $qrdatas->filter(function ($product) {
            return $product->status === 'Active';
        })->count();
        $last_added_product = Qrcode::select('code_data')
        ->orderBy('created_at', 'desc')
        ->orderBy('id', 'desc')
        ->first();
        // $qrdatas = $qrdata->paginate(10);
        return view('qrcodes.index', compact('qrdatas','qr_count','last_added_product','qractiveCount'));
    }

    public function create()
    {
        if (!Auth::user()->can('create qrcode')) {
            return view('dummy.unauthorized');
        }
        $products = Product::where('status', 'Active')->get();
        $batches = Batch::get();
        return view('qrcodes.create', compact('products', 'batches'));
    }
    public function store(Request $request)
    {
        $request->validate([
            'product_id' => 'required|numeric',
            'batch' => 'required|numeric',
            'file' => 'required',
            'gs_link' => 'required|string'
        ]);
        $batch = Batch::findOrFail($request->batch);
        $filePath = $request->file('file')->store('csv_files');
        $products = Product::select('web_url')->where('id',$request->product_id)->first();
        $link=$products->web_url;
        ProcessCsvFile::dispatch($filePath, $request->product_id, $request->batch, $request->gs_link,$link)->onQueue('bulk_uploads_product');
        return redirect('qrcodes')->with('status', 'CSV data is being processed.');
    }
    public function edit(Batch $batch)
    {
        $products = Product::get();

        return view('qrcodes.edit', compact('batch', 'products'));
    }
    public function update(Request $request, $id)
    {
        $qrcode = Qrcode::findOrFail($id);
        $qrcode->update([
            'status' => $request->status_to_change,
        ]);
    
        return response()->json(['success' => true, 'message' => 'Qrcode updated successfully']);
    }
    
    public function destroy($id)
    {
        // $batch = Batch::find($id);
        // $batch->delete();
        // return redirect('qrcodes')->with('status', 'Batch Deleted Successfully');
    }
    public function bulkstatuschange(Request $request)
    {
        

        if (!empty($request->start_code)) {
            $id_to_start = Qrcode::where('code_data', $request->start_code)->pluck('id')->first();
            if (!empty($id_to_start)) {
                $quantity = (int)$request->quantity;
                $id_to_end = $id_to_start + $quantity - 1;
                if ($request->action == 'active') {
                    $product_associated=Qrcode::whereBetween('id', [$id_to_start, $id_to_end])
                    ->whereNull('product_id')->first();
                    if($product_associated){
                        return response()->json(['producterror' => 'Code is not associated with product. Kindly associated code data with product']);
                    }
                    Qrcode::whereBetween('id', [$id_to_start, $id_to_end])
                        ->whereNotNull('product_id')
                        ->update(['status' => 'Active']);
                }
                if ($request->action == 'inactive') {
                    Qrcode::whereBetween('id', [$id_to_start, $id_to_end])
                        ->whereNotNull('product_id')
                        ->update(['status' => 'Inactive']);
                }
                if ($request->action == 'Export') {
                    $randomString = uniqid(); // Generates a unique ID based on the current timestamp
                $fileName = 'export_' . $id_to_start . '_' . $randomString . '.csv';
                
                // Dispatch job for exporting data to CSV
                ExportDataToCSV::dispatch($id_to_start, $id_to_end, $fileName);
                
                // Return response with file name
                return response()->json(['success' => true, 'filename' => $fileName]);
                }

            } else {
                return response()->json(['status' => 'Invalid or missing start_code or quantity']);
            }

            return response()->json(['status' => 'Status updated successfully'], 200);
        } else {
            return response()->json(['status' => 'Invalid or missing start_code or quantity']);
        }
    }
    public function systemalerts()
    {
        $systemalerts = SystemAlert::with('batches')->orderBy('created_at', 'desc')->paginate(10);

    // Pass the paginated results to the view
    return view('qrcodes.systemalert', compact('systemalerts'));
    }
    public function downloadStatus()
    {
        $fileLink = Cache::get('userlog_download_link');
    
        if ($fileLink) {
            return response()->json(['file_link' => $fileLink]);
        }
    
        return response()->json(['message' => 'File not yet available.'], 404);
    }
}
