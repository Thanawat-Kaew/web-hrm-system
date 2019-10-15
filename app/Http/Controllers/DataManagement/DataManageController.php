<?php

namespace App\Http\Controllers\DataManagement;

use Illuminate\Http\Request;
use App\Http\Requests;
use App\Http\Controllers\Controller;
use App\Services\Forms\FormRepository;
use App\Services\Department\Department;
use App\Services\Position\Position;
use App\Services\Employee\Employee;
use App\Services\Education\Education;
use App\Services\Request\RequestChangeData;

class DataManageController extends Controller
{
	public function index()
	{
        $department      = Department::all();
        if(\Session::has('current_employee')){
            $current_employee = \Session::get('current_employee');
            $header     = Employee::with('department')->where('id_department', $current_employee['id_department'])->get();
            $employee     = Employee::with('department')->where('id_department', $current_employee['id_department'])->get();

        }
        return $this->useTemplate('data_management.index', compact('department', 'employee'));
    }

    public function ajaxCenter(Request $request)
    {

    	$method = $request->get('method');
        switch ($method) {
            case 'getFormAddEmployee':
                $department     = Department::all();
                $position       = Position::all();
                $education      = Education::all();
                //sd($education->toArray());
                $form_repo      = new FormRepository;
                $form_add_emp   = $form_repo->getFormEmployee($department,$position,$education);
                return response()->json(['status'=> 'success','data'=> $form_add_emp]);
            break;
            case 'getFormEmployeeWithDepartment':
                    $department = $request->get('department');
                    //sd($department); // en0001
                    $employee   = Employee::where('id_department', $department)->get();
                    $form_repo      = new FormRepository;
                    $get_form_emp   = $form_repo->getFormChangeDepartment($employee);
                     return response()->json(['status'=> 'success','data'=> $get_form_emp]);
            break;

            case 'getManageData':
                $employee_id           = $request->get('employee_id');
                $get_data_employee = Employee::with('position', 'department')->where('id_employee', $employee_id)->first();
                $form_repo          = new FormRepository;
                $form_manage_data   = $form_repo->getManageData($get_data_employee);
                return response()->json(['status'=> 'success','data'=> $form_manage_data]);
                break;

            case 'getFormEditEmployee':
                $id             = $request->get('id');
                $employee    = Employee::with('department')->with('position')->with('education')->where('id_employee', $id)->first();
                //sd($id);
                //sd($employee->position['name']);
                //sd($employee->toArray());
                $department     = Department::all();
                $position       = Position::all();
                $education       = Education::all();
                $form_repo      = new FormRepository;
                $form_edit_emp   = $form_repo->getFormEmployee($department,$position, $education, $employee);
                return response()->json(['status'=> 'success','data'=> $form_edit_emp]);
            break;

            case 'getFormAmendmentEmployee':
                $form_repo      = new FormRepository;
                $form_amendment_emp   = $form_repo->getFormEmployee();
                return response()->json(['status'=> 'success','data'=> $form_amendment_emp]);
            break;

            case 'getDataPersonal':
                $id             = $request->get('id');
                $employee       = Employee::with('department')->with('position')->with('education')->where('id_employee', $id)->first();
                $form_repo      = new FormRepository;
                $form_view_emp   = $form_repo->getDataPersonal( $employee);
                return response()->json(['status'=> 'success','data'=> $form_view_emp]);
            break;

            case 'getViewDataRequest': // ดูข้อมูลที่ร้องข้อการแก้ไข
                $id             = $request->get('id');
                $employee       = RequestChangeData::with('employee')->where('id', $id)->first();
                //sd($employee->toArray());
                $emp_department    = Department::where('id_department', $employee['id_department'])->first();
                $emp_position      = Position::where('id_position', $employee['id_position'])->first();
                $emp_education     = Education::where('id_education', $employee['id_education'])->first();
                $form_repo      = new FormRepository;
                $form_view_date_request   = $form_repo->getViewDataRequest($employee, $emp_department, $emp_position, $emp_education);
                return response()->json(['status'=> 'success','data'=> $form_view_date_request]);
            break;

            default:
                # code...
            break;
        }
    }

    public function addEmployee(Request $request)
    {
        // get value from ajax function saveAddEmployee(oldValue)

        $id_department      = $request->get('department');
        $id_position        = $request->get('position');
        $first_name         = $request->get('fname');
        $last_name          = $request->get('lname');
        $email              = $request->get('email');
        $password           = $request->get('password');
        $address            = $request->get('address');
        $gender             = $request->get('gender');
        $tel                = $request->get('tel');
        $age                = $request->get('age');
        $education          = $request->get('education');
        $salary             = $request->get('salary');

        // save data to database
        $employee = new Employee();
        $employee->id_department = $id_department;
        $employee->id_position   = $id_position ;
        $employee->first_name    = $first_name;
        $employee->last_name     = $last_name;
        $employee->email         = $email;
        $employee->password      = $password;
        $employee->address       = $address;
        $employee->gender        = $gender;
        $employee->tel           = $tel;
        $employee->age           = $age;
        $employee->id_education  = $education;
        $employee->salary        = $salary;

        if($employee->id_department == 'en0001' || 'fa0001' || 'pm0001' || 'ss0001' && $employee->id_position == 1){
            $employee->id_role = 1;
        }else if($employee->id_department == 'en0001' || 'fa0001' || 'pm0001' || 'ss0001' && $employee->id_position == 2){
            $employee->id_role = 2;
        }else if($employee->id_department == 'hr0001' && $employee->id_position == 1){
            $employee->id_role = 3;
        }else if($employee->id_department == 'hr0001' && $employee->id_position == 4){
            $employee->id_role = 4;
        }
        //sd($employee->id_department);
        $employee->save();
    }

    public function notificationRequest()
    {
        $request = RequestChangeData::orderBy('id', 'desc')->get();
        //sd($request->toArray());
        return $this->useTemplate('data_management.notification_request', compact('request'));

    }

    public function confirmDataRequest(Request $request)
    {
        if(\Session::has('current_employee')){
            $current_employee = \Session::get('current_employee');
        }
        $id          = $request->get('id');
        //sd($id);
        $confirm = RequestChangeData::find($id);
        //d($confirm->toArray());
        $confirm->status                 = 1;
        $confirm->approvers              = $current_employee['id_employee'];
        $confirm->save();
    }

    public function cancelDataRequest(Request $request)
    {
        if(\Session::has('current_employee')){
            $current_employee = \Session::get('current_employee');
        }
        $id              = $request->get('id');
        $reason_reject   = $request->get('reason_reject');
        //sd($id);
        $confirm = RequestChangeData::find($id);
        //d($confirm->toArray());
        $confirm->status               = 3;
        $confirm->approvers            = $current_employee['id_employee'];
        $confirm->reason_approvers     = $reason_reject;
        $confirm->save();
    }

    // public function postDeleteData()
    //     {

    //     $employee    = Employee::first();
    //     sd($employee);
    //     if(!empty($employee))
    //     {
    //         $employee->delete();

    //         return ['status' => 'success', 'message' => 'Delete complete.'];

    //     }
    //     else
    //     {
    //         return['status' => 'failed','message' =>'Not found.'];
    //     }
    // }

}