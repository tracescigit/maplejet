<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\ScanHistory;
use Illuminate\Support\Facades\DB;
use App\Models\Qrcode;
class DashboardController extends Controller
{
    public function getCurrentMonthData()
    {
        $currentMonthData = ScanHistory::select(
            DB::raw('DATE(created_at) as date'),
            DB::raw('COUNT(*) as scan_count')
        )
            ->whereYear('created_at', now()->year)
            ->whereMonth('created_at', now()->month)
            ->groupBy('date')
            ->get();

        return response()->json($currentMonthData);
    }
    public function index()
    {
        $total = Qrcode::count();
        $active = Qrcode::where('status', 'Active')->count();
        $inactive = $total - $active;
        return view('dashboard',compact('total','active','inactive'));
    }






    public function checkConnection(Request $request)
    {
        $tcpHost = $request->input('tcpHost', '127.0.0.5'); // Default to your camera's IP address
        $tcpPort = $request->input('tcpPort', 2000); // Default to your camera's port

        $connected = $this->isCameraConnected($tcpHost, $tcpPort);

        return response()->json([
            'isCameraConnected' => $connected,
        ]);
    }
    private function isCameraConnected($host, $port)
    {
        $timeout = 3; // Timeout in seconds
        $connected = @fsockopen($host, $port, $errno, $errstr, $timeout);
        
        if ($connected){
            fclose($connected);
            return true;
        } else {
            return false;
        }
    }
}
