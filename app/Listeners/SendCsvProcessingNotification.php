<?php

namespace App\Listeners;

use App\Events\CsvProcessingCompleted;
use App\Events\CsvProcessingFailed;
use Illuminate\Support\Facades\Session;

class SendCsvProcessingNotification
{
    public function handle($event)
    {
        if ($event instanceof CsvProcessingCompleted) {
            Session::flash('status', $event->message);
        }

        if ($event instanceof CsvProcessingFailed) {
            Session::flash('error', $event->errorMessage);
        }
    }
}

