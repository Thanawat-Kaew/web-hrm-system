<?php

namespace App\Http\Controllers\TimeStamp;

use Illuminate\Http\Request;
use App\Http\Requests;
use App\Http\Controllers\Controller;
use App\Services\Forms\FormRepository;
use App\Services\TimeStamp\TimeStamp;
use App\Services\Employee\Employee;
use App\Services\Employee\EmployeeObject;
use App\Services\Request\RequestTimeStamp;
use App\Services\Request\RequestForgetToTime;

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
        if(\Session::has('current_employee')){
            $current_employee = \Session::get('current_employee');
        }
        $request = RequestTimeStamp::with('employee')->orderBy('id', 'desc')->get();
        //$request = Employee::with('eequesttimeStamp')->get();
        //$requesta = Employee::with('department')->with('request')
        //sd($request[0]);
        //sd($requesta->toArray());
        //sd($request->toArray());
        //$emp    = Employee::with('requesttimestamp')->where('id_employee', $request['id_employee'])->get();
        //sd($emp->toArray());
        return $this->useTemplate('time_stamp.time_stamp_request', compact('request'));
    }

    public function time_stamp_list_request()
    {
        return $this->useTemplate('time_stamp.list_request');
    }

    public function change_time_stamp_request()
    {
        return $this->useTemplate('time_stamp.change_time_stamp_request');
    }

    public function ajaxCenter(Request $request)
    {
    	$method = $request->get('method');
        switch ($method) {
            case 'getFormNewTimeClock': // ไม่ได้ลงเวลาเข้าและออก
                if(\Session::has('current_employee')){
                    $current_employee = \Session::get('current_employee');
                }

                $employee = TimeStamp::where('id_employee', $current_employee['id_employee'])->orderBy('id', 'desc')->first();
                //sd($employee->toArray());
                if($employee['status'] == 0){
                    $header = Employee::where('id_position', 2)->where('id_department', $current_employee['id_department'])->first();
                    /*$current_time = TimeStamp::where('id_employee', $current_employee['id_employee'])->where('status', 1)->first();
                    //sd($current_time->toArray());
                    //sd($current_time['time_in']);
                    $date_in = date('Y-m-d',strtotime($current_time['time_in']));
                    $time_in = date('H:i:s',strtotime($current_time['time_in']));
                    //sd($date);
                    //sd($time);
                    $time_break_out = date('H:i:s',strtotime($current_time['break_out']));

                    $time_break_in  = date('H:i:s',strtotime($current_time['break_in']));*/

                   	$form_repo = new FormRepository;
    				$form_new_time_clock = $form_repo->getFormNewTimeClock($header);
                    return response()->json(['status'=> 'success','data'=> $form_new_time_clock]);
                }else{
                    echo "คุณยังไม่ได้ลงเวลาออก";
                }
                break;

            case 'getRequestTimeStamp': // ลงแต่เวลาเข้าไม่ได้ลงเวลาออก //ลืมลงเวลา
                if(\Session::has('current_employee')){
                    $current_employee = \Session::get('current_employee');
                }
                $header = Employee::where('id_position', 2)->where('id_department', $current_employee['id_department'])->first();
                $form_repo = new FormRepository;
                $form_request_timestamp = $form_repo->getRequestTimeStamp($header);
                return response()->json(['status'=> 'success','data'=> $form_request_timestamp]);
                break;

            case 'getViewDataRequestTimeStamp': // ดูข้อมูลที่ร้องขอการลงเวลาย้อนหลัง
                $id             = $request->get('id');
                //sd($id);
                $data           = RequestTimeStamp::where('id', $id)->first();
                //sd($data->toArray());
                $form_repo = new FormRepository;
                $form_view_request_timestamp = $form_repo->getViewDataRequestTimeStamp($data);
                return response()->json(['status'=> 'success','data'=> $form_view_request_timestamp]);
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

    public function addRequestTimeStamp(Request $request) // การส่ง request timestamp ไปที่ database
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
        $request->break_out  = $break_out;
        $request->break_in   = $break_in;
        $request->time_out   = $time_out;
        $request->reason     = $reason;
        $request->delay_time = $delay_time;
        $request->status     = 2;

        $request->save();
    }

    public function confirmDataRequestTimeStamp(Request $request)  // กดอนุมัติ
    {
        if(\Session::has('current_employee')){
            $current_employee = \Session::get('current_employee');
        }
        $id          = $request->get('id');
        //sd($id);
        $confirm = RequestTimeStamp::find($id);
        //d($confirm->toArray());
        $confirm->status                 = 1;
        $confirm->approvers              = $current_employee['id_employee'];
        //sd($confirm->toArray());
        //sd($confirm['time_in']);
        $confirm->save();
        //sd($id_employee_request);

        $id_employee_request  = $confirm['id_employee']; // id ของผู้ request
        $date_time_in    = $confirm['delay_time'].' '.$confirm['time_in'];
        //sd($date_time_in);
        //var_dump($date_time_in);
        //var_dump($confirm['delay_time']);
        $date_break_out  = $confirm['delay_time'].' '.$confirm['break_out'];
        $date_break_in   = $confirm['delay_time'].' '.$confirm['break_in'];
        $date_time_out   = $confirm['delay_time'].' '.$confirm['time_out'];
        //sd($date_timein);
        $request = new TimeStamp();
        $request->id_employee   = $id_employee_request;
        $request->time_in       = $date_time_in;
        $request->break_out     = $date_break_out;
        $request->break_in      = $date_break_in;
        $request->time_out      = $date_time_out;
        $request->status        = 0;
        $request->save();

    }

    public function cancelDataRequestTimeStamp(Request $request)  // กดไม่อนุมัติ
    {
        if(\Session::has('current_employee')){
            $current_employee = \Session::get('current_employee');
        }
        $id              = $request->get('id');
        $reason_reject   = $request->get('reason_reject');
        //sd($id);
        $confirm = RequestTimeStamp::find($id);
        //d($confirm->toArray());
        $confirm->status               = 3;
        $confirm->approvers            = $current_employee['id_employee'];
        $confirm->reason_approvers     = $reason_reject;
        $confirm->save();
    }

    public function addRequestForgetToTime(Request $request)
    {
        if(\Session::has('current_employee')){
            $current_employee = \Session::get('current_employee');
        }

        $type_time            = $request->get('type_time');
        $time                 = $request->get('time');
        $reason               = $request->get('reason');
        $date                 = $request->get('date');

        // save data to database
        $request = new RequestForgetToTime();
        $request->id_employee = $current_employee['id_employee'];
        $request->date        = $date;
        $request->time        = $time;
        $request->type_time   = $type_time;
        $request->status      = 2;
        $request->reason      = $reason;
        $request->save();
    }



}