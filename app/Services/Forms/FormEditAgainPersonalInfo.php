<?php
namespace App\Services\Forms;

use App\Services\Employee\EmployeeObject;
class FormEditAgainPersonalInfo
{
	 public static function getEditAgain($emp_department, $emp_position ,$employee, $position, $department, $emp_education, $education){
                $form = '<div class="row">';
            $form .= '<div class="col-md-8 col-md-offset-2" >';
                $form .= '<div class="box-body">';
                $form .= '<input type="hidden" value="'.$employee['id_employee'].'" id="id_employee">';
                $form .= '<input type="hidden" value="'.$employee['id'].'" id="id">'; // id ของ table request_change_data
                     $form .= 'ชื่อ';
                    $form .= '<div class="input-group fname_employee">';
                        $form .= '<div class="input-group-addon">';
                             $form .= '<i class="fa fa-user-secret"></i>';
                         $form .= '</div>';
                         $form .= '<input class="form-control required "  type="text" value="'.$employee["first_name"].'" id="fname">';
                     $form .= '</div>';
                     $form .= '<label class="text-error" id="fname-text-error"></label>';
                     $form .= 'นามสกุล';
                    $form .= '<div class="input-group lname_employee">';
                        $form .= '<div class="input-group-addon">';
                             $form .= '<i class="fa fa-user-secret"></i>';
                         $form .= '</div>';
                         $form .= '<input class="form-control required"  type="text" value="'.$employee["last_name"].'" id="lname">';
                     $form .= '</div>';
                     $form .= '<label class="text-error" id="lname-text-error"></label>';
                     $form .= 'ตำแหน่ง';
                    $form .= '<div class="input-group position_employee">';
                        $form .= '<div class="input-group-addon">';
                             $form .= '<i class="fa fa-briefcase"></i>';
                         $form .= '</div>';
                         $form .= '<select class="form-control required select2"  style="width: 100%;" id="position">';
                            foreach ($position as $value) {
                            $form .= '<option value="'.$value["id_position"].'" '.(($value["id_position"] == $emp_position['id_position']) ? 'selected' : '').'>'.$value["name"].'</option>';
                     }
                     $form .= '</select>';
                 $form .= '</div>';
                 $form .= '<label class="text-error" id="position-text-error"></label>';
                 $form .= 'แผนก';
                $form .= '<div class="input-group department_employee">';
                    $form .= '<div class="input-group-addon">';
                         $form .= '<i class="fa fa-sitemap"></i>';
                     $form .= '</div>';
                     $form .= '<select class="form-control required select2"  style="width: 100%;" id="department">';
                         foreach ($department as $value) {
                            $form .= '<option value="'.$value["id_department"].'" '.(($value["id_department"] == $emp_department['id_department']) ? 'selected' : '').'>'.$value["name"].'</option>';
                     }
                    $form .='</select>';
             $form .= '</div>';
             $form .= '<label class="text-error" id="department-text-error"></label>';
             $form .= 'การศึกษา';
            $form .= '<div class="input-group education_employee">';
                $form .= '<div class="input-group-addon">';
                     $form .= '<i class="fa fa-graduation-cap"></i>';
                 $form .= '</div>';
                 $form .= '<select class="form-control required select2"  style="width: 100%;" id="education">';
                     foreach ($education as $value) {
                            $form .= '<option value="'.$value["id_education"].'" '.(($value["id_education"] == $emp_education['id_education']) ? 'selected' : '').'>'.$value["name"].'</option>';
                     }
                 $form .= '</select>';
             $form .= '</div>';
             $form .= '<label class="text-error" id="education-text-error"></label>';
             $form .= 'เพศ';
            $form .= '<div class="input-group gender_employee">';
                $form .= '<div class="input-group-addon">';
                     $form .= '<i class="fa fa-venus-mars"></i>';
                 $form .= '</div>';
                  $form .= '<select class="form-control required select2" style="width: 100%;" id="gender">';
                     $form .= '<option value="หญิง" '.(($employee['gender'] == "หญิง") ? 'selected' : '').'>หญิง</option>';
                     $form .= '<option value="ชาย"'.(($employee['gender'] == "ชาย") ? 'selected' : '').'>ชาย</option>';
                 $form .= '</select>';
             $form .= '</div>';
             $form .= '<label class="text-error" id="gender-text-error"></label>';
             $form .= 'อายุ';
            $form .= '<div class="input-group old_employee">';
                $form .= '<div class="input-group-addon">';
                     $form .= '<i class="fa  fa-circle-o"></i>';
                 $form .= '</div>';
                 $form .= '<input class="form-control required"  type="number" value="'.$employee["age"].'" id="age">';
             $form .= '</div>';
             $form .= 'ที่อยู่';
            $form .= '<div class="input-group address_employee">';
                $form .= '<div class="input-group-addon">';
                     $form .= '<i class="fa fa-map-marker"></i>';
                 $form .= '</div>';
                 $form .= '<input class="form-control required"  type="text" value="'.$employee["address"].'" id="address">';
             $form .= '</div>';
             $form .= '<label class="text-error" id="address-text-error"></label>';
             $form .= 'อีเมล์';
            $form .= '<div class="input-group email_employee">';
                $form .= '<div class="input-group-addon">';
                     $form .= '<i class="fa fa-envelope"></i>';
                 $form .= '</div>';
                 $form .= '<input class="form-control required"  type="email" value="'.$employee["email"].'"  id="email">';
             $form .= '</div>';
             $form .= '<label class="text-error" id="email-text-error"></label>';
            $form .= 'เบอร์โทรศัพท์';
            $form .= '<div class="input-group tel_employee">';
                $form .= '<div class="input-group-addon">';
                     $form .= '<i class="fa  fa-phone"></i>';
                 $form .= '</div>';
                 $form .= '<input class="form-control required"  type="number" value="'.$employee["tel"].'"  id="tel">';
             $form .= '</div>';
             $form .= '<label class="text-error" id="tel-text-error"></label>';
               $form .= 'เหตุผลที่แก้ไข';
            $form .= '<div class="input-group reason">';
                $form .= '<div class="input-group-addon">';
                     $form .= '<i class="fa fa-commenting"></i>';
                 $form .= '</div>';
                 $form .= '<input class="form-control required"  type="text" value="'.$employee['reason'].'" placeholder="เหตุผล..." id="reason">';
             $form .= '</div>';
             $form .= '<label class="text-error" id="reason-text-error"></label>';
             $form .= '<br>';
         $form .= '</div>';
         $form .= '</div>';
         $form .= '</div>';
        return $form;
    }

}