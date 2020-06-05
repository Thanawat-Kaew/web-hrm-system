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
use App\Services\Employee\EmployeeObject;
use App\Services\Employee\EmployeeMenu;
use App\Services\Education\Education;
use App\Services\Request\RequestChangeData;
use App\Services\Admin\Admin;
use App\Services\Admin\AdminObject;
use App\Services\Forms\FormHeaderAndEmployeeWithDepartmentForAdmin;
use App\Services\Forms\FormEditHeaderAndEmployeeForAdmin;
use App\Services\Forms\FormAddHeader;
use App\Services\Employee\StatusEmployee;
use App\Services\Admin\RecoveryStatusEmployee;
use App\Services\Evaluation\Evaluation;
use App\Services\Leaves\Leaves;
use App\Services\Request\Requesttimestamp;
use App\Services\TimeStamp\TimeStamp;
use App\Services\Evaluation\ResultEvaluation;
use App\Services\Company\Company;


class AdminController extends Controller
{
    public function admin_add_header_emp()
    {
        if(\Session::has('current_admin')){
            $current_admin = \Session::get('current_admin');
        }
        $department      = Department::all();
        return $this->useTemplate('admin.add_header_emp', compact('department', 'current_admin'));
    }

    public function admin_add_department()
    {
        $department = Department::all();
        return $this->useTemplate('admin.add_department',compact('department'));
    }

    public function admin_log()
    {
        $employee      = RecoveryStatusEmployee::with('employee', 'employee.position', 'employee.department')->where('id_status', 2)->get();

        $array_delete_by  = array();
        foreach ($employee as $value){
            $array_delete_by[] = $value->delete_by_id_employee; // for loop เพื่อเก็บ id คนที่ลบ
        }

        $count_employee = $employee->count();
        $count_first_name       = [];
        $count_last_name        = [];
        for($i=0; $i<$count_employee; $i++){
            $delete_by          = Employee::where('id_employee', $array_delete_by[$i])->first();
            $count_first_name[] = $delete_by->first_name;
            $count_last_name[]  = $delete_by->last_name;
        }
        return $this->useTemplate('admin.log', compact('employee', 'count_first_name', 'count_last_name'));
    }

    public function admin_log_history()
    {
        $employee      = RecoveryStatusEmployee::with('employee', 'employee.position', 'employee.department')->where('id_status', "!=", 2)->get();
        //sd($employee->toArray());
        /*$array_delete_by  = array();
        foreach ($employee as $value){
            $array_delete_by[] = $value->delete_by_id_employee; // for loop เพื่อเก็บ id คนที่ลบ
        }*/

        //$count_employee = $employee->count();
        /*$count_first_name       = [];
        $count_last_name        = [];
        for($i=0; $i<$count_employee; $i++){
            $delete_by          = Employee::where('id_employee', $array_delete_by[$i])->first();
            $count_first_name[] = $delete_by->first_name;
            $count_last_name[]  = $delete_by->last_name;
        }*/
        return $this->useTemplate('admin.log_history', compact('employee'));
    }

    public function admin_emergency_mode()
    {
        $get_company            = Company::where('id_company','1')->first();
        return $this->useTemplate('admin.emergency_mode',compact('get_company'));
    }

    public function setEmergencyMode(Request $request)
    {
        $get_company            = Company::where('id_company','1')->first();
        $id                     = $get_company->id_company;

        $get_emergency_status   = $request->get('emergency_status');

        $emergency_status                       = Company::find($id);
        $emergency_status->emergency_status     = $get_emergency_status;
        $emergency_status->save();

        if ($get_emergency_status == '1') {

            return response()->json(['status'=> 'success','data'=> 'เปิดการใช้งานโหมดสภาวะไม่ปกติแล้ว']);
        }else{

            return response()->json(['status'=> 'success','data'=> 'ปิดการใช้งานโหมดสภาวะไม่ปกติแล้ว']);
        }

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

            case 'getFormHeaderAndEmployeeWithDepartmentForAdmin':
                $department     = $request->get('department');
                $employee       = Employee::where('id_department', $department)->get();
                $form_repo      = new FormHeaderAndEmployeeWithDepartmentForAdmin;
                $get_form_emp   = $form_repo->getFormHeaderAndEmployeeWithDepartmentForAdmin($employee);
                return response()->json(['status'=> 'success','data'=> $get_form_emp]);
            break;

            case 'getManageData':
                if(\Session::has('current_admin')){
                    $current_admin = \Session::get('current_admin');
                }
                $employee_id                = $request->get('employee_id');
                $get_data_employee = Employee::with('position', 'department')->where('id_employee', $employee_id)->first();
                $form_repo          = new FormManageData;
                $form_manage_data   = $form_repo->getManageData($get_data_employee, $current_admin);
                return response()->json(['status'=> 'success','data'=> $form_manage_data]);
            break;

            case 'getFormEditHeaderAndEmployeeForAdmin':
                $id             = $request->get('id'); // id ของคนที่ถูกเลือก

                $employee       = Employee::with('department')->with('position')->with('education')->where('id_employee', $id)->first();
                $department     = Department::where('id_department', $employee['id_department'])->first();
                $position       = Position::all();
                $education      = Education::all();
                $form_repo      = new FormEditHeaderAndEmployeeForAdmin;
                $form_edit_emp  = $form_repo->getFormEditHeaderAndEmployeeForAdmin($department,$position, $education, $employee);
                return response()->json(['status'=> 'success','data'=> $form_edit_emp]);
            break;

            case 'getFormAddHeader':
                $department     = Department::all();
                $position       = Position::where('id_position', 2)->first();  // 2 คือ หัวหนเาแผนก
                $education      = Education::all();
                $form_repo      = new FormAddHeader;
                $form_add_emp   = $form_repo->getFormAddHeader($department,$position,$education);
                return response()->json(['status'=> 'success','data'=> $form_add_emp]);
            break;

            default:
                # code...
            break;
        }
    }

    public function editHeaderAndEmployee(Request $request)
    {  // แก้ไขตำแหน่ง
        $id_employee     = $request->get('id_employee'); // id ของหัวหน้าหรือหนักงาน
        $id_department   = $request->get('department');
        $id_position     = $request->get('position'); // 1 คือ พนักงาน // 2 คือ หัวหน้า

        $array_general_department  = [];
        $general_department = Department::where('id_department', '!=', 'hr0001')->get();
        foreach ($general_department as $value) {
            $array_general_department[] = $value['id_department'];
        }
        $humen_department   = Department::where('id_department', 'hr0001')->first();

        if($id_position == 1){ //แก้ไขต่าแหน่งเป็นพนักงาน
            $employee               = Employee::find($id_employee);
            $employee->id_position  = $id_position;
            if(in_array($employee->id_department, $array_general_department) && $id_position == "1"){ // ตรวจสอบแผนก //ตำแหน่งหนักงานแผนกทั่วไป
                $employee->id_role  = 1;
                $employee_menu      = EmployeeMenu::where('id_employee', $id_employee)->get();
                foreach ($employee_menu as $value) { // ลบ menu ทิ้ง
                    $value->delete();
                }
                for($i=1; $i<=3; $i++){ // general_employee //แล้วเพิ่มเมนูใหม่เข้าไป
                    $employee_menu                  = new EmployeeMenu();
                    $employee_menu->id_employee     = $employee->id_employee;
                    $employee_menu->id_menu         = $i;
                    $employee_menu->permission      = '["read", "write"]';
                    $employee_menu->save();
                }
            }else if(($employee->id_department == $humen_department['id_department']) && $id_position == "1"){ //ตำแหน่งพนักงานแผนก hr
                $employee->id_role = 3;
                $employee_menu      = EmployeeMenu::where('id_employee', $id_employee)->get();
                foreach ($employee_menu as $value) { // ลบ menu ทิ้ง
                    $value->delete();
                }
                for($i=1; $i<=5; $i++){
                    $employee_menu                  = new EmployeeMenu();
                    $employee_menu->id_employee     = $employee->id_employee;
                    if($i == 5){
                        $employee_menu->id_menu     = 6;
                    }else{
                        $employee_menu->id_menu     = $i;
                    }
                    $employee_menu->permission      = '["read", "write"]';
                    $employee_menu->save();
                }
            }
            $employee->save();
        }else if($id_position == 2){ //แก้ไขตำแหน่งเป็นหัวหน้า
            $verify_header   = Employee::where('id_department', $id_department)->where('id_position', 2)->get();
            $count_header    = $verify_header->count();
            if($count_header == 1){ //แสดงว่ามีหัวหน้าอยู่แล้ว ให้หัวหน้ามีได้แค่แผนกละ 1 คน
                return ['status' => 'failed'];
            }else{ // ยังไม่มีหัวหน้าที่แผนก
                $employee               = Employee::find($id_employee);
                $employee->id_position  = $id_position;
                if(in_array($employee->id_department, $array_general_department) && $id_position == "2"){ // ตรวจสอบแผนก //ตำแหน่งหนักงานแผนกทั่วไป
                    $employee->id_role  = 2;
                    $employee_menu      = EmployeeMenu::where('id_employee', $id_employee)->get();
                    foreach ($employee_menu as $value) { // ลบ menu ทิ้ง
                        $value->delete();
                    }
                    for($i=1; $i<=6; $i++){ // header_employee //แล้วเพิ่มเมนูใหม่เข้าไป
                        $employee_menu                  = new EmployeeMenu();
                        $employee_menu->id_employee     = $employee->id_employee;
                        $employee_menu->id_menu         = $i;
                        $employee_menu->permission      = '["read", "write"]';
                        $employee_menu->save();
                    }
                }else if(($employee->id_department == $humen_department['id_department']) && $id_position == "2"){ //ตำแหน่งหัวหน้าแผนก hr
                    $employee->id_role  = 4;
                    $employee_menu      = EmployeeMenu::where('id_employee', $id_employee)->get();
                    foreach ($employee_menu as $value) { // ลบ menu ทิ้ง
                        $value->delete();
                    }
                    for($i=1; $i<=6; $i++){ // header_employee //แล้วเพิ่มเมนูใหม่เข้าไป
                        $employee_menu                  = new EmployeeMenu();
                        $employee_menu->id_employee     = $employee->id_employee;
                        $employee_menu->id_menu         = $i;
                        $employee_menu->permission      = '["read", "write"]';
                        $employee_menu->save();
                    }
                }
                $employee->save();
            }
        }
    }
    public function addHeader(Request $request)  // เพิ่มหัวหน้า
    {
        $id_department           = $request->get('department');
        $id_position             = $request->get('position');
        $first_name              = $request->get('fname');
        $last_name               = $request->get('lname');
        $email                   = $request->get('email');
        $password                = $request->get('password');
        $address                 = $request->get('address');
        $gender                  = $request->get('gender');
        $tel                     = $request->get('tel');
        $age                     = $request->get('age');
        $education               = $request->get('education');
        $salary                  = $request->get('salary');

        $check_email             = Employee::all();
        $error = [];
        foreach ($check_email as $value) {
            $error[] = $value->email;
        }

        if(in_array($email, $error)){ // check email ว่าซ้ำไหม
            $error_email =   ["email" => "email ของคุณซ้ำกรุณากรอกemailใหม่"];
            return json_encode(['status' => 'failed', 'message' => $error_email]);
        }

        $verify_header   = Employee::where('id_department', $id_department)->where('id_position', 2)->get();
        $count_header    = $verify_header->count();
        //sd($count_header);
        if($count_header == 1){ //แสดงว่ามีหัวหน้าอยู่แล้ว ให้หัวหน้ามีได้แค่แผนกละ 1 คน
           $error_department =   ["add-header-department" => "ไม่สามารถเพิ่มหัวหน้าแผนกนี้ได้เนื่องจากแผนกนี้มีหัวหน้าอยู่แล้ว"];
            return json_encode(['status' => 'failed_add', 'message' => $error_department]);
        }

        // save data to database
        $employee                = new Employee();
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

        $array_general_department  = [];
        $general_department = Department::where('id_department', '!=', 'hr0001')->get();
        foreach ($general_department as $value) {
            $array_general_department[] = $value['id_department'];
        }
        $humen_department   = Department::where('id_department', 'hr0001')->first();

        if(in_array($employee->id_department, $array_general_department) && $employee->id_position == "2"){
            $employee->id_role = 2; // header_general
        }else if(($employee->id_department == $humen_department['id_department']) && $employee->id_position == "2"){
            $employee->id_role = 4; // header_hr
        }
        $employee->save();

        $find_email  = Employee::where('email', $email)->first();
        // header_employee // header_general
        for($i=1; $i<=6; $i++){
            $employee_menu                  = new EmployeeMenu();
            $employee_menu->id_employee     = $find_email->id_employee;
            $employee_menu->id_menu         = $i;
            $employee_menu->permission      = '["read", "write"]';
            $employee_menu->save();
        }
        return json_encode(['status' => 'success', 'message' => 'success']);
    }


    public function add_department(Request $request)
    {
        $get_id_department      = $request->get('id_department');
        $get_name_department    = $request->get('name_department');
        //sd($get_name_department);

        if (!empty($get_id_department) && !empty($get_name_department))  {
            $check_department_id        = Department::where('id_department', $get_id_department)->first();
            $check_department_name      = Department::where('name', $get_name_department)->first();

            if (!empty($check_department_id) || !empty($check_department_name)) {
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

    public function confirmDeleteEmployee(Request $request) // ยืนยันการลบหนักงานคนนี้
    {
        if(\Session::has('current_admin')){
            $current_admin = \Session::get('current_admin');
        }
        $id                          = $request->get('id');
        $find_id_recovery            = RecoveryStatusEmployee::where('id', $id)->first();
        $find_id_recovery->id_status = 1;
        $find_id_recovery->id_admin  = $current_admin['id_admin'];
        $find_id_recovery->save();

        $find_id     = Employee::with('evaluation_hasmany', 'evaluation_hasmany.resultevaluation', 'employeemenu', 'requestchangedata', 'timestamp', 'requesttimestamp', 'leaves')
        ->where('id_employee', $find_id_recovery->id_employee)
        ->first();

        $count_leaves  = $find_id->leaves->count(); // นับจำนวนการลาของ id ที่โดนลบ
        if($count_leaves > 0){
            for($i=0; $i<$count_leaves; $i++){
                $get_id_leaves = Leaves::where('id_employee', $find_id_recovery->id_employee)->first();
                $get_id_leaves->delete();
            }
        }

        $count_req_time  = $find_id->requesttimestamp->count(); // นับจำนวนการขอลงเวลาย้อนหลังของ id ที่โดนลบ
        if($count_req_time > 0){
            for($i=0; $i<$count_req_time; $i++){
                $get_id_req_time = Requesttimestamp::where('id_employee', $find_id_recovery->id_employee)
                                    ->first();
                $get_id_req_time->delete();
            }
        }

        $count_timestamp  = $find_id->timestamp->count(); // นับจำนวนการลงเวลาทำงานของ id ที่โดนลบ
        if($count_timestamp > 0){
            for($i=0; $i<$count_timestamp; $i++){
                $get_id_timestamp = Timestamp::where('id_employee', $find_id_recovery->id_employee)
                                    ->first();
                $get_id_timestamp->delete();
            }
        }

        $count_req_cha_data  = $find_id->requestchangedata->count(); // นับจำนวนการขอการแก้ไขข้อมูลของ id ที่โดนลบ
        if($count_req_cha_data > 0){
            for($i=0; $i<$count_req_cha_data; $i++){
                $get_id_req_cha_data = RequestChangeData::where('id_employee', $find_id_recovery->id_employee)
                                    ->first();
                $get_id_req_cha_data->delete();
            }
        }


        $count_emp_menu  = $find_id->employeemenu->count(); // นับจำนวนเมนูของ id ที่โดนลบ
        if($count_emp_menu > 0){
            for($i=0; $i<$count_emp_menu; $i++){
                $get_id_emp_menu = EmployeeMenu::where('id_employee', $find_id_recovery->id_employee)
                                    ->first();
                $get_id_emp_menu->delete();
            }
        }

        $count_evaluation        = $find_id->evaluation_hasmany->count(); // นับจำนวนการประเมินของ id ที่โดนลบ
        if($count_evaluation > 0){
            $get_id_evaluation       = []; //ตัวแปรที่เอาไว้เก็บ id ของ evaluation
            $id_result_eva           = []; //ตัวแปรที่เอาไว้เก็บ ข้อมูลทั้งหมด ของ result_evaluation
            $count_id_result_eva     = []; // นับว่า $id_result_eva มีข้อมูลกี่ตัว
            for($i=0; $i<$count_evaluation; $i++){
                $get_id_evaluation[$i] = $find_id->evaluation_hasmany[$i]->id_evaluation; //หา id ของ evaluation ของ รก ที่โดนลบ
                $id_result_eva[$i]  = ResultEvaluation::where('id_evaluation', $get_id_evaluation[$i])->get();
                $count_id_result_eva[$i] = $id_result_eva[$i]->count();
                for($j=0; $j<$count_id_result_eva[$i]; $j++){
                    $get_id_result_eva   = ResultEvaluation::where('id_evaluation', $get_id_evaluation[$i])->first();
                    $get_id_result_eva->delete(); // ลบใน result_evaluation
                }
                $id_evaluation = Evaluation::where('id_evaluation', $get_id_evaluation[$i])->first();
                $id_evaluation->delete();
            }
        }
        $find_id->delete(); // ลบใน table employee
    }

    public function cancelDeleteEmployee(Request $request) //ยกเลิกการลบพนักงานคนนี้
    {
        if(\Session::has('current_admin')){
            $current_admin = \Session::get('current_admin');
        }
        $id                          = $request->get('id');
        $find_id_recovery            = RecoveryStatusEmployee::where('id', $id)->first();
        $find_id_recovery->id_status = 3;
        $find_id_recovery->id_admin  = $current_admin['id_admin'];
        $find_id_recovery->save();
        $find_id_employee            = Employee::where('id_employee', $find_id_recovery['id_employee'])->first();
        $find_id_employee->id_status = 1;
        $find_id_employee->save();
    }
}