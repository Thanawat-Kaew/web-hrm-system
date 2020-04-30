<head>
	<meta content="Circle Chart,Pie Chart" name="keywords">
	<script src="https://canvasjs.com/assets/script/canvasjs.min.js"></script>
	<link href="/resources/assets/pie-chart/css/anychart-ui.min.css" rel="stylesheet" type="text/css">
	<link href="/resources/assets/pie-chart/css/anychart-font.css" rel="stylesheet" type="text/css">
	<script src="/resources/assets/theme/adminlte/bower_components/jquery/dist/jquery.min.js"></script>
	<script src="/resources/assets/pie-chart/js/anychart-base.min.js"></script>
	<script src="/resources/assets/pie-chart/js/anychart-ui.min.js"></script>
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

		button {
			margin-right: 5px !important;
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
	<div class="row">
		<div class="col-md-12 no-padding">
			<?php $count_emp = $get_count_emp->count() ?>
			<div class="box-header">
				<h4>Today</h4>
				<div class="btn-group pull-right">
					<button style="border-color: red;" type="button" class='btn btn-default dropdown-toggle dsh_table_view'><i class="fa fa-table"></i> TABLE VIEW
					</button>
				</div>
				<div class="btn-group pull-right">
					<button style="border-color: red;" type="button" class='btn btn-default dropdown-toggle dsh_box_view'><i class="fa fa-cube"></i> BOX VIEW
					</button>
				</div>
			</div>
			<!-- table view -->
			<div class="col-md-12 hide" id="table_view">
				<div class="box box-warning">
					<div class="box-body no-padding">
						<table class="table table-striped table-hover">
							<tbody>
								<tr>
									<th style="width: 40px; text-align: left;">Task</th>
									<th style="width: 30px;">Amount</th>
									<th style="width: 100px;">Progress</th>
									<th style="width: 40px">Percentage</th>
								</tr>
								<tr>
									<td style="text-align: left;">มาทำงาน /COME FOR WORK</td>
									<td><?php echo $get_count_timestamp ?> คน</td>
									<td>
										<div class="progress progress-xs progress-striped active">
											<div class="progress-bar progress-bar-danger" style="width: <?php echo round(($get_count_timestamp*100)/$count_emp,2).'%'?>;"></div>
										</div>
									</td>
									<td><span class="badge bg-red"><?php echo round(($get_count_timestamp*100)/$count_emp,2) ?>%</span></td>
								</tr>
								<tr>
									<td style="text-align: left;">มาสาย /LATE FOR WORK</td>
									<td><?php echo $get_count_timestamp_late ?> คน</td>
									<td>
										<div class="progress progress-xs progress-striped active">
											<div class="progress-bar progress-bar-yellow" style="width: <?php echo round(($get_count_timestamp_late*100)/$count_emp,2).'%'?>;"></div>
										</div>
									</td>
									<td><span class="badge bg-yellow"><?php echo round(($get_count_timestamp_late*100)/$count_emp,2) ?>%</span></td>
								</tr>
								<tr>
									<td style="text-align: left;">มาตรงเวลา /COME FOR WORK ON TIME</td>
									<td><?php echo $get_count_timestamp_on_time ?> คน</td>
									<td>
										<div class="progress progress-xs progress-striped active">
											<div class="progress-bar progress-bar-primary" style="width: <?php echo round(($get_count_timestamp_on_time*100)/$count_emp,2).'%'?>;"></div>
										</div>
									</td>
									<td><span class="badge bg-light-blue"><?php echo round(($get_count_timestamp_on_time*100)/$count_emp,2) ?>%</span></td>
								</tr>
								<tr>
									<td style="text-align: left;">มาก่อนเวลา /COME FOR WORK AHEAD OF TIME</td>
									<td><?php echo $get_count_timestamp_early ?> คน</td>
									<td>
										<div class="progress progress-xs progress-striped active">
											<div class="progress-bar progress-bar-success" style="width: <?php echo round(($get_count_timestamp_early*100)/$count_emp,2).'%'?>;"></div>
										</div>
									</td>
									<td><span class="badge bg-green"><?php echo round(($get_count_timestamp_early*100)/$count_emp,2) ?>%</span></td>
								</tr>
								<tr>
									<td style="text-align: left;">ลางาน /LEAVE</td>
									<td><?php echo $get_count_leave ?> คน</td>
									<td>
										<div class="progress progress-xs progress-striped active">
											<div class="progress-bar progress-bar-success" style="width: <?php echo round(($get_count_leave*100)/$count_emp,2).'%'?>;"></div>
										</div>
									</td>
									<td><span class="badge bg-aqua"><?php echo round(($get_count_leave*100)/$count_emp,2) ?>%</span></td>
								</tr>
							</tbody>
						</table>
					</div>
				</div>
			</div>

			<div id="box_view" class="">
			<div class="col-md-3">
				<div class="info-box bg-green">
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
		</div>
		</div>
		<div class="col-md-12 no-padding">
			<div class="box-header">
				<h4>Overview</h4>
				<div class="col-md-3 pull-right input-group-sm">
					<select class="form-control select2 select2-hidden-accessible" style="width: 100%;border-radius: 5px; height: 40px; font-size: 14px;" data-select2-id="9" tabindex="-1" aria-hidden="true" id="change_department">
						<option value="">แผนกทั้งหมด</option>
						<?php foreach($department as $departments):?>
							<option value="<?php echo $departments['id_department']?>">
								<?php echo $departments['name']?></option>
							<?php endforeach ?>
						</select>
					</div>
				</div>
				<div class="col-md-4">
					<div class="box box-info" id="form_total_emp">
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
					<div class="box box-success" id="form_gender">
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
					<div class="box box-danger" id="form_age">
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
			<div class="col-md-12 col-xs-12">
				<div class="box box-warning">
					<div class="box-header with-border">
						<h3 class="box-title">Employees by Departments.</h3>
					</div>
					<div class="box-body no-padding">
						<div class="row">
							<div class="col-md-12 col-xs-12">
								<div id="container_deptp" style="height: 400px;"></div>
								<script type="text/javascript">
									anychart.onDocumentReady(function () {
										var chart = anychart.pie([
											<?php foreach ($get_count_dept as $value) :?>
												["<?php echo $value->department->name?>" ,<?php echo $value->total?>],
											<?php endforeach ?>
											]);

										chart.title('')
										.radius('45%')
										.innerRadius('40%');
										chart.labels().fontSize(18);
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
	<div id="ajax-center-url" data-url="<?php echo route('dashboard.ajax_center.post')?>"></div>
	<?php echo csrf_field()?>
