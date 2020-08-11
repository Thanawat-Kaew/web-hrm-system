<?php
namespace App\Services\Forms;

use App\Services\Employee\EmployeeObject;
class FormDataVisualization
{
	public static function getFormDataVisualization($department,$list_employee,$list_topic_eval){
		
		$form ='<div class="row">';
			$form .='<div class="col-md-12">';
				// $form .='<div class="box box-danger">';
				// 	$form .='<div class="box-body">';
						$form .='<div class="box-body table-responsive no-padding">';
							$form .='<label>เลือกรูปแบบ</label>';
							$form .='<div class="form-group">';
								$form .='<div class="col-md-9">';
									$form .='<label class="group-display">';
										$form .='<input type="radio" name="format_visualization" id="one_person" value="1" class="flat-red one_person"> รายบุคคล';
									$form .='</label>&nbsp&nbsp';
									$form .='<label class="text-error" id="one_person-text-error">';
									$form .='</label>';
									// $form .='<label class="group-display">';
									// 	$form .='<input type="radio" name="format_visualization" id="one_department" value="2" class="flat-red one_department"> รายแผนก';
									// $form .='</label>&nbsp&nbsp';
									// $form .='<label class="text-error" id="one_department-text-error">';
									// $form .='</label>';
									$form .='<label class="group-display">';
										$form .='<input type="radio" name="format_visualization" id="one_company" value="3" class="flat-red one_company"> รายบริษัท';
									$form .='</label>&nbsp&nbsp';
									$form .='<label class="text-error" id="one_company-text-error">';
									$form .='</label>';
								$form .='</div><br>';
							$form .='</div>';
							$form .='<div class="one_person hide select_dept">';
								$form .='<label>กรุณาเลือกแผนก</label>';
								$form .='<div class="form-group">';
									$form .='<div class="col-md-8">';
										$form .='<select class="form-control select2 select2-hidden-accessible choice_department report_department" style="width: 100%;border-radius: 5px;" data-select2-id="9" tabindex="-1" aria-hidden="true" id="report_department">';
											$form .='<option value="">เลือกแผนก...</option>';
											foreach($department as $departments){
											$form .='<option value="'.$departments["id_department"].'">'.$departments["name"].'</option>';
											}
										$form .='</select>';
										$form .='<label class="text-error" id="report_department-text-error">';
										$form .='</label>';
									$form .='</div>';
									$form .='<div class="col-md-4">';
										$form .='<div class="form-group">';
											$form .='<div class="form-group" data-select2-id="13">';
												$form .='<select class="form-control select2 select2-hidden-accessible list_name_employee" style="width: 100%;border-radius: 5px;" data-select2-id="9" tabindex="-1" aria-hidden="true" id="list_name_employee">';
											$form .='<option value="">เลือกแผนกก่อน...</option>';

												foreach ($list_employee as $list_employees) {
													$form .='<option value="'.$list_employees->id_employee.'">เลือกรายชื่อพนักงาน...</option>';
												}
												$form .='</select>';
										$form .='<label class="text-error" id="list_name_employee-text-error">';
											$form .='</div>';
										$form .='</div>';
									$form .='</div>';
								$form .='</div>';
							$form .='</div>';
							// $form .='<div class="one_department hide">';
							// 	$form .='<label>กรุณาเลือกแผนก</label>';
							// 	$form .='<div class="form-group">';
							// 		$form .='<div class="col-md-9">';
							// 			$form .='<select class="form-control select2 select2-hidden-accessible choice_department report_department1" style="width: 100%;border-radius: 5px;" data-select2-id="9" tabindex="-1" aria-hidden="true" id="report_department1">';
							// 				$form .='<option value="">เลือกแผนก...</option>';
							// 				foreach($department as $departments){
							// 				$form .='<option value="'.$departments["id_department"].'">'.$departments["name"].'</option>';
							// 				} 
							// 			$form .='</select>';
							// 			$form .='<label class="text-error" id="report_department1-text-error">';
							// 			$form .='</label>';
							// 		$form .='</div>';
							// 		$form .='<div class="col-md-3">';
							// 			$form .='<div class="form-group">';
							// 				$form .='<div class="form-group" data-select2-id="13">';
							// 					$form .='<select class="form-control list_topic_evals select2 select2-hidden-accessible" style="width: 100%;border-radius: 5px;" data-select2-id="9" tabindex="-1" aria-hidden="true" id="list_topic_evals">';
							// 				$form .='<option value="">เลือกหัวข้อแบบประเมิน...</option>';

							// 					foreach ($list_topic_eval as $list_topic_evals) {
							// 						$form .='<option value="'.$list_topic_evals->id_topic.'">'.$list_topic_evals->topic_name.'</option>';
							// 					}
							// 					$form .='</select>';
							// 			$form .='<label class="text-error" id="list_topic_evals-text-error">';
							// 				$form .='</div>';
							// 			$form .='</div>';
							// 		$form .='</div>';
							// 	$form .='</div>';
							// $form .='</div>';
							$form .='<div class="one_company hide">';
								// $form .='<label>กรุณาเลือกหัวข้อแบบประเมิน</label>';

								$form .='<div class="form-group">';
									$form .='<div class="col-md-9">';
								$form .='<h3>กรุณาเลือกหัวข้อแบบประเมิน</h3>';

										$form .='<div class="form-group">';
											$form .='<div class="form-group" data-select2-id="13">';
												$form .='<select class="form-control list_topic_evals2 select2 select2-hidden-accessible" style="width: 100%;border-radius: 5px;" data-select2-id="9" tabindex="-1" aria-hidden="true" id="list_topic_evals2">';
											$form .='<option value="">เลือกหัวข้อแบบประเมิน...</option>';

												foreach ($list_topic_eval as $list_topic_evals) {
													$form .='<option value="'.$list_topic_evals->id_topic.'">'.$list_topic_evals->topic_name.'</option>';
												}
												$form .='</select>';
										$form .='<label class="text-error" id="list_topic_evals2-text-error">';
											$form .='</div>';
										$form .='</div>';
									$form .='</div>';
								$form .='</div>';
							$form .='</div>';
						$form .='</div>';


				// 	$form .='</div>';
				// $form .='</div>';
			$form .='</div>';
		$form .='</div>';

		return $form;
	}
}