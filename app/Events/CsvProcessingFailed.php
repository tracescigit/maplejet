<?php

namespace App\Events;

use Illuminate\Queue\SerializesModels;

class CsvProcessingFailed
{
    use SerializesModels;

    public $errorMessage;

    public function __construct($errorMessage)
    {
        $this->errorMessage = $errorMessage;
    }
}
