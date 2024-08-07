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
        $response = Bus::dispatchNow(new BulkCsvDataUpload($filePath));
        if ($response === "CSV data processed successfully.") {
            return redirect('qrcodes')->with('status', $response);
        } else {
            return redirect('qrcodes')->with('status', $response);
        }
        return redirect('qrcodes')->with('status', 'CSV data has been queued for processing.');
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
        if ($request->option == 'generate_by_serial') {
            if (empty($request->starting_code)) {
                return redirect()->back()->with('error', 'Starting code empty aborting data insertion into database');
            }
            $data['starting_code'] = $request->starting_code;
            $data['quantity'] = $request->quantity;
            $data['baseurl'] = $baseUrl;
            $response = Bus::dispatchNow(new QrUploadBySerial($data));
            if ($response === "Data processed successfully.") {
                return redirect('qrcodes')->with('status', $response);
            } else {
                return redirect('qrcodes')->with('error', $response);
            }
        } else {
            $characters = 'abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ0123456789';
            $codeLength = 16;

            for ($i = 0; $i < $request->quantity; $i++) {
                $qrCodeNumber = '';
                for ($j = 0; $j < $codeLength; $j++) {
                    $qrCodeNumber .= $characters[rand(0, strlen($characters) - 1)];
                }
                Qrcode::create([
                    'qr_code' => $qrCodeNumber,
                    'code_data' => $qrCodeNumber,
                    'url' => $baseUrl . '/' . $qrCodeNumber
                ]);
            }
        }


        return redirect('qrcodes')->with('status', 'Data has been queued for processing.');
    }

    public function bulkassign(Request $request)
    {
        if (!empty($request->start_code)) {
            $check_serial = Qrcode::where('code_data', $request->start_code)->first();

            if (!$check_serial) {
                return response()->json(['startcodeerror' => 'Code not Found']);
            }
            $check_serial_inactive = Qrcode::where('code_data', $request->start_code)->where('status', 'Active')->first();
            if (!empty($check_serial_inactive)) {
                return response()->json(['startcodeerror' => 'Code is already associated and active. Please deactivate and then assign.']);
            }
            $first_code_id = Qrcode::select('id')->where('code_data', $request->start_code)->first();
            $id_to_start = $first_code_id->id;
            if ($id_to_start) {
                $quantity = (int)$request->quantity;
                $id_to_end = $id_to_start + $quantity;
                $qr_code_number = $this->generateUniqueQRCodeNumber();
                Qrcode::whereBetween('id', [$id_to_start, $id_to_end])
                ->update([
                    'product_id' => $request->product_id,
                    'batch_id' => $request->batch_id
                ]);
            $all_data = Qrcode::where('code_data', $request->start_code)
                ->with(['product.batches'])
                ->first();
                $baseUrl = $all_data->product->web_url ?? "";
                $expDate = date('ymd', strtotime($all_data->batch->exp_date));
                for ($i = $id_to_start; $i < $id_to_end; $i++) {
                    $qrcode = Qrcode::where('id', $i)->select('code_data')->first();
                    if (!empty($qrcode->code_data)) {
                        $gslink = $baseUrl . '/01/' . $qrcode->code_data;
                    }
                    // else{
                    //     $gslink = $baseUrl . '/01';
                    // }

                    // Apply specific logic based on the generate_gs1_link_with value
                    if ($request->gs1_link == 'yes') {
                        if (empty($all_data->product->gtin)) {
                            return response()->json(['status' => 'GTIN number not provided while creating product']);
                        }
                        if ($request->generate_gs1_link_with == 'batch') {
                            $gslink = $baseUrl . '/01/' . $all_data->product->gtin . '/10/' .'?17=' . $expDate;
                        } elseif ($request->generate_gs1_link_with == 'serial_no') {
                            $gslink = $baseUrl . '/01/' . $all_data->product->gtin . '/10/' .'21/' .'?17=' . $expDate;
                        }
                    }

                    // Update the QR code in the database
                    Qrcode::where('id', $i)
                        ->update([
                            'url' => $gslink,
                            'product_id' => $request->product_id,
                            'batch_id' => $request->batch_id,
                        ]);
                }



                return response()->json(['status' => 'Status updated successfully'], 200);
            } else {
                return response()->json(['status' => 'Invalid or missing start_code or quantity'], 400);
            }
        } else {
            return response()->json(['status' => 'Invalid or missing start_code or quantity'], 400);
        }
    }
    private function generateUniqueQRCodeNumber()
    {
        $characters = 'abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ0123456789';
        $codeLength = 16;
        $qrCodeNumber = '';
        for ($i = 0; $i < $codeLength; $i++) {
            $qrCodeNumber .= $characters[rand(0, strlen($characters) - 1)];
        }

        return $qrCodeNumber;
    }
}
