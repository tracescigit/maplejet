<?php

namespace App\Jobs;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Queue\SerializesModels;
use App\Models\Qrcode;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Str;

class QrUploadByRandom implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;

    protected $quantity;
    protected $baseUrl;

    public function __construct($quantity, $baseUrl)
    {
        $this->quantity = $quantity;
        $this->baseUrl = $baseUrl;
    }
 
    public function handle(): void
    {
        set_time_limit(0); // Remove the time limit

        Log::info('QrUploadByRandom job started.');

        $batchSize = 1000; // Adjust based on your system's performance
        $totalGenerated = 0;
        $codeLength = 16;
        $characters = 'abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ0123456789';

        try {
            while ($totalGenerated < $this->quantity) {
                $currentBatchSize = min($batchSize, $this->quantity - $totalGenerated);

                // Generate a pool of unique codes
                $uniqueCodes = $this->generateUniqueQRCodeNumbers($currentBatchSize, $characters, $codeLength);

                if (empty($uniqueCodes)) {
                    Log::warning('No unique QR codes generated.');
                    break;
                }

                // Prepare data for bulk insert
                $codesToInsert = array_map(function ($code) {
                    return [
                        'qr_code' => $code,
                        'code_data' => $code,
                        'url' => $this->baseUrl . '/' . $code
                    ];
                }, $uniqueCodes);

                // Insert codes into the database
                DB::transaction(function () use ($codesToInsert) {
                    Qrcode::insert($codesToInsert);
                });

                $totalGenerated += $currentBatchSize;
            }

            Log::info('QrUploadByRandom job completed successfully.');
        } catch (\Exception $e) {
            Log::error('Error in QrUploadByRandom job: ' . $e->getMessage());
        }
    }

    private function generateUniqueQRCodeNumbers($quantity, $characters, $codeLength)
    {
        $uniqueCodes = [];
        $maxAttempts = 10000; // Limit attempts to prevent infinite loops
        $attempts = 0;

        // Generate the required number of unique codes
        while (count($uniqueCodes) < $quantity && $attempts < $maxAttempts) {
            $codesToGenerate = $quantity - count($uniqueCodes);
            $newCodes = $this->generateQRCodeBatch($codesToGenerate, $characters, $codeLength);

            // Check for duplicates
            $existingCodes = Qrcode::whereIn('qr_code', $newCodes)->pluck('qr_code')->toArray();
            $newUniqueCodes = array_diff($newCodes, $existingCodes);

            $uniqueCodes = array_merge($uniqueCodes, $newUniqueCodes);

            $attempts++;
        }

        if ($attempts >= $maxAttempts) {
            Log::warning('Max attempts reached while generating unique QR codes.');
        }

        return $uniqueCodes;
    }

    private function generateQRCodeBatch($quantity, $characters, $codeLength)
    {
        $codes = [];
        $charactersLength = strlen($characters) - 1;

        while (count($codes) < $quantity) {
            $qrCodeNumber = '';
            for ($i = 0; $i < $codeLength; $i++) {
                $qrCodeNumber .= $characters[random_int(0, $charactersLength)];
            }

            if (!in_array($qrCodeNumber, $codes)) {
                $codes[] = $qrCodeNumber;
            }
        }

        return $codes;
    }
}
