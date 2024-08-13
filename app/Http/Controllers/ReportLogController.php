<?php

namespace App\Http\Controllers;

use App\Models\ReportLog;
use Torann\GeoIP\Facades\GeoIP;
use Maatwebsite\Excel\Facades\Excel;
use Illuminate\Http\Request;
use App\Exports\ReportLogExport;

class ReportLogController extends Controller
{
   public function index(Request $request)
   {
      $query = ReportLog::query();

      // Apply filters
      if ($request->start_date) {
         $query->where('created_at', '>=', $request->start_date);
      }

      if ($request->end_date) {
         $query->where('created_at', '<=', $request->end_date);
      }
      // Apply pagination
      $reportlog = $query->paginate(10);
      $ipAddress = $request->ip();
      $geoIPData = GeoIP::getLocation($ipAddress);

      $latitude = $geoIPData['lat'];
      $longitude = $geoIPData['lon'];

      return view('reportlog.reportlog', compact('reportlog'));
   }
   public function show(Request $request,$id)
   {
     $reportlog=reportlog::where('id',$id)->first();
     return view('reportlog.show', compact('reportlog'));
      $reportlog = ReportLog::paginate(10);
      $ipAddress = $request->ip();
      $geoIPData = GeoIP::getLocation($ipAddress);

      $latitude = $geoIPData['lat'];
      $longitude = $geoIPData['lon'];

      return view('reportlog.reportlog', compact('reportlog'));
   }
   public function exceldownload(Request $request)
   {
 
      $userlog = ReportLog::get();
      return Excel::download(new ReportLogExport($userlog, $request->url()), 'reportlog.xlsx');
   }
}
