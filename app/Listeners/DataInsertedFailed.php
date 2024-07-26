<?php

namespace App\Listeners;

use App\Events\JobDataInsertion;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Queue\InteractsWithQueue;

class DataInsertedFailed
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
    public function handle(JobDataInsertion $event): void
    {
        //
    }
}
