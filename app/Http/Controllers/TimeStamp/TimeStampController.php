<?php

namespace App\Http\Controllers\TimeStamp;

use Illuminate\Http\Request;
use App\Http\Requests;
use App\Http\Controllers\Controller;
use App\Services\Forms\FormEmployee;
use App\Services\Forms\FormNewTimeClock;
use App\Services\Forms\FormRequestTimeStamp;
use App\Services\Forms\FormViewDataRequestTimeStamp;
use App\Services\Forms\FormViewRequestTimeStamp;
use App\Services\Forms\FormEditRequestTimeStamp;
use App\Services\TimeStamp\TimeStamp;
use App\Services\Employee\Employee;
use App\Services\Department\Department;
use App\Services\Position\Position;
use App\Services\Employee\EmployeeObject;
use App\Services\Request\RequestTimeStamp;
use App\Services\Company\Company;


class TimeStampController extends Controller
{
    public function ipRequestTimeStamp(Request $request)
    {
        if(\Session::has('current_employee')){
            $current_employee = \Session::get('current_employee');
        }

        $emergency_check = Company::first("emergency_status");
        $get_emergency = $emergency_check->emergency_status;
        if ($get_emergency == 0) {
            $get_ip_serv    = $request->get('ip_serv');
            $ip_config = Company::where('ip_config', $get_ip_serv )->first();

            if (!empty($ip_config)) {

                return response()->json(['status'=> 'success','data'=> 'กำลังสร้างเส้นทาง รอสักครู่']);
            }else{

                return response()->json(['status'=> 'failed','data'=> 'ขออภัย คุณไม่มีสิทธ์ในการเข้าถึงฟังก์ชันนี้']);
            }
        }else{

            return response()->json(['status'=> 'emergency','data'=> 'กรณี "สภาวะสถานการณ์ไม่ปกติ" ']);
        }
    }

	public function index()
    {
        if(\Session::has('current_employee')){
            $current_employee = \Session::get('current_employee');
        }
        $id_employee = $current_employee['id_employee'];
        //d($id_employee);
        //$data = TimeStamp::with('employee')->with('requesttimestamp')->where('id_employee', $current_employee['id_employee'])->orderBy('id', 'desc')->get();

        $data = TimeStamp::with(['requesttimestamp' => function($q) use($id_employee){
                    $q->where('id_employee', $id_employee);
                    $q->where('status', '!=', 3);
                }])
                ->orderBy('id', 'desc')
                ->get();

        //sd($data->toArray());
        return $this->useTemplate('time_stamp.index', compact('data', 'id_employee'));
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


    public function time_stamp() // ขึ้นข้อมูลเมื่อลงเวลาหน้า new window
    {
        if(\Session::has('current_employee')){
            $current_employee = \Session::get('current_employee');
        }
        $date_today   = date('Y-m-d');
        $current_data_time = TimeStamp::with('employee', 'employee.position')->where('id_employee', $current_employee['id_employee'])->where('date', $date_today)->first();

        return view('time_stamp.time_stamp', compact('current_data_time'));
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
            $form_repo = new FormNewTimeClock;
            $form_new_time_clock = $form_repo->getFormNewTimeClock($header);
            return response()->json(['status'=> 'success','data'=> $form_new_time_clock]);
            break;

            case 'getRequestTimeStamp':  //ลืมลงเวลา
            if(\Session::has('current_employee')){
                $current_employee = \Session::get('current_employee');
            }
            $header = Employee::where('id_position', 2)->where('id_department', $current_employee['id_department'])->first();
            $form_repo = new FormRequestTimeStamp;
            $form_request_timestamp = $form_repo->getRequestTimeStamp($header);
            return response()->json(['status'=> 'success','data'=> $form_request_timestamp]);
            break;

            case 'getViewDataRequestTimeStamp': // ดูข้อมูลที่ร้องขอการลงเวลาย้อนหลัง // ดูของลูกน้อง
            $id             = $request->get('id');
                //sd($id);
            $data           = RequestTimeStamp::where('id', $id)->first();
                //sd($data->toArray());
            $form_repo = new FormViewDataRequestTimeStamp;
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
            $form_repo = new FormViewRequestTimeStamp;
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
            $form_repo = new FormEditRequestTimeStamp;
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
            return ['status' => 'failed','message1' => "คุณกรอกรหัสผ่านผิด!" , 'message2' => "กรุณาลองไหมอีกครั้ง"];
        }
        if($type_time == "please_choice"){
            return ['status' => 'failed','message1' => "กรุณาเลือกรูปแบบ" , 'message2' => "ลองไหมอีกครั้ง"];
        }

        $date_today   = date('Y-m-d');
        $current_time = TimeStamp::where('id_employee', $current_employee['id_employee'])->where('date', $date_today)->first();

        if(empty($current_time)) {
            if ($type_time != 'time_in') return ['status' => 'failed', 'message1' => 'คุณไม่ได้ลงเวลาเข้างาน', 'message2' =>'กรณาลงเวลาเข้างานก่อน'];

            $new_record = new TimeStamp;
            $new_record->id_employee    = $current_employee['id_employee'];
            $new_record->date           = date('Y-m-d');
            $new_record->{$type_time}   = date('H:i:s');
            $new_record->save();
        } else {
            if ($type_time == 'time_in') return ['status' => 'failed', 'message1' => 'คุณลงเวลาเข้างานแล้ว' , 'message2' =>'ไม่สามารถลงเวลาซ้ำได้'];

            if ($current_time->break_out == ""){
                if($type_time != 'break_out' && $type_time != 'time_out') return ['status' => 'failed', 'message1' => 'คุณไม่ได้ลงเวลาพักกลางวัน' , 'message2' =>'กรณาลงเวลาพักกลางวันก่อน'];
            } else if($current_time->break_out != "" && $type_time == 'break_out'){
                return ['status' => 'failed', 'message1' => 'คุณลงเวลาพักกลางวันแล้ว' , 'message2' =>'ไม่สามารถลงเวลาซ้ำได้'];
            }

            if ($current_time->break_in != "" && $type_time == 'break_in'){
                return ['status' => 'failed', 'message1' => 'คุณลงเวลาเข้างานช่วงบ่ายแล้ว' , 'message2' =>'ไม่สามารถลงเวลาซ้ำได้'];
            }

            if ($current_time->time_out != "" && $type_time == 'break_in'){
                return ['status' => 'failed', 'message1' => 'คุณลงเวลาออกงานแล้ว' , 'message2' =>'ไม่สามารถลงเวลาพักได้'];
            }

            if ($current_time->time_out != "" && $type_time == 'break_out'){
                return ['status' => 'failed', 'message1' => 'คุณลงเวลาออกงานแล้ว' , 'message2' =>'ไม่สามารถลงเวลาพักได้'];
            }

            if ($current_time->time_out != "" && $type_time == 'time_out'){
                return ['status' => 'failed', 'message1' => 'คุณลงเวลาออกงานแล้ว' , 'message2' =>'ไม่สามารถลงเวลาซ้ำได้'];
            }

            if ($current_time->time_out != "" && $type_time == 'break_in' ){
                return ['status' => 'failed', 'message1' => 'คุณลงเวลาออกงานแล้ว' , 'message2' =>'ไม่สามารถลงเวลาพักได้'];
            }

            if ($current_time->time_out != "" && $type_time == 'break_out' ){
                return ['status' => 'failed', 'message1' => 'คุณลงเวลาออกงานแล้ว' , 'message2' =>'ไม่สามารถลงเวลาพักได้'];
            }

            $current_time->{$type_time}   = date('H:i:s');
            $current_time->save();

            return ['status' => 'success', 'message1' => 'ลงเวลาเรียบร้อยแล้ว' , 'message2' => ''];

        }

    }

    public function addRequestTimeStamp(Request $request) // บันทึกลง request_time_stamp
    {
        date_default_timezone_set('Asia/Bangkok');
        if(\Session::has('current_employee')){
            $current_employee = \Session::get('current_employee');
        }
        $request_date                       = $request->get('request_date');
        //sd($request_date);
        $time_in                            = $request->get('time_in');
        //sd($time_in);
        $break_out                          = $request->get('break_out');
        $break_in                           = $request->get('break_in');
        $time_out                           = $request->get('time_out');
        $reason                             = $request->get('reason');
        $array_time                         = [
            'time_in' => $time_in,
            'time_out' => $time_out,
            'break_in' => $break_in,
            'break_out' => $break_out,
        ];
        //sd($array_time);
        /*if(empty($time_in) && empty($time_out) && empty($break_out) && empty($break_in)){
            echo "error";
        }else{
            echo "not error";
        }
        exit();*/

        $date_today   = date('Y-m-d');
        if($request_date > $date_today){
            $error_date =   ["request_timestamp" => "ไม่สามารถลงเวลาเกินวันที่ปัจจุบันได้"];
            return json_encode(['status' => 'failed', 'message' => $error_date]);
        }

        if(empty($time_in) && empty($time_out) && empty($break_out) && empty($break_in)){
            //echo "error";
            $error_check =   ["error_check" => "กรุณาเลือกรูปแบบการลงเวลา"];
            return json_encode(['status' => 'failed', 'message' => $error_check]);
        }


        //$verify_timestamp = TimeStamp::with('requesttimestamp')->where('date', $request_date)->where('id_employee', $current_employee['id_employee'])->first();
        $employee  = Employee::with(['timestamp_hasone' => function($q) use($request_date){
            $q->where('date', $request_date);
            $q->with('requesttimestamp');
        }])
        ->where('id_employee', $current_employee['id_employee'])->first();


        if(empty($employee->timestamp_hasone)) {
            $new_record_timestamp               = new TimeStamp;
            $new_record_timestamp->id_employee  = $current_employee['id_employee'];
            $new_record_timestamp->date         = $request_date;
            $new_record_timestamp->save();

            foreach ($array_time as $key => $time) {
             if(empty($time)) continue;
             $request_timestamp                  = new RequestTimeStamp;
             $request_timestamp->id_employee     = $current_employee['id_employee'];
             $request_timestamp->request_date    = $request_date;
             $request_timestamp->request_time    = $time;
             $request_timestamp->request_type    = $key;
             $request_timestamp->reason          = $reason;
             $request_timestamp->approvers       = $request->get('approvers_id');
             $request_timestamp->status          = 2;
             $request_timestamp->save();
         }
        return json_encode(['status' => 'success', 'message' => 'success']);

        } else {
            $requesttimestamp =  isset($employee->timestamp_hasone->requesttimestamp) ? $employee->timestamp_hasone->requesttimestamp : [];

            $requesttimestamp = $requesttimestamp->where('id_employee', $current_employee['id_employee'])->where('status', '!=', 3);
            //sd($requesttimestamp->toArray());
            $errors = [];
            foreach ($array_time as $key => $time) {
                $x = $requesttimestamp->where('request_type', $key);
                if(count($x)) {
                    $errors[]  = $key;
                } else {
                    if (empty($time))  continue;
                    $new_request_timestamp                  = new RequestTimeStamp;
                    $new_request_timestamp->id_employee     = $current_employee['id_employee'];
                    $new_request_timestamp->request_date    = $request_date;
                    $new_request_timestamp->request_time    = $time;
                    $new_request_timestamp->request_type    = $key;
                    $new_request_timestamp->reason          = $reason;
                    $new_request_timestamp->approvers       = $request->get('approvers_id');
                    $new_request_timestamp->status          = 2;
                    $new_request_timestamp->save();
                }
            }

            $result_errors = [];
            $result_text_error = ["time_in" => "มีการส่งคำร้องขอลงเวลาเข้าทำงานย้อนหลังแล้ว", "break_out" => 'มีการส่งคำร้องขอลงเวลาพักกลางวันย้อนหลังแล้ว', "break_in" => 'มีการส่งคำร้องขอลงเวลาเข้าทำงานช่วงบ่ายแล้ว', "time_out" => 'มีการส่งคำร้องขอลงเวลาออกงานย้อนหลังแล้ว'];

            foreach ($array_time as $key => $time) {
                if(in_array($key, $errors) && $time != ""){
                    $result_errors[$key] = $result_text_error[$key];
                }
            }
                // d($result_errors);
            if(!empty($result_errors)) {
                return json_encode(['status' => 'failed', 'message' => $result_errors]);
            } else {
                return json_encode(['status' => 'success', 'message' => 'success']);
            }
        }

    }

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
        $id_employee  = $confirm->id_employee;

        $request      = TimeStamp::where('date', $request_date)->where('id_employee', $id_employee)->first();
        //sd($request->toArray());
        if(!empty($request)){
            if($request_type        == "time_in"){
                $request->time_in = $request_time;
            }
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

        /*$date_today   = date('Y-m-d');
        if($request_date > $date_today){
            $error_date =   ["request_timestamp" => "ไม่สามารถลงเวลาเกินวันที่ปัจจุบันได้"];
            return json_encode(['status' => 'failed', 'message' => $error_date]);
            echo "ไม่สามารถขอลงเวลาย้อนหลังเกินวันที่ปัจจุบันได้";
            exit();
        }*/
        $request_type = array();
        $request_id   = array();
        $error        = array();
        for($i=0; $i<$count_data; $i++){
            $request_type[] = $verify_request[$i]['request_type'];
            $request_id[]   = $verify_request[$i]['id'];
        }
        if(!empty($verify_timestamp)){ // ถ้า ว/ด/ป ใน timestamp มี
            if(!empty($time_in)){ // ถ้า user กรอก time_in มา
                //if(!empty($verify_timestamp['time_in'])){ // ถ้า timestamp มี time_in แล้ว
                    //$error['t_in'] = "ไม่สามารถแก้ไขได้ เพราะวันที่นี้มีใน timestamp และมี time_in แล้ว"; //1
                    //return ['status' => 'failed_t_in_ts','message' => "failed"];
                //}else{
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
                                return ['status' => 'success_timein','message' => "success"];
                            }else{
                                //$error['t_in'] = "ไม่สามารถแก้ไขได้ เพราะวันที่มีการร้องขอ time_in มีอยู่ใน request"; // 5
                                return ['status' => 'failed_t_in_q','message' => "failed"];
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
                            return ['status' => 'success_timein','message' => "success"];
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
                        return ['status' => 'success_timein','message' => "success"];
                    }
                //}
            }else if(!empty($break_out)){
                if(!empty($verify_timestamp['break_out'])){ // ถ้า timestamp มี break_out แล้ว
                    //$error['b_out'] = "ไม่สามารถแก้ไขได้ เพราะวันที่นี้มีใน timestamp และมี break_out แล้ว"; //1
                    return ['status' => 'failed_b_out_ts','message' => "failed"];
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
                                return ['status' => 'success_breakout','message' => "success"];
                            }else{
                                //$error['b_in'] = "ไม่สามารถแก้ไขได้ เพราะวันที่มีการร้องขอ break_in มีอยู่ใน request"; // 5
                                return ['status' => 'failed_b_out_q','message' => "failed"];
                            }
                        }else{
                            //$error[] = "สามารถแก้ไขได้แม้จะมีวันที่ใน timestamp และมีวันที่ใน request แต่ไม่มี break_out"; //3
                            $update                  = RequestTimeStamp::find($id);
                            $update->id_employee     = $current_employee['id_employee'];
                            $update->request_date    = $request_date;
                            $update->request_type    = "break_out";
                            $update->request_time    = $break_out;
                            $update->reason          = $reason;
                            $update->approvers       = $approvers;
                            $update->status          = 2;
                            $update->save();
                            return ['status' => 'success_breakout','message' => "success"];
                        }
                    }else{
                        //$error[] = "สามารถแก้ไขได้แม้จะมีวันที่ใน timestamp แต่ใน request ไม่มีวันที่"; //2
                        $update                  = RequestTimeStamp::find($id);
                        $update->id_employee     = $current_employee['id_employee'];
                        $update->request_date    = $request_date;
                        $update->request_type    = "break_out";
                        $update->request_time    = $break_out;
                        $update->reason          = $reason;
                        $update->approvers       = $approvers;
                        $update->status          = 2;
                        $update->save();
                        return ['status' => 'success_breakout','message' => "success"];

                    }
                }
            }else if(!empty($break_in)){
                if(!empty($verify_timestamp['break_in'])){ // ถ้า timestamp มี break_in แล้ว
                    //$error['b_in'] = "ไม่สามารถแก้ไขได้ เพราะวันที่นี้มีใน timestamp และมี break_in แล้ว";
                    return ['status' => 'failed_b_in_ts','message' => "failed"];
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
                                return ['status' => 'success_breakin','message' => "success"];
                            }else{
                                //$error['b_in'] = "ไม่สามารถแก้ไขได้ เพราะวันที่มีการร้องขอ break_in มีอยู่ใน request"; // 5
                                return ['status' => 'failed_b_in_q','message' => "failed"];
                            }
                        }else{
                            //$error[] = "สามารถแก้ไขได้แม้จะมีวันที่ใน timestamp และมีวันที่ใน request แต่ไม่มี break_in";
                            $update                  = RequestTimeStamp::find($id);
                            $update->id_employee     = $current_employee['id_employee'];
                            $update->request_date    = $request_date;
                            $update->request_type    = "break_in";
                            $update->request_time    = $break_in;
                            $update->reason          = $reason;
                            $update->approvers       = $approvers;
                            $update->status          = 2;
                            $update->save();
                            return ['status' => 'success_breakin','message' => "success"];
                        }
                    }else{
                        //$error[] = "สามารถแก้ไขได้แม้จะมีวันที่ใน timestamp แต่ใน request ไม่มีวันที่";
                        $update                  = RequestTimeStamp::find($id);
                        $update->id_employee     = $current_employee['id_employee'];
                        $update->request_date    = $request_date;
                        $update->request_type    = "break_in";
                        $update->request_time    = $break_in;
                        $update->reason          = $reason;
                        $update->approvers       = $approvers;
                        $update->status          = 2;
                        $update->save();
                        return ['status' => 'success_breakin','message' => "success"];
                    }
                }
            }else if(!empty($time_out)){
                if(!empty($verify_timestamp['time_out'])){ // ถ้า timestamp มี time_out แล้ว
                    //$error['t_out'] = "ไม่สามารถแก้ไขได้ เพราะวันที่นี้มีใน timestamp และมี time_out แล้ว";
                    return ['status' => 'failed_t_out_ts','message' => "failed"];
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
                                return ['status' => 'success_timeout','message' => "success"];
                            }else{
                                //$error['t_out'] = "ไม่สามารถแก้ไขได้ เพราะวันที่มีการร้องขอ time_out มีอยู่ใน request"; // 5
                                return ['status' => 'failed_t_out_q','message' => "failed"];
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
                            return ['status' => 'success_timeout','message' => "success"];
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
                        return ['status' => 'success_timeout','message' => "success"];
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
                            return ['status' => 'success_timein','message' => "success"];
                        }else{
                            //$error[] = "ไม่สามารถแก้ไขได้ เพราะวันที่มีการร้องขอ time_in มีอยู่ใน request และไม่มีวันที่ใน timestamp"; //4
                            //$error['t_in'] = "ไม่สามารถแก้ไขได้ เพราะวันที่นี้มีการร้องขอลงเวลาเข้าแล้ว";
                            return ['status' => 'failed_t_in_q','message' => "failed"];
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
                        return ['status' => 'success_timein','message' => "success"];
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
                    return ['status' => 'success_timein','message' => "success"];
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
                            return ['status' => 'success_breakout','message' => "success"];
                        }else{
                            //$error[] = "ไม่สามารถแก้ไขได้ เพราะวันที่มีการร้องขอ time_in มีอยู่ใน request และไม่มีวันที่ใน timestamp"; //4
                            //$error['b_out'] = "ไม่สามารถแก้ไขได้ เพราะวันที่นี้มีการร้องขอลงเวลาพักกลางวันแล้ว";
                            return ['status' => 'failed_b_out_q','message' => "failed"];
                        }
                    }else{
                        //$error[] = "สามารถแก้ไขได้แม้จะไม่มีวันที่ใน timestamp แต่มีวันที่ใน request แต่ไม่มี time_out"; //2
                        $update                  = RequestTimeStamp::find($id);
                        $update->id_employee     = $current_employee['id_employee'];
                        $update->request_date    = $request_date;
                        $update->request_type    = "break_out";
                        $update->request_time    = $break_out;
                        $update->reason          = $reason;
                        $update->approvers       = $approvers;
                        $update->status          = 2;
                        $update->save();
                        return ['status' => 'success_breakout','message' => "success"];
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
                    return ['status' => 'success_breakout','message' => "success"];
                }
            }else if(!empty($break_in)){
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
                            return ['status' => 'success_breakin','message' => "success"];
                        }else{
                            //$error[] = "ไม่สามารถแก้ไขได้ เพราะวันที่มีการร้องขอ time_in มีอยู่ใน request และไม่มีวันที่ใน timestamp"; //4
                            //$error['b_in'] = "ไม่สามารถแก้ไขได้ เพราะวันที่นี้มีการร้องขอลงเวลาเข้าแล้ว";
                            return ['status' => 'failed_b_in_q','message' => "failed"];
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
                        return ['status' => 'success_breakin','message' => "success"];
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
                    return ['status' => 'success_breakin','message' => "success"];
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
                            return ['status' => 'success_timeout','message' => "success"];
                        }else{
                            //$error[] = "ไม่สามารถแก้ไขได้ เพราะวันที่มีการร้องขอ time_in มีอยู่ใน request และไม่มีวันที่ใน timestamp"; //4
                            //$error['t_out'] = "ไม่สามารถแก้ไขได้ เพราะวันที่นี้มีการร้องขอลงเวลาเข้าแล้ว";
                            return ['status' => 'failed_t_out_q','message' => "failed"];
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
                        return ['status' => 'success_timeout','message' => "success"];
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
                    return ['status' => 'success_timeout','message' => "success"];
                }
            }
        }
    }

      public function postDeleteRequestHistory($id){

        $request_history          = RequestTimeStamp::with('employee')->where('id', $id)->first();

        // date_default_timezone_set('Asia/Bangkok');
        // $date = date('Y-m-d H:i:s');
        // sd($date );
        if(!empty($request_history))
        {
            $request_history->delete();

            return ['status' => 'success', 'message' => 'Delete complete.'];

        }
        else
        {
            return['status' => 'failed','message' =>'Not found.'];
        }
    }


}