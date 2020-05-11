<?php
namespace App\Services\Forms;

use App\Services\Employee\EmployeeObject;

class FormCheckCountEvaluationEmployee
{
	public static function getFormCheckCountEvaluationEmployee($department, $employee, $count_by_department){
        $count_department = $department->count();
        $form ='';
        for($i=0; $i<$count_department; $i++){
            $form .= '<div class="col-md-4 col-sm-2">';
                $form .= '<div class="box box-warning" style="border-radius: 5px;">';
                    $form .= '<div class="box-header with-border">';
                        $form .= '<h3 class="box-title">แผนก '.$department[$i]->name.'</h3>';
                        $form .= '<div class="box-tools pull-right">';
                            $form .= '<button type="button" class="btn btn-box-tool" data-widget="collapse">';
                                $form .= '<i class="fa fa-minus"></i>';
                            $form .= '</button>';
                        $form .= '</div>';
                    $form .= '</div>';
                    $form .= '<div class="box-body">';
                        $form .= '<div class="col-md-12">';
                            $form .= '<div class="col-xs-6" style="border-right: inset; text-align: center;">';
                                $form .= '<span class="glyphicon glyphicon-user" style="font-size: 30px;"></span>';
                                    $count_employee = $employee[$i]->count();
                                    $form .= '<p>ทั้งหมด '.$count_employee.' คน</p>';
                            $form .= '</div>';
                            $form .= '<div class="col-xs-6" style="text-align: center;">';
                                $form .= '<span class="glyphicon glyphicon-check" style="font-size: 30px; color: green;"></span>';
                                    $form .= '<p>สำเร็จ '.(isset($count_by_department[$i]) ?  $count_by_department[$i] : "0" ).' คน</p>';
                                 $form .= '</div>';
                            $form .= '</div>';
                        $form .= '</div>';
                        $form .= '<div class="box-footer no-padding">';
                             $form .= '<ul class="nav nav-stacked send_message" >';
                                 $form .= '<li class="">';
                                     $form .= '<a href="#" style="margin: 5px border: 1px; color : #F76608;"  data-id_department="'.$department[$i]->id_department.'" class="form_email">';
                                        $form .= '<center>';
                                             $form .= '<span class="glyphicon glyphicon-send"></span> แจ้งข้อผิดพลาด';
                                        $form .= '</center>';
                                    $form .= '</a>';
                                $form .= '</li>';
                            $form .= '</ul>';
                        $form .= '</div>';
                    $form .= '</div>';
                $form .= '</div>';
            $form .= '</div>';
        }
        return ['form' => $form];
    }
}