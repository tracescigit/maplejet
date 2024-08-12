<?php

namespace App\Jobs;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Queue\SerializesModels;
use Illuminate\Support\Facades\Storage;
use App\Models\Qrcode;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;

class QrUploadBySerial implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;

    /**
     * Create a new job instance.
     */
    protected $data;

    public function __construct($data)
    {
        $this->data = $data;
    }

    /**
     * Execute the job.
     */
    // public function handle(): void
    // {
    //     try {
    //         $file = Storage::disk('local')->get($this->filePath);
    //         $rows = explode("\n", $file);
    //         array_shift($rows);

    //         DB::beginTransaction();

    //         foreach ($rows as $row) {
    //             $data = str_getcsv(trim($row));
    //             if (!empty($row) && !empty($data)) {
    //                 Qrcode::create([
    //                     'code_data' => $data[0],
    //                 ]);
    //             }
    //         }

    //         DB::commit();
    //     } catch (\Exception $e) {
    //         // Handle any exceptions, log them, and rollback the transaction
    //         DB::rollBack();
    //         Log::error('Error processing CSV file: ' . $e->getMessage());
    //     }
    // }
    public function handle()
    {
        set_time_limit(0);
        Log::info('QrUploadBySerial job started.');
        $qr_to_start = $this->data['starting_code'];
        $qr_to_end = $this->data['starting_code'] + $this->data['quantity'];
    
        $batchSize = 1000; // Define a reasonable batch size
        $current = $qr_to_start;
    
        while ($current < $qr_to_end) {
            $batchEnd = min($current + $batchSize, $qr_to_end);
    
            // Check for duplicates in the current batch
            if (Qrcode::whereBetween('code_data', [$current, $batchEnd - 1])->exists()) {
                Log::error('Error in QrUploadBySerial job: Duplicate data found.');
                return "Error: Duplicate data found. Aborting data insertion.";
            }
    
            // Generate and insert QR codes
            $codesToInsert = [];
            for ($i = $current; $i < $batchEnd; $i++) {
                $qr_code_number = $this->generateUniqueQRCodeNumber();
                $codesToInsert[] = [
                    'qr_code' => $qr_code_number,
                    'code_data' => $i,
                    'url' => $this->data['baseurl'] . '/' .$qr_code_number
                ];
            }
            Log::info('Inserting QR codes: ' . json_encode($codesToInsert));
            Qrcode::insert($codesToInsert);
    
            $current = $batchEnd; // Move to the next batch
        }
    
        Log::info('QrUploadBySerial job completed successfully.');
        return "Data processed successfully.";
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
