<?php

namespace App\Http\Controllers;

use App\Models\ProductionJob;
use Illuminate\Http\Request;
use App\Models\ProductionLines;
use App\Models\ProductionPlant;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\Auth;

class ProductionLinesController extends Controller
{
   public function index(Request $request)
   {
      $query = DB::table('production_lines')
      ->join('production_plants', 'production_lines.plant_id', '=', 'production_plants.id')
      ->select('production_lines.*', 'production_plants.code as plant_code', 'production_plants.name as plant_name');
  
  // Apply filters
  if ($request->pl_name) {
      $query->where('production_lines.name', 'like', '%' . $request->pl_name . '%');
  }
  
  if ($request->pl_code) {
      // Assuming you meant to filter by the production_lines.code
      $query->where('production_lines.code', 'like', '%' . $request->pl_code . '%');
  }
  
  if ($request->pp_name) {
      $query->where('production_plants.name', 'like', '%' . $request->pp_name . '%');
  }
  
  // Apply pagination
  $productionlines = $query->paginate(10);
  
      $productionlines1 = DB::table('production_lines')
         ->join('production_plants', 'production_lines.plant_id', '=', 'production_plants.id')
         ->select('production_lines.*', 'production_plants.code as plant_code', 'production_plants.name as plant_name')
         ->paginate(10);
      $prodactiveCount = $productionlines1->filter(function ($product) {
         return $product->status === 'Active';
      })->count();
      $last_added_plline = ProductionLines::select('name')->orderBy('created_at', 'desc')->first();
      return view('production-lines.index', compact('productionlines', 'prodactiveCount', 'last_added_plline'));
   }
   public function create()
   {
      if (!Auth::user()->can('create production')) {
         return view('dummy.unauthorized');
      }
      $productionplant = ProductionPlant::get();
      return view('production-lines.create', compact('productionplant'));
   }
   public function store(Request $request)
   {
      $validator = Validator::make($request->all(), [
         'name' => [
            'required',
            'string',
            'regex:/^[a-zA-Z0-9-_ ]+$/u'
         ],
         'code' => [
            'required',
            'string',
            'regex:/^[a-zA-Z0-9-_]+$/u'
         ],
         'ip_address' => [
            'required',
            'regex:/^(?:\d{1,3}\.){3}\d{1,3}$/',
         ],
         'port' => [
            'nullable',
            'numeric',
         ],
         'printer_name' => 'required',
         'status' => 'required',
         'plant_id' => 'required',
         'printer_id' => 'required',
         'printer_password' => 'required'
      ]);
      if ($validator->fails()) {
         return redirect()->back()->withErrors($validator)->withInput();
      }
      $create = [
         'name' => $request->name,
         'code' => $request->code,
         'status' => $request->status,
         'printer_name' => $request->printer_name,
         'ip_address' => $request->ip_address,
         'plant_id' => $request->plant_id,
         'ip_printer' => $request->ip_printer,
         'port_printer' => $request->port_printer,
         'printer_id' => $request->printer_id,
      ];
      if ($request->has('Camera')) {
         $request->validate([
            'ip_camera' => 'required|max:50|regex:/^([0-9]{1,3}\.){3}[0-9]{1,3}$/',
            'port_camera' => 'required|max:4|regex:/^\d{1,9}$/',
         ]);
         $create['ip_camera'] = $request->ip_camera;
         $create['port_camera'] = $request->port_camera;
      }

      if ($request->has('PLC')) {
         $request->validate([
            'ip_plc' => 'required|max:50|regex:/^([0-9]{1,3}\.){3}[0-9]{1,3}$/',
            'port_plc' => 'required|max:4|regex:/^\d{1,9}$/',
         ]);
         $create['ip_plc'] = $request->ip_plc;
         $create['port_plc'] = $request->port_plc;
      }
      if (!empty($request->printer_password)) {
         $md5Hash = md5($request->printer_password);
         $base64Encoded = base64_encode($md5Hash);
         $create['auth_token'] = 'Auth_token_' . $request->printer_id . '=' . $base64Encoded;
      }
      $product = ProductionLines::create($create);

      return redirect('production-lines')->with('status', 'Production Lines Created Successfully');
   }
   public function show(Request $request, $id)
   {
      $productionlines = ProductionLines::where('id', $id)->first();
      return view('production-lines.show', compact('productionlines'));
   }

   public function edit($id)
   {
      if (!Auth::user()->can('update production')) {
         return view('dummy.unauthorized');
      }
      $productionplant = ProductionPlant::get();
      $productionlines = ProductionLines::findorFail($id);
      return view('production-lines.edit', compact('productionlines', 'productionplant'));
   }
   public function update(Request $request, $id)
   {
      $validator = Validator::make($request->all(), [
         'name' => [
            'required',
            'string',
            'regex:/^[a-zA-Z0-9-_ ]+$/u'
         ],
         'code' => [
            'required',
            'string',
            'regex:/^[a-zA-Z0-9-_]+$/u'
         ],
         'ip_address' => [
            'required',
            'regex:/^(?:\d{1,3}\.){3}\d{1,3}$/',
         ],
         'port' => [
            'nullable',
            'numeric',
         ],
         'printer_name' => 'required',
         'status' => 'required',
         'plant_id' => 'required',
         'printer_id' => 'required',
         'printer_password' => 'required'
      ]);
      if ($validator->fails()) {
         return redirect()->back()->withErrors($validator)->withInput();
      }
      $update = [
         'name' => $request->name,
         'code' => $request->code,
         'status' => $request->status,
         'printer_name' => $request->printer_name,
         'ip_address' => $request->ip_address,
         'plant_id' => $request->plant_id,
         'ip_printer' => $request->ip_printer,
         'port_printer' => $request->port_printer,
         'printer_id' => $request->printer_id,
      ];

      if ($request->has('Camera')) {
         $request->validate([
            'ip_camera' => 'required|max:50|regex:/^([0-9]{1,3}\.){3}[0-9]{1,3}$/',
            'port_camera' => 'required|max:4|regex:/^\d{1,9}$/',
         ]);
         $update['ip_camera'] = $request->ip_camera;
         $update['port_camera'] = $request->port_camera;
      }
      // $password = 123321;
      // $md5Hash = md5($password);

      // // Base64 encode the MD5 hash
      // $base64Encoded = base64_encode($md5Hash);
      // dd($base64Encoded);
      if ($request->has('PLC')) {
         $request->validate([
            'ip_plc' => 'required|max:50|regex:/^([0-9]{1,3}\.){3}[0-9]{1,3}$/',
            'port_plc' => 'required|max:4|regex:/^\d{1,9}$/',
         ]);
         $update['ip_plc'] = $request->ip_plc;
         $update['port_plc'] = $request->port_plc;
      }
      if (!empty($request->printer_password)) {
         $md5Hash = md5($request->printer_password);
         $base64Encoded = base64_encode($md5Hash);
         $update['auth_token'] = 'Auth_token_' . $request->printer_id . '=' . $base64Encoded;
      }
      $productionLine = ProductionLines::findOrFail($id);
      $productionLine->update($update);
      return redirect('production-lines')->with('status', 'Production Lines Updated Successfully');
   }
   public function destroy($id)
   {
      if (!Auth::user()->can('delete production')) {
         return view('dummy.unauthorized');
      }
      $ProductionLines = ProductionLines::find($id);
      $ProductionLines->delete();
      $productionjob = ProductionJob::where('line_id', $id);
      return redirect('production-lines')->with('status', 'Production Plant Deleted Successfully');
   }
}
