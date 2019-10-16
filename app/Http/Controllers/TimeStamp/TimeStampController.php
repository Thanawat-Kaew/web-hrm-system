<?php

namespace App\Http\Controllers\TimeStamp;

use Illuminate\Http\Request;
use App\Http\Requests;
use App\Http\Controllers\Controller;
use App\Services\Forms\FormRepository;
use App\Services\TimeStamp\TimeStamp;
use App\Services\Employee\EmployeeObject;

class TimeStampController extends Controller
{
	public function index()
    {
        return $this->useTemplate('time_stamp.index');
    }

    public function time_stamp()
    {
        return view('time_stamp.time_stamp');
    }

    public function time_stamp_request()
    {
        return $this->useTemplate('time_stamp.time_stamp_request');
    }

    public function ajaxCenter(Request $request)
    {
    	$method = $request->get('method');
        switch ($method) {
            case 'getFormNewTimeClock':
               	$form_repo = new FormRepository;
				$form_new_time_clock = $form_repo->getFormNewTimeClock();
                return response()->json(['status'=> 'success','data'=> $form_new_time_clock]);
                break;

            default:
                # code...
                break;
        }

    }

    public function addTimeStamp(Request $request)
    {
        date_default_timezone_set('Asia/Bangkok');
        $type_time = $request->get('type_time'); //time_in, break_out, ...
        //sd($type_time);
        if(\Session::has('current_employee')){
            $current_employee = \Session::get('current_employee');
        }
        if($type_time == "time_in"){
            $time_stamp = new TimeStamp();
            $time_stamp->id_employee   = $current_employee['id_employee'];
            $time_stamp->time_in       = date('Y-m-d H:i:s');
            $time_stamp->save();
        }else if($type_time == "break_out"){
            //$time_stamp = TimeStamp::where('id_employee', $current_employee['id_employee'])->orderBy('created_at', 'desc')->first();
            //sd($time_stamp['id']);
            //$id = $current_time['id'];
            //$time_stamp = TimeStamp::find($id);
            //$time_stamp->break_out = date('Y-m-d H:i:s');
            //$time_stamp->save();
        }else if($type_time == "break_in"){
            $time_stamp->break_in  = date('Y-m-d H:i:s');
        }else if($type_time == "time_out"){
            $time_stamp->time_out  = date('Y-m-d H:i:s');
        }
        //sd($time_stamp['id']);
/*
        $time_stamp = new TimeStamp();
        $time_stamp->id_employee   = $current_employee['id_employee'];
        $time_stamp->time_in       = date('Y-m-d H:i:s');
        $time_stamp->save();*/

    }

}
