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
        $qr_to_start = $this->data['starting_code'];
        $qr_to_end = $this->data['starting_code'] + $this->data['quantity'];
        for ($i = $qr_to_start; $i < $qr_to_end; $i++) {
            if (Qrcode::where('code_data', $i)->exists()) {
                return "Error: Duplicate data found for code: $i. Aborting data insertion into the database.";
            }
        }
        for ($i = $qr_to_start; $i < $qr_to_end; $i++) {
            $qr_code_number = $this->generateUniqueQRCodeNumber();
            Qrcode::create([
                'qr_code' => $qr_code_number,
                'code_data' => $i,
                'url' => $this->data['baseurl'] . '/' .$qr_code_number
            ]);
        }

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
