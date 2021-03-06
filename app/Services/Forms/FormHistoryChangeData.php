<?php
namespace App\Services\Forms;

use App\Services\Employee\EmployeeObject;
class FormHistoryChangeData
{
	 public static function getHistoryChangeData($emp_department, $emp_position ,$employee, $emp_education){
                $form = '<div class="row">';
            $form .= '<div class="col-md-8 col-md-offset-2" >';
                $form .= '<div class="box-body">';
                $form .= '<input type="hidden" value="'.$employee['id_employee'].'" id="id_employee">';
                     $form .= 'ชื่อ';
                    $form .= '<div class="input-group fname_employee">';
                        $form .= '<div class="input-group-addon">';
                             $form .= '<i class="fa fa-user-secret"></i>';
                         $form .= '</div>';
                         $form .= '<input class="form-control required " readonly type="text" value="'.$employee["first_name"].'" id="fname">';
                     $form .= '</div>';
                     $form .= '<label class="text-error" id="fname-text-error"></label>';
                     $form .= 'นามสกุล';
                    $form .= '<div class="input-group lname_employee">';
                        $form .= '<div class="input-group-addon">';
                             $form .= '<i class="fa fa-user-secret"></i>';
                         $form .= '</div>';
                         $form .= '<input class="form-control required" readonly type="text" value="'.$employee["last_name"].'" id="lname">';
                     $form .= '</div>';
                     $form .= '<label class="text-error" id="lname-text-error"></label>';
                     $form .= 'ตำแหน่ง';
                    $form .= '<div class="input-group position_employee">';
                        $form .= '<div class="input-group-addon">';
                             $form .= '<i class="fa fa-briefcase"></i>';
                         $form .= '</div>';
                         $form .= '<input class="form-control required select2" readonly style="width: 100%;" id="position" value="'.$emp_position['name'].'">';
                 $form .= '</div>';
                 $form .= '<label class="text-error" id="position-text-error"></label>';
                 $form .= 'แผนก';
                $form .= '<div class="input-group department_employee">';
                    $form .= '<div class="input-group-addon">';
                         $form .= '<i class="fa fa-sitemap"></i>';
                     $form .= '</div>';
                     $form .= '<input class="form-control required select2" readonly style="width: 100%;" id="department" value="'.$emp_department['name'].'">';
             $form .= '</div>';
             $form .= '<label class="text-error" id="department-text-error"></label>';
             $form .= 'การศึกษา';
            $form .= '<div class="input-group education_employee">';
                $form .= '<div class="input-group-addon">';
                     $form .= '<i class="fa fa-graduation-cap"></i>';
                 $form .= '</div>';
                 $form .= '<input class="form-control required select2" readonly style="width: 100%;" id="education" value="'.$emp_education['name'].'">';
             $form .= '</div>';
             $form .= '<label class="text-error" id="education-text-error"></label>';
             $form .= 'เพศ';
            $form .= '<div class="input-group gender_employee">';
                $form .= '<div class="input-group-addon">';
                     $form .= '<i class="fa fa-venus-mars"></i>';
                 $form .= '</div>';
                 $form .= '<input class="form-control required select2" readonly style="width: 100%;" id="education" value="'.$employee['gender'].'">';
             $form .= '</div>';
             $form .= '<label class="text-error" id="gender-text-error"></label>';
             $form .= 'วัน เดือน ปี ที่เกิด';
            $form .= '<div class="input-group old_employee">';
                $form .= '<div class="input-group-addon">';
                     $form .= '<i class="fa  fa-circle-o"></i>';
                 $form .= '</div>';
                 $form .= '<input class="form-control required" readonly type="" value="'.$employee['date_of_birth'].'" id="date_of_birth">';
             $form .= '</div>';
             $form .= 'ที่อยู่';
            $form .= '<div class="input-group address_employee">';
                $form .= '<div class="input-group-addon">';
                     $form .= '<i class="fa fa-map-marker"></i>';
                 $form .= '</div>';
                 $form .= '<input class="form-control required" readonly type="text" value="'.$employee["address"].'" id="address">';
             $form .= '</div>';
             $form .= '<label class="text-error" id="address-text-error"></label>';
             $form .= 'อีเมล์';
            $form .= '<div class="input-group email_employee">';
                $form .= '<div class="input-group-addon">';
                     $form .= '<i class="fa fa-envelope"></i>';
                 $form .= '</div>';
                 $form .= '<input class="form-control required" readonly type="email" value="'.$employee["email"].'"  id="email">';
             $form .= '</div>';
             $form .= '<label class="text-error" id="email-text-error"></label>';
            $form .= 'เบอร์โทรศัพท์';
            $form .= '<div class="input-group tel_employee">';
                $form .= '<div class="input-group-addon">';
                     $form .= '<i class="fa  fa-phone"></i>';
                 $form .= '</div>';
                 $form .= '<input class="form-control required" readonly type="number" value="'.$employee["tel"].'"  id="tel">';
             $form .= '</div>';
             $form .= '<label class="text-error" id="tel-text-error"></label>';
               $form .= 'เหตุผลที่แก้ไข';
            $form .= '<div class="input-group reason">';
                $form .= '<div class="input-group-addon">';
                     $form .= '<i class="fa fa-commenting"></i>';
                 $form .= '</div>';
                 $form .= '<input class="form-control required" readonly type="text" value="'.$employee['reason'].'" placeholder="เหตุผล..." id="reason">';
             $form .= '</div>';
             $form .= '<label class="text-error" id="reason-text-error"></label>';

            if(!empty($employee['reason_approvers'])){
            $form .= 'เหตุผลที่ไม่อนุมัติ';
            $form .= '<div class="input-group reason">';
                $form .= '<div class="input-group-addon">';
                     $form .= '<i class="fa fa-commenting"></i>';
                 $form .= '</div>';
                 $form .= '<input class="form-control" readonly type="text" value="'.$employee['reason_approvers'].'" placeholder="...." id="reason">';
             $form .= '</div>';
             $form .= '<label class="text-error" id="reason_approvers-text-error"></label>';
             $form .= '<br>';

            }
         $form .= '</div>';
         $form .= '</div>';
         $form .= '</div>';
        return $form;
    }

}