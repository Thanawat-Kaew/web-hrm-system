<?php
namespace App\Services\Forms;

use App\Services\Employee\EmployeeObject;
class FormEvaluation
{
	public static function getFormEvaluation($id_evaluation, $part, $answer_type){
        $form = '<div class="col-md-12 new-part">';
                $form .= '<div class="panel panel-default">';
                $form .= '<div class="box-tools pull-right">';
                    $form .= '<button type="button" class="btn btn-box-tool btn-remove-part" data-widget="remove"><i class="fa fa-remove"></i></button>';
                $form .= '</div>';
                     $form .= '<div class="panel-body">';
                     $form .= '<input type="hidden" name="id_evaluation" value="'.$id_evaluation.'">';
                     $form .= '<input type="hidden" name="chapter" value="'.$part->chapter.'">';
                     $form .=  '<input type="hidden" name="total-question-'.$id_evaluation.'-'.$part->chapter.'" value="1" id="total-question-'.$id_evaluation.'-'.$part->chapter.'">';
                         $form .= '<label>ชื่อตอน </label>';
                         $form .= '<input type="text" name="name-parts-'.$id_evaluation.'-'.$part->chapter.'" class="form-control required" placeholder="ชื่อตอน...">';
                         $form .= '<label class="text-error name-parts-'.$id_evaluation.'-'.$part->chapter.'-text-error" id="name-parts-'.$id_evaluation.'-'.$part->chapter.'-text-error"></label><br>';
                         $form .= '<label>คำถาม</label>';
                         $form .= '<button class="btn btn-success pull-right add-more" style="width: 63px;" type="button"><i class="glyphicon glyphicon-plus"></i> เพิ่ม</button>';

                         $form .= '<div class="control-group input-group" style="margin-top:10px">';
                             $form .= '<input type="text" name="name-question-'.$id_evaluation.'-'.$part->chapter.'-1'.'[]" id="name-question-'.$id_evaluation.'-'.$part->chapter.'-1" class="form-control required" placeholder="คำถาม">';
                             $form .= '<div class="input-group-btn"> ';
                                 $form .= '<button class="btn btn-warning remove" type="button"><i class="glyphicon glyphicon-remove"></i> ลบ</button>';
                             $form .= '</div>';
                         $form .= '</div>';
                         $form .= '<label class="text-error name-question-'.$id_evaluation.'-'.$part->chapter.'-1'.'-text-error" id="name-question-'.$id_evaluation.'-'.$part->chapter.'-1'.'-text-error"></label>';
                         $form .= '<div class="selected-question"></div>';

                        $form .= '<br>';
                             $form .= '<label>เลือกรูปแบบคำตอบ</label>';
                             $form .= '<select class="form-control required" name="type_answer-'.$id_evaluation.'-'.$part->chapter.'" style="width: 100%;">';
                                 $form .= '<option selected="selected" value="">เลือกรูปแบบ...</option>';
                                foreach($answer_type as $answer){
                                 $form .= '<option value='.$answer->id_answer_format.'>'.$answer->answer_format_name.'</option>';
                                }
                             $form .= '</select>';
                             $form .= '<label class="text-error type_answer-'.$id_evaluation.'-'.$part->chapter.'-text-error" id="type_answer-'.$id_evaluation.'-'.$part->chapter.'-text-error"></label>';
                             $form .= '<br>';
                             $form .= '<label>เปอร์เซนต์คะแนน (%)</label>';
                             $form .= '<input type="number" name="percent-'.$id_evaluation.'-'.$part->chapter.'" class="form-control required" placeholder="30">';
                             $form .= '<label class="text-error percent-'.$id_evaluation.'-'.$part->chapter.'-text-error" id="percent-'.$id_evaluation.'-'.$part->chapter.'-text-error"></label>';
                     $form .= '</div>';
                 $form .= '</div>';
             $form .= '</div>';

             return $form;
         }

}