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
				<div class="btn-group dropup-new-record pull-right ">
					<button href="" type="button" class='btn btn-danger dropdown-toggle add-new-record' data-toggle="dropdown"><i class="fa fa-plus"></i> New Record
					</button>
				</div>
				<div class="btn-group pull-right time-clock">
					<button type="button" class='btn btn-info time_stamp'><i class="fa fa-clock-o"></i> Time Clock
					</button>
				</div>
				<div class="btn-group history_record pull-right ">
					<button href="" type="button" class="btn btn-warning dropdown-toggle history_new_record"><i class="fa fa-history"></i> History
					</button>
				</div>
			</div>
			<div class="box box-info">
				<div class="box-header">
					<h3 class="box-title">ประวัติการลงเวลา</h3>

					<div class="box-tools">
						<div class="input-group input-group-sm" style="width: 150px;">
							<input type="text" name="table_search" class="form-control pull-right" placeholder="Search">

							<div class="input-group-btn">
								<button type="submit" class="btn btn-default"><i class="fa fa-search"></i></button>
							</div>
						</div>
					</div>
				</div>

				<!-- /.box-header -->
				<div class="box-body table-responsive no-padding">
					<table class="table table-hover">
						<tr>
							<th>Name</th>
							<th>Date</th>
							<th>Time-In</th>
							<th>Break-Out</th>
							<th>Break-In</th>
							<th>Time-Out</th>
							<th>Status</th>
							<th></th>
						</tr>
						<?php
						foreach($data as $value) :
							?>
							<tr>
								<td><?php echo $value->employee['first_name']?> <?php echo $value->employee['last_name']?></td>
								<td><?php echo $value['date']?></td>
								<td><?php echo $value['time_in']?></td>
								<td><?php echo $value['break_out']?></td>
								<td><?php echo $value['break_in']?></td>
								<td><?php echo $value['time_out']?></td>
								<td>
									<?php echo (!empty($value->requesttimestamp[0])  ? $value->requesttimestamp[0]['status'] : "")?>
									<?php
									if(!empty($value->requesttimestamp[0])){
										?>
										<span class="label <?php echo ($value->requesttimestamp[0]['status'] == 1 ? 'label-success' : ($value->requesttimestamp[0]['status'] == 2 ? 'label-warning' : 'label-danger')); ?>"><?php echo ($value->requesttimestamp[0]['status'] == 1 ? 'success' : ($value->requesttimestamp[0]['status'] == 2 ? 'waiting' : 'rejected')); ?>
									</span>
									<?php
								}else{
									echo "None";
								}
								?>
							</td>
							<td></td>
						</tr>
					<?php endforeach ?>
					<tr>
						<td>ธนวัฒน์ แก้วล้อมวัง</td>
						<td>11-7-2014</td>
						<td>09:00</td>
						<td>-</td>
						<td>-</td>
						<td>18:00</td>
						<td><span class="label label-warning">waiting</span></td>
						<td>
							<i class="fa fa-pencil btn" >
							</i>

							<i class="fa fa-trash btn" >
							</i>
							<i class="fa fa-eye fa-lg btn view-data"></i>
						</td>

					</tr>
					<tr>
						<td>ธนวัฒน์ แก้วล้อมวัง</td>
						<td>11-7-2014</td>
						<td>09:00</td>
						<td>-</td>
						<td>-</td>
						<td>18:00</td>
						<td><span class="label label-success">success</span></td>
						<td><i class="fa fa-eye fa-lg btn view-data"></i></td>
					</tr>
					<tr>
						<td>ธนวัฒน์ แก้วล้อมวัง</td>
						<td>11-7-2014</td>
						<td>09:00</td>
						<td>-</td>
						<td>-</td>
						<td>18:00</td>
						<td><span class="label label-danger">rejected</span></td>
						<td><i class="fa fa-eye fa-lg btn view-data"></i></td>
					</tr>
					<tr>
						<td>ธนวัฒน์ แก้วล้อมวัง</td>
						<td>11-7-2014</td>
						<td>09:00</td>
						<td>-</td>
						<td>-</td>
						<td>18:00</td>
						<td></td>
						<td></td>
					</tr>
				</table>
			</div>
			<!-- /.box-body -->
		</div>
		<!-- /.box -->
	</div>
</div>
</section>

<!-- data -->
<div id="ajax-center-url" data-url="<?php echo route('time_stamp.ajax_center.post')?>"></div>
<div id="add-request-time-stamp" data-url="<?php echo route('time_stamp.add_request_time_stamp.post')?>"></div>
<div id="add-request-forget-to-time" data-url="<?php echo route('time_stamp.add_request_forget_to_time.post')?>"></div>
<?php echo csrf_field()?>