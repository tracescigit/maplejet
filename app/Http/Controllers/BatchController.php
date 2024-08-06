<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Batch;
use App\Models\Product;
use App\Imports\BatchesImport;
use Maatwebsite\Excel\Facades\Excel;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Validator;


class BatchController extends Controller
{
    public function index(Request $request)
    {
        $query = Batch::query()->with('product');

        // Apply filters
        if ($request->batches_search) {
            $query->where('code', 'like', '%' . $request->batches_search . '%');
        }

        if ($request->product_search) {
            $query->whereHas('product', function ($q) use ($request) {
                $q->where('name', 'like', '%' . $request->product_search . '%');
            });
        }

        if ($request->status_search) {
            $query->where('status', 'like', '%' . $request->status_search . '%');
        }

        // Apply pagination
        $batches = $query->paginate(10);

        // Calculate active products count
        $prodactiveCount = $batches->filter(function ($batch) {
            return $batch->status === 'Active';
        })->count();
        $last_added_batch = Batch::select('code')->orderBy('created_at', 'desc')->first();

        return view('batches.index', compact('batches','prodactiveCount','last_added_batch'));
    }
    public function create()
    {
        if (!Auth::user()->can('create batches')) {
             return view('dummy.unauthorized');
        }
        $products = Product::where('status','Active')->get();
        return view('batches.create', compact('products'));
    }
    public function store(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'product_id' => 'required|numeric',
            'code' => [
                'required',
                'string',
                'regex:/^[a-zA-Z0-9-_]+$/u'
            ],
            'mfg_date' => 'required|date',
            'exp_date' => 'required|date',
            'currency'=>'required',
            'price'=>'required',
        ]);
        if ($validator->fails()) {
            return redirect()->back()->withErrors($validator)->withInput();
        }
        $product = Batch::create([
            'product_id' => $request->product_id,
            'code' => $request->code,
            'currency' => $request->currency,
            'price' => $request->price,
            'status' => $request->status,
            'mfg_date' => $request->mfg_date,
            'exp_date' => $request->exp_date,
            'remarks' => $request->editor_content,
        ]);
        return redirect('batches')->with('status', 'Batch Created Successfully');
    }
    public function show($id) {
        $batch = Batch::where('id',$id)->with('product')->first();
        return view('batches.show',compact('batch'));

    return view("batches.show");

    }
    public function edit(Batch $batch)
    {
        if (!Auth::user()->can('update batches')) {
             return view('dummy.unauthorized');
        }
        $products = Product::get();
        return view('batches.edit', compact('batch', 'products'));
    }
    public function update(Request $request, $id)
    {
        $validator = Validator::make($request->all(), [
            'product_id' => 'required|numeric',
            'code' => [
                'required',
                'string',
                'regex:/^[a-zA-Z0-9-_]+$/u'
            ],
            'mfg_date' => 'required|date',
            'exp_date' => 'required|date',
            'currency'=>'required',
            'price'=>'required',
        ]);
        if ($validator->fails()) {
            return redirect()->back()->withErrors($validator)->withInput();
        }
        $batch = Batch::findOrFail($id);
        $batch->update([
            'product_id' => $request->product_id,
            'code' => $request->code,
            'currency' => $request->currency,
            'price' => $request->price,
            'status' => $request->status,
            'mfg_date' => $request->mfg_date,
            'exp_date' => $request->exp_date,
            'remarks' => $request->editor_content,
        ]);
        return redirect('batches')->with('status', 'Batch Updated Successfully');
    }
    public function destroy($id)
    {
        if (!Auth::user()->can('delete batches')) {
             return view('dummy.unauthorized');
        }
        $batch = Batch::find($id);
        $batch->delete();
        return redirect('batches')->with('status', 'Batch Deleted Successfully');
    }
    public function import()
    {
        Excel::import(new BatchesImport(), 'file.xlsx');

        return redirect()->back()->with('success', 'Data imported successfully.');
    }
}
