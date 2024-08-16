<?php

namespace App\Http\Controllers;

use App\Jobs\UserlogExceldownload;
use App\Models\User;
use Illuminate\Http\Request;
use App\Models\UserLog;
use Maatwebsite\Excel\Facades\Excel;
use App\Exports\UserLogExport;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\Cache;
use Illuminate\Support\Facades\Storage;


class UserLogController extends Controller
{
    public function index(Request $request)
    {
        $users = User::get();
        $userlog = UserLog::with('user')->orderBy('created_at', 'desc')->paginate(10);
        return view('userlog.index', compact('userlog', 'users'));
    }
    public function populatemodal(Request $request)
    {
        $attributes = json_decode($request->properties, true);

        if (!empty($attributes)) {
            $new_data = $attributes['attributes'] ?? "";
            if (array_key_exists('old', $attributes)) {
                $old_data = $attributes['old'];
            } else {
                $old_data = [];
            }
        } else {
            $new_data = [];
            $old_data = [];
        }
        return response()->json(['new_data' => $new_data, 'old_data' => $old_data]);
    }
    public function downloadexcel(Request $request)
    {
          $userlog = UserLog::with('user')->limit(1000)->get();
        // Return the Excel file directly
        return Excel::download(new UserLogExport($userlog), 'userlog.xlsx');

        // Return a response indicating that the export has started
        // return response()->json(['message' => 'Export started. You will be notified when it is ready for download.'], 200);
    }

    public function getDownloadLink(Request $request)
    {
        $filePath = cache('userlog_download_link');

        if ($filePath && Storage::exists($filePath)) {
            // Generate a URL to the file
            $downloadUrl = Storage::url($filePath);
            return response()->json(['download_link' => $downloadUrl], 200);
        }

        return response()->json(['message' => 'File not available yet or has expired.'], 404);
    }
    public function show(Request $request, $id)
    {
        $log_data = '';
        $userlog = UserLog::with('user')->findOrFail($id);
        $attributes = json_decode($userlog->properties, true);
        if (!empty($attributes)) {
            $new_data = $attributes['attributes'] ?? "";
            if (array_key_exists('old', $attributes)) {
                $old_data = $attributes['old'];
            } else if (!empty($attributes) && array_key_exists('name', $attributes)) {
                $new_data = [];
                $old_data = [];
                foreach ($attributes as $key => $singleattribute) {
                    $log_data .= $key . ': ' . $singleattribute . ' , ';

                    $log_data = rtrim($log_data, ' ,');
                }
            } else {
                $new_data = [];
                $old_data = [];
            }
            return view('userlog.show', compact('userlog', 'old_data', 'new_data', 'log_data'));
        }
    }
}
