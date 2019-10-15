<section class="content-header">
	<h1>
		การลงเวลา |
		<small> Time Stamp</small>
	</h1>
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
							<th>Position</th>
							<th>Date</th>
							<th>Time-In</th>
							<th>Break-In</th>
							<th>Break-Out</th>
							<th>Time-Out</th>
							<th>Status</th>
						</tr>
						<tr>
							<td>ธนวัฒน์ แก้วล้อมวัง</td>
							<td>Web Developer</td>
							<td>11-7-2014</td>
							<td>09:00</td>
							<td>-</td>
							<td>-</td>
							<td>18:00</td>
							<td><span class="label label-warning">กำลังรอ</span></td>
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
<?php echo csrf_field()?>

