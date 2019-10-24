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
		<div class="row">
			<div class="col-md-8 col-md-offset-2">
				<div class="content-header">
					<h3>แบบประเมินผลการปฏิบัติงานของพนักงาน ประจำปี 2019</h3>
				</div>
				<div class="box box-info">
					<div class="box-header">
						<div class="col-md-6">
							<div class="form-group">
								<h4>แผนก / Dept.</h4>
								<input type="text" class="form-control assess_department">
							</div>
						</div>
						<div class="col-md-6">
							<div class="form-group">
								<h4>หน่วยงาน / Unit.</h4>
								<input type="text" class="form-control assess_organization">
							</div>
						</div>
						<div class="col-md-6">
							<div class="form-group">
								<h4>ชื่อ-นามสกุล / Full Name.</h4>
								<input type="text" class="form-control assess_fullname">
							</div>
						</div>
						<div class="col-md-6">
							<div class="form-group">
								<h4>รหัสพนักงาน / ID Emp.</h4>
								<input type="text" class="form-control assess_id_emp">
							</div>
						</div>
					</div>
					<hr>

					<div class="box-header with-border">
						<div class="col-md-8">
							<h4>ส่วนที่ 1</h4>
						</div>
						<div class="col-md-4 hidden-xs">
							<h4>คะแนนประเมิน / Score</h4>
						</div>

						<table class="table table-bordered table-condensed">
							<tr>
								<th>ข้อที่</th>
								<th>ความเข้าใจ ,ความสามารถ 30%</th>
								<th>5</th>
								<th>4</th>
								<th>3</th>
								<th>2</th>
								<th>1</th>
								<th>รวม</th>
							</tr>
							<tr>
								<td>1</td>
								<td class="name_title">ความคิดริเริ่มและสามารถนาเสนอความคิดเห็นในเรื่องที่เกี่ยวข้องกับงานที่รับผิดชอบ</td>
								<td><label><input type="radio" name="ss" id="5" class="flat-red"></label></td>
								<td><label><input type="radio" name="ss" id="4" class="flat-red"></label></td>
								<td><label><input type="radio" name="ss" id="3" class="flat-red"></label></td>
								<td><label><input type="radio" name="ss" id="2" class="flat-red"></label></td>
								<td><label><input type="radio" name="ss" id="1" class="flat-red"></label></td>
								<td></td>
							</tr>
						</table>
						<label class="pull-right">คะแนนรวม : </label>
					</div>

					<div class="box-header with-border">
						<div class="col-md-8">
							<h4>ส่วนที่ 2</h4>
						</div>
						
						<table class="table table-bordered table-condensed">
							<tr>
								<th>ข้อที่</th>
								<th>ประสิทธิภาพในการทางาน 60%</th>
								<th>5</th>
								<th>4</th>
								<th>3</th>
								<th>2</th>
								<th>1</th>
								<th>รวม</th>
							</tr>
							<tr>
								<td>1</td>
								<td class="name_title">ความคิดริเริ่มและสามารถนาเสนอความคิดเห็นในเรื่องที่เกี่ยวข้องกับงานที่รับผิดชอบ</td>
								<td><label><input type="radio" name="st" id="5" class="flat-red"></label></td>
								<td><label><input type="radio" name="st" id="4" class="flat-red"></label></td>
								<td><label><input type="radio" name="st" id="3" class="flat-red"></label></td>
								<td><label><input type="radio" name="st" id="2" class="flat-red"></label></td>
								<td><label><input type="radio" name="st" id="1" class="flat-red"></label></td>
								<td></td>
							</tr>
						</table>
						<label class="pull-right">คะแนนรวม : </label>
					</div>

					<div class="box-header with-border">
						<div class="col-md-8">
							<h4>ส่วนที่ 3</h4>
						</div>
						
						<table class="table table-bordered table-condensed">
							<tr>
								<th>ข้อที่</th>
								<th>ความร่วมมือ 20%</th>
								<th>5</th>
								<th>4</th>
								<th>3</th>
								<th>2</th>
								<th>1</th>
								<th>รวม</th>
							</tr>
							<tr>
								<td>1</td>
								<td class="name_title">ความคิดริเริ่มและสามารถนาเสนอความคิดเห็นในเรื่องที่เกี่ยวข้องกับงานที่รับผิดชอบ</td>
								<td><label><input type="radio" name="su" id="5" class="flat-red"></label></td>
								<td><label><input type="radio" name="su" id="4" class="flat-red"></label></td>
								<td><label><input type="radio" name="su" id="3" class="flat-red"></label></td>
								<td><label><input type="radio" name="su" id="2" class="flat-red"></label></td>
								<td><label><input type="radio" name="su" id="1" class="flat-red"></label></td>
								<td></td>
							</tr>
						</table>
						<label class="pull-right">คะแนนรวม : </label>
					</div>

					<div class="box-header">
						<label class="pull-right grand_total">Grand Total : 85 </label>
					</div>
				</div>

				<div class="btn-group pull-right">
					<a href="">
						<button type="button" class='btn btn-warning cancel_evaluation'> ยกเลิก
						</button>
					</a>
				</div>
				<div class="btn-group pull-right btn_success_evaluation">
					<a href="">
						<button type="button" class='btn btn-success success_evaluation'> บันทึกผล
						</button>
					</a>
				</div>
			</div>
			<div class="row hidden-xs hidden-sm">
				<div class="col-md-8 col-md-offset-2">
					<hr>
					<strong>Copyright &copy; 2019 <a href="">EngCom-RU</a>.</strong> All rights
					reserved.					
				</div>
				
			</div>
		</div>
	</section>
	<!-- jQuery 3 -->
	<script src="/resources/assets/theme/adminlte/bower_components/jquery/dist/jquery.min.js"></script>
	<!-- Bootstrap 3.3.7 -->
	<script src="/resources/assets/theme/adminlte/bower_components/bootstrap/dist/js/bootstrap.min.js"></script>
	<!-- AdminLTE App -->
	<script src="/resources/assets/theme/adminlte/dist/js/adminlte.min.js"></script>
	<!-- icheck -->
	<script src="/resources/assets/theme/adminlte/plugins/iCheck/icheck.min.js"></script>
	<script src="/resources/assets/js/evaluation/assessment.js"></script>
	<!-- sweet alert -->
	<script src="/resources/assets/js/core/sweetalert2/sweetalert2.min.js"></script>
	<!-- main function -->
	<script src="/resources/assets/js/main.js"></script>

</body>
</html>