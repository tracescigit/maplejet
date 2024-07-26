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
        if (isset($this->data['start_code'], $this->data['quantity'], $this->data['price'], $this->data['mfg_date'], $this->data['exp_date'], $this->data['ip_printer'], $this->data['port_printer'])) {
            // Extract necessary data from the job payload
            $startCode = $this->data['start_code'];
            $quantity = $this->data['quantity'];
            $idToStart = Qrcode::where('code_data', $startCode)->value('id');
            $idToEnd = $idToStart + $quantity;
            $printer_ip = '127.0.0.1';
            $printer_port = '8060';
            $price = "Price: " . $this->data['price'] . "\n";
            $formattedMfgDate = strtoupper(date('M. Y', strtotime($this->data['mfg_date'])));
            $formattedExpDate = strtoupper(date('M. Y', strtotime($this->data['exp_date'])));
            $mfg_date = "Mfg Date: " . $formattedMfgDate  . "\n";
            $exp_date = "Exp Date: " .  $formattedExpDate . "\n";

            // Example: Open a socket connection and send data to the printer
            $socket = socket_create(AF_INET, SOCK_STREAM, SOL_TCP);

            if ($socket === false) {
                Log::error("socket_create() failed: " . socket_strerror(socket_last_error()));
                return;
            }

            $result = socket_connect($socket, $printer_ip, $printer_port);
            if ($result === false) {
                Log::error("socket_connect() failed: " . socket_strerror(socket_last_error($socket)));
                socket_close($socket);
                return;
            }

            // Iterate over the range of IDs
            for ($i = $idToStart; $i < $idToEnd; $i++) {
                // Fetch URL from Qrcode model based on ID
                $url = Qrcode::where('code_data', $i)->value('url');

                if (!empty($url)) {
                    $url_text = "Url: " . $url . "\n";
                    $dataToPrint = '<EXTDO>' . $price . '%' . $mfg_date . '%' . $exp_date . '%' . $url_text . '</EXTDO>';

                    // Send data to the printer
                    $bytesWritten = socket_write($socket, $dataToPrint, strlen($dataToPrint));

                    if ($bytesWritten === false) {
                        Log::error("Failed to write to socket");
                    } else {
                        // Log success message for each print
                        Log::info("Print data sent successfully for ID $i to $printer_ip:$printer_port");
                    }
                }
            }

            // Close the socket connection
            socket_close($socket);
        } else {
            Log::error("Invalid data provided to SendToPrinterJob");
        }
    }
}
