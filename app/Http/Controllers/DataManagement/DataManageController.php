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
               	$form_repo      = new FormRepository;
				$form_add_emp   = $form_repo->getFormEmployee($department,$position);
                return response()->json(['status'=> 'success','data'=> $form_add_emp]);
                break;

            // case 'getManageData':
            //     $form_repo          = new FormRepository;
            //     $form_manage_data   = $form_repo->getManageData();
            //     return response()->json(['status'=> 'success','data'=> $form_manage_data]);
            //     break;

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

    public function changeDepartment(Request $request)
    {
        /*$department = $request->get('department');
        switch ($department) {
            case 'department':
                $employee                    = Employee::where('id_department', $departmentr)->get();
                $department                  = Department::all();
                $form_repo                   = new FormRepository;
                $form_change_department      = $form_repo->getFormChangeDepartment($employee);
                return response()->json(['status'=> 'success','data'=> $form_change_department]);
                break;

            default:
                # code...
                break;
        }*/


        $department = $request->get('department');
        $employee   = Employee::where('id_department', $department)->get();
        //sd($employee->toArray());
    

        $form ='<div class="row" id="header">';
        foreach ($employee as $key => $value) {
           if($value['id_position'] == 2) {
                $form .='<div class="col-md-2 col-sm-2 ">';
                    $form .='<div class="box box-widget widget-user-2">';
                        $form .='<div class="widget-user-header">';
                            $form .='<!-- /.widget-user-image -->';
                                $form .='<div class="group-image" align="center" valign="center">';
                                    $form .='<img src="/resources/assets/theme/adminlte/dist/img/user8-128x128.jpg">';
                                $form .='</div>';
                            $form .='<div class="about-employee" id="header">';
                                $form .='<p id="header_id">รหัส  :<span>'.$value["id_employee"].'</span></p>';
                                $form .='<p id="header_name">ชื่อ :<span>'.$value["first_name"].' '.$value["last_name"].'</span></p>';
                            $form .='</div>';
                        $form .='</div>';
                        $form .='<div class="box-footer no-padding">';
                            $form .='<ul class="nav nav-stacked">';
                                $form .='<li class="manage-employee">';
                                    $form .='<a style="margin: 5px border: 1px; color : #F76608;">';
                                        $form .='<center>';
                                            $form .='<i class="fa fa-cog"></i> Manage Data';
                                        $form .='</center>';
                                    $form .='</a>';
                                $form .='</li>';
                            $form .='</ul>';
                        $form .='</div>';
                    $form .='</div>';
                $form .='</div>';
            }
        }
        $form .= '</div>';
        $form .='<h4 class="box-title">พนักงาน</h4>
                <hr>
                <div class="box-body" id="group-employee">
                <div class="row" id="employee">';
        foreach($employee as $key => $value) {
            if($value['id_position'] == 1) {
                $form .='<div class="col-md-2 col-sm-2 ">';
                    $form .='<div class="box box-widget widget-user-2">';
                         $form .='<div class="widget-user-header">';
                            $form .='<!-- /.widget-user-image -->';
                                $form .='<div class="group-image" align="center" valign="center">';
                                    $form .='<img src="/resources/assets/theme/adminlte/dist/img/user2-160x160.jpg">';
                                $form .='</div>';
                                $form .='<div class="about-employee" id="employee">';
                                    $form .='<p>รหัส  :<span>'.$value['id_employee'].'</span></p>';
                                    $form .='<p>ชื่อ   :<span>'.$value['first_name'].' '.$value['last_name'].'</span></p>';
                                $form .='</div>';
                        $form .='</div>';
                        $form .='<div class="box-footer no-padding">';
                            $form .='<ul class="nav nav-stacked">';
                                $form .='<li class="manage-employee">';
                                    $form .='<a style="margin: 5px border: 1px; color : #F76608;">';
                                        $form .='<center>';
                                            $form .='<i class="fa fa-cog"></i> Manage Data';
                                        $form .='</center>';
                                    $form .='</a>';
                                $form .='</li>';
                            $form .='</ul>';
                        $form .='</div>';
                    $form .='</div>';
                $form .='</div>';
            }
        }
        $form .='</div>';
        $form .='</div>';
        echo $form;
        //sd($header);
    }
}
