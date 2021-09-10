 <!-- <meta http-equiv="refresh" content="15" /> -->
<section class="content-header">
	<h3>
		การลงเวลา |
		<small> Time Stamp</small>
	</h3>
</section>
<section class="content">
	<div class="row">
		<div class="col-xs-12">
			<div class="row add-leave-time-clock">
				<div class="btn-group pull-right dropup-new-record">
					<button href="" type="button" class='btn btn-danger dropdown-toggle add-new-record' data-toggle="dropdown"><i class="fa fa-plus"></i> บันทึกเวลาย้อนหลัง
					</button>
				</div>
				<div class="btn-group pull-right time-clock">
					<button type="button" class='btn btn-info time_stamp'><i class="fa fa-clock-o"></i> บันทึกเวลา
					</button>
				</div>
				<div class="btn-group pull-right ">
					<a class="histry_time_stamp" href="<?php echo route('time_stamp.request_history.get')?>">
						<button type="button" class="btn btn-warning dropdown-toggle"><i class="fa fa-history"></i> ประวัติ
						</button>
					</a>
				</div>
			</div>
			<div class="box box-info">
				<div class="box-header">
					<h3 class="box-title">ประวัติการลงเวลา</h3>
				</div>

				<!-- /.box-header -->
				<div class="box-body table-responsive no-padding">
					<table id="example" class="table table-striped table-bordered table-hover" style="width:100%">
				        <thead>
				            <tr>
				                <th>Name</th>
								<th>Date</th>
								<th>Time-In</th>
								<th>Break-Out</th>
								<th>Break-In</th>
								<th>Time-Out</th>
				            </tr>
				        </thead>
				        <tbody>
				            <?php //d($data->toArray());?>
						<?php foreach($data as $value) { ?>
							<?php if($value->id_employee == $id_employee ){?>
								<tr>
									<?php
										$time_in 	= $value->requesttimestamp->where('request_type', 'time_in')->where('status', 2)->first();
										$time_out 	= $value->requesttimestamp->where('request_type', 'time_out')->where('status', 2)->first();
										$break_in 	= $value->requesttimestamp->where('request_type', 'break_in')->where('status', 2)->first();
										$break_out 	= $value->requesttimestamp->where('request_type', 'break_out')->where('status', 2)->first();
	// d($time_in->request_time);sd('sdfsdfsdf');
									?>
									<td>
										<?php echo $value->employee['first_name']?> <?php echo $value->employee['last_name']?>
									</td>
									<td>
										<?php echo $value['date']?>
									</td>

								<?php if(isset($time_in->request_time)){?> <!-- กรณีมีวันที่ร้องขอลงเวลาย้อนหลังแล้วยังอยู่ในสถานะรอ -->
									<td>
										<?php echo "<span class='text-warning'>".$time_in->request_time.'</span>' ?>
									</td>
								<?php }else{?>
									<td>
										<?php echo !empty($value['time_in']) ? $value['time_in'] : ""?>
									</td>
								<?php } ?>

								<?php if(isset($break_out->request_time)){?> <!-- กรณีมีวันที่ร้องขอลงเวลาย้อนหลังแล้วยังอยู่ในสถานะรอ -->
									<td>
										<?php echo "<span class='text-warning'>".$break_out->request_time.'</span>' ?>
									</td>
								<?php }else{?>
									<td>
										<?php echo !empty($value['break_out']) ? $value['break_out'] : ""?>
									</td>
								<?php } ?>

								<?php if(isset($break_in->request_time)){?> <!-- กรณีมีวันที่ร้องขอลงเวลาย้อนหลังแล้วยังอยู่ในสถานะรอ -->
									<td>
										<?php echo "<span class='text-warning'>".$break_in->request_time.'</span>' ?>
									</td>
								<?php }else{?>
									<td>
										<?php echo !empty($value['break_in']) ? $value['break_in'] : ""?>
									</td>
								<?php } ?>

								<?php if(isset($time_out->request_time)){?> <!-- กรณีมีวันที่ร้องขอลงเวลาย้อนหลังแล้วยังอยู่ในสถานะรอ -->
									<td>
										<?php echo "<span class='text-warning'>".$time_out->request_time.'</span>' ?>
									</td>
								<?php }else{?>
									<td>
										<?php echo !empty($value['time_out']) ? $value['time_out'] : ""?>
									</td>
								<?php } ?>
								</tr>
							<?php }?>
						<?php } ?>
				        </tbody>
				    </table>
				</div>
			</div>
		</div>
	</div>
</section>

<div id="ajax-center-url" data-url="<?php echo route('time_stamp.ajax_center.post')?>"></div>
<div id="add-request-time-stamp" data-url="<?php echo route('time_stamp.add_request_time_stamp.post')?>"></div>
<div id="ip-request-time-stamp" data-url="<?php echo route('time_stamp.ip_request_time_stamp.post')?>"></div>
<?php echo csrf_field()?>
