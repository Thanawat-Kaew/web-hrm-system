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
				<div class="btn-group pull-right ">
					<a href="<?php echo route('request_history.get')?>">
						<button type="button" class="btn btn-warning dropdown-toggle"><i class="fa fa-history"></i> History
						</button>
					</a>
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
									<?php if($count_request_status_2 != 0):?>
										<span class="label  label-warning">waiting</span>
										<?php else: ?>
											<span class="label  label-success">success</span>
										<?php endif ?>
									</td>
									<td>
										<i class="fa fa-eye fa-lg btn view-data"></i>
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
	<div id="add-request-forget-to-time" data-url="<?php echo route('time_stamp.add_request_forget_to_time.post')?>"></div>
	<?php echo csrf_field()?>