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
        /*if(\Session::has('current_employee')){
            $current_employee = \Session::get('current_employee');
        }
        $header     = Employee::with('department')->where('id_department', )->get();
        $employee   = Employee::with('department')->where('id_department', $current_employee['id_department'])->get();*/
        return $this->useTemplate('admin.add_header_emp', compact('department'));
    }

    public function admin_add_department()
    {
        $department = Department::all();
        return $this->useTemplate('admin.add_department',compact('department'));
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

    public function add_department(Request $request)
    {
        $get_id_department      = $request->get('id_department');
        $get_name_department    = $request->get('name_department');

        if (!empty($get_id_department) && !empty($get_name_department))  {

            $check_department       = Department::where('id_department', $get_id_department)->first();

            if (!empty($check_department)) {
                return json_encode(['status' => 'failed', 'message' => "errors"]);
            }

            $request_department                     = new Department;
            $request_department->id_department      = $get_id_department;
            $request_department->name               = $get_name_department;
            $request_department->save();
            
            return json_encode(['status' => 'success', 'message' => "success"]);
        }

        return json_encode(['status' => 'failed_fied_err', 'message' => "errors"]);
    }
}