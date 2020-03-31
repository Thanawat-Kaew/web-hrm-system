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

		#ac_layer_1w {
			/*align-items: right;*/
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
			<div class="box-header">
				<div>Today</div>
			</div>
			<div class="col-md-4">
				<div class="info-box bg-green">
					<span class="info-box-icon"><i class="glyphicon glyphicon-briefcase"></i></span>
					<div class="info-box-content">
						<span class="info-box-text">มาทำงาน /Come to work</span>
						<span class="info-box-number">120</span>
						<div class="progress">
							<div class="progress-bar" style="width: 90%"></div>
						</div>
						<span class="progress-description">
							90% today.
						</span>
					</div>
				</div>
			</div>

			<div class="col-md-4">
				<div class="info-box bg-yellow">
					<span class="info-box-icon"><i class="glyphicon glyphicon-edit"></i></span>
					<div class="info-box-content">
						<span class="info-box-text">ลางาน /Leaves</span>
						<span class="info-box-number">5</span>
						<div class="progress">
							<div class="progress-bar" style="width: 5%"></div>
						</div>
						<span class="progress-description">
							5% today.
						</span>
					</div>
				</div>
			</div>
			<div class="col-md-4">
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
								<td>10</td>
								<td>20</td>
								<td>30</td>
							</tr>
						</tbody>
					</table>
				</div>
			</div>
		</div>
		<div class="col-md-12 no-padding">
			<div class="col-md-4">
				<div class="box box-info">
					<div class="box-header with-border">
						<h3 class="box-title">Total Employees.</h3>
					</div>
					<div class="box-body no-padding">
						<div class="row" style="height: 230px;">
							<div class="col-md-12">
								<div style="text-align: center; margin-top: 40px;">
									<span style="font-size: 100px;">130</span>
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
						var chart = anychart.pie();
						chart.title('');
						chart.data([
							{x: 'Male', value: 60},
							{x: 'Female', value: 40},
							]);

						chart.container('container');
						chart.draw();
					});</script>
				</div>
			</div>
			<div class="col-md-4">
				<div class="box box-danger">
					<div class="box-header with-border">
						<h3 class="box-title">Employees by Age Groups.</h3>
					</div>
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
								<td>10-20</td>
								<td>
									<div class="progress progress-xs progress-striped active">
										<div class="progress-bar progress-bar-success" style="width: 90%"></div>
									</div>
								</td>
								<td>
									<span class="badge bg-green">90%</span>
								</td>
								<td>30</td>
							</tr>
							<tr>
								<td>21-30</td>
								<td>
									<div class="progress progress-xs progress-striped active">
										<div class="progress-bar progress-bar-danger" style="width: 20%"></div>
									</div>
								</td>
								<td>
									<span class="badge bg-red">20%</span>
								</td>
								<td>30</td>
							</tr>
							<tr>
								<td>31-40</td>
								<td>
									<div class="progress progress-xs progress-striped active">
										<div class="progress-bar progress-bar-primary" style="width: 30%"></div>
									</div>
								</td>
								<td>
									<span class="badge bg-blue">30%</span>
								</td>
								<td>30</td>
							</tr>
							<tr>
								<td>41-50</td>
								<td>
									<div class="progress progress-xs progress-striped active">
										<div class="progress-bar progress-bar-info" style="width: 70%"></div>
									</div>
								</td>
								<td>
									<span class="badge bg-aqua">70%</span>
								</td>
								<td>30</td>
							</tr>
							<tr>
								<td>51-60</td>
								<td>
									<div class="progress progress-xs progress-striped active">
										<div class="progress-bar progress-bar-warning" style="width: 28%"></div>
									</div>
								</td>
								<td>
									<span class="badge bg-orange">28%</span>
								</td>
								<td>30</td>
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
							<div id="container_deptp" style="height: 400px;"></div>
							<script type="text/javascript">
								anychart.onDocumentReady(function () {
									var chart = anychart.pie([
										['Human resources',20 ],
										['Driver', 15],
										['Engineer', 31],
										['Sale and Marketing',27 ],
										['Accounting',20 ],
										['Procument', 18]
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