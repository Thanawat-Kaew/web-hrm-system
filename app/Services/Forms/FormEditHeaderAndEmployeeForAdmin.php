<?php
namespace App\Services\Forms;

use App\Services\Employee\EmployeeObject;
class FormEditHeaderAndEmployeeForAdmin
{
	public static function getFormEditHeaderAndEmployeeForAdmin($department, $position, $education, $employee){
       // sd($position->toArray());
        $form = '<div class="row">';
            $form .= '<div class="col-md-8 col-md-offset-2" >';
                $form .= '<div class="box-body">';
                $form .= '<input type="hidden" value="'.$employee['id_employee'].'" id="id_employee">';
                    $form .= '<div class="profile-picture">';
                        $form .= '<div class="form-group">';
                            $form .= '<label for="inputfilepicture">เพิ่มรูปถ่าย</label>';
                            $form .= '<input type="file" id="inputfilepicture" value="">';
                        if(!empty($employee['image'])){
                            $form .= '<br><div id="targetLayer" align="center">';
                                $form .= '<img class="image-preview" src="/public/image/'.$employee['image'].'"?t="'.'time()" class="upload-preview" style="width: 120px; height: 120px;" >';
                            $form .= '</div>';
                        }else{
                            $form .= '<br><div id="targetLayer" align="center" >No Image</div>';
                        }
                            $form .= '<br><input type="button" value="Upload image" class="upload_image">';
                        $form .= '</div>';
                     $form .= '</div>';
                    $form .= 'รหัสพนักงาน';
                    $form .= '<label class="text-error" id="text-error"></label>';
                    $form .= 'ชื่อ';
                    $form .= '<div class="input-group fname_employee">';
                        $form .= '<div class="input-group-addon">';
                             $form .= '<i class="fa fa-user-secret"></i>';
                        $form .= '</div>';
                        $form .= '<input class="form-control required " type="text" value="'.$employee["first_name"].'" readonly placeholder="สมหมาย" id="fname">';
                    $form .= '</div>';
                    $form .= '<label class="text-error" id="fname-text-error"></label>';
                    $form .= 'นามสกุล';
                    $form .= '<div class="input-group lname_employee">';
                        $form .= '<div class="input-group-addon">';
                             $form .= '<i class="fa fa-user-secret"></i>';
                         $form .= '</div>';
                         $form .= '<input class="form-control required" type="text" value="'.$employee["last_name"].'" readonly placeholder="แสนดี" id="lname">';
                    $form .= '</div>';
                    $form .= '<label class="text-error" id="lname-text-error"></label>';
                    $form .= 'ตำแหน่ง';
                    $form .= '<div class="input-group position_employee">';
                        $form .= '<div class="input-group-addon">';
                             $form .= '<i class="fa fa-briefcase"></i>';
                        $form .= '</div>';
                        $form .= '<select class="form-control required select2" style="width: 100%;" id="position">';
                            foreach($position as $value){
                                //sd($value);
                                $form .= '<option value="'.$value['id_position'].'" '.(($value['id_position'] == $employee->position['id_position']) ? 'selected' : '').'>'.$value['name'].'</option>';
                            }
                        $form .= '</select>';
                    $form .= '</div>';
                    $form .= 'แผนก';
                    $form .= '<div class="input-group department_employee">';
                        $form .= '<div class="input-group-addon">';
                            $form .= '<i class="fa fa-briefcase"></i>';
                        $form .= '</div>';
                        $form .= '<input class="form-control" type="text" value="'.$department->name.'" readonly>';
                        $form .= '<input class="form-control" type="hidden" value="'.$department->id_department.'" id="add-emp-department">';
                    $form .= '</div>';
                $form .= '<label class="text-error" id="department-text-error"></label>';
            $form .= '</div>';
        $form .= '</div>';
        return $form;
    }
}