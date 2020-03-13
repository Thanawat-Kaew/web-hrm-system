<?php

namespace App\Http\Controllers\Admin;

use Illuminate\Http\Request;
use App\Http\Requests;
use App\Http\Controllers\Controller;
use App\Services\Forms\FormEmployee;
use App\Services\Forms\FormChangeDepartment;
use App\Services\Forms\FormManageData;
use App\Services\Forms\FormDataPersonal;
use App\Services\Forms\FormViewDataRequest;
use App\Services\Department\Department;
use App\Services\Position\Position;
use App\Services\Employee\Employee;
use App\Services\Employee\EmployeeMenu;
use App\Services\Education\Education;
use App\Services\Request\RequestChangeData;

class AdminController extends Controller
{
    public function admin_add_header_emp()
    {
        $department      = Department::all();
        if(\Session::has('current_employee')){
            $current_employee = \Session::get('current_employee');
        }
        $header     = Employee::with('department')->where('id_department', $current_employee['id_department'])->get();
        $employee   = Employee::with('department')->where('id_department', $current_employee['id_department'])->get();
        return $this->useTemplate('admin.add_header_emp', compact('department', 'employee'));
    }

    public function admin_add_department()
    {
        return view('admin.add_department');
    }

    public function admin_log()
    {
        return view('admin.log');
    }

    public function ajaxCenter(Request $request)
    {
        $method = $request->get('method');
        switch ($method) {
            case 'getDataPersonal':
                $id             = $request->get('id');
                $employee       = Employee::with('department')->with('position')->with('education')->where('id_employee', $id)->first();
                $form_repo      = new FormDataPersonal;
                $form_view_emp   = $form_repo->getDataPersonal( $employee);
                return response()->json(['status'=> 'success','data'=> $form_view_emp]);
            break;

            case 'getFormEmployeeWithDepartment':
                    $department = $request->get('department');
                    //sd($department); // en0001
                    $employee   = Employee::where('id_department', $department)->get();
                    $form_repo      = new FormChangeDepartment;
                    $get_form_emp   = $form_repo->getFormChangeDepartment($employee);
                    return response()->json(['status'=> 'success','data'=> $get_form_emp]);
            break;

            default:
                # code...
            break;
        }
    }
}

