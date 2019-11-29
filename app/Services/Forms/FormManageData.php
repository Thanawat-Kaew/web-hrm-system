<?php
namespace App\Services\Forms;

use App\Services\Employee\EmployeeObject;
class FormManageData
{

    public static function getManageData($get_data_employee){
        if(!empty($get_data_employee)){
            $department_employee    = $get_data_employee->department->id_department;
            $position_employee      = $get_data_employee->position->id_position;

            $current_employee       = new EmployeeObject;
            $current_position       = $current_employee->getIdPosition();
            $current_department     = $current_employee->getIdDepartment();

                $form = '<div class="view-menu" style="padding:0 15%; text-align: center; font-size : 18px;">';
                    $form .= '<div class="form-group">';
                        $form .= '<button class="btn btn-block btn-info btn-outline-primary view_data" href="#">';
                            $form .= '<center>';
                                $form .= '<i class="fa fa-search"></i> ดูข้อมูลส่วนตัว';
                            $form .= '</center>';
                        $form .= '</button>';

                        if($current_department == 'hr0001' &&  ($position_employee == $current_position || $current_position == 2) ){
                            $form .= '<button class="btn btn-block btn-warning btn-outline-success edit_data" href="#">';
                                $form .= '<center>';
                                    $form .= '<i class="fa fa-cog"></i> แก้ไขข้อมูล';
                                $form .= '</center>';
                            $form .= '</button>';
                        }

                        if($current_department == 'hr0001' &&  $current_position == 2){
                            $form .= '<button class="btn btn-block btn-danger btn-outline-success  delete_data" href="#" data-href="'.route('data_manage.delete_employee.post',$get_data_employee['id_employee']).'" >';
                                $form .= '<center>';
                                    $form .= '<i class="fa fa-trash-o"></i> ลบข้อมูล';
                                $form .= '</center>';
                            $form .= '</button>';
                        }
                $form .= '</div>';
            return $form;
        }
    }
}