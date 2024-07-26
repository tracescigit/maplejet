<?php

namespace App\Jobs;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Queue\SerializesModels;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Storage;
use App\Models\Qrcode;
use App\Models\Product;
use Illuminate\Support\Facades\Log;

class ProcessCsvFile implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;

    protected $filePath;
    protected $product_id;
    protected $batch_id;
    protected $gs_link;
    protected $invalidRows = [];
    protected $validData = [];
    public function __construct($filePath, $product_id, $batch_id, $gs_link)
    {
        $this->filePath = $filePath;
        $this->product_id = $product_id;
        $this->batch_id = $batch_id;
        $this->gs_link = $gs_link;
    }

    public function handle()
    {
        $file = Storage::disk('local')->get($this->filePath);
        $rows = explode("\n", $file);
        array_shift($rows);
    
        $allValid = true;
    
        foreach ($rows as $row) {
            $data = str_getcsv(trim($row));
            if (!empty($row) && !empty($data)) {
                if (!$this->isAlphanumeric($data[0])) {
                    $allValid = false;
                    break;
                }
                if (Qrcode::where('code_data', $data[0])->exists()) {
                    return "Error: Duplicate data found for code: $data[0]. Aborting data insertion into the database.";
                }
            }
        }
        if (!$allValid) {
            return "Error: Data contains invalid characters. Aborting data insertion into the database.";
        }
    
        foreach ($rows as $row) {
            $data = str_getcsv(trim($row));
            if (!empty($row) && !empty($data)) {
                $qr_code_number = $this->generateUniqueQRCodeNumber();
                $productName = Product::select('name')->where('id', $this->product_id)->first()->name;
                $qr_code_url = config('constants.base_url')."01/{$productName}/10/{$qr_code_number}";
                Qrcode::create([
                    'url' => $qr_code_url,
                    'qr_code' => $qr_code_number,
                    'code_data' => $data[0],
                    'product_id' => $this->product_id,
                    'batch_id' => $this->batch_id,
                    'gs1_link' => $this->gs_link,
                ]);
            }
        }
    
        return "CSV data processed successfully.";
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
    private function isAlphanumeric($str)
    {
        return preg_match('/^[a-zA-Z0-9]+$/', $str);
    }
}
