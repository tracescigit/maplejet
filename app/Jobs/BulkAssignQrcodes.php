<?php

namespace App\Jobs;

use App\Models\Qrcode;
use App\Models\Batch;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Queue\SerializesModels;
use Illuminate\Support\Facades\Log;

class BulkAssignQrcodes implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;

    protected $startCode;
    protected $quantity;
    protected $productId;
    protected $batchId;
    protected $generateGs1LinkWith;
    protected $gs1Link;

    public function __construct($startCode, $quantity, $productId, $batchId, $generateGs1LinkWith, $gs1Link)
    {
        $this->startCode = $startCode;
        $this->quantity = $quantity;
        $this->productId = $productId;
        $this->batchId = $batchId;
        $this->generateGs1LinkWith = $generateGs1LinkWith;
        $this->gs1Link = $gs1Link;
    }

    public function handle()
    {
        Log::info('BulkAssignQrcodes job started.');

        try {
            $firstCode = Qrcode::where('code_data', $this->startCode)
                ->with('batch') // Eager load the batch relationship
                ->first();
            if (!$firstCode) {
                Log::error('Start code not found.');
                return;
            }
            $batch_all = Batch::where('id', $this->batchId)
            ->first();
            $idToStart = $firstCode->id;
            $idToEnd = $idToStart + $this->quantity;

            $baseUrl = $firstCode->product->web_url ?? "";
            $baseUrl = rtrim($baseUrl, '/');
            $expDate = date('ymd', strtotime($batch_all->exp_date));

            Qrcode::whereBetween('id', [$idToStart, $idToEnd])
                ->chunk(1000, function ($qrcodes) use ($baseUrl, $expDate) {
                    foreach ($qrcodes as $qrcode) {
                        $gslink = $this->generateGs1Link($qrcode, $baseUrl, $expDate);

                        $qrcode->update([
                            'url' => $gslink,
                            'product_id' => $this->productId,
                            'batch_id' => $this->batchId,
                        ]);
                    }
                });

            Log::info('BulkAssignQrcodes job completed successfully.');
        } catch (\Exception $e) {
            Log::error('Error processing QR codes: ' . $e->getMessage());
        }
    }

    private function generateGs1Link($qrcode, $baseUrl, $expDate)
    {
        if ($this->gs1Link == 'yes') {
            if (empty($qrcode->product->gtin)) {
                throw new \Exception('GTIN number not provided while creating product');
            }

            if ($this->generateGs1LinkWith == 'batch') {
                return $baseUrl . '/01/' . $qrcode->product->gtin . '/10/1?id=' . $qrcode->id . '&' . $expDate;
            } elseif ($this->generateGs1LinkWith == 'serial_no') {
                return $baseUrl . '/01/' . $qrcode->product->gtin . '/10/1?id=' . $qrcode->id . '&' . $expDate;
            }
        }else{

            return $baseUrl . '/11/' . $qrcode->qr_code . '?id=' . $qrcode->id;
        }

    }
}
