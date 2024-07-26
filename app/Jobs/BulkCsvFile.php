<?php

namespace App\Jobs;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Queue\SerializesModels;
use Illuminate\Support\Facades\Storage;
use App\Models\Qrcode;

class YourJobName implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;
    protected $filePath;

    /**
     * Create a new job instance.
     */
    public function __construct($filePath)
    {
        $this->filePath = $filePath;
        
    }

    /**
     * Execute the job.
     */
    
        public function handle()
        {
            $file = Storage::disk('local')->get($this->filePath);
            $rows = explode("\n", $file);
            array_shift($rows);
    
            foreach ($rows as $row) {
                $data = str_getcsv(trim($row));
                if (!empty($row) && !empty($data)) {
                    Qrcode::create([
                        'code_data' => $data[0],
                    ]);
                }
            }
        }
    }
