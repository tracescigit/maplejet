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
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Facades\Auth;

use Illuminate\Support\Facades\Password;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\Log;
use App\Mail\PasswordResetMail;
use Illuminate\Support\Facades\Validator;

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
        $formattedLocations1 = $locations->map(function($location) {
            return [
                'lat' => $location->latitude,
                'lng' => $location->longitude,
            ];
        });
        $formattedLocations=json_encode($formattedLocations1);
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
    public function SendPassword(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'email' => 'required|email|exists:users,email',
        ], [
            'email.required' => 'The email field is required.',
            'email.email' => 'The email format is invalid.',
            'email.exists' => 'The email address does not exist in our records.',
        ]);
    
        if ($validator->fails()) {
            return redirect()->back()->withErrors($validator)->withInput();
        }
        $email = $request->input('email');

        // Generate a new password
        $newPassword = $this->generateRandomPassword();

        // Find the user by email
        $user = User::where('email', $email)->first();

        if (!$user) {
            return response()->json(['message' => 'User not found.'], 404);
        }

        // Update the user's password
        $user->password = Hash::make($newPassword);
        $user->save();

        // Send the new password to the user via email
        try {
            Mail::to($email)->send(new PasswordResetMail($newPassword));
        } catch (\Exception $e) {
            Log::error('Error sending password reset email: ' . $e->getMessage());
            return response()->json(['message' => 'Error sending email.'], 500);
        }

        return redirect()->back()->with('success', 'Password has been reset and emailed to you.');
        
    }
    private function generateRandomPassword($length = 8)
    {
        $uppercase = 'ABCDEFGHIJKLMNOPQRSTUVWXYZ';
        $lowercase = 'abcdefghijklmnopqrstuvwxyz';
        $numbers = '0123456789';
        $specialChars = '!@#$%^&*()_+-=[]{}|;:,.<>?';

        $password = '';
        $password .= $uppercase[random_int(0, strlen($uppercase) - 1)];
        $password .= $lowercase[random_int(0, strlen($lowercase) - 1)];
        $password .= $numbers[random_int(0, strlen($numbers) - 1)];
        $password .= $specialChars[random_int(0, strlen($specialChars) - 1)];

        $allChars = $uppercase . $lowercase . $numbers . $specialChars;
        for ($i = 4; $i < $length; $i++) {
            $password .= $allChars[random_int(0, strlen($allChars) - 1)];
        }

        return str_shuffle($password);
    }
    public function logoutlanding(Request $request){
        Auth::guard('web')->logout();

        $request->session()->invalidate();

        $request->session()->regenerateToken();

        return view('auth.logout');
    }
    public function changepass(Request $request){
        return view('auth.changepassword');
    }
    public function changepasssave(Request $request){
        $validator = Validator::make($request->all(), [
            'password' => [
                'required',
                'string',
                'min:8', // Minimum length of 8 characters
                'regex:/[A-Za-z]/', // Must contain at least one letter
                'regex:/[!@#$%^&*(),.?":{}|<>]/', // Must contain at least one special character
            ],
        ]);
        if ($validator->fails()) {
            return redirect()->back()->withErrors($validator)->withInput();
        }
        $user = Auth::user();
        $user->password = Hash::make($request->input('new_password'));
        $user->update();
    
        return redirect()->route('dashboard')->with('status', 'Password updated successfully.');
    }
    public function viewprofile(Request $request){
        $user=Auth::user();
        return view('auth.viewprofile',compact('user'));
    }
    
 }
