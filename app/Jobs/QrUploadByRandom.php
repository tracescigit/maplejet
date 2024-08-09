<?php

namespace App\Jobs;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Queue\SerializesModels;
use App\Models\Qrcode;
use Illuminate\Support\Facades\Log;
class QrUploadByRandom implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;

    /**
     * Create a new job instance.
     */
    protected $quantity;
    protected $baseUrl;

    public function __construct($quantity,$baseUrl)
    {
        $this->quantity=$quantity;
        $this->baseUrl=$baseUrl;
    }

    /**
     * Execute the job.
     */
    public function handle(): void
    {
        set_time_limit(0); // Remove the time limit
    
        Log::info('QrUploadByRandom job started.');
    
        $batchSize = 1000; // Define a reasonable batch size
        $totalGenerated = 0;
        $characters = 'abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ0123456789';
        $codeLength = 16;
    
        try {
            while ($totalGenerated < $this->quantity) {
                $currentBatchSize = min($batchSize, $this->quantity - $totalGenerated);
                $codesToInsert = [];
                for ($i = 0; $i < $currentBatchSize; $i++) {
                    $qrCodeNumber = '';
                    for ($j = 0; $j < $codeLength; $j++) {
                        $qr_code_number = $this->generateUniqueQRCodeNumber();
                    }
                    $codesToInsert[] = [
                        'qr_code' => $qrCodeNumber,
                        'code_data' => $qrCodeNumber,
                        'url' => $this->baseUrl . '/' . $qrCodeNumber
                    ];
                }
    
                // Insert QR codes within a transaction
                Qrcode::insert($codesToInsert);
    
                $totalGenerated += $currentBatchSize; // Update the total generated count
            }
    
            Log::info('QrUploadByRandom job completed successfully.');
        } catch (\Exception $e) {
            Log::error('Error in QrUploadByRandom job: ' . $e->getMessage());
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
