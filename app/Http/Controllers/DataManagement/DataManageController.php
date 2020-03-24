<?php

namespace App\Http\Controllers\DataManagement;

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
use App\Services\Employee\StatusEmployee;
use App\Services\Admin\RecoveryStatusEmployee;
use App\Services\Employee\EmployeeObject;

class DataManageController extends Controller
{
	public function index()
	{
        $department      = Department::all();
        if(\Session::has('current_employee')){
            $current_employee = \Session::get('current_employee');
            $header     = Employee::with('department')->where('id_department', $current_employee['id_department'])->where('id_status', 1)->get();
            $employee     = Employee::with('department')->where('id_department', $current_employee['id_department'])->where('id_status', 1)->get();
        }
        return $this->useTemplate('data_management.index', compact('department', 'employee'));
    }

    public function ajaxCenter(Request $request)
    {
    	$method = $request->get('method');
        switch ($method) {
            case 'getFormAddEmployee':

                $department     = Department::all();
                //sd($current_employee['id_employee']);
                $position       = Position::where('id_position', 1)->first();
                //sd($position->id_position);
                $education      = Education::all();
                //sd($education->toArray());
                $form_repo      = new FormEmployee;
                $form_add_emp   = $form_repo->getFormEmployee($department,$position,$education);
                return response()->json(['status'=> 'success','data'=> $form_add_emp]);
            break;
            case 'getFormEmployeeWithDepartment':
                    $department = $request->get('department');
                    //sd($department); // en0001
                    $employee   = Employee::where('id_department', $department)->get();
                    $form_repo      = new FormChangeDepartment;
                    $get_form_emp   = $form_repo->getFormChangeDepartment($employee);
                    return response()->json(['status'=> 'success','data'=> $get_form_emp]);
            break;

            case 'getManageData':
                $employee_id           = $request->get('employee_id');
                $get_data_employee = Employee::with('position', 'department')->where('id_employee', $employee_id)->first();
                $form_repo          = new FormManageData;
                $form_manage_data   = $form_repo->getManageData($get_data_employee);
                return response()->json(['status'=> 'success','data'=> $form_manage_data]);
                break;

            case 'getFormEditEmployee':
                $id             = $request->get('id');
                $employee    = Employee::with('department')->with('position')->with('education')->where('id_employee', $id)->first();
                //sd($id);
                //sd($employee->position['name']);
                //sd($employee->toArray());
                $department     = Department::all();
                //$position       = Position::all();
                $position       = Position::where('id_position', $employee['id_position'])->first();
                //sd($position->name);
                $education       = Education::all();
                $form_repo      = new FormEmployee;
                $form_edit_emp   = $form_repo->getFormEmployee($department,$position, $education, $employee);
                return response()->json(['status'=> 'success','data'=> $form_edit_emp]);
            break;

            case 'getFormAmendmentEmployee':
                $form_repo      = new FormRepository;
                $form_amendment_emp   = $form_repo->getFormEmployee();
                return response()->json(['status'=> 'success','data'=> $form_amendment_emp]);
            break;

            case 'getDataPersonal':
                $id             = $request->get('id');
                $employee       = Employee::with('department')->with('position')->with('education')->where('id_employee', $id)->first();
                $form_repo      = new FormDataPersonal;
                $form_view_emp   = $form_repo->getDataPersonal( $employee);
                return response()->json(['status'=> 'success','data'=> $form_view_emp]);
            break;

            case 'getViewDataRequest': // ดูข้อมูลที่ร้องข้อการแก้ไข
                $id             = $request->get('id');
                $employee       = RequestChangeData::with('employee')->where('id', $id)->first();
                //sd($employee->toArray());
                $emp_department    = Department::where('id_department', $employee['id_department'])->first();
                $emp_position      = Position::where('id_position', $employee['id_position'])->first();
                $emp_education     = Education::where('id_education', $employee['id_education'])->first();
                $form_repo      = new FormViewDataRequest;
                $form_view_date_request   = $form_repo->getViewDataRequest($employee, $emp_department, $emp_position, $emp_education);
                return response()->json(['status'=> 'success','data'=> $form_view_date_request]);
            break;

            default:
                # code...
            break;
        }
    }

    public function addEmployee(Request $request)
    {
        // get value from ajax function saveAddEmployee(oldValue)
        $images                  = $request->file("file_picture");
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

        if(in_array($email, $error)){
            $error_email =   ["email" => "email ของคุณซ้ำกรุณากรอกemailใหม่"];
            return json_encode(['status' => 'failed', 'message' => $error_email]);
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

        if(in_array($employee->id_department, $array_general_department) && $employee->id_position == "1"){
            $employee->id_role = 1; // general_employee
        }else if(in_array($employee->id_department, $array_general_department) && $employee->id_position == "2"){
            $employee->id_role = 2; // header_general
        }else if(($employee->id_department == $humen_department['id_department']) && $employee->id_position == "1"){
            $employee->id_role = 3; // hr_employee
        }else if(($employee->id_department == $humen_department['id_department']) && $employee->id_position == "2"){
            $employee->id_role = 4; // header_hr
        }
        $employee->save();

        $find_email  = Employee::where('email', $email)->first();
        //sd($find_email->toArray());
        if($find_email->id_role == 1){ // general_employee
            for($i=1; $i<=3; $i++){
                $employee_menu                  = new EmployeeMenu();
                $employee_menu->id_employee     = $find_email->id_employee;
                $employee_menu->id_menu         = $i;
                $employee_menu->permission      = '["read", "write"]';
                $employee_menu->save();
            }
        }else if($find_email->id_role == 3){ // humen_employee
            for($i=1; $i<=5; $i++){
                $employee_menu                  = new EmployeeMenu();
                $employee_menu->id_employee     = $find_email->id_employee;
                if($i == 5){
                    $employee_menu->id_menu     = 6;
                }else{
                    $employee_menu->id_menu     = $i;
                }
                $employee_menu->permission      = '["read", "write"]';
                $employee_menu->save();
            }
        }else{ // header_employee // header_general
            for($i=1; $i<=6; $i++){
                $employee_menu                  = new EmployeeMenu();
                $employee_menu->id_employee     = $find_email->id_employee;
                $employee_menu->id_menu         = $i;
                $employee_menu->permission      = '["read", "write"]';
                $employee_menu->save();
            }
        }

        $find_id_employee        = Employee::where('email', $email)->first();
        $id_employee             = $find_id_employee['id_employee'];
        if($_FILES['file_picture']['name'] != ''){
            $test = explode('.', $_FILES['file_picture']['name']);
            $extension = end($test);
            $name = $id_employee.'.'.$extension;
            $location = 'public/image/'.$name;
            move_uploaded_file($_FILES['file_picture']['tmp_name'], $location);
        }
        $find_id_employee->image = $name;
        $find_id_employee->save();
        return json_encode(['status' => 'success', 'message' => 'success']);
    }

    public function notificationRequest()
    {
        $request = RequestChangeData::orderBy('id', 'desc')->get();
        //sd($request->toArray());
        return $this->useTemplate('data_management.notification_request', compact('request'));

    }


    public function confirmDataRequest(Request $request)
    {
        if(\Session::has('current_employee')){
            $current_employee = \Session::get('current_employee');
        }
        $id          = $request->get('id');
        //sd($id);
        $confirm = RequestChangeData::find($id);
        //d($confirm->toArray());
        $confirm->status                 = 1;
        $confirm->approvers              = $current_employee['id_employee'];
        $confirm->save();
    }

    public function cancelDataRequest(Request $request)
    {
        if(\Session::has('current_employee')){
            $current_employee = \Session::get('current_employee');
        }
        $id              = $request->get('id');
        $reason_reject   = $request->get('reason_reject');
        //sd($id);
        $confirm = RequestChangeData::find($id);
        //d($confirm->toArray());
        $confirm->status               = 3;
        $confirm->approvers            = $current_employee['id_employee'];
        $confirm->reason_approvers     = $reason_reject;
        $confirm->save();
    }

    public function editEmployee(Request $request)
    {
        $images                     = $request->file("file_picture");
        $id_employee                = $request->get('id_employee');
        //sd($id_employee);
        $id_department              = $request->get('department');
        $id_position                = $request->get('position');
        $first_name                 = $request->get('fname');
        $last_name                  = $request->get('lname');
        $email                      = $request->get('email');
        $password                   = $request->get('password');
        $address                    = $request->get('address');
        $gender                     = $request->get('gender');
        $tel                        = $request->get('tel');
        $age                        = $request->get('age');
        $education                  = $request->get('education');
        $salary                     = $request->get('salary');

        // save data to database
        $employee                   = Employee::find($id_employee);
        //sd($employee->id_employee);
        $employee->id_department    = $id_department;
        $employee->id_position      = $id_position ;
        $employee->first_name       = $first_name;
        $employee->last_name        = $last_name;
        $employee->email            = $email;
        $employee->password         = $password;
        $employee->address          = $address;
        $employee->gender           = $gender;
        $employee->tel              = $tel;
        $employee->age              = $age;
        $employee->id_education     = $education;
        $employee->salary           = $salary;

        if($_FILES['file_picture']['name'] != ''){  // ตรวจสอบไฟล์รูปภาพ
            $test = explode('.', $_FILES['file_picture']['name']); //แยกชื่อ
            $extension = end($test); // นามสกุลไฟล์
            $name = $employee->id_employee.'.'.$extension;
            $location = 'public/image/'.$name;
            move_uploaded_file($_FILES['file_picture']['tmp_name'], $location);
        }
        $employee->image            = $name;

        $array_general_department  = [];
        $general_department = Department::where('id_department', '!=', 'hr0001')->get();
        foreach ($general_department as $value) {
            $array_general_department[] = $value['id_department'];
        }
        $humen_department   = Department::where('id_department', 'hr0001')->first();

        if(in_array($employee->id_department, $array_general_department) && $employee->id_position == "1"){
            $employee->id_role = 1; // general_employee
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
        }else if(in_array($employee->id_department, $array_general_department) && $employee->id_position == "2"){
            $employee->id_role = 2; // header_general
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
        }else if(($employee->id_department == $humen_department['id_department']) && $employee->id_position == "1"){
            $employee->id_role = 3; // hr_employee
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
        }else if(($employee->id_department == $humen_department['id_department']) && $employee->id_position == "2"){
            $employee->id_role = 4; // header_hr
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

    public function postDeleteData($id_employee)
    {
        if(\Session::has('current_employee')){
            $current_employee = \Session::get('current_employee');
        }

        $get_data_employee = Employee::with('statusemployee')->where('id_employee', $id_employee)->first();
        //sd($get_data_employee->toArray());

        if(!empty($get_data_employee))
        {
            $get_data_employee->id_status   = 0;
            $get_data_employee->save();

            $date                                     = date('Y-m-d');
            $delete_employee                          = new RecoveryStatusEmployee;
            $delete_employee->id_employee             = $get_data_employee['id_employee'];
            $delete_employee->delete_by_id_employee   = $current_employee['id_employee'];
            $delete_employee->id_status               = 2;
            $delete_employee->date                    = $date;
            $delete_employee->save();

            return ['status' => 'success', 'message' => 'Delete complete.'];

        }
        else
        {
            return['status' => 'failed','message' =>'Not found.'];
        }
    }
}