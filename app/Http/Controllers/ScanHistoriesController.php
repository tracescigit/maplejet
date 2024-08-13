<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\ScanHistory;
use Maatwebsite\Excel\Facades\Excel;
use App\Exports\ScanhistoriesExcelExport;
class ScanHistoriesController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {
        $query = ScanHistory::query();

        // Apply filters
        if ($request->products_search) {
            $query->where('product', $request->products_search);
        }
        if ($request->has('genuine')) {
            $genuineStatus = $request->genuine;

            // Define a mapping of statuses to their corresponding values
            $statusMapping = [
                'genuine' => 1,
                'suspicious' => 2,
                'fake' => 0,
            ];

            // Check if the provided status exists in the mapping
            if (array_key_exists($genuineStatus, $statusMapping)) {
                // Get the corresponding value for the status
                $statusValue = $statusMapping[$genuineStatus];

                // Add the status condition to the query
                $query->where('genuine', $statusValue);
            }
        }
        if ($request->qrcode) {
            $query->where('qr_code', $request->qrcode);
        }
        // Apply pagination
        $scanhistories = $query->paginate(10);
        $genuine = $scanhistories->filter(function ($product) {
            return $product->status === 'Genuine';
        })->count();
        $last_added_history = ScanHistory::select('qr_code')->orderBy('created_at', 'desc')->first();
        $scan_count = ScanHistory::count();
        return view('scan-histories.index', compact('scanhistories', 'last_added_history', 'scan_count', 'scanhistories', 'genuine'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        //
    }

    /**
     * Display the specified resource.
     */
    public function show(Request $request, $id)
    {
        $scanhistories = scanhistory::where('id', $id)->first();

        return view('scan-histories.show', compact('scanhistories'));
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(string $id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        //
    }
    public function exceldownloadscanhistories(Request $request)
    {
  
       $scanreportlog =ScanHistory::with('batch')->get();
       return Excel::download(new ScanhistoriesExcelExport($scanreportlog), 'scanresport.xlsx');
    }
}
