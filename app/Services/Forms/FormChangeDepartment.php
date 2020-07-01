<?php
namespace App\Services\Forms;

use App\Services\Employee\EmployeeObject;
class FormChangeDepartment
{
	 public static function getFormChangeDepartment($employee){
      $form_head ='';
      $form_emp ='';

            foreach ($employee as $key => $value) {
               if($value['id_position'] == 2) {
                $form_head .='<div class="col-md-3 col-sm-2 ">';
                $form_head .='<div class="box box-widget widget-user-2">';
                $form_head .='<div class="widget-user-header">';
                $form_head .='<!-- /.widget-user-image -->';
                $form_head .='<div class="group-image header_image'.$value["id_employee"].'" align="center" valign="center">';
                if(!empty($value->image)){
                    $form_head .='<img src="/public/image/'.$value->image.'?t='.'time()">';
                    $form_head .='</div>';
                }else{
                    $form_head .='<img src="/resources/assets/theme/adminlte/dist/img/user8-128x128.jpg">';
                    $form_head .='</div>';
                }
                $form_head .='<div class="about-employee" id="header">';
                $form_head .='<p id="header_id">รหัส  : <span>'.$value["id_employee"].'</span></p>';
                $form_head .='<p id="header_name">ชื่อ : <span>'.$value["first_name"].' '.$value["last_name"].'</span></p>';
                $form_head .='</div>';
                $form_head .='</div>';
                $form_head .='<div class="box-footer no-padding">';
                $form_head .='<ul class="nav nav-stacked">';
                $form_head .='<li class="manage-employee" data-form_id="'.$value["id_employee"].'" data-form_position="'.$value["id_position"].'" data-form_department="'.$value["id_department"].'">';
                $form_head .='<a style="margin: 5px border: 1px; color : #F76608;">';
                $form_head .='<center>';
                $form_head .='<i class="fa fa-cog"></i> Manage Data';
                $form_head .='</center>';
                $form_head .='</a>';
                $form_head .='</li>';
                $form_head .='</ul>';
                $form_head .='</div>';
                $form_head .='</div>';
                $form_head .='</div>';
            }
        }

        foreach($employee as $key => $value) {
            //d($value->toArray());
            if($value['id_position'] == 1) {
                $form_emp .='<div class="col-md-3 col-sm-2">';
                $form_emp .='<div class="box box-widget widget-user-2">';
                $form_emp .='<div class="widget-user-header">';
                $form_emp .='<!-- /.widget-user-image -->';
                $form_emp .='<div class="group-image employee_image'.$value->id_employee.'" align="center" valign="center">';
                if(!empty($value->image)){
                    $form_emp .='<img src="/public/image/'.$value->image.'"?t="'.'time()">';
                    $form_emp .='</div>';
                }else{
                    $form_emp .='<img src="/resources/assets/theme/adminlte/dist/img/user2-160x160.jpg">';
                    $form_emp .='</div>';
                }
                $form_emp .='<div class="about-employee" id="employee">';
                $form_emp .='<p>รหัส  : <span>'.$value['id_employee'].'</span></p>';
                $form_emp .='<p>ชื่อ   : <span>'.$value['first_name']." ".$value['last_name'].'</span></p>';
                $form_emp .='</div>';
                $form_emp .='</div>';
                $form_emp .='<div class="box-footer no-padding">';
                $form_emp .='<ul class="nav nav-stacked">';
                $form_emp .='<li class="manage-employee" data-form_id="'.$value["id_employee"].'" data-form_position="'.$value["id_position"].'" data-form_department="'.$value["id_department"].'">';
                $form_emp .='<a style="margin: 5px border: 1px; color : #F76608;">';
                $form_emp .='<center>';
                $form_emp .='<i class="fa fa-cog"></i> Manage Data';
                $form_emp .='</center>';
                $form_emp .='</a>';
                $form_emp .='</li>';
                $form_emp .='</ul>';
                $form_emp .='</div>';
                $form_emp .='</div>';
                $form_emp .='</div>';
            }
        }

        return ['form_head' => $form_head, 'form_emp' => $form_emp];
    }
}