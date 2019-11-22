<?php

namespace App\Http\Controllers\TimeStamp;

use Illuminate\Http\Request;
use App\Http\Requests;
use App\Http\Controllers\Controller;
use App\Services\Forms\FormRepository;
use App\Services\TimeStamp\TimeStamp;
use App\Services\Employee\Employee;
use App\Services\Department\Department;
use App\Services\Position\Position;
use App\Services\Employee\EmployeeObject;
use App\Services\Request\RequestTimeStamp;

class TimeStampController extends Controller
{

	public function index()
    {
        if(\Session::has('current_employee')){
            $current_employee = \Session::get('current_employee');
        }
        $date_today   = date('Y-m-d');
        $data = TimeStamp::with('employee')->with('requesttimestamp')->where('id_employee', $current_employee['id_employee'])->orderBy('id', 'desc')->get();

        // sd($data->toArray());
        return $this->useTemplate('time_stamp.index', compact('data'));
    }

    public function request_history() //ดูประวัติการร้องขอ
    {
        if(\Session::has('current_employee')){
            $current_employee = \Session::get('current_employee');
        }
        $request = RequestTimeStamp::with('employee')->where('id_employee', $current_employee['id_employee'])->orderBy('id', 'desc')->get();
        //sd($request->toArray());
        return $this->useTemplate('time_stamp.request_history', compact('request'));
    }


    public function time_stamp() // ขึ้นข้อมูลปัจจุบัน
    {
        if(\Session::has('current_employee')){
            $current_employee = \Session::get('current_employee');
        }
        $date_today   = date('Y-m-d');
        $current_data_time = TimeStamp::with('employee')->where('id_employee', $current_employee['id_employee'])->where('date', $date_today)->first();
        //sd($current_data->toArray());
        $current_data = Employee::with('timestamp')->where('id_employee', $current_data_time['id_employee'])->first();
        //sd($current_data->toArray());
        $current_data_position = Position::with('employee')->where('id_position', $current_data['id_position'])->first();
        //sd($current_data_position->toArray());
        return view('time_stamp.time_stamp', compact('current_data_time', 'current_data', 'current_data_position'));
    }

    public function time_stamp_request() // หน้า confirm/cancel การลงวลาย้อนหลัง
    {
        if(\Session::has('current_employee')){
            $current_employee = \Session::get('current_employee');
        }
        $request = RequestTimeStamp::with('employee')->where('approvers', $current_employee['id_employee'])->orderBy('id', 'desc')->get();
        //sd($request->toArray());
        return $this->useTemplate('time_stamp.time_stamp_request', compact('request'));
    }

    public function ajaxCenter(Request $request)
    {
    	$method = $request->get('method');
        switch ($method) {
            case 'getFormNewTimeClock': // ลงเวลาย้อนหลัง
            if(\Session::has('current_employee')){
                $current_employee = \Session::get('current_employee');
            }
                // $employee = TimeStamp::where('id_employee', $current_employee['id_employee'])->get();
            $header = Employee::where('id_position', 2)->where('id_department', $current_employee['id_department'])->first();
            $form_repo = new FormRepository;
            $form_new_time_clock = $form_repo->getFormNewTimeClock($header);
            return response()->json(['status'=> 'success','data'=> $form_new_time_clock]);
            break;

            case 'getRequestTimeStamp':  //ลืมลงเวลา
            if(\Session::has('current_employee')){
                $current_employee = \Session::get('current_employee');
            }
            $header = Employee::where('id_position', 2)->where('id_department', $current_employee['id_department'])->first();
            $form_repo = new FormRepository;
            $form_request_timestamp = $form_repo->getRequestTimeStamp($header);
            return response()->json(['status'=> 'success','data'=> $form_request_timestamp]);
            break;

            case 'getViewDataRequestTimeStamp': // ดูข้อมูลที่ร้องขอการลงเวลาย้อนหลัง // ดูของลูกน้อง
            $id             = $request->get('id');
                //sd($id);
            $data           = RequestTimeStamp::where('id', $id)->first();
                //sd($data->toArray());
            $form_repo = new FormRepository;
            $form_view_data_request_timestamp = $form_repo->getViewDataRequestTimeStamp($data);
                //sd($form_view_request_timestamp);
            return response()->json(['status'=> 'success','data'=> $form_view_data_request_timestamp]);
            break;

            case 'getViewRequestTimeStamp': // ดูลายละเอียดที่ขอลงเวลาย้อนหลัง //ดูของตัวเอง
            $id             = $request->get('id');
                //sd($id);
            //$data           = TimeStamp::where('id', $id)->first();
            $data           = RequestTimeStamp::where('id', $id)->first();
                //sd($data->toArray());
            $form_repo = new FormRepository;
            $form_view_request_timestamp = $form_repo->getViewRequestTimeStamp($data);
            return response()->json(['status'=> 'success','data'=> $form_view_request_timestamp]);
            break;

            case 'getEditRequestTimeStamp': // แก้ไข้ข้อมูลที่ร้องขอไป
            if(\Session::has('current_employee')){
                $current_employee = \Session::get('current_employee');
            }
            $header = Employee::where('id_position', 2)->where('id_department', $current_employee['id_department'])->first();
            $id         = $request->get('id');
            /*$request    = TimeStamp::find($id);
            $date       = $request->date;*/
                //sd($date);
            $data           = RequestTimeStamp::where('id', $id)->first();
            //sd($data->toArray());
                //sd($data->toArray());
                //sd($data['time_in']);
            $form_repo = new FormRepository;
            $form_edit_request_timestamp = $form_repo->getEditRequestTimeStamp($header, $data);
            return response()->json(['status'=> 'success','data'=> $form_edit_request_timestamp]);
            break;

            default:
                # code...
            break;
        }

    }

    public function addTimeStamp(Request $request) // ลงเวลาเข้า-ออกงาน
    {
        date_default_timezone_set('Asia/Bangkok');
        $type_time = $request->get('type_time'); //time_in, break_out, ...
        //sd($type_time);
        $pass = $request->get('pass');
        //sd($pass);
        if(\Session::has('current_employee')){
            $current_employee = \Session::get('current_employee');
        }
        if($pass !== $current_employee['password']){
            return ['status' => 'failed_password','message' => "failed_password"];
        }
        $date_today   = date('Y-m-d');
        if($type_time == "time_in"){
            $current_time = TimeStamp::where('id_employee', $current_employee['id_employee'])->orderBy('date', 'desc')->first();
            $latest_date  = $current_time['date'];
            //sd($latest_date);
            if($latest_date !== $date_today){ //time_in ซ้ำไม่ได้
                $time_stamp = new TimeStamp();
                $time_stamp->id_employee   = $current_employee['id_employee'];
                $time_stamp->date          = date('Y-m-d');
                $time_stamp->time_in       = date('H:i:s');
                $time_stamp->save();
                return ['status' => 'success_timein','message' => "success"];
            }else{
                return ['status' => 'failed_timein','message' => "failed"];
            }
        }else if($type_time == "break_out"){
            $current_time = TimeStamp::where('id_employee', $current_employee['id_employee'])->where('date', $date_today)->first();
            if(empty($current_time['break_out'])){
                $id = $current_time['id'];
                $time_stamp = TimeStamp::find($id);
                $time_stamp->break_out = date('Y-m-d H:i:s');
                $time_stamp->save();
                return ['status' => 'success_breakout','message' => "success"];
            }else{
                 return ['status' => 'failed_breakout','message' => "failed"];
            }
        }else if($type_time == "break_in"){

            $current_time = TimeStamp::where('id_employee', $current_employee['id_employee'])->where('date', $date_today)->first();
            if(empty($current_time['break_in'])){
                $id = $current_time['id'];
                $time_stamp = TimeStamp::find($id);
                $time_stamp->break_in = date('Y-m-d H:i:s');
                $time_stamp->save();
                return ['status' => 'success_breakin','message' => "success"];
            }else{
                return ['status' => 'failed_breakin','message' => "failed"];
            }
        }else if($type_time == "time_out"){
            $current_time = TimeStamp::where('id_employee', $current_employee['id_employee'])->where('date', $date_today)->first();
            if(empty($current_time['time_out'])){
                $id = $current_time['id'];
                $time_stamp = TimeStamp::find($id);
                $time_stamp->time_out = date('Y-m-d H:i:s');
                $time_stamp->save();
                return ['status' => 'success_timeout','message' => "success"];
            }else{
                return ['status' => 'failed_timeout','message' => "failed"];
            }
        }
    }

    public function addRequestTimeStamp(Request $request) // บันทึกลง request_time_stamp
    {
        date_default_timezone_set('Asia/Bangkok');
        if(\Session::has('current_employee')){
            $current_employee = \Session::get('current_employee');
        }

        $request_date                       = $request->get('request_date');
        $time_in                            = $request->get('time_in');
        $break_out                          = $request->get('break_out');
        $break_in                           = $request->get('break_in');
        $time_out                           = $request->get('time_out');
        $reason                             = $request->get('reason');
        $array_time                         = [
                                                'time_in' =>$time_in,
                                                'time_out' => $time_out,
                                                'break_in' => $break_in,
                                                'break_out' => $break_out,
                                            ];

        $verify_request  = RequestTimeStamp::where('request_date', $request_date)->where('id_employee', $current_employee['id_employee'])->where('status', 2)->get();
        $count_data = count($verify_request->toArray());
        $verify_timestamp = TimeStamp::where('date', $request_date)->where('id_employee', $current_employee['id_employee'])->first();
        $result = [];
        $request_type = [];
        if(!empty($verify_timestamp)){  // ถ้ามีrecord ของ timestamp
            if(!empty($time_in)){ //ถ้า มีการส่งค่า time_in
                if(!empty($verify_timestamp['time_in'])){ //ถ้า time_in ของ timestamp มีข้อมูลอยู่
                    $result['t_in'] = "มีการบันทึกเวลาเข้าทำงานแล้ว";
                }else{ // ถ้าไม่มีก็ new record ที่ request_time_stamp
                    if($count_data !== 0){  // check ใน request_time_stamp
                        for($i=0; $i<$count_data; $i++){
                            $request_type[] = $verify_request[$i]['request_type'];
                        }
                        if(in_array("time_in", $request_type)){
                            $result['t_in'] = "มีการส่งคำร้องขอลงเวลาเข้าทำงานย้อนหลังแล้ว";
                        }else{
                            $timeStamp                    = new RequestTimeStamp();
                            $timeStamp->id_employee       = $current_employee['id_employee'];
                            $timeStamp->request_date      = $request_date;
                            $timeStamp->request_type      = "time_in";
                            $timeStamp->request_time      = $time_in;
                            $timeStamp->reason            = $reason;
                            $timeStamp->status            = 2;
                            $timeStamp->detail            = "user กรอก time_in มา วันที่ตรงแต่ไม่มี time_in 1";
                            $timeStamp->approvers         = $request->get('approvers_id');
                        }
                    }else{
                        $timeStamp                    = new RequestTimeStamp();
                        $timeStamp->id_employee       = $current_employee['id_employee'];
                        $timeStamp->request_date      = $request_date;
                        $timeStamp->request_type      = "time_in";
                        $timeStamp->request_time      = $time_in;
                        $timeStamp->reason            = $reason;
                        $timeStamp->status            = 2;
                        $timeStamp->detail            = "user กรอก time_in มาวันที่ไม่ตรง 2";
                        $timeStamp->approvers         = $request->get('approvers_id');
                    }
                }
            }

            if(!empty($break_out)){
                if(!empty($verify_timestamp['break_out'])){
                    $result['b_out'] = "มีการบันทึกเวลาพักกลางวันแล้ว";
                }else{
                    if(($count_data !== 0)){
                        for($i=0; $i<$count_data; $i++){
                            $request_type[] = $verify_request[$i]['request_type'];
                        }
                        if(in_array("break_out", $request_type)){
                            $result['b_out'] = "มีการส่งคำร้องขอลงเวลาพักกลางวันย้อนหลังแล้ว";
                        }else{
                            $timeStamp                    = new RequestTimeStamp();
                            $timeStamp->id_employee       = $current_employee['id_employee'];
                            $timeStamp->request_date      = $request_date;
                            $timeStamp->request_type      = "break_out";
                            $timeStamp->request_time      = $break_out;
                            $timeStamp->reason            = $reason;
                            $timeStamp->status            = 2;
                            $timeStamp->detail            = "user กรอก break_out มา วันที่ตรงแต่ไม่มี break_out 1";
                            $timeStamp->approvers         = $request->get('approvers_id');
                            $timeStamp->save();
                        }
                    }else{
                        $timeStamp                    = new RequestTimeStamp();
                        $timeStamp->id_employee       = $current_employee['id_employee'];
                        $timeStamp->request_date      = $request_date;
                        $timeStamp->request_type      = "break_out";
                        $timeStamp->request_time      = $break_out;
                        $timeStamp->reason            = $reason;
                        $timeStamp->status            = 2;
                        $timeStamp->detail            = "user กรอก break_out มาวันที่ไม่ตรง 2";
                        $timeStamp->approvers         = $request->get('approvers_id');
                        $timeStamp->save();
                    }
                }
            }

            if(!empty($break_in)){
                if(!empty($verify_timestamp['break_in'])){
                    $result['b_in'] = "มีการบันทึกเวลาเข้าทำงานช่วงบ่ายแล้ว";
                }else{
                    if($count_data !== 0){
                        for($i=0; $i<$count_data; $i++){
                            $request_type[] = $verify_request[$i]['request_type'];
                        }
                        if(in_array("break_in", $request_type)){
                            $result['b_in'] = "มีการส่งคำร้องขอลงเวลาเข้าทำงานช่วงบ่ายแล้ว";
                        }else{
                            $timeStamp                    = new RequestTimeStamp();
                            $timeStamp->id_employee       = $current_employee['id_employee'];
                            $timeStamp->request_date      = $request_date;
                            $timeStamp->request_type      = "break_in";
                            $timeStamp->request_time      = $break_in;
                            $timeStamp->reason            = $reason;
                            $timeStamp->status            = 2;
                            $timeStamp->detail            = "user กรอก break_in มา วันที่ตรงแต่ไม่มี break_in 1";
                            $timeStamp->approvers         = $request->get('approvers_id');
                            $timeStamp->save();
                        }
                    }else{
                        $timeStamp                    = new RequestTimeStamp();
                        $timeStamp->id_employee       = $current_employee['id_employee'];
                        $timeStamp->request_date      = $request_date;
                        $timeStamp->request_type      = "break_in";
                        $timeStamp->request_time      = $break_in;
                        $timeStamp->reason            = $reason;
                        $timeStamp->status            = 2;
                        $timeStamp->detail            = "user กรอก break_in มาวันที่ไม่ตรง 2";
                        $timeStamp->approvers         = $request->get('approvers_id');
                        $timeStamp->save();
                    }
                }
            }

            if(!empty($time_out)){
                if(!empty($verify_timestamp['time_out'])){
                    $result['t_out'] = "มีการบันทึกเวลาออกงานแล้ว";
                }else{
                    if($count_data !== 0){
                        for($i=0; $i<$count_data; $i++){
                            $request_type[] = $verify_request[$i]['request_type'];
                        }
                        if(in_array("time_out", $request_type)){
                            $result['t_out'] = "มีการส่งคำร้องขอลงเวลาออกงานแล้ว";
                        }else{
                            $timeStamp                    = new RequestTimeStamp();
                            $timeStamp->id_employee       = $current_employee['id_employee'];
                            $timeStamp->request_date      = $request_date;
                            $timeStamp->request_type      = "time_out";
                            $timeStamp->request_time      = $time_out;
                            $timeStamp->reason            = $reason;
                            $timeStamp->status            = 2;
                            $timeStamp->detail            = "user กรอก time_out มา วันที่ตรงแต่ไม่มี time_out 1";
                            $timeStamp->approvers         = $request->get('approvers_id');
                            $timeStamp->save();
                        }
                    }else{
                        $timeStamp                    = new RequestTimeStamp();
                        $timeStamp->id_employee       = $current_employee['id_employee'];
                        $timeStamp->request_date      = $request_date;
                        $timeStamp->request_type      = "time_out";
                        $timeStamp->request_time      = $time_out;
                        $timeStamp->reason            = $reason;
                        $timeStamp->status            = 2;
                        $timeStamp->detail            = "user กรอก time_out มาวันที่ไม่ตรง 2";
                        $timeStamp->approvers         = $request->get('approvers_id');
                        $timeStamp->save();
                    }
                }
            }

        }else{ // ไม่ตรงกับ timestamp
            if(!empty($time_in)){  // ถ้า time_in ที่ส่งมาไม่วาง
                if($count_data !== 0){ // ถ้า request_time_stmap ไม่ว่าง
                    for($i=0; $i<$count_data; $i++){
                         $request_type[] = $verify_request[$i]['request_type'];
                    }
                    if(in_array("time_in", $request_type)){
                        $result['t_in'] = "มีการส่งคำร้องขอลงเวลาเข้าทำงานย้อนหลังแล้ว";
                    }else{
                        $timeStamp                    = new RequestTimeStamp();
                        $timeStamp->id_employee       = $current_employee['id_employee'];
                        $timeStamp->request_date      = $request_date;
                        $timeStamp->request_type      = "time_in";
                        $timeStamp->request_time      = $time_in;
                        $timeStamp->reason            = $reason;
                        $timeStamp->status            = 2;
                        $timeStamp->detail            = "user กรอก time_in มาไม่มีวันที่ใน timestamp วันที่ตรงแต่ไม่มี time_in 3";
                        $timeStamp->approvers         = $request->get('approvers_id');
                        $timeStamp->save();
                    }
                }else{
                    $timeStamp                    = new RequestTimeStamp();
                    $timeStamp->id_employee       = $current_employee['id_employee'];
                    $timeStamp->request_date      = $request_date;
                    $timeStamp->request_type      = "time_in";
                    $timeStamp->request_time      = $time_in;
                    $timeStamp->reason            = $reason;
                    $timeStamp->status            = 2;
                    $timeStamp->detail            = "user กรอก time_in มาไม่มีวันที่ใน timestamp วันที่ไม่ตรง 4";
                    $timeStamp->approvers         = $request->get('approvers_id');
                    $timeStamp->save();
                }
            }

            if(!empty($break_out)){  // ถ้า break_out ที่ส่งมาไม่วาง
                if($count_data !== 0){ // ถ้า request_time_stmap ไม่ว่าง
                    for($i=0; $i<$count_data; $i++){
                         $request_type[] = $verify_request[$i]['request_type'];
                    }
                    if(in_array("break_out", $request_type)){
                        $result['b_out'] = "มีการส่งคำร้องขอลงเวลาพักกลางวันย้อนหลังแล้ว";
                    }else{
                        $timeStamp                    = new RequestTimeStamp();
                        $timeStamp->id_employee       = $current_employee['id_employee'];
                        $timeStamp->request_date      = $request_date;
                        $timeStamp->request_type      = "break_out";
                        $timeStamp->request_time      = $break_out;
                        $timeStamp->reason            = $reason;
                        $timeStamp->status            = 2;
                        $timeStamp->detail            = "user กรอก break_out มาไม่มีวันที่ใน timestamp วันที่ตรงแต่ไม่มี break_out 3";
                        $timeStamp->approvers         = $request->get('approvers_id');
                        $timeStamp->save();
                    }
                }else{
                    $timeStamp                    = new RequestTimeStamp();
                    $timeStamp->id_employee       = $current_employee['id_employee'];
                    $timeStamp->request_date      = $request_date;
                    $timeStamp->request_type      = "break_out";
                    $timeStamp->request_time      = $break_out;
                    $timeStamp->reason            = $reason;
                    $timeStamp->status            = 2;
                    $timeStamp->detail            = "user กรอก break_out มาไม่มีวันที่ใน timestamp วันที่ไม่ตรง 4";
                    $timeStamp->approvers         = $request->get('approvers_id');
                    $timeStamp->save();
                }
            }

            if(!empty($break_in)){  // ถ้า break_in ที่ส่งมาไม่วาง
                if($count_data !== 0){ // ถ้า request_time_stmap ไม่ว่าง
                    for($i=0; $i<$count_data; $i++){
                         $request_type[] = $verify_request[$i]['request_type'];
                    }
                    if(in_array("break_in", $request_type)){
                        $result['b_in'] = "มีการส่งคำร้องขอลงเวลาเข้าทำงานช่วงบ่ายย้อนหลังแล้ว";
                    }else{
                        $timeStamp                    = new RequestTimeStamp();
                        $timeStamp->id_employee       = $current_employee['id_employee'];
                        $timeStamp->request_date      = $request_date;
                        $timeStamp->request_type      = "break_in";
                        $timeStamp->request_time      = $break_in;
                        $timeStamp->reason            = $reason;
                        $timeStamp->status            = 2;
                        $timeStamp->detail            = "user กรอก break_in มาไม่มีวันที่ใน timestamp วันที่ตรงแต่ไม่มี break_in 3";
                        $timeStamp->approvers         = $request->get('approvers_id');
                        $timeStamp->save();
                    }
                }else{
                    $timeStamp                    = new RequestTimeStamp();
                    $timeStamp->id_employee       = $current_employee['id_employee'];
                    $timeStamp->request_date      = $request_date;
                    $timeStamp->request_type      = "break_in";
                    $timeStamp->request_time      = $break_in;
                    $timeStamp->reason            = $reason;
                    $timeStamp->status            = 2;
                    $timeStamp->detail            = "user กรอก break_in มาไม่มีวันที่ใน timestamp วันที่ไม่ตรง 4";
                    $timeStamp->approvers         = $request->get('approvers_id');
                    $timeStamp->save();
                }
            }

            if(!empty($time_out)){  // ถ้า time_out ที่ส่งมาไม่วาง
                if($count_data !== 0){ // ถ้า request_time_stmap ไม่ว่าง
                    for($i=0; $i<$count_data; $i++){
                         $request_type[] = $verify_request[$i]['request_type'];
                    }
                    if(in_array("time_out", $request_type)){
                        $result['t_out'] = "มีการส่งคำร้องขอลงเวลาออกงานย้อนหลังแล้ว";
                    }else{
                        $timeStamp                    = new RequestTimeStamp();
                        $timeStamp->id_employee       = $current_employee['id_employee'];
                        $timeStamp->request_date      = $request_date;
                        $timeStamp->request_type      = "time_out";
                        $timeStamp->request_time      = $time_out;
                        $timeStamp->reason            = $reason;
                        $timeStamp->status            = 2;
                        $timeStamp->detail            = "user กรอก time_out มาไม่มีวันที่ใน timestamp วันที่ตรงแต่ไม่มี time_out 3";
                        $timeStamp->approvers         = $request->get('approvers_id');
                        $timeStamp->save();
                    }
                }else{
                    $timeStamp                    = new RequestTimeStamp();
                    $timeStamp->id_employee       = $current_employee['id_employee'];
                    $timeStamp->request_date      = $request_date;
                    $timeStamp->request_type      = "time_out";
                    $timeStamp->request_time      = $time_out;
                    $timeStamp->reason            = $reason;
                    $timeStamp->status            = 2;
                    $timeStamp->detail            = "user กรอก time_out มาไม่มีวันที่ใน timestamp วันที่ไม่ตรง 4";
                    $timeStamp->approvers         = $request->get('approvers_id');
                    $timeStamp->save();
                }
            }
        }
        $count_error = count($result);
        if($count_error > 0){
            $jsonData =   $result;
            return json_encode(['status' => 'failed','message' => $jsonData]);
        }else{
            return json_encode(['status' => 'success', 'message' => 'success']);
        }
    }

    // save data to database
    /*foreach ($array_time as $key => $time) {
                    if(empty($time)) continue;
                    $timeStamp                    = new RequestTimeStamp();
                    $timeStamp->id_employee       = $current_employee['id_employee'];
                    $timeStamp->request_date      = $request_date;
                    $timeStamp->request_type      = $key;
                    $timeStamp->request_time      = $time;
                    $timeStamp->reason            = $reason;
                    $timeStamp->status            = 2;
                    $timeStamp->approvers         = $request->get('approvers_id');
                    $timeStamp->save();
                }*/

        //sd($verify_request->toArray());
        //sd($verify_timestamp->toArray());
        //sd($verify_timestamp['time_in']);
        //$count_data = count($verify_request->toArray());
        //sd($count);
        /*if($count_data != 0){
            echo "request";
        }else if(!empty($verify_timestamp)){
            echo "timeStamp";
        }
        exit();*/
        /*if(!empty($verify_request)){
            $request_type = [];
            for($i=0; $i<$count_data; $i++){
                $request_type[] = $verify_request[$i]['request_type'];
            }
            $result = [];
            if(in_array("time_in", $request_type)){
                $result[] = "time_in";
            }
             if(in_array("break_out", $request_type)){
                $result[] = "break_out";
            }
             if(in_array("break_in", $request_type)){
                $result[] = "break_in";
            }
             if(in_array("time_out", $request_type)){
                $result[] = "time_out";
            }
            //sd($result);
            //print_r($result);
            echo "เข้า case 1";
        }else if(!empty($verify_timestamp)){
            $result2 = [];
            if(!empty($time_in)){
                if(!empty($verify_timestamp['time_in'])){
                    $result2[] = "มีการลงเวลาเข้าแล้ว";
                }else{
                    $timeStamp                    = new RequestTimeStamp();
                    $timeStamp->id_employee       = $current_employee['id_employee'];
                    $timeStamp->request_date      = $request_date;
                    $timeStamp->request_type      = "time_in";
                    $timeStamp->request_time      = $time_in;
                    $timeStamp->reason            = $reason;
                    $timeStamp->status            = 2;
                    $timeStamp->approvers         = $request->get('approvers_id');
                    $timeStamp->save();
                }
                echo "เข้า case 2";
            }
            if(!empty($break_out)){
                if(!empty($verify_timestamp['break_out'])){
                    $result2[] = "มีการลงเวลาพักกลางวัน";
                }else{
                    $timeStamp                    = new RequestTimeStamp();
                    $timeStamp->id_employee       = $current_employee['id_employee'];
                    $timeStamp->request_date      = $request_date;
                    $timeStamp->request_type      = "break_out";
                    $timeStamp->request_time      = $break_out;
                    $timeStamp->reason            = $reason;
                    $timeStamp->status            = 2;
                    $timeStamp->approvers         = $request->get('approvers_id');
                    $timeStamp->save();
                }
                echo "เข้า case 2";
            }
            if(!empty($break_in)){
                if(!empty($verify_timestamp['break_in'])){
                    $result2[] = "มีการลงเวลาเข้าทำงานช่วงบ่าย";
                }else{
                    $timeStamp                    = new RequestTimeStamp();
                    $timeStamp->id_employee       = $current_employee['id_employee'];
                    $timeStamp->request_date      = $request_date;
                    $timeStamp->request_type      = "break_in";
                    $timeStamp->request_time      = $break_in;
                    $timeStamp->reason            = $reason;
                    $timeStamp->status            = 2;
                    $timeStamp->approvers         = $request->get('approvers_id');
                    $timeStamp->save();
                }
                echo "เข้า case 2";
            }
            if(!empty($time_out)){
                if(!empty($verify_timestamp['time_out'])){
                    $result2[] = "มีการลงเวลาออก";
                }else{
                    $timeStamp                    = new RequestTimeStamp();
                    $timeStamp->id_employee       = $current_employee['id_employee'];
                    $timeStamp->request_date      = $request_date;
                    $timeStamp->request_type      = "time_out";
                    $timeStamp->request_time      = $time_out;
                    $timeStamp->reason            = $reason;
                    $timeStamp->status            = 2;
                    $timeStamp->approvers         = $request->get('approvers_id');
                    $timeStamp->save();
                }
                echo "เข้า case 2";
            }*/
            //sd($result2);
            //print_r($result2);
            //echo "เข้า case 2";







        /*$date    = TimeStamp::with('requesttimestamp')->where('date', $request_date)->where('id_employee', $current_employee['id_employee'])->get();
        sd($date->toArray());
        if(!empty($date[0])){ // วันที่ตรงกับ timestamp
            $result = [];
            if(!empty($time_in)){
                if(!empty($date[0]['time_in'])){
                    $result[]      = "TimeIn";
                }
            }
            if(!empty($break_out)){
                if(!empty($date[0]['break_out'])){
                    $result[]        = "BreakOut";
                }
            }
            if(!empty($break_in)){
                if(!empty($date[0]['break_in'])){
                    $result[]       = "BreakIn";
                }
            }
            if(!empty($time_out)){
                if(!empty($date[0]['time_out'])){
                    $result[]       = "TimeOut";
                }
            }
            print_r($result);
            //return error()->json(['status'=> 'error','data'=> $result]);
        }else{ // วันที่ไม่ตรงกับ timestamp
            // save data to database
            foreach ($array_time as $key => $time) {
                if(empty($time)) continue;
                $timeStamp                    = new RequestTimeStamp();
                $timeStamp->id_employee       = $current_employee['id_employee'];
                $timeStamp->request_date      = $request_date;
                $timeStamp->request_type      = $key;
                $timeStamp->request_time      = $time;
                $timeStamp->reason            = $reason;
                $timeStamp->status            = 2;
                $timeStamp->approvers         = $request->get('approvers_id');
                //$timeStamp->save();
            }
        /*}*/

    /*}*/

    public function confirmDataRequestTimeStamp(Request $request)  // กดอนุมัติ
    {
        if(\Session::has('current_employee')){
            $current_employee = \Session::get('current_employee');
        }
        $id      = $request->get('id');
        $confirm = RequestTimeStamp::find($id);
        $confirm->status  = 1;
        $confirm->save();
        $request_date = $confirm->request_date;
        $request_type = $confirm->request_type;
        $request_time = $confirm->request_time;

        $request      = TimeStamp::where('date', $request_date)->first();

        if(!empty($request)){
            if($request_type        == "break_out"){
                $request->break_out = $request_time;
            }
            if($request_type        == "break_in"){
                $request->break_in  = $request_time;
            }
            if($request_type        == "time_out"){
                $request->time_out  = $request_time;
            }
            $request->save();
        }else{
            $add                = new TimeStamp();
            $add->id_employee   = $current_employee['id_employee'];
            $add->date          = $request_date;
            if($request_type    == "time_in"){
                $add->time_in   = $request_time;
            }
            if($request_type    == "break_out"){
                $add->break_out = $request_time;
            }
            if($request_type    == "break_in"){
                $add->break_in  = $request_time;
            }
            if($request_type    == "time_out"){
                $add->time_out  = $request_time;
            }
            $add->save();
        }
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
        $confirm->reason_approvers     = $reason_reject;
        $confirm->save();
    }

    public function editRequestTimeStamp(Request $request){ //แก้ไขข้อมูลที่ร้องขอลงเวลาย้อนหลัง
        if(\Session::has('current_employee')){
            $current_employee = \Session::get('current_employee');
        }
        $id                    = $request->get('id');
        $request_date          = $request->get('request_date');
        $time_in               = $request->get('time_in');
        $break_out             = $request->get('break_out');
        $break_in              = $request->get('break_in');
        $time_out              = $request->get('time_out');
        $reason                = $request->get('reason');
        $approvers             = $request->get('approvers_id');

        $verify_timestamp      = TimeStamp::where('date', $request_date)->where('id_employee', $current_employee['id_employee'])->first();
        $verify_request        = RequestTimeStamp::where('request_date', $request_date)->where('id_employee', $current_employee['id_employee'])->where('status', 2)->get();
        $count_data   = count($verify_request->toArray());
        //sd($count_data);
        $request_type = array();
        $request_id   = array();
        $error        = array();
        for($i=0; $i<$count_data; $i++){
            $request_type[] = $verify_request[$i]['request_type'];
            $request_id[]   = $verify_request[$i]['id'];
        }
        if(!empty($verify_timestamp)){ // ถ้า ว/ด/ป ใน timestamp มี
            if(!empty($time_in)){ // ถ้า user กรอก time_in มา
                if(!empty($verify_timestamp['time_in'])){ // ถ้า timestamp มี time_in แล้ว
                    $error['t_in'] = "ไม่สามารถแก้ไขได้ เพราะวันที่นี้มีใน timestamp และมี time_in แล้ว"; //1
                }else{
                    if($count_data !== 0){
                        if(in_array('time_in', $request_type)){ // วันที่ที่ร้องขอกับประเภทมีอยู่ใน request อยู่แล้ว
                            if(in_array($id, $request_id)){
                                $update                  = RequestTimeStamp::find($id);
                                $update->id_employee     = $current_employee['id_employee'];
                                $update->request_date    = $request_date;
                                $update->request_type    = "time_in";
                                $update->request_time    = $time_in;
                                $update->reason          = $reason;
                                $update->approvers       = $approvers;
                                $update->status          = 2;
                                $update->save();
                                //$error[] = "สามารถแก้ไขได้ เพราะแก้ไขของวันที่ของตัวเอง"; //4
                            }else{
                                $error['t_in'] = "ไม่สามารถแก้ไขได้ เพราะวันที่มีการร้องขอ time_in มีอยู่ใน request"; // 5
                            }
                        }else{
                            //$error[] = "สามารถแก้ไขได้แม้จะมีวันที่ใน timestamp และมีวันที่ใน request แต่ไม่มี time_in"; //3
                            $update                  = RequestTimeStamp::find($id);
                            $update->id_employee     = $current_employee['id_employee'];
                            $update->request_date    = $request_date;
                            $update->request_type    = "time_in";
                            $update->request_time    = $time_in;
                            $update->reason          = $reason;
                            $update->approvers       = $approvers;
                            $update->status          = 2;
                            $update->save();
                        }
                    }else{
                        //$error[] = "สามารถแก้ไขได้แม้จะมีวันที่ใน timestamp แต่ใน request ไม่มีวันที่"; //2
                        $update                  = RequestTimeStamp::find($id);
                        $update->id_employee     = $current_employee['id_employee'];
                        $update->request_date    = $request_date;
                        $update->request_type    = "time_in";
                        $update->request_time    = $time_in;
                        $update->reason          = $reason;
                        $update->approvers       = $approvers;
                        $update->status          = 2;
                        $update->save();
                    }
                }
            }else if(!empty($break_in)){
                if(!empty($verify_timestamp['break_in'])){ // ถ้า timestamp มี break_in แล้ว
                    $error['b_in'] = "ไม่สามารถแก้ไขได้ เพราะวันที่นี้มีใน timestamp และมี break_in แล้ว"; //1
                }else{
                    if($count_data !== 0){
                        if(in_array('break_in', $request_type)){ // วันที่ที่ร้องขอกับประเภทมีอยู่ใน request อยู่แล้ว
                            if(in_array($id, $request_id)){
                                $update                  = RequestTimeStamp::find($id);
                                $update->id_employee     = $current_employee['id_employee'];
                                $update->request_date    = $request_date;
                                $update->request_type    = "break_in";
                                $update->request_time    = $break_in;
                                $update->reason          = $reason;
                                $update->approvers       = $approvers;
                                $update->status          = 2;
                                $update->save();
                                //$error[] = "สามารถแก้ไขได้ เพราะแก้ไขของวันที่ของตัวเอง"; //4
                            }else{
                                $error['b_in'] = "ไม่สามารถแก้ไขได้ เพราะวันที่มีการร้องขอ break_in มีอยู่ใน request"; // 5
                            }
                        }else{
                            //$error[] = "สามารถแก้ไขได้แม้จะมีวันที่ใน timestamp และมีวันที่ใน request แต่ไม่มี break_in"; //3
                            $update                  = RequestTimeStamp::find($id);
                            $update->id_employee     = $current_employee['id_employee'];
                            $update->request_date    = $request_date;
                            $update->request_type    = "break_in";
                            $update->request_time    = $break_in;
                            $update->reason          = $reason;
                            $update->approvers       = $approvers;
                            $update->status          = 2;
                            $update->save();
                        }
                    }else{
                        //$error[] = "สามารถแก้ไขได้แม้จะมีวันที่ใน timestamp แต่ใน request ไม่มีวันที่"; //2
                        $update                  = RequestTimeStamp::find($id);
                        $update->id_employee     = $current_employee['id_employee'];
                        $update->request_date    = $request_date;
                        $update->request_type    = "break_in";
                        $update->request_time    = $break_in;
                        $update->reason          = $reason;
                        $update->approvers       = $approvers;
                        $update->status          = 2;
                        $update->save();

                    }
                }
            }else if(!empty($break_out)){
                if(!empty($verify_timestamp['break_out'])){ // ถ้า timestamp มี break_out แล้ว
                    $error['b_out'] = "ไม่สามารถแก้ไขได้ เพราะวันที่นี้มีใน timestamp และมี break_out แล้ว";
                }else{
                    if($count_data !== 0){
                        if(in_array('break_out', $request_type)){ // วันที่ที่ร้องขอกับประเภทมีอยู่ใน request อยู่แล้ว
                            if(in_array($id, $request_id)){
                                $update                  = RequestTimeStamp::find($id);
                                $update->id_employee     = $current_employee['id_employee'];
                                $update->request_date    = $request_date;
                                $update->request_type    = "break_out";
                                $update->request_time    = $break_out;
                                $update->reason          = $reason;
                                $update->approvers       = $approvers;
                                $update->status          = 2;
                                $update->save();
                                //$error[] = "สามารถแก้ไขได้ เพราะแก้ไขของวันที่ของตัวเอง"; //4
                            }else{
                                $error['b_out'] = "ไม่สามารถแก้ไขได้ เพราะวันที่มีการร้องขอ break_out มีอยู่ใน request"; // 5
                            }
                        }else{
                            //$error[] = "สามารถแก้ไขได้แม้จะมีวันที่ใน timestamp และมีวันที่ใน request แต่ไม่มี break_out";
                            $update                  = RequestTimeStamp::find($id);
                            $update->id_employee     = $current_employee['id_employee'];
                            $update->request_date    = $request_date;
                            $update->request_type    = "break_out";
                            $update->request_time    = $break_out;
                            $update->reason          = $reason;
                            $update->approvers       = $approvers;
                            $update->status          = 2;
                            $update->save();
                        }
                    }else{
                        //$error[] = "สามารถแก้ไขได้แม้จะมีวันที่ใน timestamp แต่ใน request ไม่มีวันที่";
                        $update                  = RequestTimeStamp::find($id);
                        $update->id_employee     = $current_employee['id_employee'];
                        $update->request_date    = $request_date;
                        $update->request_type    = "break_out";
                        $update->request_time    = $break_out;
                        $update->reason          = $reason;
                        $update->approvers       = $approvers;
                        $update->status          = 2;
                        $update->save();
                    }
                }
            }else if(!empty($time_out)){
                if(!empty($verify_timestamp['time_out'])){ // ถ้า timestamp มี time_out แล้ว
                    $error['t_out'] = "ไม่สามารถแก้ไขได้ เพราะวันที่นี้มีใน timestamp และมี time_out แล้ว";
                }else{
                    if($count_data !== 0){
                        if(in_array('time_out', $request_type)){ // วันที่ที่ร้องขอกับประเภทมีอยู่ใน request อยู่แล้ว
                            if(in_array($id, $request_id)){
                                $update                  = RequestTimeStamp::find($id);
                                $update->id_employee     = $current_employee['id_employee'];
                                $update->request_date    = $request_date;
                                $update->request_type    = "time_out";
                                $update->request_time    = $time_out;
                                $update->reason          = $reason;
                                $update->approvers       = $approvers;
                                $update->status          = 2;
                                $update->save();
                                //$error[] = "สามารถแก้ไขได้ เพราะแก้ไขของวันที่ของตัวเอง"; //4
                            }else{
                                $error['t_out'] = "ไม่สามารถแก้ไขได้ เพราะวันที่มีการร้องขอ time_out มีอยู่ใน request"; // 5
                            }
                        }else{
                            //$error[] = "สามารถแก้ไขได้แม้จะมีวันที่ใน timestamp และมีวันที่ใน request แต่ไม่มี time_out";
                            $update                  = RequestTimeStamp::find($id);
                            $update->id_employee     = $current_employee['id_employee'];
                            $update->request_date    = $request_date;
                            $update->request_type    = "time_out";
                            $update->request_time    = $time_out;
                            $update->reason          = $reason;
                            $update->approvers       = $approvers;
                            $update->status          = 2;
                            $update->save();
                        }
                    }else{
                        //$error[] = "สามารถแก้ไขได้แม้จะมีวันที่ใน timestamp แต่ใน request ไม่มีวันที่";
                        $update                  = RequestTimeStamp::find($id);
                        $update->id_employee     = $current_employee['id_employee'];
                        $update->request_date    = $request_date;
                        $update->request_type    = "time_out";
                        $update->request_time    = $time_out;
                        $update->reason          = $reason;
                        $update->approvers       = $approvers;
                        $update->status          = 2;
                        $update->save();
                    }
                }
            }
        }else{ // ไม่มีวันที่ใน timestamp
            if(!empty($time_in)){
                if($count_data !== 0){
                    if(in_array('time_in', $request_type)){ // วันที่ที่ร้องขอกับประเภทมีอยู่ใน request อยู่แล้ว
                        if(in_array($id, $request_id)){
                            $update                  = RequestTimeStamp::find($id);
                            $update->id_employee     = $current_employee['id_employee'];
                            $update->request_date    = $request_date;
                            $update->request_type    = "time_in";
                            $update->request_time    = $time_in;
                            $update->reason          = $reason;
                            $update->approvers       = $approvers;
                            $update->status          = 2;
                            $update->save();
                            //$error[] = "สามารถแก้ไขได้ เพราะแก้ไขของวันที่ของตัวเอง ไม่มีวันที่ใน timestamp "; //3
                        }else{
                            //$error[] = "ไม่สามารถแก้ไขได้ เพราะวันที่มีการร้องขอ time_in มีอยู่ใน request และไม่มีวันที่ใน timestamp"; //4
                            $error['t_in'] = "ไม่สามารถแก้ไขได้ เพราะวันที่นี้มีการร้องขอลงเวลาเข้าแล้ว";
                        }
                    }else{
                        //$error[] = "สามารถแก้ไขได้แม้จะไม่มีวันที่ใน timestamp แต่มีวันที่ใน request แต่ไม่มี time_in"; //2
                        $update                  = RequestTimeStamp::find($id);
                        $update->id_employee     = $current_employee['id_employee'];
                        $update->request_date    = $request_date;
                        $update->request_type    = "time_in";
                        $update->request_time    = $time_in;
                        $update->reason          = $reason;
                        $update->approvers       = $approvers;
                        $update->status          = 2;
                        $update->save();
                    }
                }else{
                    $update                  = RequestTimeStamp::find($id);
                    $update->id_employee     = $current_employee['id_employee'];
                    $update->request_date    = $request_date;
                    $update->request_type    = "time_in";
                    $update->request_time    = $time_in;
                    $update->reason          = $reason;
                    $update->approvers       = $approvers;
                    $update->status          = 2;
                    $update->save();
                    //$error[] = "แก้ไขได้ เพราะไม่มีวันที่ใน timestamp และไม่มีวันที่ใน request"; //1
                }
            }
            else if(!empty($break_in)){
                if($count_data !== 0){
                    if(in_array('break_in', $request_type)){ // วันที่ที่ร้องขอกับประเภทมีอยู่ใน request อยู่แล้ว
                        if(in_array($id, $request_id)){
                            $update                  = RequestTimeStamp::find($id);
                            $update->id_employee     = $current_employee['id_employee'];
                            $update->request_date    = $request_date;
                            $update->request_type    = "break_in";
                            $update->request_time    = $break_in;
                            $update->reason          = $reason;
                            $update->approvers       = $approvers;
                            $update->status          = 2;
                            $update->save();
                            //$error[] = "สามารถแก้ไขได้ เพราะแก้ไขของวันที่ของตัวเอง ไม่มีวันที่ใน timestamp "; //3
                        }else{
                            //$error[] = "ไม่สามารถแก้ไขได้ เพราะวันที่มีการร้องขอ time_in มีอยู่ใน request และไม่มีวันที่ใน timestamp"; //4
                            $error['b_in'] = "ไม่สามารถแก้ไขได้ เพราะวันที่นี้มีการร้องขอลงเวลาเข้าแล้ว";
                        }
                    }else{
                        //$error[] = "สามารถแก้ไขได้แม้จะไม่มีวันที่ใน timestamp แต่มีวันที่ใน request แต่ไม่มี time_in"; //2
                        $update                  = RequestTimeStamp::find($id);
                        $update->id_employee     = $current_employee['id_employee'];
                        $update->request_date    = $request_date;
                        $update->request_type    = "break_in";
                        $update->request_time    = $break_in;
                        $update->reason          = $reason;
                        $update->approvers       = $approvers;
                        $update->status          = 2;
                        $update->save();
                    }
                }else{
                    $update                  = RequestTimeStamp::find($id);
                    $update->id_employee     = $current_employee['id_employee'];
                    $update->request_date    = $request_date;
                    $update->request_type    = "break_in";
                    $update->request_time    = $break_in;
                    $update->reason          = $reason;
                    $update->approvers       = $approvers;
                    $update->status          = 2;
                    $update->save();
                    //$error[] = "แก้ไขได้ เพราะไม่มีวันที่ใน timestamp และไม่มีวันที่ใน request"; //1
                }
            }else if(!empty($break_out)){
                if($count_data !== 0){
                    if(in_array('break_out', $request_type)){ // วันที่ที่ร้องขอกับประเภทมีอยู่ใน request อยู่แล้ว
                        if(in_array($id, $request_id)){
                            $update                  = RequestTimeStamp::find($id);
                            $update->id_employee     = $current_employee['id_employee'];
                            $update->request_date    = $request_date;
                            $update->request_type    = "break_out";
                            $update->request_time    = $break_out;
                            $update->reason          = $reason;
                            $update->approvers       = $approvers;
                            $update->status          = 2;
                            $update->save();
                            //$error[] = "สามารถแก้ไขได้ เพราะแก้ไขของวันที่ของตัวเอง ไม่มีวันที่ใน timestamp "; //3
                        }else{
                            //$error[] = "ไม่สามารถแก้ไขได้ เพราะวันที่มีการร้องขอ time_in มีอยู่ใน request และไม่มีวันที่ใน timestamp"; //4
                            $error['b_out'] = "ไม่สามารถแก้ไขได้ เพราะวันที่นี้มีการร้องขอลงเวลาเข้าแล้ว";
                        }
                    }else{
                        //$error[] = "สามารถแก้ไขได้แม้จะไม่มีวันที่ใน timestamp แต่มีวันที่ใน request แต่ไม่มี time_in"; //2
                        $update                  = RequestTimeStamp::find($id);
                        $update->id_employee     = $current_employee['id_employee'];
                        $update->request_date    = $request_date;
                        $update->request_type    = "break_out";
                        $update->request_time    = $break_out;
                        $update->reason          = $reason;
                        $update->approvers       = $approvers;
                        $update->status          = 2;
                        $update->save();
                    }
                }else{
                    $update                  = RequestTimeStamp::find($id);
                    $update->id_employee     = $current_employee['id_employee'];
                    $update->request_date    = $request_date;
                    $update->request_type    = "break_out";
                    $update->request_time    = $break_out;
                    $update->reason          = $reason;
                    $update->approvers       = $approvers;
                    $update->status          = 2;
                    $update->save();
                    //$error[] = "แก้ไขได้ เพราะไม่มีวันที่ใน timestamp และไม่มีวันที่ใน request"; //1
                }
            }else if(!empty($time_out)){
                if($count_data !== 0){
                    if(in_array('time_out', $request_type)){ // วันที่ที่ร้องขอกับประเภทมีอยู่ใน request อยู่แล้ว
                        if(in_array($id, $request_id)){
                            $update                  = RequestTimeStamp::find($id);
                            $update->id_employee     = $current_employee['id_employee'];
                            $update->request_date    = $request_date;
                            $update->request_type    = "time_out";
                            $update->request_time    = $time_out;
                            $update->reason          = $reason;
                            $update->approvers       = $approvers;
                            $update->status          = 2;
                            $update->save();
                            //$error[] = "สามารถแก้ไขได้ เพราะแก้ไขของวันที่ของตัวเอง ไม่มีวันที่ใน timestamp "; //3
                        }else{
                            //$error[] = "ไม่สามารถแก้ไขได้ เพราะวันที่มีการร้องขอ time_in มีอยู่ใน request และไม่มีวันที่ใน timestamp"; //4
                            $error['t_out'] = "ไม่สามารถแก้ไขได้ เพราะวันที่นี้มีการร้องขอลงเวลาเข้าแล้ว";
                        }
                    }else{
                        //$error[] = "สามารถแก้ไขได้แม้จะไม่มีวันที่ใน timestamp แต่มีวันที่ใน request แต่ไม่มี time_in"; //2
                        $update                  = RequestTimeStamp::find($id);
                        $update->id_employee     = $current_employee['id_employee'];
                        $update->request_date    = $request_date;
                        $update->request_type    = "time_out";
                        $update->request_time    = $time_out;
                        $update->reason          = $reason;
                        $update->approvers       = $approvers;
                        $update->status          = 2;
                        $update->save();
                    }
                }else{
                    $update                  = RequestTimeStamp::find($id);
                    $update->id_employee     = $current_employee['id_employee'];
                    $update->request_date    = $request_date;
                    $update->request_type    = "time_out";
                    $update->request_time    = $time_out;
                    $update->reason          = $reason;
                    $update->approvers       = $approvers;
                    $update->status          = 2;
                    $update->save();
                    //$error[] = "แก้ไขได้ เพราะไม่มีวันที่ใน timestamp และไม่มีวันที่ใน request"; //1
                }
            }
        }
        $count_error = count($error);
        if($count_error > 0){
            return json_encode(['status' => 'failed','message' => $error]);
        }else{
            return json_encode(['status' => 'success', 'message' => 'success']);
        }
        //sd($error);
    }

    function array_push_associative(&$arr) {
        $args = func_get_args();
        foreach ($args as $arg) {
            if (is_array($arg)) {
                foreach ($arg as $key => $value) {
                    $arr[$key] = $value;
                    $ret++;
                }
            }else{
                $arr[$arg] = "";
            }
        }
        return $ret;
    }
}