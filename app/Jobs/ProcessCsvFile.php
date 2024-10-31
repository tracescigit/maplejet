<?php

namespace App\Jobs;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Queue\SerializesModels;
use Illuminate\Support\Facades\Storage;
use App\Models\Qrcode;
use App\Models\Product;
use Illuminate\Support\Facades\Log;
use App\Events\CsvProcessingCompleted;
use App\Events\CsvProcessingFailed;

class ProcessCsvFile implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;

    protected $filePath;
    protected $product_id;
    protected $batch_id;
    protected $gs_link;
    protected $link;

    public function __construct($filePath, $product_id, $batch_id, $gs_link, $link)
    {
        $this->filePath = $filePath;
        $this->product_id = $product_id;
        $this->batch_id = $batch_id;
        $this->gs_link = $gs_link;
        $this->link = $link;
    }

    public function handle()
    {
        Log::info('ProcessCsvFile job started.');

        try {
            $file = Storage::disk('local')->get($this->filePath);
            $rows = explode("\n", $file);
            array_shift($rows); // Remove header row

            $batchSize = 1000; // Define the batch size
            $currentBatch = [];
            $allValid = true;

            foreach ($rows as $row) {
                $data = str_getcsv(trim($row));

                if (!empty($row) && !empty($data)) {
                    // Validation
                    if (!$this->isAlphanumeric($data[0])) {
                        $allValid = false;
                        break;
                    }
                    if (Qrcode::where('code_data', $data[0])->where('product_id',$this->product_id)->exists()) {
                        Log::error("Error: Duplicate data found for code: $data[0]. Aborting data insertion.");
                        event(new CsvProcessingFailed("Error: Duplicate data found for code: $data[0]. Aborting data insertion."));
                        return;
                    }

                    // Collect valid rows for batch insertion
                    $qr_code_number = $this->generateUniqueQRCodeNumber();
                    $productName = Product::select('name')->where('id', $this->product_id)->first()->name;
                    $qr_code_url = $this->link . "/01/{$productName}/10/{$qr_code_number}";

                    $currentBatch[] = [
                        'url' => $qr_code_url,
                        'qr_code' => $qr_code_number,
                        'code_data' => $data[0],
                        'product_id' => $this->product_id,
                        'batch_id' => $this->batch_id,
                        'gs1_link' => $this->gs_link,
                    ];

                    // Insert data in batches
                    if (count($currentBatch) >= $batchSize) {
                        Qrcode::insert($currentBatch);
                        $currentBatch = []; // Clear the batch
                    }
                }
            }

            // Insert any remaining data in the final batch
            if (!empty($currentBatch)) {
                Qrcode::insert($currentBatch);
            }

            if (!$allValid) {
                Log::error("Error: Data contains invalid characters. Aborting data insertion.");
                event(new CsvProcessingFailed("Error: Data contains invalid characters. Aborting data insertion."));
                return;
            }

            Log::info('ProcessCsvFile job completed successfully.');
            event(new CsvProcessingCompleted("CSV data processed successfully."));
        } catch (\Exception $e) {
            Log::error('Error processing CSV file: ' . $e->getMessage());
            event(new CsvProcessingFailed('Error processing CSV file: ' . $e->getMessage()));
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

    private function isAlphanumeric($str)
    {
        return preg_match('/^[a-zA-Z0-9]+$/', $str);
    }
}
