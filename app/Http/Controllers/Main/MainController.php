<?php

namespace App\Http\Controllers\Main;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
//use Illuminate\Support\Facades\Session;
use App\Services\Employee\EmployeeObject;

class MainController extends Controller
{
	public function main()
    {
    	if(\Session::has('current_employee')){
            $current_employee = \Session::get('current_employee');
            //sd($current_employee->image);
		}

        return view('main', compact('current_employee'));
    }

    public function admin_main()
    {
        return view('admin.admin_main');
    }
}

