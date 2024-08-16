<?php

namespace App\Listeners;
use App\Jobs\QrUploadBySerial;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Queue\InteractsWithQueue;
use App\Events\DispatchQrUploadBySerial;
class HandleDispatchQrUploadBySerial implements ShouldQueue
{
    use InteractsWithQueue;

    /**
     * Handle the event.
     *
     * @param  DispatchQrUploadBySerial  $event
     * @return void
     */
    public function handle(DispatchQrUploadBySerial $event)
    {
        // Dispatch the job
        QrUploadBySerial::dispatch($event->data)->onQueue('generate_by_serial');
    }
}
