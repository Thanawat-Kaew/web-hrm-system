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
						<button type="button" name="add-leave" class='btn btn-success dropdown-toggle pull-right add-leave'><i class="fa fa-plus"></i> เพิ่มรายการ
						</button>
						<a href="<?php echo route('leave.leave_history.get');?>">
							<button href="" type="button" name="view-history" class='btn btn-warning pull-right dropdown-toggle view-history'><i class="fa fa-history"></i> ประวัติ
							</button>
						</a>
						<?php if($current_employee->id_department == "hr0001"):?>
							<?php if($current_employee['id_position'] == 2):?>
						<a href="<?php echo route("leave.set_holiday.get")?>">
							<button href="" type="button" name="set-holiday" class='btn btn-info pull-right dropdown-toggle set-holidays'><i class="fa fa-calendar-plus-o"></i> ตั้งค่าวันหยุด
							</button>
						</a>
					<?php endif?>
					<?php endif?>
						<button type="button" name="view_holiday" class='btn btn-danger dropdown-toggle pull-right view_holiday'><i class="fa fa-calendar-times-o"></i> ดูวันหยุดประจำปี
						</button>
					</div>
				</div>
				<div class="box box-info"><br>
					<div class="box-body table-responsive no-padding">
						<table id="myTable" class="table table-striped table-bordered table-hover" style="width:100%;">
							<thead>
								<tr>
									<th style="width: 5%;">#</th>
									<th style="width: 30%;">วันที่ลา</th>
									<th style="width: 13%;">ประเภท</th>
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
										<td><?php echo $leave->start_leave ." <label> ถึง </label> ".$leave->end_leave ?></td>
										<td style="text-align: left;"><?php echo $leave->leaves_type->leaves_name ?></td>
										<td><?php echo $leave->total_leave ?></td>
										<td style="text-align: left; word-break: break-word;"><?php echo $leave->reason ?></td>
										<td style="font-size: 14px;"><span class="label label-primary"><?php echo ($leave->leaves_status->name == "not_allowed") ? "Rejected" : ucfirst($leave->leaves_status->name) ?></span></td>
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
								<th style="width: 40%;font-size: 10px;">ประเภทการลา</th>
								<th style="width: 10%;font-size: 10px;">All</th>
								<th style="width: 10%;font-size: 10px;">Approved</th>
								<th style="width: 10%;font-size: 10px;">Waiting</th>
								<th style="width: 10%;font-size: 10px;">Rejected</th>
								<th style="width: 10%;font-size: 10px;">Balance</th>
							</tr>
							<?php foreach($history_leave as $leave):?>
								<tr>
									<td style="text-align: left; padding-left: 5px;"><?php echo $leave["leaves_name"] ?></td>
									<td style="font-size: 13px;width: 10%;"><?php echo $leave["max_day"] ?></td>
									<?php $sum_leave = 0;?>
									<?php foreach($leave["leave"] as $status):?>
										<?php $sum_leave = ($status['id'] == 1) ? $sum_leave+ $status['total'] :$sum_leave;?>
										<td style="font-size: 13px; color: <?php echo ($status['name'] == "approved") ? "green" : ($status['name'] == "waiting" ? "orange" : "red")?>; width: 10%;"><?php echo (round($status['total'],1))  ?></td>
									<?php endforeach ?>
									<td style="font-size: 13px;width: 10%;"><?php $a = (round($leave["max_day"],1)-round($sum_leave,1));
									if(strpos($a,".") !== false){ echo $a-0.2 ; }else{ echo $a;} ?></td>
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