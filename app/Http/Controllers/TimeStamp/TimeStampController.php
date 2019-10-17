<?php

namespace App\Http\Controllers\TimeStamp;

use Illuminate\Http\Request;
use App\Http\Requests;
use App\Http\Controllers\Controller;
use App\Services\Forms\FormRepository;
use App\Services\TimeStamp\TimeStamp;
use App\Services\Employee\EmployeeObject;
use App\Services\Request\RequestTimeStamp;

class TimeStampController extends Controller
{
	public function index()
    {
        return $this->useTemplate('time_stamp.index');
    }

    public function time_stamp()
    {
        return $this->useTemplate('time_stamp.time_stamp');
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
                if(\Session::has('current_employee')){
                    $current_employee = \Session::get('current_employee');
                }
                $current_time = TimeStamp::where('id_employee', $current_employee['id_employee'])->where('status', 1)->first();
                //sd($current_time->toArray());
                //sd($current_time['time_in']);
                $date_in = date('Y-m-d',strtotime($current_time['time_in']));
                $time_in = date('H:i:s',strtotime($current_time['time_in']));
                //sd($date);
                //sd($time);
                $time_break_out = date('H:i:s',strtotime($current_time['break_out']));

                $time_break_in  = date('H:i:s',strtotime($current_time['break_in']));

               	$form_repo = new FormRepository;
				$form_new_time_clock = $form_repo->getFormNewTimeClock($current_time, $date_in, $time_in, $time_break_out, $time_break_in);
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
        //var_dump($type_time);
        //sd($type_time);
        //echo $type_time;
        if(\Session::has('current_employee')){
            $current_employee = \Session::get('current_employee');
        }
        if($type_time == "time_in"){
            $current_time = TimeStamp::where('id_employee', $current_employee['id_employee'])->orderBy('created_at', 'desc')->first();
            if($current_time['status'] == 0){
                $time_stamp = new TimeStamp();
                $time_stamp->id_employee   = $current_employee['id_employee'];
                $time_stamp->time_in       = date('Y-m-d H:i:s');
                $time_stamp->status        = 1;
                $time_stamp->save();
            }else{
                return "NotTimeIn";
            }
        }else if($type_time == "break_out"){
            $current_time = TimeStamp::where('id_employee', $current_employee['id_employee'])->orderBy('created_at', 'desc')->first();
            //sd($time_stamp['id']);
            $id = $current_time['id'];
            $time_stamp = TimeStamp::find($id);
            $time_stamp->break_out = date('Y-m-d H:i:s');
            $time_stamp->save();
        }else if($type_time == "break_in"){
            $current_time = TimeStamp::where('id_employee', $current_employee['id_employee'])->orderBy('created_at', 'desc')->first();
            $id = $current_time['id'];
            $time_stamp = TimeStamp::find($id);
            $time_stamp->break_in  = date('Y-m-d H:i:s');
            $time_stamp->save();
        }else if($type_time == "time_out"){
            $current_time = TimeStamp::where('id_employee', $current_employee['id_employee'])->orderBy('created_at', 'desc')->first();
            $id = $current_time['id'];
            $time_stamp = TimeStamp::find($id);
            $time_stamp->time_out  = date('Y-m-d H:i:s');
            $time_stamp->status        = 0;
            $time_stamp->save();
        }
        //sd($time_stamp['id']);
/*
        $time_stamp = new TimeStamp();
        $time_stamp->id_employee   = $current_employee['id_employee'];
        $time_stamp->time_in       = date('Y-m-d H:i:s');
        $time_stamp->save();*/

    }

    public function addRequestTimeStamp(Request $request)
    {
        if(\Session::has('current_employee')){
            $current_employee = \Session::get('current_employee');
        }

        $delay_time            = $request->get('delay_time');
        //sd($delay_time);
        $time_in               = $request->get('time_in');
        $break_out             = $request->get('break_out');
        $break_in              = $request->get('break_in');
        $time_out              = $request->get('time_out');
        $reason                = $request->get('reason');

        // save data to database
        $request = new RequestTimeStamp();
        $request->id_employee = $current_employee['id_employee'];
        $request->time_in     = $time_in;
        $request->$break_out  = $break_out;
        $request->$break_in   = $break_in;
        $request->$time_out   = $time_out;
        $request->$reason     = $reason;
        $request->$delay_time = $delay_time;
        $request->$status     = 2;

        $request->save();


    }



}
