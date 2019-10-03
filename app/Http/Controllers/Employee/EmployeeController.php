<?php

namespace App\Http\Controllers\Employee;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Services\Employee\Employee;
use App\Services\Employee\EmployeeObject;
use App\Services\Position\Position;
use App\Services\Department\Department;

class EmployeeController extends Controller
{
	public function personal_info()
    {
    	//$current_id = Employee::with('position', 'department')->where('id_employee', $this->employee)->first();
        //return view('personal_info.personal_info', ['current_id' => $current_id]);
        if(\Session::has('current_employee')){
        	$current_employee = \Session::get('current_employee');
        	//sd($current_employee['id_department']);
        	$name_position  = Position::with('employee')->where('id_position', $current_employee['id_position'])->first();
        	//sd($name_position['name']);
        	$name_department = Department::with('employee')->where('id_department', $current_employee['id_department'])->first();
        	//sd($name_position['name']);
        	//sd($name_department['name']);
    	}
        return view('personal_info.personal_info', compact('name_position', 'name_department'));
    }

}
