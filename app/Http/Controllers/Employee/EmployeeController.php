<?php

namespace App\Http\Controllers\Employee;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Services\Employee\Employee;
use App\Services\Employee\EmployeeObject;
use App\Services\Position\Position;
use App\Services\Department\Department;
use App\Services\Forms\FormEmployee;
use App\Services\Forms\FormAmendment;
use App\Services\Forms\FormHistoryChangeData;
use App\Services\Forms\FormEditAgainPersonalInfo;
use App\Services\Request\RequestChangeData;
use App\Services\Education\Education;
use App\Services\TimeStamp\TimeStamp;
use App\Services\Forms\FormEmail;
use Illuminate\Support\Facades\Mail;

class EmployeeController extends Controller
{
	public function personal_info() //หน้าแสดงข้อมูลส่วนตัว
    {
        session_start();
        if(isset($_SESSION['status'])){
            if(isset($_SESSION["get_session_dep"])){
                unset($_SESSION["get_session_dep"]);
            }
            if(isset($_SESSION["get_session_topic"])){
                unset($_SESSION["get_session_topic"]);
            }
        }
    
        if(\Session::has('current_employee')){
        	$current_employee  = \Session::get('current_employee');
        	$name_position     = Position::with('employee')->where('id_position', $current_employee['id_position'])->first();
        	$name_department   = Department::with('employee')->where('id_department', $current_employee['id_department'])->first();
            $name_education   = Education::with('employee')->where('id_education', $current_employee['id_education'])->first();
            $request_edit_data = RequestChangeData::with('employee')->where('id_employee', $current_employee['id_employee'])->orderBy('id', 'desc')->get();
    	}
        $employee       = Employee::with('position', 'department', 'education')->where('id_employee', $current_employee['id_employee'])->first();
        $date_of_birth  = $employee->date_of_birth; // วันเกิดจากฐานข้อมูล
        $str            = strtotime(date('Y-m-d')) - (strtotime($date_of_birth)); //นำมาลบกับวันที่ปัจจุบัน
        $day            = floor($str/3600/24); // แปลงเป็นวัน
        $age            = number_format($day / 365); // แปลงเป็นอายุ
        return $this->useTemplate('personal_info.personal_info', compact('name_position', 'name_department', 'request_edit_data', 'name_education', 'age', 'employee'));
    }

    public function ajaxCenter(Request $request)
    {

        $method = $request->get('method');
        switch ($method) {
            case 'getFormAmendmentEmployee': // แก้ไขข้อมูลครั้งแรก
                $id             = $request->get('id');
                $employee       = Employee::with('department')->with('position')->with('education')->where('id_employee', $id)->first();
                $department     = Department::all();
                $position       = Position::where('id_position', $employee['id_position'])->first();
                $education      = Education::all();
                $form_repo              = new FormAmendment;
                $form_amendment_emp     = $form_repo->getFormAmendment($department, $position ,$employee, $education);
                return response()->json(['status'=> 'success','data'=> $form_amendment_emp]);
            break;

            case 'getHistoryChangeData': // ดูข้อมูล
                $id             = $request->get('id');
                $employee       = RequestChangeData::with('employee')->where('id', $id)->first();
                $emp_department    = Department::where('id_department', $employee['id_department'])->first();
                $emp_position      = Position::where('id_position', $employee['id_position'])->first();
                $emp_education     = Education::where('id_education', $employee['id_education'])->first();
                $form_repo              = new FormHistoryChangeData;
                $form_amendment_emp     = $form_repo->getHistoryChangeData($emp_department, $emp_position ,$employee, $emp_education);
                return response()->json(['status'=> 'success','data'=> $form_amendment_emp]);
            break;

            case 'getEditAgain': // แก้ไขข้อมูลครั้งที่ 2
                $id                = $request->get('id');
                $employee          = RequestChangeData::with('employee')->where('id', $id)->first();
                $emp_department    = Department::where('id_department', $employee['id_department'])->first();
                $emp_position      = Position::where('id_position', $employee['id_position'])->first();
                $emp_education     = Education::where('id_education', $employee['id_education'])->first();
                $department        = Department::all();
                $position          = Position::all();
                $education         = Education::all();
                $form_repo              = new FormEditAgainPersonalInfo;
                $form_amendment_emp     = $form_repo->getEditAgain($emp_department, $emp_position ,$employee, $position, $department, $emp_education, $education);
                return response()->json(['status'=> 'success','data'=> $form_amendment_emp]);
            break;

            case 'getFormEmail': // Form กรอกข้อมูลของ email
                $id_employee   = $request->get('id_employee');
                $reciver       = Employee::where('id_employee', $id_employee)->first();
                $form_repo     = new FormEmail;
                $get_form      = $form_repo->getFormEmail($reciver);
                return response()->json(['status'=> 'success','data'=> $get_form]);
            break;

            default:
            break;
        }
    }

    public function editDataEmployee(Request $request){  // แก้ไขครังแรก
        $id_employee = $request->get('id_employee');
        $fname       = $request->get('fname');
        $lname       = $request->get('lname');
        $position    = $request->get('position');
        $department  = $request->get('department');
        $education   = $request->get('education');
        $gender      = $request->get('gender');
        $date_of_birth         = $request->get('date_of_birth');
        $address     = $request->get('address');
        $email       = $request->get('email');
        $tel         = $request->get('tel');
        $reason      = $request->get('reason');

        //save to database
        $edit = new RequestChangeData();
        $edit->id_employee     = $id_employee;
        $edit->first_name      = $fname;
        $edit->last_name       = $lname;
        $edit->id_position     = $position;
        $edit->id_department   = $department;
        $edit->id_education    = $education;
        $edit->gender          = $gender;
        $edit->date_of_birth             = $date_of_birth;
        $edit->address         = $address;
        $edit->email           = $email;
        $edit->tel             = $tel;
        $edit->reason          = $reason;
        $edit->status          = 2;

        $edit->save();
    }

    public function updateEditDataEmployee(Request $request){ // แก้ไขครั้งที่2
        $id          = $request->get('id');
        $id_employee = $request->get('id_employee');
        $fname       = $request->get('fname');
        $lname       = $request->get('lname');
        $position    = $request->get('position');
        $department  = $request->get('department');
        $education   = $request->get('education');
        $gender      = $request->get('gender');
        $date_of_birth         = $request->get('date_of_birth');
        $address     = $request->get('address');
        $email       = $request->get('email');
        $tel         = $request->get('tel');
        $reason      = $request->get('reason');

        //save to database
        $edit = RequestChangeData::find($id);
        $edit->id_employee     = $id_employee;
        $edit->first_name      = $fname;
        $edit->last_name       = $lname;
        $edit->id_position     = $position;
        $edit->id_department   = $department;
        $edit->id_education    = $education;
        $edit->gender          = $gender;
        $edit->date_of_birth             = $date_of_birth;
        $edit->address         = $address;
        $edit->email           = $email;
        $edit->tel             = $tel;
        $edit->reason          = $reason;
        $edit->status          = 2;

        $edit->save();
    }

     public function postDeleteRequestChangeData($id)
        {

        $employee           = RequestChangeData::with('employee')->where('id', $id)->first();
        if(!empty($employee))
        {
            $employee->delete();

            return ['status' => 'success', 'message' => 'Delete complete.'];

        }
        else
        {
            return['status' => 'failed','message' =>'Not found.'];
        }
    }


}
