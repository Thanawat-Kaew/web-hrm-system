<section class="content-header">
	<h3>
		การลา |
		<small> Leave</small>
	</h3>
</section>
<section class="content">
	<div class="row">
		<div class="col-xs-12">
			<div class="col-md-8" style="padding-right: 5px; padding-left: 5px;">
				<div class="row">
					<div class="col-md-12 btn-group dropup pull-right ">
						<button type="button" name="add-leave" class='btn btn-success dropdown-toggle pull-right add-leave'><i class="fa fa-plus"></i> New Record
						</button>
						<a href="<?php echo route('leave.leave_history.get');?>">
							<button href="" type="button" name="view-history" class='btn btn-warning pull-right dropdown-toggle view-history'><i class="fa fa-history"></i> History
							</button>
						</a>
						<a href="<?php echo route("leave.set_holiday.get")?>">
							<button href="" type="button" name="set-holiday" class='btn btn-info pull-right dropdown-toggle set-holidays'><i class="fa fa-calendar-plus-o"></i> Set Holiday
							</button>
						</a>
					</div>
				</div>
				<div class="box box-info"><br>
					<div class="box-body table-responsive no-padding">
						<table id="myTable" class="table table-striped table-bordered table-hover" style="width:100%;">
							<thead>
								<tr>
									<th style="width: 5%;">#</th>
									<th style="width: 30%;">วันที่ลา</th>
									<th style="width: 13%;">ประเภทการลา</th>
									<th style="width: 12%;">จำนวน (ชม.)</th>
									<th>เหตุผล</th>
									<th style="width: 10%;">สถานะ</th>
								</tr>
							</thead>
							<?php $count = 1;?>
							<?php foreach ($leaves as $key => $leave): ?>
								<?php if($leave->status_leave == 1): ?>
									<tr>
										<td><?php echo $count++ ;?></td>
										<td><?php echo $leave->start_leave ." ถึง ".$leave->end_leave ?></td>
										<td style="text-align: left;"><?php echo $leave->leaves_type->leaves_name ?></td>
										<td><?php echo $leave->total_leave ?></td>
										<td style="text-align: left;"><?php echo $leave->reason ?></td>
										<td style="font-size: 9px;"><span class="label label-primary"><?php echo ($leave->leaves_status->name == "not_allowed") ? "Rejected" : ucfirst($leave->leaves_status->name) ?></span></td>
									</tr>
								<?php endif?>
							<?php endforeach?>
						</table>
					</div>
				</div>
			</div>
			<div class="col-md-4" style="padding-right: 5px; padding-left: 5px;">
				<div class="box box-danger">
					<div class="box-header with-border">
						<h3 class="box-title">Summary Leaves</h3>
						<div class="box-tools pull-right">
							<button type="button" class="btn btn-box-tool" data-widget="collapse"><i class="fa fa-minus"></i>
							</button>
						</div>
					</div>
					<div class="box-body no-padding">
						<table class=" table-striped table-bordered table-hover">
							<tbody><tr>
								<th style="width: 40%;font-size:6px;">ประเภทการลา</th>
								<th style="width: 10%;font-size: 6px;">All</th>
								<th style="width: 10%;font-size: 6px;">Approved</th>
								<th style="width: 10%;font-size: 6px;">Waiting</th>
								<th style="width: 10%;font-size: 6px;">Rejected</th>
								<th style="width: 10%;font-size: 6px;">Balance</th>
							</tr>
							<?php foreach($history_leave as $leave):?>
								<tr>
									<td style="text-align: left;"><?php echo $leave["leaves_name"] ?></td>
									<td style="font-size: 13px;width: 10%;"><?php echo $leave["max_day"] ?></td>
									<?php $sum_leave = 0;?>
									<?php foreach($leave["leave"] as $status):?>
										<?php $sum_leave = ($status['id'] == 1) ? $sum_leave+ $status['total'] :$sum_leave;?>
										<td style="font-size: 13px; color: <?php echo ($status['name'] == "approved") ? "green" : ($status['name'] == "waiting" ? "orange" : "red")?>; width: 10%;"><?php echo $status['total']  ?></td>
									<?php endforeach ?>
									<td style="font-size: 13px;width: 10%;"><?php echo $leave["max_day"]-$sum_leave  ?></td>
								</tr>
							<?php endforeach ?>
						</tbody>
					</table>
				</div>
			</div>
		</div>
	</div>
</section>

<!-- data -->
<div id="ajax-center-url" data-url="<?php echo route('leave.ajax_center.post')?>"></div>
<div id="add-request-leave" data-url="<?php echo route('leave.add_request_leave.post')?>"></div>
<?php echo csrf_field()?>