<?php

namespace App\Jobs;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Queue\SerializesModels;
use Illuminate\Support\Facades\Log;

class StopNodeServer implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;

    protected $port;

    /**
     * Create a new job instance.
     *
     * @param int $port
     */
    public function __construct($port)
    {
        $this->port = $port;
    }

    /**
     * Execute the job.
     *
     * @return void
     */
    public function handle()
    {
        // Find the PIDs of the Node.js processes running on the specified port
        $output = shell_exec("netstat -ano | findstr :{$this->port}");

        if ($output) {
            // Split output into lines
            $lines = explode("\n", trim($output));
            $pids = [];

            foreach ($lines as $line) {
                // Extract the PID from each line
                preg_match('/\s+(\d+)$/', trim($line), $matches);
                if (isset($matches[1])) {
                    $pids[] = $matches[1];
                }
            }

            if (!empty($pids)) {
                foreach ($pids as $pid) {
                    // Check if the process command line contains the specific script
                    $processInfo = shell_exec("wmic process where ProcessId={$pid} get CommandLine");
                    if (strpos($processInfo, "node " . base_path('server2.js')) !== false) {
                        // Kill the Node.js process
                        shell_exec("taskkill /F /PID {$pid}");
                        Log::info("Stopped Node.js process with PID: {$pid} on port {$this->port}");
                    }
                }
            } else {
                Log::info("No PIDs found for port {$this->port}.");
            }
        } else {
            Log::info("No Node.js processes found on port {$this->port}.");
        }
    }
}
