<?php

namespace App\Jobs;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Queue\SerializesModels;
use Illuminate\Support\Facades\Storage;
use App\Models\Qrcode;
use Illuminate\Support\Facades\Log;
use App\Events\CsvProcessingCompleted;
use App\Events\CsvProcessingFailed;

class BulkCsvDataUpload implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;

    protected $filePath;

    public function __construct($filePath)
    {
        $this->filePath = $filePath;
    }

    public function handle()
    {
        Log::info('BulkCsvDataUpload job started.');
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
                    if (!$this->isAlphanumeric($data[0])) {
                        $allValid = false;
                        break;
                    }
                    if (Qrcode::where('code_data', $data[0])->exists()) {
                        event(new CsvProcessingFailed("Error: Duplicate data found for code: $data[0]. Aborting data insertion into the database."));
                        return;
                    }

                    // Prepare data for batch insertion
                    $qr_code_number = $this->generateUniqueQRCodeNumber();
                    $currentBatch[] = [
                        'qr_code' => $qr_code_number,
                        'code_data' => $data[0],
                        'created_at' => now(),
                        'updated_at' => now(),
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
                event(new CsvProcessingFailed("Error: Data contains invalid characters. Aborting data insertion into the database."));
                return;
            }

            Log::info('BulkCsvDataUpload job completed successfully.');
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
