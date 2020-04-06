<head>
	<link href="https://playground.anychart.com/templates/pie_chart/iframe" rel="canonical">
	<meta content="Circle Chart,Pie Chart" name="keywords">
	<meta content="AnyChart - JavaScript Charts designed to be embedded and integrated" name="description">
	<link href="/resources/assets/pie-chart/css/anychart-ui.min.css" rel="stylesheet" type="text/css">
	<link href="/resources/assets/pie-chart/css/anychart-font.css" rel="stylesheet" type="text/css">
	<style type="text/css">
		html, body, #container {
			width: 100%;
			height: 100%;
			margin: 0;
			padding: 0;
		}
		.anychart-credits {
			display: none;
		}

	</style>
</head>
<section class="content-header">
	<h3>
		Dashboard |
		<small> หน้าควบคุม </small>
	</h3>
</section>
<section class="content">
	<script src="/resources/assets/pie-chart/js/anychart-base.min.js"></script>
	<script src="/resources/assets/pie-chart/js/anychart-ui.min.js"></script>
	<div class="row">
		<div class="col-md-12 no-padding">
					<?php $count_emp = $get_count_emp->count() ?>
			<div class="box-header">
				<div>Today</div>
			</div>
			<div class="col-md-3">
				<div class="info-box bg-green">
					<!-- where('date',$get_date_now)->count(); -->

					<span class="info-box-icon"><i class="glyphicon glyphicon-briefcase"></i></span>
					<div class="info-box-content">
						<span class="info-box-text">มาทำงาน /Come to work</span>

						<span class="info-box-number"> <?php echo $get_count_timestamp ?> คน</span>
						<div class="progress">
							<div class="progress-bar" style="width: <?php echo round(($get_count_timestamp*100)/$count_emp,2).'%'?>;"></div>
						</div>

						<span class="progress-description">
							<?php echo round(($get_count_timestamp*100)/$count_emp,2) ?>% วันนี้ จากพนักงานทั้งหมด
						</span>
					</div>
				</div>
			</div>

			<div class="col-md-2">
				<div class="info-box bg-red">
					<span class="info-box-icon"><i class="glyphicon glyphicon-time"></i></span>
					<div class="info-box-content">
						<span class="info-box-text">มาสาย</span>
						<span class="info-box-number"><?php echo $get_count_timestamp_late ?> คน</span>
						<div class="progress">
							<div class="progress-bar" style="width: <?php echo round(($get_count_timestamp_late*100)/$count_emp,2).'%'?>;"></div>
						</div>
						<span class="progress-description">
							<?php echo round(($get_count_timestamp_late*100)/$count_emp,2) ?>%
						</span>
					</div>
				</div>
			</div>

			<div class="col-md-2">
				<div class="info-box bg-gray">
					<span class="info-box-icon"><i class="glyphicon glyphicon-time"></i></span>
					<div class="info-box-content">
						<span class="info-box-text">มาตรงเวลา</span>
						<span class="info-box-number"><?php echo $get_count_timestamp_on_time ?> คน</span>
						<div class="progress">
							<div class="progress-bar" style="width: <?php echo round(($get_count_timestamp_on_time*100)/$count_emp,2).'%'?>;"></div>
						</div>
						<span class="progress-description">
							<?php echo round(($get_count_timestamp_on_time*100)/$count_emp,2) ?>%
						</span>
					</div>
				</div>
			</div>

			<div class="col-md-2">
				<div class="info-box bg-aqua">
					<span class="info-box-icon"><i class="glyphicon glyphicon-time"></i></span>
					<div class="info-box-content">
						<span class="info-box-text">มาก่อนเวลา</span>
						<span class="info-box-number"><?php echo $get_count_timestamp_early ?> คน</span>
						<div class="progress">
							<div class="progress-bar" style="width: <?php echo round(($get_count_timestamp_early*100)/$count_emp,2).'%'?>;"></div>
						</div>
						<span class="progress-description">
							<?php echo round(($get_count_timestamp_early*100)/$count_emp,2) ?>%
						</span>
					</div>
				</div>
			</div>
			
			<div class="col-md-3">
				<div class="info-box bg-yellow">
					<span class="info-box-icon"><i class="glyphicon glyphicon-envelope"></i></span>
					<div class="info-box-content">
						<span class="info-box-text">ลางาน /Leaves</span>
						<span class="info-box-number"><?php echo $get_count_leave ?> คน</span>
						<div class="progress">
							<div class="progress-bar" style="width: <?php echo round(($get_count_leave*100)/$count_emp,2).'%'?>;"></div>
						</div>
						<span class="progress-description">
							<?php echo round(($get_count_leave*100)/$count_emp,2) ?>% วันนี้ จากพนักงานทั้งหมด
						</span>
					</div>
				</div>
			</div>
			<!-- <div class="col-md-4">
				<div class="box box-info">
					<table class="table table-bordered">
						<thead>
							<tr>
								<th>มาสาย</th>
								<th>มาตรงเวลา</th>
								<th>มาก่อนเวลา</th>
							</tr>
						</thead>
						<tbody>
							<tr>
								<td><?php echo $get_count_timestamp_late ?></td>
								<td><?php echo $get_count_timestamp_on_time ?></td>
								<td><?php echo $get_count_timestamp_early ?></td>
							</tr>
						</tbody>
					</table>
				</div>
			</div> -->
		</div>
		<div class="col-md-12 no-padding">
			<div class="box-header">
				<div>Overview</div>
			</div>
			<div class="col-md-4">
				<div class="box box-info">
					<div class="box-header with-border">
						<h3 class="box-title">Total Employees.</h3>
					</div>
					<div class="box-body no-padding">
						<div class="row" style="height: 230px;">
							<div class="col-md-12">
								<div style="text-align: center; margin-top: 40px;">
									<span style="font-size: 100px;"><?php echo $get_count_emp->count() ?></span>
								</div>
							</div>

						</div>
					</div>
				</div>
			</div>
			<div class="col-md-4">
				<div class="box box-success">
					<div class="box-header with-border">
						<h3 class="box-title">Gender.</h3>
					</div>
					<div id="container" style="height: 230px;"></div>
					<script type="text/javascript">anychart.onDocumentReady(function() {
						var chart = anychart.bar();
						chart.title('');
						chart.data([
							{x: 'ชาย', value: <?php echo $get_count_emp->where('gender' ,'ชาย')->count(); ?>},
							{x: 'หญิง', value: <?php echo $get_count_emp->where('gender' ,'หญิง')->count(); ?> },
							]);
						chart.container('container');
						chart.labels().fontSize(20);
						chart.draw();
					});</script>
				</div>
			</div>
			<div class="col-md-4">
				<div class="box box-danger">
					<div class="box-header with-border">
						<h3 class="box-title">Employees by Age Groups.</h3>
					</div>
					<?php $age_min_20	= $get_count_emp->where('age','>=',1)->where('age','<=',20)->count();?>
					<?php $age_21_30	= $get_count_emp->where('age','>=',21)->where('age','<=',30)->count();?>
					<?php $age_31_40	= $get_count_emp->where('age','>=',31)->where('age','<=',40)->count();?>
					<?php $age_41_50	= $get_count_emp->where('age','>=',41)->where('age','<=',50)->count();?>
					<?php $age_max_50	= $get_count_emp->where('age','>=',51)->count();?>
					<?php $count_emp = $get_count_emp->count() ?>

					<table class="table table-bordered">
						<thead>
							<tr>
								<th>Age</th>
								<th>Progress</th>
								<th></th>
								<th>Employee</th>
							</tr>
						</thead>
						<tbody>
							<tr>
								<td><20</td>
								<td>
									<div class="progress progress-xs progress-striped active">
										<div class="progress-bar progress-bar-success" style="width: <?php echo round(($age_min_20*100)/$count_emp,2).'%'?>;"></div>
									</div>
								</td>
								<td>
									<span class="badge bg-green"><?php echo round(($age_min_20*100)/$count_emp,2) ?> %</span>
								</td>
								<td><?php echo $age_min_20 ?> คน</td>
							</tr>
							<tr>
								<td>21-30</td>
								<td>
									<div class="progress progress-xs progress-striped active">
										<div class="progress-bar progress-bar-danger" style="width: <?php echo round(($age_21_30*100)/$count_emp,2).'%'?>;"></div>
									</div>
								</td>
								<td>
									<span class="badge bg-red"><?php echo round(($age_21_30*100)/$count_emp,2) ?> %</span>
								</td>
								<td><?php echo $age_21_30 ?> คน</td>
							</tr>
							<tr>
								<td>31-40</td>
								<td>
									<div class="progress progress-xs progress-striped active">
										<div class="progress-bar progress-bar-primary" style="width: <?php echo round(($age_31_40*100)/$count_emp,2).'%'?>;"></div>
									</div>
								</td>
								<td>
									<span class="badge bg-blue"><?php echo round(($age_31_40*100)/$count_emp,2) ?> %</span>
								</td>
								<td><?php echo $age_31_40 ?> คน</td>
							</tr>
							<tr>
								<td>41-50</td>
								<td>
									<div class="progress progress-xs progress-striped active">
										<div class="progress-bar progress-bar-info" style="width: <?php echo round(($age_41_50*100)/$count_emp,2).'%'?>;"></div>
									</div>
								</td>
								<td>
									<span class="badge bg-aqua"><?php echo round(($age_41_50*100)/$count_emp,2) ?> %</span>
								</td>
								<td><?php echo $age_41_50 ?> คน</td>
							</tr>
							<tr>
								<td>>51</td>
								<td>
									<div class="progress progress-xs progress-striped active">
										<div class="progress-bar progress-bar-warning" style="width: <?php echo round(($age_max_50*100)/$count_emp,2).'%'?>;"></div>
									</div>
								</td>
								<td>
									<span class="badge bg-orange"><?php echo round(($age_max_50*100)/$count_emp,2) ?> %</span>
								</td>
								<td><?php echo $age_max_50 ?> คน</td>
							</tr>
						</tbody>
					</table>
				</div>
			</div>
		</div>

		<div class="col-md-12">
			<div class="box box-warning">
				<div class="box-header with-border">
					<h3 class="box-title">Employees by Departments.</h3>
				</div>
				<div class="box-body no-padding">
					<div class="row">
						<div class="col-md-12">
							<?php /*sd($get_count_dept->where('id_department','id_department')->groupBy('name')->count())*/ ?>
							<div id="container_deptp" style="height: 400px;"></div>
								<?php foreach ($get_count_dept as $value1) :?>
								<?php $check_math_id_dept = $value1->id_department ?>
								<?php endforeach ?>

								
											<!-- // ['Driver', 15],
											// ['Engineer', 31],
											// ['Sale and Marketing',27 ],
											// ['Accounting',20 ],
											// ['Procument', 18] -->
							<script type="text/javascript">
								anychart.onDocumentReady(function () {
									var chart = anychart.pie([
										<?php foreach ($get_count_dept as $value) :?>
											["<?php echo $value->name?>" ,30],
										<?php endforeach ?>
										]);

									chart.title('')
									.radius('45%')
									.innerRadius('40%');
									chart.labels().fontSize(20);
									chart.container('container_deptp');
									chart.draw();
								});
							</script>
						</div>
					</div>
				</div>
			</div>
		</div>
	</div>
</section>