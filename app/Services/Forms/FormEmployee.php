<?php
namespace App\Services\Forms;

use App\Services\Employee\EmployeeObject;
class FormEmployee
{
	public static function getFormEmployee($department, $position, $education, $employee=''){
        //sd($employee->image);
        /*ถ้า employee ไม่ว่างก็คือการแก้ไข */
        $form = '<div class="row">';
            $form .= '<div class="col-md-8 col-md-offset-2" >';
                $form .= '<div class="box-body">';
                $form .= '<input type="hidden" value="'.((!empty($employee['id_employee']) ? $employee['id_employee'] : '')).'" id="id_employee">';
                    /*if(empty($employee)){*/
                    $form .= '<div class="profile-picture">';
                        $form .= '<div class="form-group">';
                            $form .= '<label for="inputfilepicture">เพิ่มรูปถ่าย</label>';
                             $form .= '<input type="file" name="picture" id="inputfilepicture" value="'.((!empty($employee['image']) ? $employee['image'] : '')).'" multiple="multiple">';
                         $form .= '</div>';
                     $form .= '</div>';
                    /*}*/
                     $form .= 'รหัสพนักงาน';
                    $form .= '<div class="input-group id_employee">';
                        $form .= '<div class="input-group-addon">';
                             $form .= '<i class="fa fa-key"></i>';
                         $form .= '</div>';
                         $form .= '<input class="form-control" type="text" value="" readonly placeholder="Auto Generate" id="id_employee">';
                     $form .= '</div>';
                    $form .= '<label class="text-error" id="text-error"></label>';
                     $form .= 'ชื่อ';
                    $form .= '<div class="input-group fname_employee">';
                        $form .= '<div class="input-group-addon">';
                             $form .= '<i class="fa fa-user-secret"></i>';
                         $form .= '</div>';
                         $form .= '<input class="form-control required " type="text" value="'.((!empty($employee) ? $employee["first_name"] : '' )).'" placeholder="สมหมาย" id="fname">';
                     $form .= '</div>';
                    $form .= '<label class="text-error" id="fname-text-error"></label>';
                     $form .= 'นามสกุล';
                    $form .= '<div class="input-group lname_employee">';
                        $form .= '<div class="input-group-addon">';
                             $form .= '<i class="fa fa-user-secret"></i>';
                         $form .= '</div>';
                         $form .= '<input class="form-control required" type="text" value="'.((!empty($employee) ? $employee["last_name"] : '' )).'" placeholder="แสนดี" id="lname">';
                     $form .= '</div>';
                    $form .= '<label class="text-error" id="lname-text-error"></label>';
                     $form .= 'ตำแหน่ง';
                    $form .= '<div class="input-group position_employee">';
                        $form .= '<div class="input-group-addon">';
                             $form .= '<i class="fa fa-briefcase"></i>';
                        $form .= '</div>';
                         /*$form .= '<select class="form-control required select2" style="width: 100%;" id="position">';
                            if(!empty($employee)){ //แก้ไข
                                foreach($position as $value){
                                    sd($value);
                                    $form .= '<option value="'.$employee->position['id_position'].'" '.(($value['id_position'] == $employee->position['id_position']) ? 'selected' : '').'>'.$value['name'].'</option>';
                                }
                            }else{ // เพิ่มพนักงาน
                                $form .= '<option value="">'.'เลือกตำแหน่ง...'.'</option>';
                                foreach($position as $value) {
                                    $form .= '<option value="'.$value['id_position'].'">'.$value['name'].'</option>';
                                }
                            }
                            //sd($position[0]);
                     $form .= '</select>';*/
                        $form .= '<input class="form-control" type="text" value="'.$position->name.'" readonly>';
                        $form .= '<input class="form-control" type="hidden" value="'.$position->id_position.'" id="position">';
                    $form .= '</div>';
                $form .= '<label class="text-error" id="position-text-error"></label>';
                $form .= 'แผนก';
            $form .= '<div class="input-group department_employee">';
                $form .= '<div class="input-group-addon">';
                     $form .= '<i class="fa fa-graduation-cap"></i>';
                $form .= '</div>';
                $form .= '<select class="form-control required select2" style="width: 100%;" id="add-emp-department">';
                     if(!empty($employee)){ //แก้ไข
                        foreach($department as $value){
                             $form .= '<option value="'.$value['id_department'].'" '.(($value['id_department'] == $employee->department['id_department']) ? 'selected' : '').'>'.$value['name'].'</option>';
                        }
                    }else{ // เพิ่มพนักงาน
                        $form .= '<option value="">'.'เลือกแผนก...'.'</option>';
                        foreach($department as $value) {
                            $form .= '<option value="'.$value['id_department'].'">'.$value['name'].'</option>';
                        }
                    }
                $form .= '</select>';
            $form .= '</div>';
            $form .= '<label class="text-error" id="add-emp-department-text-error"></label>';
             $form .= 'อัตราเงินเดือน';
            $form .= '<div class="input-group salary_employee">';
                $form .= '<div class="input-group-addon">';
                     $form .= '<i class="fa fa-money"></i>';
                 $form .= '</div>';
                 $form .= '<input class="form-control required" type="number" value="'.((!empty($employee) ? $employee["salary"] : '' )).'" placeholder="15,000..." id="salary">';
             $form .= '</div>';
            $form .= '<label class="text-error" id="salary-text-error"></label>';
             $form .= 'การศึกษา';
            $form .= '<div class="input-group education_employee">';
                $form .= '<div class="input-group-addon">';
                     $form .= '<i class="fa fa-graduation-cap"></i>';
                 $form .= '</div>';
                 $form .= '<select class="form-control required select2" style="width: 100%;" id="education">';
                     if(!empty($employee)){ //แก้ไข
                                foreach($education as $value){
                                    $form .= '<option value="'.$employee->education['id_education'].'" '.(($value['id_education'] == $employee->education['id_education']) ? 'selected' : '').'>'.$value['name'].'</option>';
                                }
                            }else{ // เพิ่มพนักงาน
                                $form .= '<option value="">'.'เลือกระดับการศึกษา...'.'</option>';
                                foreach($education as $value) {
                                    $form .= '<option value="'.$value['id_education'].'">'.$value['name'].'</option>';
                                }
                            }
                 $form .= '</select>';
             $form .= '</div>';
            $form .= '<label class="text-error" id="education-text-error"></label>';
             $form .= 'เพศ';
            $form .= '<div class="input-group gender_employee">';
                $form .= '<div class="input-group-addon">';
                     $form .= '<i class="fa fa-venus-mars"></i>';
                 $form .= '</div>';


                 /*$form .= '<select class="form-control required select2" style="width: 100%;" id="gender">';
                     $form .= '<option selected="selected" value="'.((!empty($employee) ? $employee['gender'] : '' )).'">'.((!empty($employee) ? $employee['gender'] : 'เลือกเพศ...' )).'</option>';
                if(!empty($employee)){ // แก้ไข
                    $form .= '<option value="หญิง">หญิง</option>';
                    $form .= '<option value="ชาย">ชาย</option>';
                }else{ // เพิ่มหนักงาน
                    $form .= '<option value="หญิง">หญิง</option>';
                    $form .= '<option value="ชาย">ชาย</option>';
                }
                 $form .= '</select>';*/


            if(!empty($employee)){ // กรณีแก้ไข
                $form .= '<select class="form-control required select2" style="width: 100%;" id="gender">';
                    $form .= '<option value="หญิง" '.(($employee['gender'] == "หญิง") ? 'selected' : '').'>หญิง</option>';
                    $form .= '<option value="ชาย"'.(($employee['gender'] == "ชาย") ? 'selected' : '').'>ชาย</option>';

                $form .= '</select>';
            }else{ // กรณีเพิ่มพนักงาน
                $form .= '<select class="form-control required select2" style="width: 100%;" id="gender">';
                    $form .= '<option selected="selected" value="">เลือกเพศ...</option>';
                    $form .= '<option value="หญิง">หญิง</option>';
                    $form .= '<option value="ชาย">ชาย</option>';
                $form .= '</select>';
            }


             $form .= '</div>';
            $form .= '<label class="text-error" id="gender-text-error"></label>';
             $form .= 'อายุ';
            $form .= '<div class="input-group old_employee">';
                $form .= '<div class="input-group-addon">';
                     $form .= '<i class="fa  fa-circle-o"></i>';
                 $form .= '</div>';
                 $form .= '<input class="form-control required" type="number" value="'.((!empty($employee) ? $employee["age"] : '' )).'" placeholder="25..." id="age">';
             $form .= '</div>';
            $form .= '<label class="text-error" id="age-text-error"></label>';
             $form .= 'ที่อยู่';
            $form .= '<div class="input-group address_employee">';
                $form .= '<div class="input-group-addon">';
                     $form .= '<i class="fa fa-map-marker"></i>';
                 $form .= '</div>';
                 $form .= '<input class="form-control required" type="text" value="'.((!empty($employee) ? $employee["address"] : '' )).'" placeholder="ยานนาวา สาทร กรุงเทพฯ" id="address">';
             $form .= '</div>';
            $form .= '<label class="text-error" id="address-text-error"></label>';
             $form .= 'อีเมล์';
            $form .= '<div class="input-group email_employee">';
                $form .= '<div class="input-group-addon">';
                     $form .= '<i class="fa fa-envelope"></i>';
                 $form .= '</div>';
                 $form .= '<input class="form-control required" type="text" value="'.((!empty($employee) ? $employee["email"] : '' )).'" placeholder="email@example.com" id="email">';
             $form .= '</div>';
            $form .= '<label class="text-error" id="email-text-error"></label>';
            $form .= 'เบอร์โทรศัพท์';
            $form .= '<div class="input-group tel_employee">';
                $form .= '<div class="input-group-addon">';
                     $form .= '<i class="fa  fa-phone"></i>';
                 $form .= '</div>';
                 $form .= '<input class="form-control required" type="number" value="'.((!empty($employee) ? $employee["tel"] : '' )).'" placeholder="023456789..." id="tel">';
             $form .= '</div>';
            $form .= '<label class="text-error" id="tel-text-error"></label>';
             $form .= 'ตั้งรหัสผ่านเข้าสู่ระบบ';
            $form .= '<div class="input-group password_employee">';
                $form .= '<div class="input-group-addon">';
                     $form .= '<i class="fa fa-lock"></i>';
                 $form .= '</div>';
                 $form .= '<input class="form-control required"  type="text" value="'.((!empty($employee) ? $employee["password"] : '' )).'" placeholder="Password..." id="password">';
             $form .= '</div>';
            $form .= '<label class="text-error" id="password-text-error"></label>';
             $form .= 'ยืนยันรหัสผ่านอีกครั้ง';
            $form .= '<div class="input-group confirm_password">';
                $form .= '<div class="input-group-addon">';
                     $form .= '<i class="fa fa-lock"></i>';
                 $form .= '</div>';
                 $form .= '<input class="form-control "  type="text" value="'.((!empty($employee) ? $employee["password"] : '' )).'" id="confirm_password" placeholder="Confirm Password...">';
             $form .= '</div><br>';
            $form .= '<label class="text-error" id="confirm_password-text-error"></label>';
         $form .= '</div>';
         $form .= '</div>';
         $form .= '</div>';
        return $form;
    }
}