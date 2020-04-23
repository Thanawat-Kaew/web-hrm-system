<?php
namespace App\Services\Forms;

use App\Services\Employee\EmployeeObject;

class FormViewEvaluation
{
	public static function getFormViewEvaluation($evaluation_data, $evaluation_details){
	$form = '<section class="content">';
		$form .= '<div class="row">';
			$form .= '<div class="col-md-12">';
				$form .= '<div class="content-header">';
					$form .= '<h3>'.$evaluation_data->topic_name.'</h3>';
				$form .= '</div>';
					$count_part  = $evaluation_data->parts->count();
					//sd($count_part);
				$form .= '<div class="box box-info">';
					$count_answerdeatils = $evaluation_data->answerformat->answerdetails->count(); //นับจำนวนรูปแบบคำตอบ

					$count_answer = $evaluation_details->resultevaluation->count(); // นับจำนวนคำตอบทั้งหมด
					//sd($count_answer);
					$sum_of_question  	= 0; /*ผมรวมของแต่ละคำถาม*/
					$sum_of_part      	= 0; /*ผมรวมของแต่ละตอน*/
					$sum_of_evaluation  = 0; /*ผมรวมของทุกตอนรวมกัน*/

					for($i=0; $i < $count_part; $i++){ // i = part
						$part_no = $i+1;
						$count_question      = $evaluation_data->parts[$i]->question->count(); //นับจำนวนคำถามต่อตอน
						//sd($count_question);
						$form .= '<div class="box-header with-border">';
							$form .= '<div class="col-md-8">';
								$form .= '<h4>ส่วนที่'.$part_no.' '.$evaluation_data->parts[$i]->part_name.'</h4>';
								$form .= '<input type="hidden" name="id_part-<?php echo $i;?>" value="<?php echo $data_evaluation->parts[$i]->id_part;?>">';
							$form .= '</div>';
							$form .= '<div class="col-md-4 hidden-xs">';
								$form .= '<h4>คะแนนประเมิน / Score</h4>';
							$form .= '</div>';
							$form .= '<table class="table table-bordered table-condensed" id="type_one">';
								$form .= '<tr>';
									$form .= '<th>ข้อที่-'.$evaluation_data->parts[$i]->id_part.'</th>';
									$form .= '<th>ความเข้าใจ ,ความสามารถ'.$evaluation_data->parts[$i]->percent.'>%</th>';
									$form .= '<input type="hidden" name="percent-" value="">';
									for($ad=0; $ad<$count_answerdeatils; $ad++){ /*check จำนวนรูปแบบคำตอบ, ad = answerdetails */
										$form .= '<th>'
													.$evaluation_data->answerformat->answerdetails[$ad]->description.
													'<br>'
													.$evaluation_data->answerformat->answerdetails[$ad]->value.
												'</th>';
									}
									$form .= '<th>รวม</th>';
								$form .= '</tr>';
								for($j=0; $j < $count_question; $j++){ // j = question
									 $question_no = $j+1;
								$form .= '<input type="hidden" name="id_question-"" value="">';
								$form .= '<tr class="g-question">';
									$form .= '<td>'.$question_no.'</td>';
									$form .= '<td class="name_title">'.$evaluation_data->parts[$i]->question[$j]->question_name.'</td>';
									for($k=0; $k < $count_answerdeatils; $k++){ //k = answer_details
										$form .= '<td>';
											$form .= '<label>';
												/*$form .= '<input type="radio" name="format_answer-'.$i.'-'.$j.'"  id="" class="flat-red score" value="'.$evaluation_data->answerformat->answerdetails[$k]->value.'" ';
												if($evaluation_data->answerformat->answerdetails[$k]->value == $evaluation_details->resultevaluation[$sum_of_question]->answer){
													$form .= 'checked ';
												}
												$form .= ' disabled>';*/
												if($evaluation_data->answerformat->answerdetails[$k]->value == $evaluation_details->resultevaluation[$sum_of_question]->answer){
														$form .= '<input type="radio" name="format_answer-'.$i.'-'.$j.'"  id="" class="flat-red score" value="'.$evaluation_data->answerformat->answerdetails[$k]->value.'" ';
													if($evaluation_data->answerformat->answerdetails[$k]->value == $evaluation_details->resultevaluation[$sum_of_question]->answer){
														$form .= 'checked>';
													}
												}
											$form .= '</label>';
										$form .= '</td>';
									}
									if($evaluation_data->parts[$i]->id_part == $evaluation_details->resultevaluation[$sum_of_question]->id_part){ /*ถ้า part ตรงกัน ก็เข้าเงื่อนไขนี้*/
										$form .= '<td id="total-question-"'.$i.'-'.$j.'">'.$evaluation_details->resultevaluation[$sum_of_question]->answer.'</td>';
										$form .= '<input type="hidden" name="total-question-"" value="" class="required">';
										$sum_of_part = $sum_of_part + $evaluation_details->resultevaluation[$sum_of_question]->answer;
									}
								$sum_of_question   = $sum_of_question + 1;
								}
								$form .= '</tr>';
							$form .= '</table>';
							$form .= '<label class="pull-right">คะแนนรวม : <label id="total-part-"">'.$sum_of_part.'</label></label>';
							$form .= '<input type="hidden" name="total-part-"" value="" class="">';
						$form .= '</div>';
						$sum_of_evaluation = $sum_of_evaluation + $sum_of_part; /*เอา คะแนนขงแต่ละ part มาบวกกัน*/
						$sum_of_part = 0; /*พอจบแต่ละตอนก็ set ค่า คะแนนรวมของแต่ละตอนให้เริ่มที่0*/
					} /*End of loop i*/
					$form .= '<div class="box-header">';
						$form .= '<label class="pull-right grand_total">คะแนนรวมทั้งหมด : <label id="total-evluation">'.$sum_of_evaluation.'</label> </label>';
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