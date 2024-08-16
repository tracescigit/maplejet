<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Qrcode;
use App\Models\ProductionPlant;
use App\Models\ProductionLines;
use App\Events\JobDataInsertion;
use App\Models\ProductionJob;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Auth;


class JobsController extends Controller
{
    public function index()
    {
        $jobdatas = ProductionJob::with(['productionplant', 'productionLines'])->orderBy('created_at', 'desc')->paginate(10);
        $prodactiveCount = $jobdatas->filter(function ($product) {
            return $product->status === 'Active';
        })->count();
        $last_added_job = ProductionJob::select('code')->orderBy('created_at', 'desc')->first();
        return view('jobs.index', compact('jobdatas','last_added_job','prodactiveCount'));
    }
    public function create()
    {
        if (!Auth::user()->can('create job')) {
             return view('dummy.unauthorized');
        }
        $productionplant = ProductionPlant::get();
        $productionline = ProductionLines::get();
        return view('jobs.create', compact('productionplant', 'productionline'));
    }
    public function store(Request $request)
    {
        $request->validate([
            'job_code' => 'required|max:50|regex:/^[a-zA-Z0-9_$]+$/',
            'prod_line' => 'required|max:50',
            'prod_plant' => 'required|max:50',
            'start_code' => 'required',
            'quantity' => 'required|numeric',
            'status' => 'required'
        ]);
        if (empty($request->start_code)) {
            return redirect()->back()->with(['status' => 'Invalid or missing start_code']);
        }
        $id_to_start = Qrcode::where('code_data', $request->start_code)->value('id');
        if (empty($id_to_start)) {
            return redirect()->back()->with(['status' => 'Invalid or missing start_code']);
        }
        $quantity = (int)$request->quantity;
        $id_to_end = $id_to_start + $quantity - 1;
       
        $create = [
            'job_code' => $request->job_code,
            'prod_line' => $request->prod_line,
            'prod_plant' => $request->prod_plant,
            'start_code' => $request->start_code,
            'quantity' => $request->quantity,
            'status' => $request->status
        ];
        $response = event(new JobDataInsertion($id_to_start, $id_to_end, $create));
        if (strpos($response[0], 'Data update failed') === 0) {
            return redirect('jobs')->with('error', $response[0]);
        }
        return redirect('jobs')->with('status', $response[0]);
    }
    public function show(Request $request ,$id)
    {
        $jobs=ProductionJob::where('id',$id)->first();
        return view('jobs.show',compact('jobs'));
    }
    public function edit($id)
    {
        if (!Auth::user()->can('update job')) {
             return view('dummy.unauthorized');
        }
       
        $productionplant = ProductionPlant::get();
        $productionline = ProductionLines::get();
        $productionjob = ProductionJob::findorFail($id);
        return view('jobs.edit', compact('productionplant', 'productionline', 'productionjob'));
    }
    public function update(Request $request, $id)
    {  
        
    $request->validate([
            'job_code' => 'required|max:50|regex:/(^[a-zA-Z0-9 \-\&]+$)/u',
            'prod_line' => 'required|max:50',
            'prod_plant' => 'required|max:50',
            'start_code' => 'required',
            'quantity' => 'required|numeric',
            'status' => 'required'
        ]);
        if (empty($request->start_code)) {
            return redirect()->back()->with(['status' => 'Invalid or missing start_code']);
        }
        $id_to_start = Qrcode::where('code_data', $request->start_code)->value('id');
        if (empty($id_to_start)) {
            return redirect()->back()->with(['status' => 'Invalid or missing start_code']);
        }
        $quantity = (int)$request->quantity;
        $id_to_end = $id_to_start + $quantity - 1;
        $update = [
            'code' => $request->job_code,
            'plant_id' => $request->prod_line,
            'line_id' => $request->prod_plant,
            'start_code' => $request->start_code,
            'quantity' => $request->quantity,
            'status' => $request->status
        ];
        ProductionJob::where('id', $id)->update($update);

        return redirect('jobs')->with('status', "Job Updated Successfully");
    }
    public function destroy($id)
    {
        // if (!Auth::user()->can('delete job')) {
        //      return view('dummy.unauthorized');
        // }
        $product = ProductionJob::find($id);
        $product->delete();
        return redirect('jobs')->with('status', 'Job Deleted Successfully');
    }
    public function jobscsvdownload()
    {
        $jobdatas = DB::table('production_jobs')
            ->select(
                'production_jobs.code', 
                'production_jobs.start_code', 
                'production_jobs.quantity', 
                'production_jobs.status', 
                'production_plants.code as plant_code', 
                'production_plants.name as plant_name', 
                'production_plants.status as plant_status', 
                'production_lines.code as line_code', 
                'production_lines.ip_address', 
                'production_lines.printer_name', 
                'production_lines.name as line_name', 
                'production_lines.status as line_status', 
                'production_lines.ip_printer', 
                'production_lines.port_printer', 
                'production_lines.ip_camera', 
                'production_lines.port_camera', 
                'production_lines.ip_plc', 
                'production_lines.port_plc'
            )
            ->join('production_plants', 'production_jobs.plant_id', '=', 'production_plants.id')
            ->join('production_lines', 'production_jobs.line_id', '=', 'production_lines.id')
            ->get();

        $csvData = $this->convertToCsv($jobdatas);

        return response($csvData)
            ->header('Content-Type', 'text/csv')
            ->header('Content-Disposition', 'attachment; filename="jobs.csv"');
    }

    private function convertToCsv($jobdatas)
    {
        // Define the CSV header
        $csvHeader = [
            'Job Code', 
            'Start Code', 
            'Quantity', 
            'Job Status', 
            'Plant Code', 
            'Plant Name', 
            'Plant Status', 
            'Line Code', 
            'IP Address', 
            'Printer Name', 
            'Line Name', 
            'Line Status', 
            'IP Printer', 
            'Port Printer', 
            'IP Camera', 
            'Port Camera', 
            'IP PLC', 
            'Port PLC'
        ];

        // Initialize CSV rows array with the header
        $csvRows = [];
        $csvRows[] = implode(',', $csvHeader);

        // Add data rows
        foreach ($jobdatas as $job) {
            $csvRows[] = implode(',', [
                $job->code, 
                $job->start_code, 
                $job->quantity, 
                $job->status, 
                $job->plant_code, 
                $job->plant_name, 
                $job->plant_status, 
                $job->line_code, 
                $job->ip_address, 
                $job->printer_name, 
                $job->line_name, 
                $job->line_status, 
                $job->ip_printer, 
                $job->port_printer, 
                $job->ip_camera, 
                $job->port_camera, 
                $job->ip_plc, 
                $job->port_plc
            ]);
        }

        // Convert the array to a single CSV string
        return implode("\n", $csvRows);
    }
}
