<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Laravel\Ui\Presets\React;
use App\Jobs\BulkCsvDataUpload;
use App\Jobs\QrUploadBySerial;
use App\Models\Product;
use App\Models\Batch;
use App\Models\Qrcode;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Bus;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Validator;
use App\Jobs\QrUploadByRandom;
use App\Jobs\BulkAssignQrcodes;
use App\Events\DispatchQrUploadBySerial;
use App\Events\QrUploadRequested;

class BulkUploadController extends Controller
{
    public function index()
    {
        $products = Product::get();
        $batches = Batch::get();
        return view('bulk-uploads.index', compact('products', 'batches'));
    }
    public function store(Request $request)
    {
        $filePath = $request->file('file')->store('csv_files');
        BulkCsvDataUpload::dispatch($filePath);
        return redirect('qrcodes')->with('status', 'CSV data is being processed.');
    }
    public function store_serial_no(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'starting_code' => 'nullable|numeric|digits_between:7,21',
            'quantity' => 'required|numeric|min:1',
        ]);
    
        if ($validator->fails()) {
            return redirect()->back()->withErrors($validator)->withInput();
        }
    
        $baseUrl = url('/');
        $data = [
            'quantity' => $request->quantity,
            'baseurl' => $baseUrl
        ];
    
        if ($request->option == 'generate_by_serial') {
            if (empty($request->starting_code)) {
                return redirect()->route('qrcodes')->with('error', 'Starting code is empty. Aborting data insertion into database.');
            }
            $data['starting_code'] = $request->starting_code;
            event(new DispatchQrUploadBySerial($data));
            $statusMessage = 'Data has been queued for processing by serial.';
        } else {
            QrUploadByRandom::dispatch($request->quantity, $baseUrl);
            $statusMessage = 'Data has been queued for processing by random.';
        }
    
        return redirect()->route('qrcodes.index')->with('status', $statusMessage);
    }
    



    public function bulkassign(Request $request)
    {
        $startCode = $request->start_code;
        $quantity = (int)$request->quantity;
        $productId = $request->product_id;
        $batchId = $request->batch_id;
        $generateGs1LinkWith = $request->generate_gs1_link_with;
        $gs1Link = $request->gs1_link;
        // Validation
        if (empty($startCode) || $quantity <= 0 || empty($productId) || empty($batchId)) {
            return response()->json(['status' => 'Invalid or missing start_code, quantity, product_id, or batch_id'], 400);
        }

        $checkSerial = Qrcode::where('code_data', $startCode)->first();
        if (!$checkSerial) {
            return response()->json(['startcodeerror' => 'Code not Found']);
        }

        $checkSerialInactive = Qrcode::where('code_data', $startCode)->where('status', 'Active')->first();
        if ($checkSerialInactive) {
            return response()->json(['startcodeerror' => 'Code is already associated and active. Please deactivate and then assign.']);
        }
      
        dispatch(new BulkAssignQrcodes($startCode, $quantity, $productId, $batchId, $generateGs1LinkWith, $gs1Link));

        return response()->json(['status' => 'Job dispatched for processing'], 200);
    }
}
