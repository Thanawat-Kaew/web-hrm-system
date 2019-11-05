<?php

namespace App\Http\Controllers\Employee;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Services\Employee\Employee;
use App\Services\Employee\EmployeeObject;
use App\Services\Position\Position;
use App\Services\Department\Department;
use App\Services\Forms\FormRepository;
use App\Services\Request\RequestChangeData;
use App\Services\Education\Education;
use App\Services\TimeStamp\TimeStamp;

class EmployeeController extends Controller
{
	public function personal_info()
    {
    	//$current_id = Employee::with('position', 'department')->where('id_employee', $this->employee)->first();
        //return view('personal_info.personal_info', ['current_id' => $current_id]);
        if(\Session::has('current_employee')){
        	$current_employee  = \Session::get('current_employee');
        	$name_position     = Position::with('employee')->where('id_position', $current_employee['id_position'])->first();
        	$name_department   = Department::with('employee')->where('id_department', $current_employee['id_department'])->first();
            $name_education   = Education::with('employee')->where('id_education', $current_employee['id_education'])->first();
            //sd($name_education['name']);

            $request_edit_data = RequestChangeData::with('employee')->where('id_employee', $current_employee['id_employee'])->orderBy('id', 'desc')->get();
            //sd($request_edit_data->toArray());
    	}
        return $this->useTemplate('personal_info.personal_info', compact('name_position', 'name_department', 'request_edit_data', 'name_education'));
    }

    public function ajaxCenter(Request $request)
    {

        $method = $request->get('method');
        switch ($method) {
            case 'getFormAmendmentEmployee': // แก้ไขข้อมูลครั้งแรก
                $id             = $request->get('id');
                $employee       = Employee::with('department')->with('position')->with('education')->where('id_employee', $id)->first();
                // sd($employee->toArray());
                //sd($employee['gender']);
                //sd($employee->education['name']);
                $department     = Department::all();
                $position       = Position::all();
                $education      = Education::all();
                $form_repo              = new FormRepository;
                $form_amendment_emp     = $form_repo->getFormAmendment($department, $position ,$employee, $education);
                return response()->json(['status'=> 'success','data'=> $form_amendment_emp]);
            break;

            case 'getHistoryChangeData': // ดูข้อมูล
                $id             = $request->get('id');
                //sd($id);
                $employee       = RequestChangeData::with('employee')->where('id', $id)->first();
                //sd($employee['id_employee']);
                $emp_department    = Department::where('id_department', $employee['id_department'])->first();
                $emp_position      = Position::where('id_position', $employee['id_position'])->first();
                $emp_education     = Education::where('id_education', $employee['id_education'])->first();
                //sd($emp_position->position['id_position']);
                //sd($emp_position);
                $form_repo              = new FormRepository;
                $form_amendment_emp     = $form_repo->getHistoryChangeData($emp_department, $emp_position ,$employee, $emp_education);
                return response()->json(['status'=> 'success','data'=> $form_amendment_emp]);
            break;

            case 'getEditAgain': // แก้ไขข้อมูลครั้งที่ 2
                $id                = $request->get('id');
                //sd($id);
                $employee          = RequestChangeData::with('employee')->where('id', $id)->first();
                //sd($employee['id']);
                //sd($employee['created_at']);
                //$exp = explode(" ", $employee['created_at']);
                //sd($exp[0]);
                $emp_department    = Department::where('id_department', $employee['id_department'])->first();
                $emp_position      = Position::where('id_position', $employee['id_position'])->first();
                $emp_education     = Education::where('id_education', $employee['id_education'])->first();
                $department        = Department::all();
                $position          = Position::all();
                $education         = Education::all();
                $form_repo              = new FormRepository;
                $form_amendment_emp     = $form_repo->getEditAgain($emp_department, $emp_position ,$employee, $position, $department, $emp_education, $education);
                return response()->json(['status'=> 'success','data'=> $form_amendment_emp]);
            break;

            default:
            break;
        }
    }

    public function editDataEmployee(Request $request){
        $id_employee = $request->get('id_employee');
        $fname       = $request->get('fname');
        $lname       = $request->get('lname');
        $position    = $request->get('position');
        $department  = $request->get('department');
        $education   = $request->get('education');
        $gender      = $request->get('gender');
        $age         = $request->get('age');
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
        $edit->age             = $age;
        $edit->address         = $address;
        $edit->email           = $email;
        $edit->tel             = $tel;
        $edit->reason          = $reason;
        $edit->status          = 2;

        $edit->save();
    }

    public function updateEditDataEmployee(Request $request){
        $id          = $request->get('id');
        $id_employee = $request->get('id_employee');
        $fname       = $request->get('fname');
        $lname       = $request->get('lname');
        $position    = $request->get('position');
        $department  = $request->get('department');
        $education   = $request->get('education');
        $gender      = $request->get('gender');
        $age         = $request->get('age');
        $address     = $request->get('address');
        $email       = $request->get('email');
        $tel         = $request->get('tel');
        $reason      = $request->get('reason');

        //sd($id_employee);
        //sd($reason);
        //sd($id);

        //save to database
        $edit = RequestChangeData::find($id);
        //sd($edit);
        $edit->id_employee     = $id_employee;
        $edit->first_name      = $fname;
        $edit->last_name       = $lname;
        $edit->id_position     = $position;
        $edit->id_department   = $department;
        $edit->id_education    = $education;
        $edit->gender          = $gender;
        $edit->age             = $age;
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

        // date_default_timezone_set('Asia/Bangkok');
        // $date = date('Y-m-d H:i:s');
        // sd($date );
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
