<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\ScanHistory;

class ScanHistoriesController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $scanhistories=ScanHistory::paginate(10);
        $genuine = $scanhistories->filter(function ($product) {
            return $product->status === 'Genuine';
        })->count();
        $last_added_history = ScanHistory::select('qr_code')->orderBy('created_at', 'desc')->first();
        $scan_count=ScanHistory::count();
      return view('scan-histories.index',compact('scanhistories','last_added_history','scan_count','scanhistories','genuine'));
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
    public function show(Request $request,$id)
    {
        $scanhistories=scanhistory::where('id',$id)->first();
       
return view('scan-histories.show',compact('scanhistories'));
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
}
