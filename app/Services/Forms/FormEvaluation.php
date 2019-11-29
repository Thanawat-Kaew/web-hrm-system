<?php
namespace App\Services\Forms;

use App\Services\Employee\EmployeeObject;
class FormEvaluation
{
	public static function getFormEvaluation(){
        $form = '<div class="col-md-12 new-part">';
                 $form .= '<div class="panel panel-default">';
                     $form .= '<div class="panel-body">';

                         $form .= '<label>ชื่อตอน </label>';
                         $form .= '<input type="text" name="add-name" class="form-control" placeholder="ชื่อตอน..."><br>';
                         $form .= '<label>คำถาม</label>';
                         $form .= '<button class="btn btn-success pull-right add-more" style="width: 63px;" type="button"><i class="glyphicon glyphicon-plus"></i> เพิ่ม</button>';

                         $form .= '<div class="control-group input-group" style="margin-top:10px">';
                             $form .= '<input type="text" name="addmore[]" class="form-control" placeholder="คำถาม">';
                             $form .= '<div class="input-group-btn"> ';
                                 $form .= '<button class="btn btn-warning remove" type="button"><i class="glyphicon glyphicon-remove"></i> ลบ</button>';
                             $form .= '</div>';
                         $form .= '</div>';
                         $form .= '<div class="selected-question"></div>';

                         $form .= '<div class="copy hide">';
                             $form .= '<div class="control-group input-group" style="margin-top:10px">';
                                 $form .= '<input type="text" name="addmore[]" class="form-control" placeholder="คำถาม">';
                                 $form .= '<div class="input-group-btn"> ';
                                     $form .= '<button class="btn btn-warning remove" type="button"><i class="glyphicon glyphicon-remove"></i> ลบ</button>';
                                 $form .= '</div>';
                             $form .= '</div>';
                         $form .= '</div><br>';
                             $form .= '<label>เลือกรูปแบบคำตอบ</label>';
                             $form .= '<select class="form-control" style="width: 100%;">';
                                 $form .= '<option selected="selected">เลือกรูปแบบ...</option>';
                                 $form .= '<option>รูปแบบ 1</option>';
                                 $form .= '<option>รูปแบบ 2</option>';
                             $form .= '</select>';
                             $form .= '<br>';
                             $form .= '<label>เปอร์เซนต์คะแนน (%)</label>';
                             $form .= '<input type="number" name="percen" class="form-control" placeholder="30">';
                     $form .= '</div>';
                 $form .= '</div>';
             $form .= '</div>';

             return $form;
         }

}