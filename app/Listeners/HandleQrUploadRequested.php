<?php

namespace App\Listeners;

use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Queue\InteractsWithQueue;
use App\Events\QrUploadRequested;
use App\Jobs\QrUploadByRandom;
class HandleQrUploadRequested implements ShouldQueue
{
    use InteractsWithQueue;

    /**
     * Handle the event.
     *
     * @param  QrUploadRequested  $event
     * @return void
     */
    public function handle(QrUploadRequested $event)
    {
        // Dispatch the QrUploadByRandom job
        QrUploadByRandom::dispatch($event->quantity, $event->baseUrl)
            ->onQueue('generate_by_random');
    }
}
