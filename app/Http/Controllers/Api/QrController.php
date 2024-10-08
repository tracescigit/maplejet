<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Qrcode;
use App\Models\Product;
use App\Models\ReportedProductsModel;
use App\Models\ScanHistory;
use Illuminate\Support\Facades\DB;
use Carbon\Carbon;
use App\Models\OTP;
use App\Models\User_app;
use Illuminate\Support\Str;
use Laravel\Passport\Client;

class QrController extends Controller
{
    public function generateQRCode(Request $request, $product_id, $qrcode)
    {
        if ($request->otp) {
            if ($request->otp != '123456') {
                return redirect()->back()->withInput()->with(['status' => 'OTP is incorrect. Please enter the correct OTP.']);
            }
        }
        $media_base_url = config('constants.base_url');
        if (!empty($product_id) && !empty($qrcode)) {
            $product_id = Product::where('name', $product_id)->select('id')->first();
            $product_id = $product_id->id;
            $product_id_ver = Qrcode::where('qr_code', $qrcode)
                ->where('product_id', $product_id)
                ->with('product')
                ->first();
            dd($product_id_ver);
            $product_count = ScanHistory::where('qr_code', $qrcode)
                ->where('product_id', $product_id)
                ->get()
                ->count();
            if ($product_id_ver) {
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
                if (empty($product_id_ver->product)) {
                    return response()->json(['status' => 'Product is Suspicious.']);
                }
                if (!$request->otp && $product_id_ver->product->auth_required == 1) {
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
                    'product' => $product_id_ver->product->name,
                    'batch' => $product_id_ver->batch_id,
                    'genuine' => 1,
                    'scan_count' => $product_count + 1,
                    'ip_address' => $clientIp,
                    'code_id' => $product_id_ver->id,
                    'product_id' => $product_id,
                    'qr_code' => $qrcode
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
                $product_id_expiry_check = DB::table('qrcodes')
                    ->join('batches', 'qrcodes.batch_id', '=', 'batches.id')
                    ->select('qrcodes.*', 'batches.mfg_date', 'batches.exp_date')
                    ->where('qrcodes.qr_code', $qrcode)
                    ->where('batches.mfg_date', '<', $currentDate)
                    ->where('batches.exp_date', '>', $currentDate)
                    ->get();

                if ($product_scanned_count > 10) {
                    if ($request->phone_number) {
                        ScanHistory::where('code_id', $request->qrcode_id)->update([
                            'genuine' => 2,
                        ]);
                    }
                    return response()->json(['status' => 'Product is Suspicious.']);
                }
                $genuine = '';
                if ($product_id_expiry_check->isEmpty()) {
                    if (($product_count + 1) > 10) {
                        $genuine = "Product is Suspicious";
                    } else {
                        $genuine = "Product is Genuine";
                        return view('apicall.index', compact('product_id_ver', 'media_base_url', 'genuine', 'batch_info'));
                    }
                } else {
                    $genuine = "Product is Expired";
                    return view('apicall.index', compact('product_id_ver', 'media_base_url', 'batch_info', 'genuine'));
                    return response()->json(['status' => 'Product is Suspicious.']);
                }
                return response()->json([
                    'product_name' => $product_id_ver->product->name,
                    'genuine' => $genuine,
                    'scan_count' => $product_count + 1,
                ]);
            } else {
                return response()->json(['status' => 'Product is Fake.']);
            }
        } else {
            return response()->json(['data' => 'Product is Fake.']);
        }
    }
    public function register(Request $request)
    {
        $request->validate([
            'phone_number' => 'required|numeric',
        ]);

        // $user = Qrcode::create([
        //     'phone_number' => $request->phone_number,
        // ]);

        // Optionally, you can delete the OTP record from the database after successful registration
        // $otp->delete();

        return response()->json(['data' => $request->phone_number, 'id' => $request->qr_code_id]);
    }
    public function getotp(Request $request)
    {
        $request->validate([
            'phone_number' => 'required|numeric',
        ]);

        ScanHistory::where('code_id', $request->qrcode_id)->update([
            'phone' => $request->phone_number,
        ]);

        return response()->json(['data' => $request->phone_number, 'id' => $request->qr_code_id]);
    }
    public function scanhistoryall(Request $request, $product_id)
    {
        if ($product_id) {
            $scanHistory = ScanHistory::where('product_id', $product_id)->paginate(20);
            $items = $scanHistory->items();
            return $scanHistory;
        } else {
            return response()->json(['data' => 'Product ID not found.']);
        }
    }
    public function getproductdetails(Request $request, $product_id, $qrcode)
    {
        // if($request->otp){
        //     if($request->otp!='123456'){
        //         return redirect()->back()->withInput()->with(['status' => 'OTP is incorrect. Please enter the correct OTP.']);
        //     }
        // }
        $media_base_url = config('constants.base_url');
        if (!empty($product_id) && !empty($qrcode)) {
            $product_id_ver = Qrcode::where('qr_code', $qrcode)
                ->where('product_id', $product_id)
                ->with('product')
                ->first();

            $product_count = ScanHistory::where('qr_code', $qrcode)
                ->where('product_id', $product_id)
                ->get()
                ->count();
            if ($product_id_ver) {
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
                if (empty($product_id_ver->product)) {
                    return response()->json(['data' => 'Product is Suspicious.']);
                }
                // if (!$request->otp && $product_id_ver->product->auth_required == 1) {
                //     return view('apicall.register', compact('product_id_ver','product_id','qrcode'));

                // }
                if ($request->phone_number) {
                    $request->validate([
                        'phone_number' => 'required|numeric',
                    ]);
                }
                ScanHistory::create([
                    'product' => $product_id_ver->product->name,
                    'batch' => $product_id_ver->batch_id,
                    'genuine' => 1,
                    'scan_count' => $product_count + 1,
                    'ip_address' => $clientIp,
                    'code_id' => $product_id_ver->id,
                    'product_id' => $product_id,
                    'qr_code' => $qrcode
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
                $product_id_expiry_check = DB::table('qrcodes')
                    ->join('batches', 'qrcodes.batch_id', '=', 'batches.id')
                    ->select('qrcodes.*', 'batches.mfg_date', 'batches.exp_date')
                    ->where('qrcodes.qr_code', $qrcode)
                    ->where('batches.mfg_date', '<', $currentDate)
                    ->where('batches.exp_date', '>', $currentDate)
                    ->get();

                if ($product_scanned_count > 10) {
                    if ($request->phone_number) {
                        ScanHistory::where('code_id', $request->qrcode_id)->update([
                            'genuine' => 2,
                        ]);
                    }
                    return response()->json([
                        'product' => $product_id_ver,
                        'genuine' => 'Product is Suspicious',
                    ]);
                }
                $batch = DB::table('qrcodes')
                    ->join('batches', 'qrcodes.batch_id', '=', 'batches.id')
                    ->select('qrcodes.*', 'batches.mfg_date', 'batches.exp_date')
                    ->where('qrcodes.qr_code', $qrcode)
                    ->get();
                $genuine = '';
                return response()->json([
                    'error' => true,
                    'message' => 'Success',
                    'data' => [
                        'product' => $product_id_ver,
                        'genuine' => '2',
                        'batch' => $batch,
                        'scan_count' => $product_scanned_count
                    ]
                ]);
            } else {
                return response()->json([
                    'error' => true,
                    'message' => 'Success',
                    'data' => [
                        'genuine' => '0',
                    ]
                ]);
            }
        } else {
            return response()->json([
                'error' => true,
                'message' => 'Success',
                'data' => [
                    'genuine' => '0',
                ]
            ]);
        }
    }

    public function generateToken(Request $request)
    {
        $token = Str::random(40);
        return response()->json(['token' => $token], 200);
    }

    /*

   public function getuserdetails(Request $request)
    {
        $mobile = $request->input('mobile');
        $otp = $request->input('otp');
        if (!empty($mobile) && empty($otp)) {
            return response()->json([
                'error' => false,
                'message' => 'Success',
                'status' => 200,
                'data' => [
                    'otp' => '1234',
                    'message' => '',
                ],
            ]);
        } elseif (!empty($mobile) && !empty($otp)) {

            if ($otp === '1234') { // Replace '1234' with your actual OTP verification logic

                $user = User_app::where('mobile', $mobile)->first();

                if (!$user) {
                    // Create a new user
                    $user = User_app::create([
                        'mobile' => $mobile,
                    ]);
                }

                // Create a new client
                $client = Client::where('password_client', true)->first();

                // Generate a token for the user
                // $token = $user->createToken('Bearer Token', ['*'], $client)->accessToken;

                $token = $user->createToken('Bearer Token', ['user_id' => $user->user_id])->accessToken;

                // updating field table with token 
                User_app::where('mobile', $mobile)->update([
                    'bearer_token' => $token,
                ]);

                // Return success response
                return response()->json([
                    'error' => false,
                    'message' => 'Success',
                    'status' => 200,
                    'data' => [
                        'message' => 'User details stored successfully',
                        'bearer_token' => $token,
                        'user' => $user,
                    ],
                ]);
            } else {
                return response()->json([
                    'error' => false,
                    'message' => 'Invalid OTP. Please try again!',
                    'status' => 200,
                ], 400);
            }
        } else {
            return response()->json([
                'error' => false,
                'message' => 'Success',
                'status' => 200,
                'data' => [
                    'message' => 'Mobile Number not found',
                ], 200
            ]);
        }
    }

    
*/




    public function getapidetails(Request $request)
    {

        $user_id = $request['user']->user_id;
        $url = $request->input('url');
        $lat = $request->input('lat');
        $long = $request->input('long');
        $ip = $request->input('ip');
        $data_after_last_slash = basename($url);
        $qrcode_check = Qrcode::where('url', $url)
            ->first();
        if (!empty($qrcode_check)) {
            $product_id = $qrcode_check->product_id;
            $qrcode = $qrcode_check->qr_code;
            $media_base_url = config('constants.base_url');
            if (!empty($product_id) && !empty($qrcode)) {
                $product_id_ver = Qrcode::where('qr_code', $qrcode)
                    ->where('product_id', $product_id)
                    ->with('product')
                    ->first();

                $product_count = ScanHistory::where('qr_code', $qrcode)
                    ->where('product_id', $product_id)
                    ->get()
                    ->count();
                if ($product_id_ver) {
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
                    if (empty($product_id_ver->product)) {
                        return response()->json(['status' => 'Product is Suspicious.']);
                    }
                    if (!$request->otp && $product_id_ver->product->auth_required == 1) {
                        return view('apicall.register', compact('product_id_ver', 'product_id', 'qrcode'));
                    }
                    if ($request->phone_number) {
                        $request->validate([
                            'phone_number' => 'required|numeric',
                        ]);
                    }
                    if ($product_scanned_check > 50) {
                        return response()->json(['status' => 'Product is already scanned from this IP or Mobile.']);
                    }

                    $locationData = [
                        'lat' => $request->lat,
                        'long' => $request->long
                    ];

                    $scanHistory = ScanHistory::create([
                        'user_id' => $user_id,
                        'product' => $product_id_ver->product->name,
                        'batch' => $product_id_ver->batch_id,
                        'location' => json_encode($locationData),
                        'genuine' => 1,
                        'scan_count' => $product_count + 1,
                        'ip_address' => $clientIp,
                        'code_id' => $product_id_ver->id,
                        'product_id' => $product_id,
                        'qr_code' => $qrcode
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
                    $product_id_expiry_check = DB::table('qrcodes')
                        ->join('batches', 'qrcodes.batch_id', '=', 'batches.id')
                        ->select('qrcodes.*', 'batches.mfg_date', 'batches.exp_date')
                        ->where('qrcodes.qr_code', $qrcode)
                        ->where('batches.mfg_date', '<', $currentDate)
                        ->where('batches.exp_date', '>', $currentDate)
                        ->get();


                    $batch = DB::table('qrcodes')
                        ->join('batches', 'qrcodes.batch_id', '=', 'batches.id')
                        ->select('qrcodes.*', 'batches.mfg_date', 'batches.exp_date')
                        ->where('qrcodes.qr_code', $qrcode)
                        ->first();
                    $genuine = '';
                    if ($product_id_expiry_check->isEmpty()) {
                        $scanHistoryId = $scanHistory->id;
                        ScanHistory::where('id', $scanHistoryId)->update(['genuine' => 2]);
                        return response()->json([
                            'error' => true,
                            'message' => 'Success',
                            'data' => [
                                'qrdetails' => $product_id_ver,
                                'genuine' => '2',
                                'batch' => $batch,
                                'scan_count' => $product_scanned_count
                            ],
                        ]);
                    } else {
                        if (($product_count + 1) > 10) {
                            $scanHistoryId = $scanHistory->id;
                            ScanHistory::where('id', $scanHistoryId)->update(['genuine' => 2]);
                            return response()->json([
                                'error' => true,
                                'message' => 'Success',
                                'data' => [
                                    'qrdetails' => $product_id_ver,
                                    'genuine' => '2',
                                    'batch' => $batch,
                                    'scan_count' => $product_scanned_count
                                ]
                            ]);
                        } else {
                            $scanHistoryId = $scanHistory->id;
                            ScanHistory::where('id', $scanHistoryId)->update(['genuine' => 1]);
                            return response()->json([
                                'error' => true,
                                'message' => 'Success',
                                'data' => [
                                    'qrdetails' => $product_id_ver,
                                    'genuine' => '1',
                                    'batch' => $batch,
                                    'scan_count' => $product_scanned_count
                                ]
                            ]);
                        }
                    }
                } else {
                    $locationData = [
                        'lat' => $request->lat,
                        'long' => $request->long
                    ];
                    $scanHistory = ScanHistory::create([
                        'user_id' => $user_id,
                        'product' => "*Fake Product*",
                        'genuine' => 0,
                        'location' => json_encode($locationData)

                    ]);

                    return response()->json([
                        'error' => true,
                        'message' => 'Success',
                        'data' => [
                            'genuine' => '0'
                        ]
                    ]);
                }
            } else {
                $locationData = [
                    'lat' => $request->lat,
                    'long' => $request->long
                ];
                $scanHistory = ScanHistory::create([
                    'user_id' => $user_id,
                    'product' => "*Fake Product*",
                    'genuine' => 0,
                    'location' => json_encode($locationData)

                ]);
                return response()->json([
                    'error' => true,
                    'message' => 'Success',
                    'data' => [
                        'genuine' => '0'
                    ]
                ]);
            }
        } else {
            $locationData = [
                'lat' => $request->lat,
                'long' => $request->long
            ];
            $scanHistory = ScanHistory::create([
                'user_id' => $user_id,
                'product' => "*Fake Product*",
                'genuine' => 0,
                'location' => json_encode($locationData)

            ]);
            return response()->json([
                'error' => true,
                'message' => 'Success',
                'data' => [
                    'genuine' => '0'
                ]
            ]);
        }
    }

    public function reportProducts(Request $request)
    {


        // Validate the request

        // $request->validate([
        //     'image' => 'image|mimes:jpeg,png,jpg,gif|max:2048', // Adjust validation rules as needed
        //     'lat' => 'required',
        //     'long' => 'required',
        //     'product_id' => 'required',
        //     'report_reason'  => 'required'

        // ]);



        $user_id = $request['user']->user_id;

        if ($request->hasFile('image')) {

            $imageName = time() . '.' . $request->image->getClientOriginalExtension();
            $request->image->move(public_path('images'), $imageName);
            $img = 'images/' . $imageName;
        }

        // saving other data
        ReportedProductsModel::create([
            'reporter_id' => $user_id,
            'lat' => $request->lat,
            'long' => $request->long,
            'report_reason' => $request->report_reason,
            'image_path' => $img ?? "",
            'mobile' => $request['user']->mobile,
            'description' => $request->description
        ]);

        return response()->json([
            'error' => false,
            'message' => 'Report submitted!',
            'data' => [
                'message' => 'Your query has been submited.' // Path where the image is stored
                // Full URL of the stored image
            ]
        ]);
    }


    public function scanHistory(Request $request)
    {

        $user_id = $request['user']->user_id;
        $scanHistory = ScanHistory::where('user_id', $user_id)
            ->paginate(2);

        if ($scanHistory->isEmpty()) {
            return response()->json([
                'error' => false,
                'message' => 'Scan history not found',
                'data' => []
            ], 404);
        }

        // Return paginated scan history with metadata
        return response()->json([

            'error' => false,
            'message' => 'Success',
            'data' => [
                'scan_history' => $scanHistory->items(),
                'total' => $scanHistory->total(),
                'per_page' => $scanHistory->perPage(),
                'current_page' => $scanHistory->currentPage(),
                'last_page' => $scanHistory->lastPage(),
            ]

        ]);

        return $scanHistory;
    }

    public function getuserdetails(Request $request)
    {
        $mobile = $request->input('mobile');
        $otp = $request->input('otp');

        if (!empty($mobile) && empty($otp)) {

            // Generate and store OTP in session
            $otp = '1234'; // Generate OTP (replace with your logic)

            return response()->json([
                'error' => false,
                'message' => 'Success',
                'status' => 200,
                'data' => [
                    'otp' => $otp,
                    'message' => 'OTP sent successfully!',
                ],
            ]);
        } elseif (!empty($mobile) && !empty($otp)) {

            if ($otp === '1234') { // Replace '1234' with your actual OTP verification logic

                $user = User_app::where('mobile', $mobile)->first();

                if (!$user) {
                    $locationData = [
                        'lat' => $request->lat,
                        'long' => $request->long
                    ];
                    $user = User_app::create([
                        'mobile' => $mobile,
                        'location' => json_encode($locationData)
                    ]);
                    // Create a new client
                    // Generate a token for the user
                    $client = Client::where('password_client', true)->first();
                    $token = $user->createToken('Bearer Token', ['*'], $client)->accessToken;


                    // updating field table with token 
                    User_app::where('mobile', $mobile)->update([
                        'bearer_token' => $token,
                    ]);
                    $user_updated = User_app::where('mobile', $mobile)->first();
                    return response()->json([
                        'error' => false,
                        'message' => 'Success',
                        'status' => 200,
                        'data' => [
                            'message' => 'User details stored successfully',
                            'user' => $user_updated,
                        ],
                    ]);
                } else {
                    $locationData = [
                        'lat' => $request->lat,
                        'long' => $request->long
                    ];
                    User_app::where('mobile', $mobile)->update([
                        'location' => $locationData,
                    ]);
                    $user_updated = User_app::where('mobile', $mobile)->first();
                    return response()->json([
                        'error' => false,
                        'message' => 'Success',
                        'status' => 200,
                        'data' => [
                            'message' => 'User details stored successfully',
                            'user' => $user_updated,
                        ],
                    ]);
                }


                // Return success response

            } else {
                return response()->json([
                    'error' => false,
                    'message' => 'Invalid OTP. Please try again!',
                    'status' => 200,
                ], 400);
            }
        } else {
            return response()->json([
                'error' => true,
                'message' => 'Invalid request',
                'status' => 400,
            ], 400);
        }
    }


    function showUserProfile(Request $request)
    {
        $user_id = $request['user']->user_id;
        $user = User_app::where('user_id', $user_id)->first();
        return response()->json([
            'error' => false,
            'message' => 'Success',
            'status' => 200,
            'data' => [
                'message' => 'User details stored successfully',
                'user' => $user,
            ]
        ],);
    }


    function editProfile(Request $request)
    {

        $user_id = $request['user']->user_id;
        $imageName = time() . '.' . $request->user_profile->getClientOriginalExtension();
        $request->user_profile->move(public_path('images'), $imageName);
        $img = 'images/' . $imageName;



        try {
            // Update the user record based on user_id
            User_app::where('user_id', $user_id)->update([
                'email' => $request->email,
                'name' => $request->name,
                'user_profile' => $img
            ]);

            // Retrieve the updated user details
            $user = User_app::where('user_id', $user_id)->first();


            // Return success response with updated user details
            return response()->json([
                'error' => false,
                'message' => 'Success',
                'status' => 200,
                'data' => [
                    'message' => 'User details updated successfully',
                    'user' => $user,
                ]
            ]);
        } catch (\Exception $e) {


            // Handle any exceptions or errors that occur during the update process
            return response()->json([
                'error' => true,
                'message' => 'Failed to update user',
                'status' => 500,
                'data' => [
                    'message' => 'Failed to update user',
                ]
            ]);
        }
    }
}
