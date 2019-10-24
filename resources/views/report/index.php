<section class="content-header">
	<h3>
		การออกรายงาน |
		<small> Report</small>
	</h3>
</section>
<section class="content">
	<!-- Small boxes (Stat box) -->
	<div class="row">
		<div class="col-md-12"><br>
			<div class="col-lg-3 col-xs-6">
				<!-- small box -->
				<div class="small-box bg-aqua">
					<div class="inner">
						<h4>Time Stamp</h4>

						<p>การลงเวลา</p>
					</div>
					<div class="icon">
						<i class="fa fa-clock-o"></i>
					</div>
					<a href="<?php echo route('report.report_time_stamp.get')?>" class="small-box-footer">View info <i class="fa fa-arrow-circle-right"></i></a>
				</div>
			</div>
			<!-- ./col -->
			<div class="col-lg-3 col-xs-6">
				<!-- small box -->
				<div class="small-box bg-yellow">
					<div class="inner">
						<h4>Leave</h4>

						<p>การลา</p>
					</div>
					<div class="icon">
						<i class="fa fa-envelope-o"></i>
					</div>
					<a href="<?php echo route('report.report_leave.get')?>" class="small-box-footer">View info <i class="fa fa-arrow-circle-right"></i></a>
				</div>
			</div>
			<!-- ./col -->
			<div class="col-lg-3 col-xs-6">
				<!-- small box -->
				<div class="small-box bg-red">
					<div class="inner">
						<h4>Evaluation</h4>

						<p>การประเมินผล</p>
					</div>
					<div class="icon">
						<i class="ion ion-pie-graph"></i>
					</div>
					<a href="<?php echo route('report.report_evaluations.get')?>" class="small-box-footer">View info <i class="fa fa-arrow-circle-right"></i></a>
				</div>
			</div>
			<!-- ./col -->
			<div class="col-lg-3 col-xs-6">
				<!-- small box -->
				<div class="small-box bg-primary">
					<div class="inner">
						<h4>Overview</h4>

						<p>ภาพรวม</p>
					</div>
					<div class="icon">
						<i class="fa fa-bar-chart"></i>
					</div>
					<a href="<?php echo route('report.report_overview.get')?>" class="small-box-footer">View info <i class="fa fa-arrow-circle-right"></i></a>
				</div>
			</div>
			<!-- ./col -->
		</div>
	</div>
</section>