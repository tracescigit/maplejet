<?php

namespace App\Jobs;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Queue\SerializesModels;
use Illuminate\Support\Facades\Log;

class StartNodeServer implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;

    protected $tcpPort;

    /**
     * Create a new job instance.
     *
     * @param int $tcpPort
     */
    public function __construct($tcpPort)
    {
        $this->tcpPort = $tcpPort;
    }

    /**
     * Execute the job.
     *
     * @return void
     */
    public function handle()
    {
        $command = "node " . base_path('server2.js') . " " . $this->tcpPort;

        Log::info("Running command: " . $command);

        // Detach the process
        if (stripos(PHP_OS, 'WIN') === 0) {
            // For Windows, use 'start' to run in a new command window
            pclose(popen("start /B " . $command . " > NUL 2>&1", 'r'));
        } else {
            // For Unix/Linux, use 'nohup' to detach
            exec("nohup " . $command . " > /dev/null 2>&1 &");
        }

        Log::info("Node server started on port: " . $this->tcpPort);
    }
}
