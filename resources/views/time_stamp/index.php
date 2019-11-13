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
									<?php
									$count_request 			= $value->requesttimestamp->count();
									$count_request_status_2 = $value->requesttimestamp->where('status',2)->count();
									?>
									<?php if($count_request && $count_request_status_2 != 0):?>
										<span class="label  label-warning">waiting</span>
									<?php else: ?>
										<span class="label  label-success">success</span>
									<?php endif ?>
								</td>
								<td>
									<?php if($count_request && $count_request_status_2 != 0):?>
										<i class="fa fa-eye fa-lg btn edit-data-request-timestamp" data-id="<?php echo $value['id']?>"></i>
									<?php else: ?>
										<i class="fa fa-eye fa-lg btn view-request-timestamp" data-id="<?php echo $value['id']?>"></i>
									<?php endif ?>
								</td>
							</tr>
						<?php endforeach ?>
					</table>
				</div>
				<!-- /.box-body -->
			</div>
			<!-- /.box -->
		</div>
	</div>
</section>

<div id="ajax-center-url" data-url="<?php echo route('time_stamp.ajax_center.post')?>"></div>
<div id="add-request-time-stamp" data-url="<?php echo route('time_stamp.add_request_time_stamp.post')?>"></div>
<div id="edit-request-time-stamp" data-url="<?php echo route('time_stamp.edit_request_time_stamp.post')?>"></div>
<?php echo csrf_field()?>