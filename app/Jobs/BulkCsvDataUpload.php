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

class BulkCsvDataUpload implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;

    /**
     * Create a new job instance.
     */
    protected $filePath;

    public function __construct($filePath)
    {
        $this->filePath = $filePath;
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
                    Qrcode::create([
                        'qr_code' => $qr_code_number,
                        'code_data' => $data[0],
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
        return preg_match('/^[a-zA-Z0-9.+-]+(?:[eE][0-9]+)?$/', $str);
    }
}
