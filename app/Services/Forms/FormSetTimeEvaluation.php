<?php
namespace App\Services\Forms;

use App\Services\Employee\EmployeeObject;
class FormSetTimeEvaluation
{
	 public static function getFormSetTimeEvaluation($id_topic, $check_set_date_evaluation){

		$form_set_time ='<div class="row">';
			$form_set_time .='<input type="hidden" name="id_topic" id="id_topic" value="'.$id_topic.'">';
			$form_set_time .='<div class="col-md-6">';
				$form_set_time .='<div class="form-group">';
					$form_set_time .='<label>เริ่มวันที่</label>';
					$form_set_time .='<div class="input-group">';
						$form_set_time .='<div class="input-group-addon">';
							$form_set_time .='<i class="fa fa-calendar"></i>';
						$form_set_time .='</div>';
						$form_set_time .='<input type="text" id="input-start_date" class="form-control datetimepicker start_date required" placeholder="เลือกวันที่..." name="start_date" value="'.(!empty($check_set_date_evaluation->start_date_evaluation) ? $check_set_date_evaluation->start_date_evaluation : '' ).'">';
					$form_set_time .='</div>';
					  $form_set_time .= '<label class="text-error" id="input-start_date-text-error">';
                $form_set_time .= '</label>';
				$form_set_time .='</div>';
			$form_set_time .='</div>';
			$form_set_time .='<div class="col-md-6">';
				$form_set_time .='<div class="form-group">';
					$form_set_time .='<label>สิ้นสุดวันที่</label>';
					$form_set_time .='<div class="input-group">';
						$form_set_time .='<div class="input-group-addon">';
							$form_set_time .='<i class="fa fa-calendar"></i>';
						$form_set_time .='</div>';
						$form_set_time .='<input type="text" id="input-end_date" class="form-control datetimepicker end_date required" placeholder="เลือกวันที่..." name="end_date" value="'.(!empty($check_set_date_evaluation->end_date_evaluation) ? $check_set_date_evaluation->end_date_evaluation : '' ).'">';
					$form_set_time .='</div>';
						  $form_set_time .= '<label class="text-error" id="input-end_date-text-error">';
                $form_set_time .= '</label>';
				$form_set_time .='</div>';
			$form_set_time .='</div>';
		$form_set_time .='</div>';

    return $form_set_time;
	}
}