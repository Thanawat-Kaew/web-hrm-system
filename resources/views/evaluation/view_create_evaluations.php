<!DOCTYPE html>
<html>
<head>
	<meta charset="utf-8">
	<meta http-equiv="X-UA-Compatible" content="IE=edge">
	<title>Time | Stamp</title>
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
	<link rel="stylesheet" type="text/css" href="/resources/assets/js/core/sweetalert2/sweetalert2.min.css">

	<!-- Theme style -->
	<link rel="stylesheet" href="/resources/assets/theme/adminlte/dist/css/AdminLTE.min.css">
	<!-- Google Font -->
	<link href="https://fonts.googleapis.com/css?family=Kanit:200&display=swap" rel="stylesheet">
	<link rel="stylesheet" href="/resources/assets/css/evaluation/view_create_evaluations.css">

</head>
<body>
	<div class="container">
		<section>
			<div class="col-md-8 col-md-offset-2 content-header">
				<h3>
					ดูแบบประเมิน |
					<small class="text-head-small"> View Evaluation</small>
				</h3>
			</div>
			<div class="col-md-8 col-md-offset-2 text-right">
				<h2 class="topic">รหัสแบบประเมินที่ : <?php echo sprintf("%06d", $view_create_evaluation['id_topic']) ?></h2>
			</div>
			<div class="container">
				<div class="row">
					<div class="col-md-8 col-md-offset-2">
						<div class="row">
							<div class="col-md-12">
								<div class="panel panel-default">
									<div class="panel-body">
										<label>ชื่อแบบการประเมิน </label>
										<input type="text" name="name-evaluation" class="form-control" value="<?php echo $view_create_evaluation['topic_name'] ?>" readonly>
										<br>
									</div>
								</div>
							</div>
						</div>
						<br>
						<?php foreach ($view_create_evaluation->parts as  $value) { ?>
							<div class="new-part">
								<div class="panel panel-default">
									<div class="panel-body">
										<label>ชื่อตอน </label>
										<input type="text" name="name-parts" class="form-control required" value="<?php echo $value['part_name']?>" readonly >
										<br>
										<label>คำถาม</label>
										<?php foreach($value->question as $name_question ): ?>
											<div class="control-group" style="margin-top:10px">
												<input type="text" name="name-question" id="name-question" class="form-control" value="<?php echo $name_question['question_name'] ?>" readonly>
											</div>
											<div class="selected-question"></div>
										<?php endforeach ?>
										<br>
										<label>รูปแบบคำตอบ</label>

										<input type="text" name="name-question" id="type-question" class="form-control" value="<?php echo $value->answerformat['answer_format_name'] ?>" readonly>

										<br>
										<label>เปอร์เซนต์คะแนน (%)</label>
										<input type="number" name="percent" class="form-control required" value="<?php echo $value['percent'] ?>" readonly>
									</div>
								</div>
							</div>
						<?php } ?>
						<br><br>
						<a href="<?php echo route("evaluation.index.get")?>">
							<button class="btn btn-app" id="btn-app"><i class="fa fa-reply"></i></button>
						</a>
					</div>
				</div>
			</div>
		</section>
	</div>
	<footer class="my-5 pt-5 text-muted text-center text-small">
		<p class="mb-1">Copyright © 2019 EngCom-RU. All rights reserved.</p>
		<p class="mb-1">Version 1.0.0</p>
	</footer>
</div>
<script>
	var mybutton = document.getElementById("btn-app");
	var body = document.getElementById('html, body');

	window.onscroll = function() {scrollFunction()};

	function scrollFunction() {

		if (document.body.scrollTop > 20 || document.documentElement.scrollTop > 20) {
			mybutton.style.display = "block";
		} else {
			mybutton.style.display = "none";
		}
	}
	// }
</script>
<!-- jQuery 3 -->
<script src="/resources/assets/theme/adminlte/bower_components/jquery/dist/jquery.min.js"></script>
<!-- Bootstrap 3.3.7 -->
<script src="/resources/assets/theme/adminlte/bower_components/bootstrap/dist/js/bootstrap.min.js"></script>
<!-- AdminLTE App -->
<script src="/resources/assets/theme/adminlte/dist/js/adminlte.min.js"></script>
<!-- Sweet Alert -->
<script src="/resources/assets/js/core/sweetalert2/sweetalert2.min.js"></script>
<!--Clock-->
<script src="/resources/assets/js/time_stamp/time_stamp.js"></script>

<script src="/resources/assets/js/main.js"></script>
<script src="/resources/assets/js/core/sweetalert2/sweetalert2.min.js"></script>
</body>
</html>