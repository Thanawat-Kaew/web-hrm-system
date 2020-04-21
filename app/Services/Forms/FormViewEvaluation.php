<?php
namespace App\Services\Forms;

use App\Services\Employee\EmployeeObject;

class FormViewEvaluation
{
	public static function getFormViewEvaluation($detail_evaluation, $evaluation_data){
	$form = '<section class="content">';
		$form .= '<div class="row">';
			$form .= '<div class="col-md-9">';
				$form .= '<div class="content-header">';
					$form .= '<h3>'.$evaluation_data->topic_name.'</h3>';
				$form .= '</div>';
					$count_part  = $evaluation_data->parts->count();
					//sd($count_part);
				$form .= '<div class="box box-info">';
					for($i=0; $i < $count_part; $i++){ // i = part
						$part_no = $i+1;
						$count_question      = $evaluation_data->parts[$i]->question->count(); //นับจำนวนคำถามต่อตอน
						//sd($count_question);
						 $count_answerdeatils = $evaluation_data->parts[$i]->answerformat->answerdetails->count(); //นับจำนวนรูปแบบคำตอบต่อตอน
						  //sd($count_answerdeatils);
					}
					$form .= '<div class="box-header with-border">';
						$form .= '<div class="col-md-8">';
							$form .= '<h4>ส่วนที่</h4>';
							$form .= '<input type="hidden" name="id_part-<?php echo $i;?>" value="<?php echo $data_evaluation->parts[$i]->id_part;?>">';
						$form .= '</div>';
						$form .= '<div class="col-md-4 hidden-xs">';
							$form .= '<h4>คะแนนประเมิน / Score</h4>';
						$form .= '</div>';
						//if($data_evaluation->parts[$i]->id_answer_format == '1'){ <!-- กรณีเป็นรุปแบบที่1 -->
						$form .= '<table class="table table-bordered table-condensed" id="type_one">';
								$form .= '<tr>';
									$form .= '<th>ข้อที่</th>';
									$form .= '<th>ความเข้าใจ ,ความสามารถ%</th>';
									//$count_answerdeatils;
									$form .= '<input type="hidden" name="percent-" value="">';
									$form .= '<th>1</th>';
									$form .= '<th>2</th>';
									$form .= '<th>3</th>';
									$form .= '<th>4</th>';
									$form .= '<th>5</th>';
									$form .= '<th>รวม</th>';
								$form .= '</tr>';
								/*for($j=0; $j < $count_question; $j++){ // j = question
									  $question_no = $j+1;*/
								$form .= '<input type="hidden" name="id_question-"" value="">';
								$form .= '<tr class="g-question">';
									$form .= '<td></td>';
									$form .= '<td class="name_title"></td>';
									//for($k=0; $k < $count_answerdeatils; $k++){ //k = answer_details
									$form .= '<td><label><input type="radio" name="format_answer-""  id="" class="flat-red score" value="" data-group="" data-part="" data-question=""></label></td>';
									//}
									$form .= '<td id="total-question-"">0</td>';
									$form .= '<input type="hidden" name="total-question-"" value="" class="required">';

								$form .= '</tr>';
								//}
							$form .= '</table>';
						$form .= '<label class="pull-right">คะแนนรวม : <label id="total-part-"">0</label></label>';
						$form .= '<input type="hidden" name="total-part-"" value="" class="">';
					$form .= '</div>';
					//}
					$form .= '<div class="box-header">';
						$form .= '<label class="pull-right grand_total">คะแนนรวมทั้งหมด : <label id="total-evluation">0</label> </label>';
						$form .= '<input type="hidden" name="total-evluation" value="" class="">';
					$form .= '</div>';
				$form .= '</div>';
			$form .= '</div><br><br>';
		$form .= '</div>';
	$form .= '</section>';
    return $form;
	}
}

?>