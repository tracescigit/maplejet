<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;
use App\Models\UserLog;
use Maatwebsite\Excel\Facades\Excel;
use App\Exports\UserLogExport;

class UserLogController extends Controller
{
    public function index(Request $request)
    {
        $users=User::get();
        $userlog = UserLog::with('user')->paginate(10);
        return view('userlog.index', compact('userlog','users'));
    }
    public function populatemodal(Request $request)
    {
        $attributes=json_decode($request->properties, true);
        
        if(!empty($attributes)){
            $new_data=$attributes['attributes']??"";
            if(array_key_exists('old',$attributes)){
                $old_data=$attributes['old'];
            }else{
                $old_data=[];
            }
        }else{
            $new_data=[];
            $old_data=[];

        }
        return response()->json(['new_data'=>$new_data,'old_data'=>$old_data]);
    }
    public function downloadexcel(Request $request){
        
        if(!empty($request->user || $request->start_date || $request->end_date)){
            $from=$request->start_date;
            $to=$request->end_date;
            $userlog = UserLog::with('user')->whereBetween('created_at', [$from, $to])->get();
            return Excel::download(new UserLogExport($userlog,$request->user), 'userlog.xlsx');
        }
     
    }
    public function show(Request $request,$id)
    {
        $userlog = UserLog::findorFail($id)->with('user')->first();
        return view('userlog.show', compact('userlog'));
    }

    
}
