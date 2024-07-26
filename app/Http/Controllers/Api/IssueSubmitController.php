<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\ReportLog;
use GuzzleHttp\Client;
use GuzzleHttp\Exception\ClientException;
use App\Models\Product;

class IssueSubmitController extends Controller
{
    public function submitissue(Request $request)
    {
        $ip = $request->ip;
        $location = $request->input('location');
        $lat = $request->input('lat');
        $long = $request->input('long');
        $url = $request->url();
        $productt = $request->product_name;
        $batch = $request->batch;
        $product = str_replace('_', ' ', $productt);
        // $product_id = Product::select('id')->where('name', $product)->first();
        if (!empty($lat && $long)) {
            try {
                $client = new Client();
                $response = $client->get('https://nominatim.openstreetmap.org/reverse', [
                    'query' => [
                        'format' => 'json',
                        'lat' => $lat,
                        'lon' => $long,
                        'addressdetails' => 1,
                    ],
                ]);

                $body = json_decode($response->getBody());
                // Check if the response contains address details
                if (!empty($body->address)) {
                    $city = $body->address->city ?? null;
                    $country = $body->address->country ?? null;
                }
            } catch (ClientException $e) {
                if ($e->getResponse()->getStatusCode() == 403) {
                    // Handle 403 error (e.g., log, notify, retry logic)
                    echo 'Error: Access to Nominatim API is forbidden.';
                } else {
                    // Handle other ClientExceptions
                    echo 'Error: ' . $e->getMessage();
                }
            }
        }

        $report = ReportLog::create([
            "report_reason" => $request->issue,
            "description" => $request->description,
            "mobile" => $request->mobile ?? "0000000000",
            'product'=>$product,
            'batch'=>$batch,
            "lat" => $lat ?? "",
            "long" => $long ?? "",
            'city' => $city ?? "",
            'country' => $country ?? "",
            "ip" => $ip ?? "",
            "scanned_by" => $request->scanned_by ?? "Web",
            "feedback" => $request->feedback ?? "",
        ]);

        return response()->json(['success' => 'Data inserted successfully'], 200);
    }
}
