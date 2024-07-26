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
      $reportlog = ReportLog::paginate(10);
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
      // \DB::enableQueryLog();

      // Your original query
      $from = $request->start_date . ' 00:00:00';
      $to = $request->end_date . ' 23:59:59';
      $userlog = ReportLog::whereBetween('created_at', [$from, $to])->get();
      return Excel::download(new ReportLogExport($userlog, $request->url()), 'reportlog.xlsx');
   }
}
