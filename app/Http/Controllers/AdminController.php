<?php

namespace App\Http\Controllers;

use App\Models\Product;
use Illuminate\Http\Request;
use App\Models\User;
use Spatie\Permission\Models\Role;
use Illuminate\Support\Facades\Hash;
use App\Models\Batch;
use App\Models\Qrcode;
use App\Models\ProductionJob;
use App\Models\ScanHistory;
use App\Models\ReportedProductsModel;
use Illuminate\Support\Facades\DB;

class AdminController extends Controller
{
    public function index()
    {
        $total_products = Product::count();
        $total_batch = Batch::count();
        $total_user = User::count();
        $total_qrcodes = Qrcode::count();
        $total_jobs = ProductionJob::count();
        $active_jobs = ProductionJob::where('status', 'Assigned')->count();
        $total_scan = ReportedProductsModel::count();
        $mostCommonIssue = ReportedProductsModel::select('report_reason', DB::raw('COUNT(*) as count'))
            ->groupBy('report_reason')
            ->orderBy('count', 'desc')
            ->first();
        $jobCounts = ProductionJob::select(DB::raw('MONTH(created_at) as month'), DB::raw('COUNT(*) as count'))
            ->groupBy(DB::raw('MONTH(created_at)'))
            ->orderBy(DB::raw('MONTH(created_at)'))
            ->get();

        // Prepare data for the chart
        $months = ['January', 'February', 'March', 'April', 'May', 'June', 'July', 'August', 'September', 'October', 'November', 'December'];
        $data = array_fill(0, 12, 0); // Initialize data array with zero values

        foreach ($jobCounts as $jobCount) {
            $data[$jobCount->month - 1] = $jobCount->count; // Adjust month index
        }
        $locations=ScanHistory::select('latitude','longitude')->get();
        $formattedLocations = $locations->map(function($location) {
            return [
                'lat' => $location->latitude,
                'lng' => $location->longitude,
                'title' => ""
            ];
        });
        // return view('dashboard', compact('total_products', 'total_batch', 'total_user', 'total_qrcodes', 'total_jobs', 'active_jobs', 'total_scan', 'mostCommonIssue','months','data','formattedLocations'));
        return view('dashboard', [
            'jsonLocations' => $formattedLocations,
            'total_products' => $total_products,
            'total_batch' => $total_batch,
            'total_user' => $total_user,
            'total_qrcodes' => $total_qrcodes,
            'total_jobs' => $total_jobs,
            'active_jobs' => $active_jobs,
            'total_scan' => $total_scan,
            'mostCommonIssue' => $mostCommonIssue,
            'months' => $months,
            'data' => $data
        ]);
    }
}
