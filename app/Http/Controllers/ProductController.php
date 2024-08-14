<?php

namespace App\Http\Controllers;

use App\Models\Product;
use App\Custom\Validations;
use Illuminate\Support\Facades\Validator;
use App\Models\Qrcode;
use App\Models\Batch;
use App\Models\ScanHistory;
use Illuminate\Support\Facades\DB;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Http;

class ProductController extends Controller
{
    public function index(Request $request)
    {
        // Initialize the query
        $query = Product::query();

        // Apply filters
        if ($request->products_search) {
            $query->where('name', 'like', '%' . $request->products_search . '%');
        }

        if ($request->brands_search) {
            $query->where('brand', 'like', '%' . $request->brands_search . '%');
        }

        if ($request->company_search) {
            $query->where('company_name', 'like', '%' . $request->company_search . '%');
        }

        // Apply pagination
        $products = $query->paginate(10);

        // Calculate active products count
        $prodactiveCount = $products->filter(function ($product) {
            return $product->status === 'Active';
        })->count();
        $last_added_product = Product::select('name')->orderBy('created_at', 'desc')->first();
        // Return view with paginated products and active count
        return view('products.index', compact('products', 'prodactiveCount', 'last_added_product'));
    }
    public function show(Request $request, $id)
    {
        $product = Product::where('id', $id)->first();
        return view('products.show', compact('product'));
    }
    public function create()
    {
        if (!Auth::user()->can('create products')) {
            return view('dummy.unauthorized');
        }
        return view('products.create');
    }
    public function store(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'name' => [
                'required',
                'max:50',
                'regex:/^[a-zA-Z0-9-_ ]+$/u' // Regex to include spaces
            ],
            'brand' => [
                'required',
                'string',
                'regex:/^[a-zA-Z0-9-_ ]+$/u' // Regex to include spaces
            ],
            'company_name' => ['required', 'string'],
            'web_url' => 'required|url', // Validate URL
            'video' => 'nullable|mimetypes:video/mp4,video/quicktime|max:5120',
            'image' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:500',
            'label_img' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:500',
            'gtin' => [
                'nullable',
                'unique:products,gtin'
            ],
        ]);
        
        
        if ($validator->fails()) {
            return redirect()->back()->withErrors($validator)->withInput();
        }
        if ($request->hasFile('image')) {
            $imageName = time() . '.' . $request->image->getClientOriginalExtension();
            $request->image->move(public_path('images'), $imageName);
            $img = 'images/' . $imageName;
        }
        if ($request->hasFile('label_img')) {
            $label_img = time() . '.' . $request->label_img->getClientOriginalExtension();
            $request->label_img->move(public_path('images'), $label_img);
            $label_img = 'images/' . $label_img;
        }
        if ($request->hasFile('video')) {
            $videoName = time() . '.' . $request->video->getClientOriginalExtension();
            $request->video->move(public_path('videos'), $videoName);
            $video_url = 'videos/' . $videoName;
        }
        $product_name = str_replace(' ', '_', trim($request->name));
        $product = Product::create([
            'name' => $product_name,
            'brand' => $request->brand,
            'company_name' => $request->company_name,
            'gtin' => $request->gtin,
            'status' => $request->status,
            'bypass_conditions' => $request->bypass_conditions,
            'description' => $request->editor_content ?? "",
            'slug' => strtolower(str_replace(' ', '_', $request->company_name)),
            'web_url' => $request->web_url,
            'auth_required' => $request->auth_required == '1' ? 1 : 0,
            'image' => $img ?? "",
            'label' => $label_img ?? "",
            'media' => $video_url ?? "",
        ]);
        return redirect('products')->with('status', 'Products Created Successfully');
    }
    public function edit(Product $product)
    {
        if (!Auth::user()->can('update products')) {
            return view('dummy.unauthorized');
        }
        $media_base_url = config('constants.base_url');
        return view('products.edit', compact('product', 'media_base_url'));
    }
    public function update(Request $request, $id)
    {
        $validator = Validator::make($request->all(), [
            'name' => [
                'required',
                'max:50',
                'regex:/^[a-zA-Z0-9-_ ]+$/u' // Regex to include spaces
            ],
            'brand' => [
                'required',
                'string',
                'regex:/^[a-zA-Z0-9-_ ]+$/u' // Regex to include spaces
            ],
            'company_name' => ['required', 'string'],
            'web_url' => 'required|url', // Validate URL
            'video' => 'nullable|mimetypes:video/mp4,video/quicktime|max:5120',
            'image' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:500',
            'label_img' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:500',
            'gtin' => [
                'nullable',
                'unique:products,gtin' 
            ],
        ]);
        
        if ($validator->fails()) {
            return redirect()->back()->withErrors($validator)->withInput();
        }
        $product = Product::find($id);
        $updates = [
            'name' => $request->name,
            'brand' => $request->brand,
            'company_name' => $request->company_name,
            'gtin' => $request->gtin,
            'status' => $request->status,
            'bypass_conditions' => $request->bypass_conditions,
            'description' => $request->editor_content ?? "",
            'slug' => strtolower(str_replace(' ', '_', $request->company_name)),
            'web_url' => $request->web_url,
            'auth_required' => $request->auth_required == '1' ? 1 : 0,
        ];

        if ($request->hasFile('image')) {
            $imageName = time() . '.' . $request->image->getClientOriginalExtension();
            $request->image->move(public_path('images'), $imageName);
            $img = 'images/' . $imageName;
            $updates['image'] = $img;
        }

        if ($request->hasFile('label_img')) {
            $label_img = time() . '.' . $request->label_img->getClientOriginalExtension();
            $request->label_img->move(public_path('images'), $label_img);
            $label_img = 'images/' . $label_img;
            $updates['label'] = $label_img;
        }

        if ($request->hasFile('video')) {
            $videoName = time() . '.' . $request->video->getClientOriginalExtension();
            $request->video->move(public_path('videos'), $videoName);
            $video_url = 'videos/' . $videoName;
            $updates['media'] = $video_url;
        }

        $product->update($updates);

        return redirect('products')->with('status', 'Products Update Successfully');
    }
    public function destroy($id)
    {
        if (!Auth::user()->can('delete products')) {
            return view('dummy.unauthorized');
        }
        $product = Product::find($id);
        $product->delete();
        $qrcodes = Qrcode::where('product_id', $id)->delete();
        $batches = Batch::where('product_id', $id)->delete();

        return redirect('products')->with('status', 'Product Deleted Successfully');
    }
    public function getproductdetails(Request $request, $product_name = null, $qrcode = null)
    {
        $ip = $request->ip();
        // Get geolocation data from ipinfo.io without an API key
        $response = Http::get("https://ipinfo.io/{$ip}/json");

        if ($response->successful()) {
            $data = $response->json();

            // The 'loc' field contains both latitude and longitude separated by a comma
            $loc = $data['loc'] ?? null;
            $location = $loc ? explode(',', $loc) : [null, null];
            $latitude = $location[0];
            $longitude = $location[1];
        }
        if ($request->otp) {
            if ($request->otp != '123456') {
                return redirect()->back()->withInput()->with(['status' => 'OTP is incorrect. Please enter the correct OTP.']);
            }
        }
        $media_base_url = config('constants.base_url');
        $currentURL = url()->current();
        if (!empty($product_name) && !empty($request->id)) {
            $product = str_replace('_', ' ', $product_name);
            $product_id = Product::select('id')->where('name', $product)->first();
            if (empty($product_id)) {
                $product_id = Product::select('id')->where('gtin', $product)->first();
            }
            if (empty($product_id)) {
                $genuine = 'Product is Fake';
                return view('apicall.index', compact('genuine'));
            }
            $product_id_ver = DB::table('qrcodes')
                ->where('qrcodes.id', $request->id)
                ->where('qrcodes.product_id', $product_id->id)
                ->join('batches', 'qrcodes.batch_id', '=', 'batches.id')
                ->join('products', 'qrcodes.product_id', 'products.id')
                ->select('qrcodes.*', 'batches.*', 'products.*') // Select columns from both tables as needed
                ->first();
            $product_count = ScanHistory::where('qr_code', $qrcode)
                ->where('product_id', $product_id)
                ->get()
                ->count();
            if (empty($product_id_ver)) {
                $product_id_ver = DB::table('qrcodes')
                    ->where('qrcodes.product_id', $product_id->id)
                    ->join('batches', 'qrcodes.batch_id', '=', 'batches.id')
                    ->join('products', 'qrcodes.product_id', 'products.id')
                    ->select('qrcodes.*', 'batches.*', 'products.*') // Select columns from both tables as needed
                    ->first();
            }
            $currentDate = Carbon::now();
            $clientIp = request()->ip();
            $clientLocation = json_decode(file_get_contents("https://ipinfo.io/{$clientIp}/json"));

            $product_scanned_check = ScanHistory::where('qr_code', $qrcode)
                ->where('product_id', $product_id)
                ->where('ip_address', $clientIp)
                ->get()
                ->count();
            $batch_info = DB::table('qrcodes')
                ->join('batches', 'qrcodes.batch_id', '=', 'batches.id')
                ->select('qrcodes.*', 'batches.mfg_date', 'batches.exp_date')
                ->where('qrcodes.qr_code', $qrcode)
                ->first();
            if (!$request->otp && $product_id_ver->auth_required == 1) {
                return view('apicall.register', compact('product_id_ver', 'product_id', 'qrcode'));
            }
            if ($request->phone_number) {
                $request->validate([
                    'phone_number' => 'required|numeric',
                ]);
            }
            if ($product_scanned_check > 5) {
                return response()->json(['status' => 'Product is already scanned from this IP or Mobile.']);
            }
            ScanHistory::create([
                'product' => $product_id_ver->name,
                'batch' => $product_id_ver->batch_id,
                'genuine' => 1,
                'scan_count' => $product_count + 1,
                'ip_address' => $clientIp,
                'code_id' => $product_id_ver->id,
                'product_id' => $product_id->id,
                'qr_code' => $qrcode,
                'latitude' => $latitude,
                'longitude' => $longitude
            ]);
            if ($request->phone_number) {
                ScanHistory::where('code_id', $request->qrcode_id)->update([
                    'phone' => $request->phone_number,
                ]);
            }
            $product_scanned_count = ScanHistory::select('scan_count')->where('qr_code', $qrcode)
                ->where('product_id', $product_id)
                ->where('ip_address', $clientIp)
                ->get()
                ->count();
            $product_id_expiry_check = $product_id_ver->exp_date < $currentDate ? 'Expired' : '';


            if ($product_scanned_count > 10) {
                $genuine = "Product is Suspicious";
                return view('apicall.index', compact('product_id_ver', 'media_base_url', 'genuine', 'batch_info'));
            }
            $genuine = '';
            if ($product_id_expiry_check == 'Expired') {
                $genuine = "Product is Expired";
                return view('apicall.index', compact('product_id_ver', 'media_base_url', 'batch_info', 'genuine'));
            } else {
                $genuine = "Product is Genuine";
                return view('apicall.index', compact('product_id_ver', 'media_base_url', 'batch_info', 'genuine'));
            }
        } else {

            $genuine = 'Product is Fake';
            return view('apicall.index', compact('genuine'));
        }
    }
    public function getproductdetailsqr(Request $request, $qrcode)
    {
        $clientIp = request()->ip();

        if ($request->otp) {
            if ($request->otp != '123456') {
                return redirect()->back()->withInput()->with(['status' => 'OTP is incorrect. Please enter the correct OTP.']);
            }
        }
        $currentURL = url()->current();
        if (!empty($qrcode)) {
            $product_id_ver = DB::table('qrcodes')
                ->where('qr_code', $qrcode)
                ->join('batches', 'qrcodes.batch_id', 'batches.id')
                ->join('products', 'qrcodes.product_id', 'products.id')
                ->select('qrcodes.*', 'batches.*', 'products.*') // Select columns from both tables as needed
                ->first();
            if (empty($product_id_ver)) {
                return response()->json(['data' => 'Product is Fake.']);
            }
            $media_base_url = $product_id_ver->web_url;
            if (substr($media_base_url, -1) !== '/') {
                // Append a slash if it doesn't end with one
                $media_base_url .= '/';
            }
            $product_count = ScanHistory::where('qr_code', $qrcode)
                ->where('product_id', $product_id_ver->product_id)
                ->get()
                ->count();
            if ($product_id_ver) {
                $currentDate = Carbon::now();
                // $clientIp = request()->ip();
                $clientLocation = json_decode(file_get_contents("https://ipinfo.io/{$clientIp}/json"));

                $product_scanned_check = ScanHistory::where('qr_code', $qrcode)
                    ->where('product_id', $product_id_ver->product_id)
                    ->where('ip_address', $clientIp)
                    ->get()
                    ->count();

                if (empty($product_id_ver->name)) {
                    return response()->json(['status' => 'Product is Suspicious.']);
                }
                if (!$request->otp && $product_id_ver->auth_required == 1) {
                    return view('apicall.register', compact('product_id_ver', 'product_id', 'qrcode', 'clientIp','media_base_url'));
                }
                if ($request->phone_number) {
                    $request->validate([
                        'phone_number' => 'required|numeric',
                    ]);
                }
                // if ($product_scanned_check > 5) {
                //     return response()->json(['status' => 'Product is already scanned from this IP or Mobile.']);
                // }
                ScanHistory::create([
                    'product' => $product_id_ver->name,
                    'batch' => $product_id_ver->batch_id,
                    'genuine' => 1,
                    'scan_count' => $product_count + 1,
                    'ip_address' => $clientIp,
                    'code_id' => $product_id_ver->id,
                    'product_id' => $product_id_ver->product_id,
                    'qr_code' => $qrcode
                ]);
                if ($request->phone_number) {
                    ScanHistory::where('code_id', $request->qrcode_id)->update([
                        'phone' => $request->phone_number,
                    ]);
                }
                $product_scanned_count = ScanHistory::select('scan_count')->where('qr_code', $qrcode)
                    ->where('product_id', $product_id_ver->product_id)
                    ->where('ip_address', $clientIp)
                    ->get()
                    ->count();
                $product_id_expiry_check = DB::table('qrcodes')
                    ->join('batches', 'qrcodes.batch_id', '=', 'batches.id')
                    ->select('qrcodes.*', 'batches.mfg_date', 'batches.exp_date')
                    ->where('qrcodes.qr_code', $qrcode)
                    ->where('batches.mfg_date', '<', $currentDate)
                    ->where('batches.exp_date', '>', $currentDate)
                    ->get();

                // if ($product_scanned_count > 10) {
                //     if ($request->phone_number) {
                //         ScanHistory::where('code_id', $request->qrcode_id)->update([
                //             'genuine' => 2,
                //         ]);
                //     } 
                //     dd('ab');

                //     return response()->json(['status' => 'Product is Suspicious.']);
                // }
                $product_id_expiry_check = $product_id_ver->exp_date < $currentDate ? 'Expired' : '';


                if ($product_scanned_count > 10) {
                    $genuine = "Product is Suspicious";
                    return view('apicall.index', compact('product_id_ver', 'media_base_url', 'genuine'));
                }
                $genuine = '';
                if ($product_id_expiry_check == 'Expired') {
                    $genuine = "Product is Expired";
                    return view('apicall.index', compact('product_id_ver', 'media_base_url', 'genuine'));
                } else {
                    $genuine = "Product is Genuine";
                    return view('apicall.index', compact('product_id_ver', 'media_base_url', 'genuine'));
                }
            } else {
                $genuine = 'Product is Fake';
                return view('apicall.index', compact('genuine'));
            }
        } else {
            $genuine = 'Product is Fake';
            return view('apicall.index', compact('genuine'));
        }
    }
}
