<?php
namespace App\Services\Forms;

use App\Services\Employee\EmployeeObject;
class FormDataPersonal
{
	 public static function getDataPersonal($employee){
        $form = '<div class="box-body" style="text-center">';
            $form .= '<div class="text-center">';
                $form .= '<img src="/resources/assets/theme/adminlte/dist/img/user2-160x160.jpg" class="user-image img-circle" alt="User Image">';
            $form .= '</div>';
            $form .= '<div class="personal-data">';
            $form .= '<h4>รหัสพนักงาน :  '.$employee['id_employee'].' </h4>';
            $form .= '<h4>ชื่อ - สกุล :   '.$employee['first_name'].' '. $employee['last_name'].'</h4>';
            $form .= '<h4>ตำแหน่ง :    '.  $employee->position["name"].'</h4>';
            $form .= '<h4>แผนก :  '.  $employee->department['name'].'</h4>';
            if($employee['$id_position'] == 2 ){
            $form .= '<h4>อัตราเงินเดือน : '. $employee['salary'].' </h4>';
            }
            $form .= '<h4>การศึกษา :  '. $employee->education['name'].' </h4>';
            $form .= '<h4>เพศ :  '. $employee['gender'].' </h4>';
            $form .= '<h4>อายุ :  '. $employee['age'].' </h4>';
            $form .= '<h4>ที่อยู่ :  '. $employee['address'].' </h4>';
            $form .= '<h4>อีเมล์ :  '. $employee['email'].' </h4>';
            $form .= '<h4>เบอร์โทรศัพท์ : '. $employee['tel'].' </h4>';
        $form .= '</div>';
        $form .= '</div>';

    return $form;
    }

}