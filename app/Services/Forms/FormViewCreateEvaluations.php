<?php
namespace App\Services\Forms;

use App\Services\Employee\EmployeeObject;
class FormViewCreateEvaluations
{
	public static function getFormViewCreateEvaluations($view_create_evaluation){

		$form ='<h2 class="topic">รหัสแบบประเมินที่ : '.sprintf("%06d", $view_create_evaluation['id_topic']).'</h2>';
				$form .='<div class="row">';
					$form .='<div class="col-md-12">';
						$form .='<div class="panel panel-default">';
							$form .='<div class="panel-body">';
								$form .='<label>ชื่อแบบการประเมิน </label>';
								$form .='<input type="text" name="name-evaluation" class="form-control" value="'.$view_create_evaluation['topic_name'] .'" readonly>';
								$form .='<br>';
							$form .='</div>';
						$form .='</div>';
						$form .='<div class="panel panel-default">';
							$form .='<div class="panel-body">';
								$form .='<label>รูปแบบคำตอบ</label>';
								$form .='<input type="text" name="name-question" id="type-question" class="form-control" value="'.$view_create_evaluation->answerformat->answer_format_name .'" readonly>';
							$form .='</div>';
						$form .='</div>';
					$form .='</div>';
				$form .='</div>';
				$form .='<br>';
				foreach($view_create_evaluation->parts as  $value) {
				$form .='<div class="new-part">';
					$form .='<div class="panel panel-default">';
						$form .='<div class="panel-body">';
							$form .='<label>ชื่อตอน </label>';
							$form .='<input type="text" name="name-parts" class="form-control required" value="'. $value['part_name'].'" readonly >';
							$form .='<br>';
							$form .='<label>คำถาม</label>';
							foreach($value->question as $name_question ){
							$form .='<div class="control-group" style="margin-top:10px">';
								$form .='<input type="text" name="name-question" id="name-question" class="form-control" value="'.$name_question['question_name'] .'" readonly>';
							$form .='</div>';
							$form .='<div class="selected-question"></div>';
							}
							$form .='<br>';
							$form .='<label>เปอร์เซนต์คะแนน (%)</label>';
							$form .='<input type="number" name="percent" class="form-control required" value="'. $value['percent'] .'" readonly>';
						$form .='</div>';
					$form .='</div>';
				$form .='</div>';
				}
			$form .='</div>';

		return $form;
	}
}