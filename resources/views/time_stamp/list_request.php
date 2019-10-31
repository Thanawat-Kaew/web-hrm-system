<section class="content-header">
	<h3>
		การร้องขอ |
		<small> Request</small>
	</h3>
</section>
<section class="content">
	<div class="row">
		<div class="col-xs-6">
			<div class="box box-info">
				<div class="box-header">
					<h3 class="box-title">การขอลงเวลาย้อนหลัง  (New Record, request-time-stamp)</h3>
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
							<th>#</th>
							<th>วันที่</th>
							<th>เรื่อง</th>
							<th>สถานะ</th>
							<th></th>
							<th></th>
							<th>รายละเอียด</th>
						</tr>
						<?php $count = 0;
							foreach($request_time_stamp as $value) :
						 	$count = $count + 1;
						?>
						<tr>
							<td><?php echo $count ?></td>
							<td><?php echo $value['created_at']?></td>
							<td><?php echo $value['reason']?></td>
							<td>
								<span class="label <?php echo ($value['status'] == 1 ? 'label-success' : ($value['status'] == 2 ? 'label-warning' : 'label-danger')); ?>"><?php echo ($value['status'] == 1 ? 'อนุมัติแล้ว' : ($value['status'] == 2 ? 'กำลังรอ' : 'ไม่อนุมัติ')); ?>
                            	</span>
							</td>
							<td>
								<span class="btn btn-warning form-control edit-request-time-stamp" data-id="<?php echo $value['id']?>">แก้ไข</span>
							</td>
							<td>
								<span class="btn btn-danger form-control">ลบ</span>
							</td>
							<td>
								<i class="fa fa-eye fa-lg btn view-request-time-stamp" data-id="<?php echo $value['id']?>"></i>
							</td>
						</tr>
					    <?php endforeach ?>
					</table>
				</div>
				<!-- /.box-body -->
			</div>
			<!-- /.box -->
		</div>
		<div class="col-xs-6">
			<div class="box box-danger">
				<div class="box-header">
					<h3 class="box-title">การแก้ไขการลงเวลา (ลืมลงเวลา, forget-to-time)</h3>
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
							<th>#</th>
							<th>วันที่</th>
							<th>เรื่อง</th>
							<th>สถานะ</th>
							<th></th>
							<th></th>
							<th>รายละเอียด</th>
						</tr>
						<?php $count = 0;
							foreach($request_forget_to_time as $value) :
						 	$count = $count + 1;
						?>
						<tr>
							<td><?php echo $count ?></td>
							<td><?php echo $value['created_at']?></td>
							<td><?php echo $value['reason']?></td>
							<td>
								<span class="label <?php echo ($value['status'] == 1 ? 'label-success' : ($value['status'] == 2 ? 'label-warning' : 'label-danger')); ?>"><?php echo ($value['status'] == 1 ? 'อนุมัติแล้ว' : ($value['status'] == 2 ? 'กำลังรอ' : 'ไม่อนุมัติ')); ?>
                            	</span>
							</td>
							<td>
								<span class="btn btn-warning form-control edit-request-forget-to-time" data-id="<?php echo $value['id']?>">แก้ไข</span>
							</td>
							<td>
								<span class="btn btn-danger form-control">ลบ</span>
							</td>
							<td>
								<i class="fa fa-eye fa-lg btn view-request-forget-to-time" data-id="<?php echo $value['id']?>"></i>
							</td>
						</tr>
					    <?php endforeach ?>
						<tr>
							<td>2</td>
							<td>12-7-2014</td>
							<td>แก้ไขการลงเวลา</td>
							<td><span class="label label-success">อนุมัติ</span></td>
							<td><span class="btn btn-warning form-control disabled">แก้ไข</span></td>
							<td><span class="btn btn-danger form-control disabled">ลบ</span></td>
							<td><i class="fa fa-eye fa-lg btn"></i></td>
						</tr>
					</table>
				</div>
				<!-- /.box-body -->
			</div>
			<!-- /.box -->
		</div>
	</div>
</section>
<div id="ajax-center-url" data-url="<?php echo route('time_stamp.ajax_center.post')?>"></div>
<div id="update-edit-request-timestamp" data-url="<?php echo route('time_stamp.update_request_time_stamp.post')?>"></div>
<?php echo csrf_field()?>