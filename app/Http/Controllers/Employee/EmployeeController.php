<?php

namespace App\Http\Controllers\Employee;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Services\Auth\Employee;
use App\Services\Auth\Position;
use App\Services\Auth\Department;

class EmployeeController extends Controller
{
	public function personal_info($id)
    {	
    	$current_id = Employee::with('position', 'department')->where('id_employee', $id)->first();
        return view('personal_info.personal_info', ['current_id' => $current_id]);
    }
  
}
