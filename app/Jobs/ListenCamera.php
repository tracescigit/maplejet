<?php

namespace App\Jobs;

use App\Events\CameraDataRead;
use Illuminate\Bus\Queueable;
use Illuminate\Queue\SerializesModels;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Http;

class ListenCamera implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;

    protected $ipCamera;
    protected $portCamera;
    protected $checkData;

    /**
     * Create a new job instance.
     *
     * @param  string  $ipCamera
     * @param  int  $portCamera
     * @param  array  $checkData
     * @return void
     */
    public function __construct($ipCamera, $portCamera, $checkData)
    {
        $this->ipCamera = $ipCamera;
        $this->portCamera = $portCamera;
        $this->checkData = $checkData;
    }

    /**
     * Execute the job.
     *
     * @return void
     */
    public function handle()
    {
        // Initialize previous response as empty
        $previousResponse = '';

        while (true) {
            try {
                $uri = "http://{$this->ipCamera}:{$this->portCamera}";

                // Initialize cURL session
                $ch = curl_init();
                
                // Set the URL
                curl_setopt($ch, CURLOPT_URL, $uri);
                
                // Set the request method (GET by default)
                curl_setopt($ch, CURLOPT_HTTPGET, true);
                
                // Set the timeout for the request (in seconds)
                curl_setopt($ch, CURLOPT_TIMEOUT, 30); // Adjust as needed
                
                // Set option to return the response as a string
                curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
                
                // Set the HTTP version to use (HTTP/0.9)
                curl_setopt($ch, CURLOPT_HTTP_VERSION, "0.9");
                
                // Execute the request and capture the response
                $response = curl_exec($ch);
                
                // Check for cURL errors
                if ($response === false) {
                    $error = curl_error($ch);
                    curl_close($ch);
                    throw new \Exception('cURL error: ' . $error);
                }
                
                // HTTP request was successful
                curl_close($ch);
                
                // Process the response
                dd($response);
                
                
                

                // Compare with the previous response
                if ($response !== $previousResponse) {
                    $previousResponse = $response; // Update the previous response

                    // Splitting data into parts
                    $parts = explode('|', $response);

                    if (
                        count($parts) === 4 &&
                        $parts[0] == $this->checkData['price'] &&
                        $parts[1] == $this->checkData['mfg_date'] &&
                        $parts[2] == $this->checkData['exp_date']
                    ) {
                        $url = DB::table('qrcodes')->where('url', $parts[3])->value('url');
                        if ($url) {
                            return $url;
                        } else {
                            event(new CameraDataRead("Url Not found in Database."));
                        }
                    } else {
                        event(new CameraDataRead("Data Unreadable/Incorrect."));
                    }
                }
            } catch (\Exception $e) {
                // Log the exception
                \Log::error('Exception during HTTP request: ' . $e->getMessage());
                event(new CameraDataRead("Exception during HTTP request: " . $e->getMessage()));
            }

            // Sleep for 1 millisecond before the next request
            usleep(1000);
        }
    }
    private function fetchDataFromUrl($url) {
        $ch = curl_init();
        curl_setopt($ch, CURLOPT_URL, $url);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
        curl_setopt($ch, CURLOPT_CONNECTTIMEOUT, 5);
        curl_setopt($ch, CURLOPT_TIMEOUT, 10);
        $response = curl_exec($ch);
    
        // Check for cURL errors
        if ($response === false) {
            throw new \Exception('cURL error: ' . curl_error($ch));
        }
    
        curl_close($ch);
        return $response;
    }
}
