<!DOCTYPE html>
<html>
<head>
	<meta charset="utf-8">
	<meta http-equiv="X-UA-Compatible" content="IE=edge">
	<title>Assessment</title>
	<!-- Tell the browser to be responsive to screen width -->
	<meta content="width=device-width, initial-scale=1, maximum-scale=1, user-scalable=no" name="viewport">
	<!-- Bootstrap 3.3.7 -->
	<link rel="stylesheet" href="/resources/assets/theme/adminlte/bower_components/bootstrap/dist/css/bootstrap.min.css">
	<!-- Font Awesome -->
	<link rel="stylesheet" href="/resources/assets/theme/adminlte/bower_components/font-awesome/css/font-awesome.min.css">
	<!-- Ionicons -->
	<link rel="stylesheet" href="/resources/assets/theme/adminlte/bower_components/Ionicons/css/ionicons.min.css">
	<!-- jvectormap -->
	<link rel="stylesheet" href="/resources/assets/theme/adminlte/bower_components/jvectormap/jquery-jvectormap.css">
	<!-- Theme style -->
	<link rel="stylesheet" href="/resources/assets/theme/adminlte/dist/css/AdminLTE.min.css">
	<!-- AdminLTE Skins. Choose a skin from the css/skins folder instead downloading all them to reduce the load. -->
	<link rel="stylesheet" href="/resources/assets/theme/adminlte/dist/css/skins/_all-skins.min.css">
	<!-- icheck -->
	<link rel="stylesheet" href="/resources/assets/theme/adminlte/plugins/iCheck/all.css">
	<!-- sweet alert -->
	<link rel="stylesheet" type="text/css" href="/resources/assets/js/core/sweetalert2/sweetalert2.min.css">
	<!-- main -->
	<link rel="stylesheet" href="/resources/assets/css/main.css">

	<!-- Google Font -->
	<link href="https://fonts.googleapis.com/css?family=Kanit:200&display=swap" rel="stylesheet">
</head>
<body class="content_assessment">
	<section class="content">
	<form action="<?php echo route('evaluation.post_edit_record_evaluation.post'); ?>" method="POST" id="save-evaluation">
	<?php echo csrf_field()?>
		<div class="row">
			<div class="col-md-3">
				<div class="content-header">
					<h3>ข้อมูล</h3>
				</div>
				<input type="hidden" name="datetime_of_evaluation" value="<?php echo $data_evaluation['years'];?>">
				<div class="text-center">
					<img src="/resources/assets/theme/adminlte/dist/img/user8-128x128.jpg" class="user-imaged img-circle" alt="User Image">
				</div>

				<div class="box-header information_detail">
					<div class="col-md-12">
						<div class="form-group">
							<h4>รหัสพนักงาน / ID Emp.</h4>
							<input type="text" class="form-control assess_id_emp input_box" readonly value="<?php echo $data_assessor_person->id_employee?>" name="id_assessor_person">
						</div>
					</div>
					<div class="col-md-12">
						<div class="form-group">
							<h4>ชื่อ-นามสกุล / Full Name.</h4>
							<input type="text" class="form-control assess_fullname input_box" readonly value="<?php echo $data_assessor_person->first_name?> <?php echo $data_assessor_person->last_name?>">
						</div>
					</div>
					<div class="col-md-12">
						<div class="form-group">
							<h4>แผนก / Dept.</h4>
							<input type="text" class="form-control assess_department input_box" readonly value="<?php echo $data_assessor_person->department->name?>">
						</div>
					</div>
					<div class="col-md-12">
						<div class="form-group">
							<h4>หน่วยงาน / Unit.</h4>
							<input type="text" class="form-control assess_organization input_box" readonly value="Bookkaza Co.,Ltd">
						</div>
					</div>
				</div>
			</div>

			<div class="col-md-9">
				<div class="content-header">
					<h3><?php echo $data_evaluation->topic_name ?></h3>
					<input type="hidden" name="id_topic" value="<?php echo $data_evaluation->id_topic;?>">
					<input type="hidden" name="get_id_topic" id="get_id_topic" value="<?php echo $data_evaluation->id_topic;?>">
					<input type="hidden" name="id_evaluation" value="<?php echo $details_evaluation->id_evaluation;?>">
				</div>
				<?php $count_part 	     = $data_evaluation->parts->count(); // นับจำนวนตอน
					  //$count_parts = $part + 1;
				?>
				<div class="box box-info">
					<?php $count_answerdeatils = $data_evaluation->answerformat->answerdetails->count(); //นับจำนวนรูปแบบคำตอบ
						//sd($count_answerdeatils);
						$count_answer = $details_evaluation->resultevaluation->count(); // นับจำนวนคำตอบทั้งหมด
						//sd($count_answer);
						$sum_of_question  	= 0; /*ผมรวมของแต่ละคำถาม*/
						$sum_of_part      	= 0; /*ผมรวมของแต่ละตอน*/
						$sum_of_evaluation  = 0; /*ผมรวมของทุกตอนรวมกัน*/
					?>
					<?php for($i=0; $i < $count_part; $i++){ // i = part
						  $part_no = $i+1;
						  $count_question      = $data_evaluation->parts[$i]->question->count(); //นับจำนวนคำถามต่อตอน
						  //sd($count_question);
					?>
					<div class="box-header with-border">
						<div class="col-md-8">
							<h4>ส่วนที่ <?php echo $part_no; ?> <?php echo $data_evaluation->parts[$i]->part_name;?></h4>
							<input type="hidden" name="id_part-<?php echo $i;?>" value="<?php echo $data_evaluation->parts[$i]->id_part;?>">
						</div>
						<div class="col-md-4 hidden-xs">
							<h4>คะแนนประเมิน / Score</h4>
						</div>
						<?php if(!empty($data_evaluation->id_answer_format)){?> <!-- กรณีเป็นมีรุปแบบคำตอบ -->
							<table class="table table-bordered table-condensed" id="type_one">
								<tr>
									<th>ข้อที่
										<input type="hidden" name="total-question" value="<?php echo $count_question;?>">
										<input type="hidden" name="count-question-<?php echo $i;?>" value="<?php echo $count_question;?>">
										<input type="hidden" name="total-part" value="<?php echo $count_part;?>">
									</th>
									<th>ความเข้าใจ ,ความสามารถ <?php echo $data_evaluation->parts[$i]->percent;?>%</th>
									<?php echo $count_answerdeatils;?>
									<input type="hidden" name="percent-<?php echo $i;?>" value="<?php echo $data_evaluation->parts[$i]->percent;?>">
									<?php for($ad=0; $ad<$count_answerdeatils; $ad++){?> <!-- check จำนวนรูปแบบคำตอบ -->
										<th><?php echo $data_evaluation->answerformat->answerdetails[$ad]->description;?><br><?php echo $data_evaluation->answerformat->answerdetails[$ad]->value;?></th>
									<?php } ?>
									<th>รวม</th>
								</tr>
								<?php for($j=0; $j < $count_question; $j++){ // j = question
									  $question_no = $j+1;
								?>
								<input type="hidden" name="id_question-<?php echo $i;?>-<?php echo $j;?>" value="<?php echo $data_evaluation->parts[$i]->question[$j]->id_question;?>">
								<tr class="g-question">
									<td><?php echo $question_no; ?></td>
									<td class="name_title"><?php echo $data_evaluation->parts[$i]->question[$j]->question_name;?></td>

									<?php for($k=0; $k < $count_answerdeatils; $k++){ //k = answer_details
									?>
									<td>
										<label>
											<input type="radio" name="format_answer-<?php echo $i;?>-<?php echo $j;?>"  id="<?php echo $data_evaluation->answerformat->answerdetails[$k]->value;?>" class="flat-red score" value="<?php echo $data_evaluation->answerformat->answerdetails[$k]->value;?>" data-group="<?php echo $i;?>-<?php echo $j;?>" data-part="<?php echo $i;?>" data-question="<?php echo $j;?>"
											<?php echo ($data_evaluation->answerformat->answerdetails[$k]->value == $details_evaluation->resultevaluation[$sum_of_question]->answer) ? "checked" : "" ?> >
										</label>
									</td>
									<?php }?>
									<?php if($data_evaluation->parts[$i]->id_part == $details_evaluation->resultevaluation[$sum_of_question]->id_part){
									?>
									<td id="total-question-<?php echo $i;?>-<?php echo $j;?>"><?php echo $details_evaluation->resultevaluation[$sum_of_question]->answer?></td>
									<input type="hidden" name="total-question-<?php echo $i;?>-<?php echo $j;?>" value="<?php echo $details_evaluation->resultevaluation[$sum_of_question]->answer?>" class="required">
									<?php
										$sum_of_part = $sum_of_part + $details_evaluation->resultevaluation[$sum_of_question]->answer;
									?>
									<?php } ?>
								<?php $sum_of_question   = $sum_of_question + 1; ?>
								</tr>
								<?php } ?>
							</table>
						<?php }?> <!-- End if check ว่ามีรูปแบบคำตอบไหม -->
						<label class="pull-right">คะแนนรวม : <label id="total-part-<?php echo $i;?>"><?php echo $sum_of_part ?></label></label>
						<input type="hidden" name="total-part-<?php echo $i;?>" value="<?php echo $sum_of_part ?>" class="">
					</div>
						<?php $sum_of_evaluation = $sum_of_evaluation + $sum_of_part; ?><!--เอา คะแนนขงแต่ละ part มาบวกกัน-->
						<?php $sum_of_part=0; ?> <!-- set ค่า คะแนนของแต่ละตอน เป็น 0 -->
					<?php } ?> <!-- End for loop i -->

					<div class="box-header">
						<label class="pull-right grand_total">คะแนนรวมทั้งหมด : <label id="total-evluation"><?php echo $sum_of_evaluation?></label> </label>
						<input type="hidden" name="total-evluation" value="<?php echo $sum_of_evaluation?>" class="">
					</div>
				</div>

				<div class="btn-group pull-right">
					<button type="button" class='btn btn-warning cancel_evaluation'> ยกเลิก
					</button>
				</div>
				<div class="btn-group pull-right btn_success_evaluation">

						<button type="button" class='btn btn-success success_evaluation'> บันทึกผล
						</button>

				</div>
		</div><br><br>
		<div class="row hidden-xs hidden-sm">
			<div class="col-md-12">
				<hr>
				<strong style="margin-left: 10px;">Copyright &copy; 2019 <a href="">EngCom-RU</a>.</strong> All rights
				reserved.
			</div>
		</div>
	</div>
</form>
</section>
<!-- jQuery 3 -->
<script src="/resources/assets/theme/adminlte/bower_components/jquery/dist/jquery.min.js"></script>
<!-- Bootstrap 3.3.7 -->
<script src="/resources/assets/theme/adminlte/bower_components/bootstrap/dist/js/bootstrap.min.js"></script>
<!-- AdminLTE App -->
<script src="/resources/assets/theme/adminlte/dist/js/adminlte.min.js"></script>
<!-- icheck -->
<script src="/resources/assets/theme/adminlte/plugins/iCheck/icheck.min.js"></script>
<script src="/resources/assets/js/evaluation/edit_assessment.js"></script>
<!-- sweet alert -->
<script src="/resources/assets/js/core/sweetalert2/sweetalert2.min.js"></script>
<!-- main function -->
<script src="/resources/assets/js/main.js"></script>

</body>
</html>
<div id="ajax-center-url" data-url="<?php echo route('evaluation.ajax_center.post')?>"></div>
<?php echo csrf_field()?>