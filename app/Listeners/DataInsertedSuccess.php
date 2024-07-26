<?php

namespace App\Listeners;

use App\Events\JobDataInsertion;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Queue\InteractsWithQueue;
use App\Models\Qrcode;
use App\Models\ProductionJob;

class DataInsertedSuccess
{
    /**
     * Create the event listener.
     */
    public function __construct()
    {
        //
    }

    /**
     * Handle the event.
     */

    public function handle(JobDataInsertion $event)
    {
        $startId = $event->startId;
        $endId = $event->endId;
        $data = $event->data;
        try {
            ProductionJob::create([
                'code' => $data['job_code'],
                'line_id' => $data['prod_line'],
                'plant_id' => $data['prod_plant'],
                'start_code' => $data['start_code'],
                'quantity' => $data['quantity'],
                'status' => $data['status']
            ]);
                // Qrcode::update([
                //     'job_id' => $data['job_code'],
                // ])->whereBetween($id_to_start,$id_to_end);
            return 'Data update successful';
        } catch (\Exception $e) {
            \Log::error('Data update failed: ' . $e->getMessage());
            return 'Data update failed'. $e->getMessage();
        }
    }
}
