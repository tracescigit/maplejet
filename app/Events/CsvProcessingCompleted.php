<?php

namespace App\Events;

use Illuminate\Queue\SerializesModels;

class CsvProcessingCompleted
{
    use SerializesModels;

    public $message;

    public function __construct($message)
    {
        $this->message = $message;
    }
}