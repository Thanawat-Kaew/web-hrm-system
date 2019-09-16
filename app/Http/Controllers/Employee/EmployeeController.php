<?php

namespace App\Http\Controllers\Employee;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

class EmployeeController extends Controller
{
	public function personal_info()
    {
        return view('personal_info.personal_info');
    }
    
}
