<?php

namespace App\Jobs;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Queue\SerializesModels;
use App\Models\Qrcode;
use Illuminate\Support\Facades\Log;

class SendToPrinterJob implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;

    protected $data;

    /**
     * Create a new job instance.
     *
     * @param array $data Data to be sent to the printer
     * @return void
     */
    public function __construct(array $data)
    {
        $this->data = $data;
    }

    /**
     * Execute the job.
     *
     * @return void
     */
    public function handle()
    {
        // Extract necessary data from the job payload
        $startCode = $this->data['productionjob_start_code'];
        $quantity = $this->data['quantity'];
        $idToStart = Qrcode::where('code_data', $startCode)->value('id');
        $idToEnd = $idToStart + $quantity -1;
        $printer_ip = $this->data['ip_printer'];
        // $printer_port = '8060';
        $authToken = $this->data['auth_token'];
        // $stop = '<APCMD><PRINT>1</PRINT></APCMD>';
        //         $connected = $this->hitUrlWithAuthToken("http://$printer_ip", $authToken, $stop);
        $price = "Price: " . $this->data['price'];
        $formattedMfgDate = strtoupper(date('M. Y', strtotime($this->data['mfg_date'])));
        $formattedExpDate = strtoupper(date('M. Y', strtotime($this->data['exp_date'])));
        $mfg_date = "Mfg Date: " . $formattedMfgDate;
        $exp_date = "Exp Date: " .  $formattedExpDate;
        try {
            // $batchSize = 100;
            $j = 1;
            for ($i = $idToStart; $i < $idToEnd; $i ++) {
                // $batchIds = range($i, min($i + $batchSize - 1, $idToEnd));
                $url = Qrcode::where('id', $i)->value('url') ?? "";
                if (!empty($url)) {
                    $print_count = '<APCMD><PMCNT/></APCMD>';
                    $connected = $this->hitUrlWithAuthToken("http://$printer_ip", $authToken, $print_count);
                    dump($connected);
                    $mfg_date = "Mfg Date: " . $formattedMfgDate;
                    $data = '<EXTDO>' . $price . '%' . $mfg_date . '%' . $exp_date . '%' . $url . '</EXTDO>';
                    Log::info('Sent data: ' . $data);
                    $response = $this->hitUrlWithAuthToken("http://$printer_ip", $authToken, $data);
                    Log::info('Printer response: ' . $response);
                    sleep(.5);
                    // $getprintcounter = $this->hitUrlWithAuthTokentogetpmcounter($url, $authToken);
                    // if (empty($response)) {
                    //     $maxx_wait_time = 60;
                    //     $elapsedd_time = 0;
                    //     $intervall = 2;
                    //     while ($elapsedd_time < $maxx_wait_time) {
                    //         $response = $this->hitUrlWithAuthToken("http://$printer_ip", $authToken, $data);
                    //         if (!empty($response)) {
                    //             break;
                    //         }
                    //         sleep($intervall);
                    //         $elapsedd_time += $maxx_wait_time;
                    //     }
                    // }
                    $connected_after = $this->hitUrlWithAuthToken("http://$printer_ip", $authToken, $print_count);
                    $max_wait_time = 10000;
                    $elapsed_time = 0;
                    $interval = 0.1;
                    while ($connected_after <= $connected + 1 && $elapsed_time < $max_wait_time) {
                        $connected_after = $this->hitUrlWithAuthToken("http://$printer_ip", $authToken, $print_count);
                        if ($connected_after == $connected + 1) {
                            $connected = $connected_after;
                            break;
                        }
                        sleep($interval);
                        $elapsed_time += $interval;
                    }
                    $clr_command = "<CLREXT>0</CLREXT>";
                    $clear_data = $this->hitUrlWithAuthToken("http://$printer_ip", $authToken, $clr_command);

                    Qrcode::where('id', $i)->update([
                        'printed' => 1,
                    ]);

                    Qrcode::where('id', $i)->increment('print_count');
                    // if ($elapsed_time == 60) {
                    //     return 'Getting no response for ' . $data;
                    // }
                    $j++;
                }
            }
            $stop = '<APCMD><PRINT>0</PRINT></APCMD>';
                $connected = $this->hitUrlWithAuthToken("http://$printer_ip", $authToken, $stop);

            // $printer->cut();
        } finally {
            $data = '<APCMD><PRINT>1</PRINT></APCMD>';

            try {
                // $connected = $this->hitUrlWithAuthTokenn("http://$printer_ip", $authToken, $data);
                // return response()->json(['data' => $request->data, 'message' => "Printer disconnected successfully!"]);
                // if ($connected == 0) {
                // } else {
                //     return "Failed to connect to printer: Response does not match expected.";
                // }
            } catch (\Exception $e) {
                return "Failed to connect to printer: " . $e->getMessage();
            }
        }
    }
    private function hitUrlWithAuthToken($url, $authToken, $data)
    {
        $ch = curl_init();
        curl_setopt($ch, CURLOPT_URL, $url);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
        curl_setopt($ch, CURLOPT_COOKIE, "auth_token=$authToken");
        curl_setopt($ch, CURLOPT_HTTPHEADER, array('Content-Type: text/xml'));
        curl_setopt($ch, CURLOPT_POST, 1);
        curl_setopt($ch, CURLOPT_POSTFIELDS, $data);
        curl_setopt($ch, CURLOPT_CONNECTTIMEOUT, 5);
        curl_setopt($ch, CURLOPT_TIMEOUT, 10);
        $response = curl_exec($ch);
        $httpCode = curl_getinfo($ch, CURLINFO_HTTP_CODE);
        curl_close($ch);

        return $response;
    }
}
