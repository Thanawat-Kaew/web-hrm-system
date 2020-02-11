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
	<!-- datepicker -->
	<link rel="stylesheet" href="/resources/assets/theme/adminlte/bower_components/bootstrap-datepicker/dist/css/bootstrap-datepicker.min.css">
	<link rel="stylesheet" type="text/css" href="/resources/assets/js/core/bootstrap_datetimepicker/css/bootstrap-datetimepicker.min.css">
	 <!-- iCheck -->
  	<link rel="stylesheet" href="/resources/assets/theme/adminlte/plugins/iCheck/all.css">
	<!-- Google Font -->
	<link href="https://fonts.googleapis.com/css?family=Kanit:200&display=swap" rel="stylesheet">
	<link rel="stylesheet" href="/resources/assets/css/leave/set_holiday.css">
	<link rel="stylesheet" type="text/css" href="/resources/assets/js/core/sweetalert2/sweetalert2.min.css">


</head>
<body>
	<div class="container">
		<section class="box">
			<div class="col-md-10 col-md-offset-1 content-header hidden-xs">
				<h3>
					ตั้งค่าวันหยุดประจำปี |
					<small class="text-head-small"> Set Holidays</small>
				</h3>
				<hr>
			</div>
			<div class="col-md-8 col-md-offset-2 hidden-md hidden-sm hidden-lg mobile-head-show">
				<h3>
					ตั้งค่าวันหยุดประจำปี |
					<small class="text-head-small"> Set Holidays</small>
				</h3>
				<hr>
			</div>
			<div class="container">
				<div class="row">
					<div class="col-md-10 col-md-offset-1">
						<div class="col-md-2">
							<?php foreach($detail_day_off_year as $value) :?>
							<input type="hidden" class="required" id="id-set_holiday" value="<?php echo $value->id ;?>">
						<?php endforeach ?>
							ประจำปี<br>
							<input type="text" name="" id="set_year" class="form-control yearpicker" readonly placeholder="เลือกปี..." value="">
						</div>
						<div class="col-md-6">
							รายการ<br>
							<select class="form-control set_holiday_day">
								<option>เลือกรายการ...</option>
								<?php foreach ($day_off_year as $key => $value): ?>
									<option class="set_holiday" value="<?php echo $value['id']?>"><?php echo $value['name'] ?></option>
								<?php endforeach ?>
							</select>
						</div>
						<div class="col-md-2">
							หยุดชดเชย<br>
							<input type="checkbox" id="check_stop_compensation" name="check_stop_compensation" class="flat-red">
						</div>
						<div class="col-md-2">
							วันที่<br>
							<input type="text" id="set_date" class="form-control datepicker" readonly placeholder="เลือกวันที่..." value="">
						</div>
					</div>
				</div>
				<div class="col-md-10 col-md-offset-1">                   
					<button class="btn btn-warning cancel pull-right">ยกเลิก</button>
					<button class="btn btn-info save pull-right">บันทึก</button>
				</div><br><br>
				<div class="col-md-10 col-md-offset-1 table-show">
					<?php $count_total = count($detail_day_off_year) ?>
					<div class="box-header">
						<div class="box-tools">
							<div class="input-group input-group-sm" style="width: 150px;">
								<input type="text" id="myInput" name="table_search" style="height: 20% !important;width: 120% !important; font-size: 15px !important;" class="form-control pull-right " placeholder="ค้นหารายการ...">
							</div>
						</div>
					</div>
					<p>Total : <?php echo $count_total ?></p>

					<div class="table-responsive">
						<table class="table select-options table-hover table-bordered table-responsive" id="myTable" style=" padding: 0px;">
							<tr class="header">
								<th>#</th>
								<th>ประจำปี</th>
								<th>รายการ</th>
								<th>วันที่</th>
								<th></th>
							</tr>
							<?php $count = 0;?>
							<?php foreach($detail_day_off_year as $value):?>
								<tr>
									<td><?php echo $count = $count+1 ;?></td>
									<td><?php echo $value->year ?></td>
									<?php $compensate = ($value->compensate) ? 'ชดเชย':''?>
									<td><?php echo $compensate.$value->day_off_year['name']?></td>
									<td><?php echo $value->date ?></td>
									<td><span><i class="fa fa-trash btn btn-trash delete-data" data-href="<?php echo route('leaves.delete_set_holiday.post',$value['id']);?>"></i></span></td>
								</tr>
							<?php endforeach ?>
							<?php if(count($detail_day_off_year)== 0):?>
								<tr>
									<td colspan="7" style="text-align: center;"> Data not found.</td>
								</tr>
							<?php endif ?>
						</table>
					</div>
				</div>
			</div>
		</section>
						<a href="<?php echo route('leave.leave.get');?>">
							<button class="btn btn-app" id="btn-app"><i class="fa fa-reply"></i></button>
						</a>
	</script>
	<div class="col-md-8 col-md-offset-2 hidden-md hidden-sm hidden-lg mobile-show">
		<footer class="my-5 pt-5 text-muted text-center page-footer text-small">
			<p class="mb-1">Copyright © 2019 EngCom-RU. All rights reserved.</p>
			<p class="mb-1">Version 1.0.0</p>
		</footer>
	</div>
	<div class="col-md-8 col-md-offset-2 hidden-xs">
		<footer class="my-5 pt-5 text-muted text-center page-footer text-small">
			<p class="mb-1">Copyright © 2019 EngCom-RU. All rights reserved.</p>
			<p class="mb-1">Version 1.0.0</p>
		</footer>
	</div>
</div>

<!-- data -->
<div id="add-set_holiday" data-url="<?php echo route('leave.add_set_holiday.post')?>"></div>
<?php echo csrf_field()?>

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
<!-- icheck -->
<script src="/resources/assets/theme/adminlte/plugins/iCheck/icheck.min.js"></script>
<!-- Sweet Alert -->
<script src="/resources/assets/js/core/sweetalert2/sweetalert2.min.js"></script>
<!--Clock-->
<script src="/resources/assets/js/time_stamp/time_stamp.js"></script>
<!-- datepicker -->
<script src="/resources/assets/theme/adminlte/bower_components/bootstrap-datepicker/dist/js/bootstrap-datepicker.js"></script>

<script src="/resources/assets/js/core/sweetalert2/sweetalert2.min.js"></script>


<script src="/resources/assets/js/main.js"></script>
<script src="/resources/assets/js/core/sweetalert2/sweetalert2.min.js"></script>
<script src="/resources/assets/js/leave/set_holiday.js"></script>
</body>
</html>