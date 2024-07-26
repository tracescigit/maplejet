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

class AdminController extends Controller
{
    public function index()
    {
        $total_products=Product::count();
        $total_batch=Batch::count();
        $total_user=User::count();
        $total_qrcodes=Qrcode::count();
        $total_jobs=ProductionJob::count();
        $active_jobs = ProductionJob::where('status', 'Assigned')->count();
        return view('dashboard',compact('total_products','total_batch','total_user','total_qrcodes','total_jobs','active_jobs'));
    }
   
}
