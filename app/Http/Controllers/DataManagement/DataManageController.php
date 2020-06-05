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
use App\Services\Forms\FormDumpEmp;
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
            $header     = Employee::with('department')->where('id_department', $current_employee['id_department'])->where('id_status', 1)->where('id_position', 2)->first();
            //sd($header->toArray());
            $employee     = Employee::with('department')->where('id_department', $current_employee['id_department'])->where('id_status', 1)->get();
        }
        $department_pdf = Department::all();
        return $this->useTemplate('data_management.index', compact('department', 'employee', 'header','department_pdf'));
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
                    $employee   = Employee::where('id_department', $department)->where('id_status', 1)->get();
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

            case 'getFormEditEmployee': // แก้ไขหัวหน้าและพนักงาน หัวหน้า hr เป็นคนแก้ไข
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

            case 'getFormAmendmentEmployee': // กดแก้ไขครั้งแรก
                $form_repo      = new FormRepository;
                $form_amendment_emp   = $form_repo->getFormEmployee();
                return response()->json(['status'=> 'success','data'=> $form_amendment_emp]);
            break;

            case 'getDataPersonal':
                $id             = $request->get('id');
                $employee       = Employee::with('department')->with('position')->with('education')->where('id_employee', $id)->first();

                $date_of_birth  = $employee->date_of_birth; // วันเกิดจากฐานข้อมูล
                $str            = strtotime(date('Y-m-d')) - (strtotime($date_of_birth)); //นำมาลบกับวันที่ปัจจุบัน
                $day            = floor($str/3600/24); // แปลงเป็นวัน
                $age            = number_format($day / 365); // แปลงเป็นอายุ
                $form_repo      = new FormDataPersonal;
                $form_view_emp   = $form_repo->getDataPersonal($employee, $age);
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

            case 'getFormDumpEmp':
                $departments    = Department::all();
                $form_repo      = new FormDumpEmp;
                $form_dump_emp   = $form_repo->getFormDumpEmp($departments);
                return response()->json(['status'=> 'success','data'=> $form_dump_emp]);
            break;

            case 'uploadImage':
                /*$id                     = $request->get('id');
                sd($id);
                $images                  = $request->file("file_picture");
                if($_FILES['file_picture']['name'] != ''){
                    $test = explode('.', $_FILES['file_picture']['name']);
                    $extension = end($test);
                    $name = $id_employee.'.'.$extension;
                    $location = 'public/before_save_image/'.$name;
                    move_uploaded_file($_FILES['file_picture']['tmp_name'], $location);
                }*/

                return response()->json(['status'=> 'success','data'=> $form_dump_emp]);
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
        $date_of_birth           = $request->get('date_of_birth');
        //sd($date_of_birth);
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
        $employee->date_of_birth = $date_of_birth;
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
        $id                            = $request->get('id');

        $confirm                       = RequestChangeData::find($id);
        $confirm->status               = 1;
        $confirm->approvers            = $current_employee['id_employee'];
        $confirm->save();

        $find_employee                 = Employee::where('id_employee', $confirm['id_employee'])->first();
        $find_employee->first_name     = $confirm->first_name;
        $find_employee->last_name      = $confirm->last_name;
        $find_employee->id_department  = $confirm->id_department;
        $find_employee->id_education   = $confirm->id_education;
        $find_employee->gender         = $confirm->gender;
        $find_employee->date_of_birth  = $confirm->date_of_birth;
        $find_employee->address        = $confirm->address;
        $find_employee->email          = $confirm->email;
        $find_employee->tel            = $confirm->tel;

        if($confirm->id_department == "hr0001"){
            $find_employee->id_role    = 3;
        }else if($confirm->id_department !== "hr0001"){
            $find_employee->id_role    = 1;
        }
        $find_employee->save();

        $employee                   = Employee::where('id_employee', $find_employee->id_employee)->first();
        //d($employee->toArray());
        $array_general_department   = [];
        $general_department         = Department::where('id_department', '!=', 'hr0001')->get();
        foreach ($general_department as $value) {
            $array_general_department[] = $value['id_department'];
        }
        //d($array_general_department);
        $humen_department   = Department::where('id_department', 'hr0001')->first();
        //d($humen_department->toArray());
        if(in_array($employee->id_department, $array_general_department) && $employee->id_position == "1"){
            $employee->id_role = 1; // general_employee
            $employee_menu      = EmployeeMenu::where('id_employee', $employee->id_employee)->get();
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
            /*$employee->id_role = 2; // header_general
            $employee_menu      = EmployeeMenu::where('id_employee', $employee->id_employee)->get();
            foreach ($employee_menu as $value) { // ลบ menu ทิ้ง
                $value->delete();
            }
            for($i=1; $i<=6; $i++){ // header_employee //แล้วเพิ่มเมนูใหม่เข้าไป
                $employee_menu                  = new EmployeeMenu();
                $employee_menu->id_employee     = $employee->id_employee;
                $employee_menu->id_menu         = $i;
                $employee_menu->permission      = '["read", "write"]';
                $employee_menu->save();
            }*/
            //echo "2";
            //exit(); // เป็นกรณีที่เป็นพนักงานแต่ป้อนข้อมูลผิดเลยเป็นหัวหน้า ไม่มีทางเกิดแบบนี้
        }else if(($employee->id_department == $humen_department['id_department']) && $employee->id_position == "1"){
            $employee->id_role = 3; // hr_employee
            $employee_menu      = EmployeeMenu::where('id_employee', $employee->id_employee)->get();
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
        // ถ้า images มีการแก้ไขรูปจะมีข้อมูลมา แต่ถ้าแกไขอะไรที่ไม่ใช่รูป จะไม่มีข้อมูลมาดังนั้นจึงต้องมีการทำ !empty($images)
        $id_employee                = $request->get('id_employee');
        $id_department              = $request->get('department');
        $id_position                = $request->get('position');
        $first_name                 = $request->get('fname');
        $last_name                  = $request->get('lname');
        $email                      = $request->get('email');
        $password                   = $request->get('password');
        $address                    = $request->get('address');
        $gender                     = $request->get('gender');
        $tel                        = $request->get('tel');
        $date_of_birth              = $request->get('date_of_birth');
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
        $employee->date_of_birth    = $date_of_birth;
        $employee->id_education     = $education;
        $employee->salary           = $salary;

        if(!empty($images)){
            if($_FILES['file_picture']['name'] != ''){  // ตรวจสอบไฟล์รูปภาพ
                $test = explode('.', $_FILES['file_picture']['name']); //แยกชื่อ
                $extension = end($test); // นามสกุลไฟล์
                $name = $employee->id_employee.'.'.$extension;
                $location = 'public/image/'.$name;
                move_uploaded_file($_FILES['file_picture']['tmp_name'], $location);
            }
            $employee->image            = $name;
        }

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

    public function postDeleteData($id_employee) // หัวหน้า Hr กดลบหนักงาน
    {
        if(\Session::has('current_employee')){
            $current_employee = \Session::get('current_employee');
        }
        //sd($current_employee->toArray());
        $get_data_employee = Employee::with('statusemployee', 'department', 'position')->where('id_employee', $id_employee)->first();
        //sd($get_data_employee->toArray());

        if(!empty($get_data_employee))
        {
            $get_data_employee->id_status   = 0;
            $get_data_employee->save();

            $date                                     = date('Y-m-d');
            $delete_employee                          = new RecoveryStatusEmployee;
            $delete_employee->id_employee             = $get_data_employee['id_employee'];
            $delete_employee->first_name              = $get_data_employee['first_name'];
            $delete_employee->last_name               = $get_data_employee['last_name'];
            $delete_employee->department              = $get_data_employee->department['name'];
            $delete_employee->position                = $get_data_employee->position['name'];
            $delete_employee->delete_by_id_employee   = $current_employee['id_employee'];
            $delete_employee->delete_by_first_name    = $current_employee['first_name'];
            $delete_employee->delete_by_last_name     = $current_employee['last_name'];
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

    public function uploadImage(Request $request){
        $id_employee             = $request->get('id');
        $images                  = $request->file("file_picture");
        //$end = {"jpg", "png", "jpeg", "gif"};
       /* $allow = array("jpg", "jpeg", "gif", "png");
        $location = 'public/before_save_image/'.$id_employee.'.'.;
        sd($location);*/
        /*$m = '/public/before_save_image/91.jkjik';
        if(isset('/public/before_save_image/91.jepg')){
            echo "มี";
        }else{
            echo "ไม่มี";
        }exit();*/
        /*if(in_array($location, $allow)){
            echo "มี";
        }else{
            echo "ไม่มี";
        }
        exit();*/

        /*$dir       = '/public/before_save_image/';
        $files1 = scandir($dir);
        $files2 = scandir($dir, 1);
        print_r($files1);
        print_r($files2);
        exit();*/

        /*$dir_path  = "public/before_save_image/";
        $file_name;
        if(is_dir($dir_path)){
            //echo "มี";
            $files = opendir($dir_path);
            if($files){
                while(($file_name == readdir($files)) !== FALSE){
                    echo $file_name;
                }
            }
        }else{

        }*///exit();
        //unlink('public/before_save_image/'.$id_employee;
        /*$floder_path   = 'public/before_save_image';
        $name_image    = 'public/before_save_image/91.png';
        $files = glob($floder_path.'/*');
        if(in_array($name_image, $files)){
            echo "มี";
        }else{
            echo "ไม่มี";
        }
        sd($files);*/

        if($_FILES['file_picture']['name'] != ''){
            $test = explode('.', $_FILES['file_picture']['name']);
            $extension = end($test);
            $name = $id_employee.'.'.$extension;
            /*if(('/public/before_save_image/'.$name) != NULL){
                unlink('public/before_save_image/'.$name);
            }*/
            $floder_path   = 'public/before_save_image';
            $name_image    = 'public/before_save_image/'.$name;
            $files         = glob($floder_path.'/*');
            if(in_array($name_image, $files)){
                unlink('public/before_save_image/'.$name);
                //echo "ลบ";
            }
            $location = 'public/before_save_image/'.$name;
            move_uploaded_file($_FILES['file_picture']['tmp_name'], $location);
        }
        //unlink('public/before_save_image/91.jpg');

        return response()->json(['status'=> 'success','data'=> '<img class="image-preview" src="/public/before_save_image/'.$name.'" class="upload-preview" style="width: 50px; height: 50px;" >']);
        /*return response()->json(['status'=> 'success','data'=> '<img class="image-preview" src="'.$location.'" class="upload-preview" style="width: 50px; height: 50px;" >']);*/
    }
}

//<img src="/public/image/93.jpg" class="user-image img-circle" alt="User Image" style="width: 120px; height: 120px;">