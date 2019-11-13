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

    public function request_history()
    {

        return $this->useTemplate('time_stamp.request_history');
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
        return $this->useTemplate('time_stamp.time_stamp_request', compact('request'));
    }

    public function time_stamp_list_request() //ประวัติการร้องขอ
    {
        if(\Session::has('current_employee')){
            $current_employee = \Session::get('current_employee');
        }
        $request_time_stamp     = RequestTimeStamp::where('id_employee', $current_employee['id_employee'])->orderBy('id', 'desc')->get();
        //sd($request_time_stamp->toArray());
        return $this->useTemplate('time_stamp.list_request', compact('request_time_stamp'));
    }

    public function ajaxCenter(Request $request)
    {
    	$method = $request->get('method');
        switch ($method) {
            case 'getFormNewTimeClock': // ลงเวลาย้อนหลัง
                if(\Session::has('current_employee')){
                    $current_employee = \Session::get('current_employee');
                }
                $employee = TimeStamp::where('id_employee', $current_employee['id_employee'])->get();

                $header = Employee::where('id_position', 2)->where('id_department', $current_employee['id_department'])->first();
                $form_repo = new FormRepository;
                $form_new_time_clock = $form_repo->getFormNewTimeClock($header);
                return response()->json(['status'=> 'success','data'=> $form_new_time_clock]);
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

            case 'getViewDataRequestTimeStamp': // ดูข้อมูลที่ร้องขอการลงเวลาย้อนหลัง // ดูของลูกน้อง
                $id             = $request->get('id');
                //sd($id);
                $data           = RequestTimeStamp::where('id', $id)->first();
                //sd($data->toArray());
                $form_repo = new FormRepository;
                $form_view_request_timestamp = $form_repo->getViewDataRequestTimeStamp($data);
                //sd($form_view_request_timestamp);
                return response()->json(['status'=> 'success','data'=> $form_view_request_timestamp]);
                break;

            case 'getViewDetailRequestTimeStamp': // ดูลายละเอียดที่ขอลงเวลาย้อนหลัง //ดูของตัวเอง
                $id             = $request->get('id');
                //sd($id);
                $data           = RequestTimeStamp::where('id', $id)->first();
                //sd($data->toArray());
                $form_repo = new FormRepository;
                $form_view_detail_request_timestamp = $form_repo->getViewDetailRequestTimeStamp($data);
                return response()->json(['status'=> 'success','data'=> $form_view_detail_request_timestamp]);
                break;

            case 'getEditRequestTimeStamp': // แก้ไข้ที่ร้องขอไป
                $id             = $request->get('id');
                //sd($id);
                $data           = RequestTimeStamp::where('id', $id)->first();
                //sd($data->toArray());
                $form_repo = new FormRepository;
                $form_edit_request_timestamp = $form_repo->getEditRequestTimeStamp($data);
                return response()->json(['status'=> 'success','data'=> $form_edit_request_timestamp]);
                break;

            case 'getViewDataRequestForgetToTime': // ดูข้อมูลที่ร้องขอการลงเวลาย้อนหลัง // ดูของลูกน้อง
                $id             = $request->get('id');
                //sd($id);
                $data           = RequestForgetToTime::where('id', $id)->first();
                //sd($data->toArray());
                $form_repo = new FormRepository;
                $form_view_data_request_forget_to_time = $form_repo->getViewDataRequestForgetToTime($data);
                return response()->json(['status'=> 'success','data'=> $form_view_data_request_forget_to_time]);
                break;

            case 'getViewDetailRequestForgetToTime': // ดูข้อมูลที่ร้องขอการลงเวลาย้อนหลัง // ลืมลงเวลาบ้างส่วน //ดูของตัวเอง
                $id             = $request->get('id');
                //sd($id);
                $data           = RequestForgetToTime::where('id', $id)->first();
                //sd($data->toArray());
                $form_repo = new FormRepository;
                $form_view_request_forget_to_time = $form_repo->getViewDetailRequestForgetToTime($data);
                return response()->json(['status'=> 'success','data'=> $form_view_request_forget_to_time]);
                break;

            case 'getHistoryNewRecord': // ดูข้อมูลที่ร้องขอการลงเวลาย้อนหลัง // ลืมลงเวลาบ้างส่วน //ดูของตัวเอง

                $form_repo = new FormRepository;
                $form_history_record = $form_repo->getHistoryNewRecord();
                return response()->json(['status'=> 'success','data'=> $form_history_record]);
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
        if(\Session::has('current_employee')){
            $current_employee = \Session::get('current_employee');
        }
        $date_today   = date('Y-m-d');
        if($type_time == "time_in"){
            $current_time = TimeStamp::where('id_employee', $current_employee['id_employee'])->orderBy('date', 'desc')->first();
            $latest_date  = $current_time['date'];
            if($latest_date !== $date_today){ //time_in ซ้ำไม่ได้
                $time_stamp = new TimeStamp();
                $time_stamp->id_employee   = $current_employee['id_employee'];
                $time_stamp->date          = date('Y-m-d');
                $time_stamp->time_in       = date('H:i:s');
                $time_stamp->save();
            }else{
                return "คุณลงเวลาเข้าไปแล้ว";
            }
        }else if($type_time == "break_out"){
            $current_time = TimeStamp::where('id_employee', $current_employee['id_employee'])->where('date', $date_today)->first();

            /*$current_time = TimeStamp::where('id_employee', $current_employee['id_employee'])->where('cr')->first();
            $date_today   = date('Y-m-d');*/

            $id = $current_time['id'];
            $time_stamp = TimeStamp::find($id);
            $time_stamp->break_out = date('Y-m-d H:i:s');
            $time_stamp->save();
        }else if($type_time == "break_in"){
            /*$current_time = TimeStamp::where('id_employee', $current_employee['id_employee'])->orderBy('created_at', 'desc')->first();*/
            $current_time = TimeStamp::where('id_employee', $current_employee['id_employee'])->where('date', $date_today)->first();
            $id = $current_time['id'];
            $time_stamp = TimeStamp::find($id);
            $time_stamp->break_in  = date('Y-m-d H:i:s');
            $time_stamp->save();
        }else if($type_time == "time_out"){
            /*$current_time = TimeStamp::where('id_employee', $current_employee['id_employee'])->orderBy('created_at', 'desc')->first();*/
            $current_time = TimeStamp::where('id_employee', $current_employee['id_employee'])->where('date', $date_today)->first();
            $id = $current_time['id'];
            $time_stamp = TimeStamp::find($id);
            $time_stamp->time_out  = date('Y-m-d H:i:s');
            $time_stamp->save();
        }
    }

    public function addRequestTimeStamp(Request $request) // บันทึกลง request_time_stamp
    {
        date_default_timezone_set('Asia/Bangkok');
        if(\Session::has('current_employee')){
            $current_employee = \Session::get('current_employee');
        }

        $request_date          = $request->get('request_date');
        //sd($request_date);
        $time_in               = $request->get('time_in');
        $break_out             = $request->get('break_out');
        $break_in              = $request->get('break_in');
        $time_out              = $request->get('time_out');
        $reason                = $request->get('reason');

        // save data to database
        $request = new RequestTimeStamp();
        $request->id_employee  = $current_employee['id_employee'];
        $request->request_date = $request_date ;
        $request->time_in      = $time_in;
        $request->break_out    = $break_out;
        $request->break_in     = $break_in;
        $request->time_out     = $time_out;
        $request->reason       = $reason;
        $request->status       = 2;
        if(($current_employee['id_department'] == "en0001" ) && ($current_employee['id_position'] == 1)){
            $request->approvers = 96;
        }else if(($current_employee['id_department'] == "fa0001" ) && ($current_employee['id_position'] == 1)){
            $request->approvers = 99;
        }else if(($current_employee['id_department'] == "hr0001" ) && ($current_employee['id_position'] == 1)){
            $request->approvers = 100;
        }else if(($current_employee['id_department'] == "pm0001" ) && ($current_employee['id_position'] == 1)){
            $request->approvers = 98;
        }else if(($current_employee['id_department'] == "ss0001" ) && ($current_employee['id_position'] == 1)){
            $request->approvers = 97;
        }

        $request->save();
    }

    public function confirmDataRequestTimeStamp(Request $request)  // กดอนุมัติ
    {
        if(\Session::has('current_employee')){
            $current_employee = \Session::get('current_employee');
        }
        $id          = $request->get('id');
        $confirm = RequestTimeStamp::find($id);
        $confirm->status                 = 1;
        //$confirm->save();

        $id_employee_request  = $confirm['id_employee']; // id ของผู้ request
        $date_time_in         = $confirm['delay_time'].' '.$confirm['time_in'];
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
        //$request->save();

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

    public function updateRequestTimeStamp(Request $request){ //แก้ไขข้อมูลที่ร้องขอลงเวลาย้อนหลัง
        $id                    = $request->get('id');
        //sd($id);
        $date                  = $request->get('date');
        $time_in               = $request->get('time_in');
        $break_out             = $request->get('break_out');
        $break_in              = $request->get('break_in');
        $time_out              = $request->get('time_out');
        $reason                = $request->get('reason');

        $update  = RequestTimeStamp::find($id);
        //sd($update);
        $update->delay_time    = $date;
        $update->time_in       = $time_in;
        $update->break_out     = $break_out;
        $update->break_in      = $break_in;
        $update->time_out      = $time_out;
        $update->reason        = $reason;
        $update->status        = 2;
        $update->save();

    }
}