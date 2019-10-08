<?php

namespace App\Http\Controllers\DataManagement;

use Illuminate\Http\Request;
use App\Http\Requests;
use App\Http\Controllers\Controller;
use App\Services\Forms\FormRepository;
use App\Services\Department\Department;
use App\Services\Position\Position;
use App\Services\Employee\Employee;

class DataManageController extends Controller
{
	public function index()
	{
        $department      = Department::all();
        if(\Session::has('current_employee')){
            $current_employee = \Session::get('current_employee');

            $employee     = Employee::with('department')->where('id_department', $current_employee['id_department'])->get();
            //$department = Department::where('id_department', $current_employee['id_department'])->first();
            //sd($department->toArray());
           // $name_department = Department::with('employee')->where('id_department', $current_employee['id_department'])->first();
            //sd($name_department);
            //sd($header->toArray());
            //sd($header->department->toArray());
            //sd($header->department['name']);
           //$employee = Employee::where('id_department', $current_employee['id_department'])->where('id_position', 1)->get();
           //sd($employee[0]['first_name']);

            /*if($current_employee['id_role'] == 4 ){ //header_hr
                $header   = Employee::where('id_role', 4)->where('id_employee', $current_employee['id_employee'])->first();
                $employee = Employee::where('id_role', 3)->get();
                //sd($employee[1]['first_name']);
                //var_dump($employee);
            }else if($current_employee['id_role'] == 3 ){ //employee_hr
                $header   = Employee::where('id_role', 4)->first();
                $employee = Employee::where('id_role', 3)->get();
            }else if($current_employee['id_role'] == 2 ){ //header_general
                $header   = Employee::where('id_role', 2)->where('id_employee', $current_employee['id_employee'])->first();
                $employee = Employee::where('id_role', 1)->where('id_department', $current_employee['id_department'])->get();
            }*/


		/*$current_id      = Employee::with('position', 'department')->where('id_employee', $id)->first();
        $employee_header = Employee::with('position', 'department')->where('id_position', 2)->where('id_department', 'hr0001')->first();
        $employee_hr     = Employee::where('id_position', 1)->where('id_department', 'hr0001')->get();
        $department      = Department::all();*/
		//return $this->useTemplate('data_management.index', compact('current_id', 'employee_hr', 'department', 'employee_header'));

            /*$name_position  = Position::with('employee')->where('id_position', $current_employee['id_position'])->first();
            $name_department = Department::with('employee')->where('id_department', $current_employee['id_department'])->first();*/
            /*if($current_employee['id_department'] == "hr0001" && $current_employee['id_position'] == 2){ //header_hr
                $header   = Employee::where('id_department', "hr0001")->where('id_position', 2);
                $employee = Employee::where('id_department', "hr0001")->where('id_position', 1);
            }else if($current_employee['id_department'] == "hr0001" && $current_employee['id_position'] == 1){ //employee_hr
                $header   = Employee::where('id_department', "hr0001")->where('id_position', 2);
                $employee = Employee::where('id_department', "hr0001")->where('id_position', 1);
            }else if($current_employee['id_department'] == "hr0001" && $current_employee['id_position'] == 2){ //header_general

            }*/


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
                $form_repo      = new FormRepository;
                $form_add_emp   = $form_repo->getFormEmployee($department,$position);
                return response()->json(['status'=> 'success','data'=> $form_add_emp]);
            break;
            case 'getFormEmployeeWithDepartment':
                    $department = $request->get('department');
                    $employee   = Employee::where('id_department', $department)->get();

                    $form_repo      = new FormRepository;
                    $get_form_emp   = $form_repo->getFormChangeDepartment($employee);
                     return response()->json(['status'=> 'success','data'=> $get_form_emp]);
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
        $employee->education     = $education;
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

        $employee->save();

        //return redirect()->route('data_management.index.get');
    }


}
