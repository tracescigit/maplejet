<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\ProductionPlant;
use App\Models\Product;
use App\Models\ProductionJob;
use App\Models\ProductionLines;
use Illuminate\Support\Facades\Auth;

class ProductionPlantController extends Controller
{
    public function index(Request $request)
    {
        $query = ProductionPlant::query();
        // Apply filters
        if ($request->plants_search) {
            $query->where('code', 'like', '%' . $request->plants_search . '%');
        }

        if ($request->plants_name_search) {
            // Assuming you meant to filter by the production_lines.code
            $query->where('name', 'like', '%' . $request->plants_name_search . '%');
        }

        // Apply pagination
        $productionplant = $query->paginate(10);

        $productionplant1 = ProductionPlant::paginate(10);
        $prodactiveCount = $productionplant1->filter(function ($product) {
            return $product->status === 'Active';
        })->count();
        $last_added_plplant = ProductionPlant::select('name')->orderBy('created_at', 'desc')->first();
        return view('production-plants.index', compact('productionplant', 'last_added_plplant', 'prodactiveCount'));
    }
    public function create()
    {
        if (!Auth::user()->can('create production')) {
            return view('dummy.unauthorized');
        }
        $products = Product::get();
        return view('production-plants.create', compact('products'));
    }
    public function store(Request $request)
    {
        $request->validate([
            'name' => 'required|max:50|regex:/(^[a-zA-Z0-9 \-\&]+$)/u',
            'code' => 'required',
            'status' => 'required'
        ]);
        $product = ProductionPlant::create([
            'name' => $request->name,
            'code' => $request->code,
            'status' => $request->status,
        ]);
        return redirect('production-plants')->with('status', 'Production Plant Created Successfully');
    }

    public function show(Request $request, $id)
    {
        $productionplant = ProductionPlant::where('id', $id)->first();
        return view('production-plants.show', compact('productionplant'));
    }
    public function edit($id)
    {
        if (!Auth::user()->can('update production')) {
            return view('dummy.unauthorized');
        }
        $productionplant = ProductionPlant::findorFail($id);
        return view('production-plants.edit', compact('productionplant'));
    }
    public function update(Request $request, Productionplant $productionPlant)
    {
        $request->validate([
            'name' => 'required|max:50|regex:/(^[a-zA-Z0-9 \-\&]+$)/u',
            'code' => 'required',
            'status' => 'required'
        ]);
        $productionPlant->update([
            'name' => $request->name,
            'code' => $request->code,
            'status' => $request->status,
        ]);
        return redirect('production-plants')->with('status', 'Plant Details Updated Successfully');
    }
    public function destroy($id)
    {
        if (!Auth::user()->can('delete production')) {
            return view('dummy.unauthorized');
        }
        $ProductionPlant = ProductionPlant::find($id);
        $productionline = ProductionLines::where('plant_id', $id)->delete();
        $productionjob = ProductionJob::where('plant_id', $id);
        $ProductionPlant->delete();
        return redirect('production-plants')->with('status', 'Production Plant Deleted Successfully');
    }
}
