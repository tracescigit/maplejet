<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use GuzzleHttp\Client;
class NodeDataController extends Controller
{
    public function fetchData()
    {
        $client = new Client();
        $response = $client->get('http://127.0.0.5:2000'); 
        $data = json_decode($response->getBody(), true);

        return view('node_data', ['data' => $data]);
    }
}
