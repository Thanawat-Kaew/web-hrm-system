<?php

namespace App\Http\Controllers\DataManagement;

use Illuminate\Http\Request;
use App\Http\Requests;
use App\Http\Controllers\Controller;
use App\Services\Forms\FormRepository;
use App\Services\Auth\Department;
use App\Services\Auth\Position;
use App\Services\Auth\Employee;

class DataManageController extends Controller
{
	public function index()
	{
		
		return $this->useTemplate('data_management.index'/*,compact('form_add_emp')*/);
	}  

	 public function ajaxCenter(Request $request)
    {

    	$method = $request->get('method');
        switch ($method) {
            case 'getFormAddEmpolyee':
                $department = Department::all();
                $position = Position::all();
               	$form_repo = new FormRepository;
				$form_add_emp = $form_repo->getFormEmployee($department,$position);
                return response()->json(['status'=> 'success','data'=> $form_add_emp]);
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
        $employee->salary        =  $salary;

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
    }
}
