<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Mike42\Escpos\PrintConnectors\NetworkPrintConnector;
use Mike42\Escpos\Printer;
use Mike42\Escpos\EscposImage;
use App\Models\ProductionJob;
use App\Models\Qrcode;
use GuzzleHttp\Client;
use App\Jobs\ListenCamera;
use Illuminate\Support\Facades\Bus;
use Maatwebsite\Excel\Facades\Excel;
use App\Jobs\SendToPrinterJob;
use App\Exports\ExportJobStatus;
use Illuminate\Support\Facades\Validator;
use App\Jobs\StartNodeServer;
use App\Jobs\StopNodeServer;

class PrintController extends Controller
{
    // public function SendPrintData(Request $request)
    // {
    //     if ($request->job_id && $request->data['ip_printer'] && $request->data['port_printer']) {
    //         $connector = new NetworkPrintConnector($request->data['ip_printer'], $request->data['port_printer']);

    //         $printer = new Printer($connector);
    //         $id_to_start = Qrcode::select('id')->where('code_data', $request->data['start_code'])->first();
    //         $id_to_end = $id_to_start->id + $request->data['quantity'];

    //         try {
    //             $printer->initialize();
    //             for ($i = $id_to_start->id; $i < $id_to_end; $i++) {
    //                 $text = "Price: " . $request->data['price'] . "\n";
    //                 $formattedMfgDate = strtoupper(date('M. Y', strtotime($request->data['mfg_date'])));
    //                 $formattedExpDate = strtoupper(date('M. Y', strtotime($request->data['exp_date'])));
    //                 $text .= "Mfg Date: " . $formattedMfgDate  . "\n";
    //                 $text .= "Exp Date: " .  $formattedExpDate . "\n";
    //                 $url = Qrcode::where('id', $i)->value('url');
    //                 $text .= "Url: " . $url . "\n";
    //                 $printer->text($text);
    //             }

    //             $printer->cut();
    //         } finally {
    //             $printer->close();
    //         }

    //         return "Print Data sent successfully !";
    //     } else {
    //         return "Job Id not found";
    //     }
    // }
    public function SendPrintData(Request $request)
    {
        if ($request->job_id && isset($request->data['productionjob_start_code'], $request->data['quantity'], $request->data['ip_printer'])) {
            $data = $request->data;
            SendToPrinterJob::dispatch($data)->onQueue('print_jobs');
            return response()->json(['message' => 'Print job queued successfully']);
        } else {
            return response()->json(['error' => 'Invalid request parameters'], 400);
        }
    }

    public function SendPrintDataaa(Request $request)
    {
        // if ($request->job_id && $request->data['ip_printer'] && $request->data['port_printer']) {
        if ($request->job_id) {
            // $connector = new NetworkPrintConnector($request->data['ip_printer'], $request->data['port_printer']);
            // $printer = new Printer($connector);
            $startCode = $request->data['start_code'];
            $quantity = $request->data['quantity'];
            $idToStart = Qrcode::where('code_data', $startCode)->value('id');
            $idToEnd = $idToStart + $quantity;
            $authToken = 'Auth_token_2840=ZTEwYWRjMzk0OWJhNTlhYmJlNTZlMDU3ZjIwZjg4M2U=';
            // $data = '<EXTDO>mrinal%devansh%keshav%kunsl</EXTDO>';
            $printer_ip = '192.168.0.130';
            try {
                $batchSize = 100;
                for ($i = $idToStart; $i < $idToEnd; $i += $batchSize) {
                    $batchIds = range($i, min($i + $batchSize - 1, $idToEnd));
                    $url = Qrcode::where('id', $i)->where('printed', '==', 1)->value('url') ?? "";
                    if (!empty($url)) {
                        $print_count = '<APCMD><PMCNT/></APCMD>';
                        $connected = $this->hitUrlWithAuthToken("http://$printer_ip", $authToken, $print_count);
                        $price = "Price: " . $request->data['price'] . "\n";
                        $formattedMfgDate = strtoupper(date('M. Y', strtotime($request->data['mfg_date'])));
                        $formattedExpDate = strtoupper(date('M. Y', strtotime($request->data['exp_date'])));
                        $mfg_date = "Mfg Date: " . $formattedMfgDate  . "\n";
                        $exp_date = "Exp Date: " .  $formattedExpDate . "\n";
                        $url_text = "Url: " . $url . "\n";
                        $data = '<EXTDO>' . $price . '%' . $mfg_date . '%' . $exp_date . '%' . $url_text . '</EXTDO>';
                        $response = $this->hitUrlWithAuthToken("http://$printer_ip", $authToken, $data);
                        $getprintcounter = $this->hitUrlWithAuthTokentogetpmcounter($url, $authToken);
                        if (empty($response)) {
                            $maxx_wait_time = 60;
                            $elapsedd_time = 0;
                            $intervall = 2;
                            while ($elapsedd_time < $maxx_wait_time) {
                                $response = $this->hitUrlWithAuthToken("http://$printer_ip", $authToken, $data);
                                if (!empty($response)) {
                                    break;
                                }
                                sleep($intervall);
                                $elapsedd_time += $maxx_wait_time;
                            }
                        }
                        $connected_after = $this->hitUrlWithAuthToken("http://$printer_ip", $authToken, $print_count);
                        $max_wait_time = 600;
                        $elapsed_time = 0;
                        $interval = 2;
                        while ($connected_after < $connected + 1 && $elapsed_time < $max_wait_time) {
                            $connected_after = $this->hitUrlWithAuthToken("http://$printer_ip", $authToken, $print_count);
                            if ($connected_after == $connected + 1) {
                                break;
                            }
                            sleep($interval);
                            $elapsed_time += $interval;
                        }

                        Qrcode::where('id', $i)->update([
                            'printed' => 1,
                        ]);

                        Qrcode::where('id', $i)->increment('print_count');
                    }
                    if ($elapsed_time == 60) {
                        return 'Getting no response for ' . $data;
                    }
                }

                // $printer->cut();
            } finally {
                $data = '<APCMD><PRINT>0</PRINT></APCMD>';

                try {
                    $connected = $this->hitUrlWithAuthTokenn("http://$printer_ip", $authToken, $data);
                    if ($connected == 0) {
                        return response()->json(['data' => $request->data, 'message' => "Printer disconnected successfully!"]);
                    } else {
                        return "Failed to connect to printer: Response does not match expected.";
                    }
                } catch (\Exception $e) {
                    return "Failed to connect to printer: " . $e->getMessage();
                }
            }
            dump('c');
            return "Print Data sent successfully !";
        } else {
            return "Job Id not found";
        }
    }
    function hitUrlWithAuthTokentogetpmcounter($url, $authToken)
    {
        while (true) {
            $startTime = microtime(true);

            // Initialize curl
            $ch = curl_init();
            curl_setopt($ch, CURLOPT_URL, $url);
            curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
            curl_setopt($ch, CURLOPT_HTTPHEADER, [
                'Authorization: Bearer ' . $authToken,
            ]);

            // Execute curl and get the response
            $response = curl_exec($ch);
            curl_close($ch);

            // Check if the response contains XML data
            if ($response !== false) {
                // Parse the XML response
                $xml = simplexml_load_string($response);

                // Check if the <PMCNT> tag exists and get its content
                if (isset($xml->PMCNT)) {
                    $pmcnt = (string) $xml->PMCNT;
                    echo "PMCNT: $pmcnt\n";
                } else {
                    echo "No <PMCNT> data found.\n";
                }
            } else {
                echo "Failed to fetch data from the printer.\n";
            }

            $endTime = microtime(true);
            $executionTime = ($endTime - $startTime) * 1000; // Convert to milliseconds

            // Calculate the remaining time to wait to achieve 1 millisecond interval
            $sleepTime = max(1 - $executionTime, 0);

            // Wait for the remaining time
            usleep($sleepTime * 1000); // Convert milliseconds to microseconds
        }
    }
    // Replace 'your_printer_ip_here' and 'your_auth_token_here' with the actual values

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

    private function hitUrlWithAuthTokenn($url, $authToken, $data)
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

        if ($httpCode == 200 && trim($response) == '1') {
            return true;
        } else {
            return false;
        }
    }

    public function checkPrinterConnection(Request $request)
    {
        $printer_ip = $request->data['ip_printer'];
        $authToken = $request->data['auth_token'];

        $data = '<APCMD><PRINT>1</PRINT></APCMD>';

        try {
            $connected = $this->hitUrlWithAuthTokenn("http://$printer_ip", $authToken, $data);
            return response()->json(['data' => $request->data, 'message' => "Printer connected successfully!"]);
            // if ($connected == 1) {
            //     return response()->json(['data' => $request->data, 'message' => "Printer connected successfully!"]);
            // } else {
            //     return "Failed to connect to printer: Response does not match expected.";
            // }
        } catch (\Exception $e) {
            return "Failed to connect to printer: " . $e->getMessage();
        }
    }
    public function index()
    {
        $job = ProductionJob::where('status', 'Assigned')->get();

        return view('printmodule', compact('job'));
    }
    public function print_job(Request $request)
    {

        if (!empty($request->job_id)) {
            $productionJobs = ProductionJob::select('production_jobs.id as productionjob_id', 'production_jobs.code as productionjob_code', 'production_jobs.plant_id', 'production_jobs.line_id', 'production_jobs.start_code as productionjob_start_code', 'production_jobs.quantity', 'qrcodes.id as qr_id', 'qrcodes.product_id as product_id', 'qrcodes.url as url', 'qrcodes.gs1_link as isgs1_link_unable', 'qrcodes.qr_code', 'qrcodes.batch_id', 'qrcodes.status as qr_status', 'batches.id as batches_id', 'batches.price', 'batches.code as batches_name', 'batches.currency as currency', 'batches.mfg_date', 'batches.exp_date', 'batches.status as batches_status', 'production_lines.id as pline_id', 'production_lines.code as pline_code', 'production_lines.ip_address', 'production_lines.printer_name', 'production_lines.name as pline_name', 'production_lines.status as pline_status', 'production_lines.created_at', 'production_lines.updated_at', 'production_lines.ip_printer', 'production_lines.port_printer', 'production_lines.ip_camera', 'production_lines.port_camera', 'production_lines.ip_plc', 'production_lines.port_plc', 'products.name as product_name', 'products.company_name', 'products.gtin', 'production_lines.printer_id', 'production_lines.auth_token',)
                ->join('qrcodes', 'production_jobs.start_code', '=', 'qrcodes.code_data')
                ->join('batches', 'qrcodes.batch_id', '=', 'batches.id')
                ->join('production_lines', 'production_jobs.line_id', '=', 'production_lines.id')
                ->join('products', 'batches.product_id', '=', 'products.id')
                ->where('production_jobs.id', $request->job_id)
                ->first();
        } else {
            $productionJobs = [];
        }
        if (!empty($productionJobs->port_camera) && is_numeric($productionJobs->port_camera)) {
            dispatch(new StartNodeServer($productionJobs->port_cameratcpPort));
        }
        return response()->json($productionJobs);
    }
    public function StopPrint(Request $request)
    {
        $printer_ip = $request->data['ip_printer'];
        $authToken = $request->data['auth_token'];
        // $printer_ip = '192.168.2.145';
        // $authToken = 'Auth_token_2840=ZTEwYWRjMzk0OWJhNTlhYmJlNTZlMDU3ZjIwZjg4M2U=';
        $data = '<APCMD><PRINT>0</PRINT></APCMD>';
        try {
            $connected = $this->hitUrlWithAuthToken("http://$printer_ip", $authToken, $data);
            if ($connected == 0) {
                return response()->json(["message" => "Printer stopped successfully!"]);
            } else {
                return "Failed to connect to printer: Response does not match expected.";
            }
        } catch (\Exception $e) {
            return "Error stopping printer: " . $e->getMessage();
        }
    }
    public function connectionweber(Request $request) {}
    protected function listencamera($ipcamera, $portcamera)
    {
        $address = '127.0.0.1';
        $port = 2000;
        $retryInterval = 0.02;
        $response = null;

        while (true) {
            $errno = 0;
            $errstr = '';

            $fp = stream_socket_client("tcp://$address:$port", $errno, $errstr, 30);
            if (!$fp) {
                echo "Unable to connect: $errstr ($errno)\n";
                usleep($retryInterval * 1000000);
            } else {
                echo "Connected successfully to $address:$port\n";
                stream_set_timeout($fp, 1);

                $response = fread($fp, 1024);
                if ($response !== false && strlen($response) > 0) {
                    echo "Received response: $response\n";
                    fclose($fp);
                    break;
                } else {
                    echo "No response, retrying...\n";
                    fclose($fp);
                    usleep($retryInterval * 1000000);
                }
            }
        }

        return $response;
    }
    public function cameraDataCheck(Request $request)
    {
        if ($request->job_id) {
            $expected_data = [
                'batch' => $request->data['batches_name'],
                'mfg_date' => strtoupper(date('M. Y', strtotime($request->data['mfg_date']))),
                'exp_date' => strtoupper(date('M. Y', strtotime($request->data['exp_date']))),
                'price' => $request->data['price'],
            ];
            $camera_data_received = $request->message;
            // Check if the camera data contains the ';' character
            if (strpos($camera_data_received, ';') !== false) {
                $data_parts = explode(';', $camera_data_received);
            } else {
                return response()->json([
                    'message' => 'Camera Data is unreadable or incorrect',
                    'data' => $camera_data_received,
                    'remark' => ''
                ]);
            }

            $keys = ['batch', 'mfg_date', 'exp_date', 'price', 'url'];
            foreach ($keys as $index => $key) {
                if (array_key_exists($index, $data_parts)) {
                    if ($index != '4') {
                        if (strcasecmp(trim($expected_data[$key]), trim($data_parts[$index])) !== 0) {
                            return response()->json([
                                'message' => ucfirst(str_replace('_', ' ', $key)) . ' is unreadable or incorrect',
                                'data' => $camera_data_received,
                                'remark' => ''
                            ]);
                        }
                    } else {
                        $expected_data = [
                            'url' => Qrcode::where('url', $data_parts[$index])->value('url'),
                        ];
                        if (strcasecmp(trim($expected_data[$key]), trim($data_parts[$index])) !== 0) {
                            return response()->json([
                                'message' => ucfirst(str_replace('_', ' ', $key)) . ' is unreadable or incorrect',
                                'data' => $camera_data_received,
                                'remark' => ''
                            ]);
                        }
                    }
                } else {
                    return response()->json([
                        'message' => ucfirst(str_replace('_', ' ', $key)) . ' is unreadable or incorrect',
                        'data' => $camera_data_received,
                        'remark' => ''
                    ]);
                }
            }
            return response()->json(['message' => 'All correct']);
        } else {
            return response()->json([
                'message' => 'Camera Data is unreadable',
                'data' => '',
                'remark' => 'Url is incorrect'
            ]);
        }
    }
    public function downloadexcel(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'jobSelect' => 'required',
            'statusSelect' => 'required'
        ]);
        if ($validator->fails()) {
            return redirect()->back()->withErrors($validator)->withInput();
        }

        return Excel::download(new ExportJobStatus($request->jobSelect, $request->statusSelect), 'jobdataexcel.xlsx');
    }
}
