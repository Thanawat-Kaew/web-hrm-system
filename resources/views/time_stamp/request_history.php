<section class="content-header">
	<h3>
		การลงเวลา |
		<small> Time Stamp</small>
	</h3>
</section>
<section class="content">
	<div class="row">
		<div class="col-xs-12">
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
					<table class="table table-hover" id="myTable">
						<tr>
							<th>วันที่</th>
							<th>ประเภท</th>
							<th>เวลา</th>
							<th>เหตุผล</th>
							<th>สถานะ</th>
							<th></th>
						</tr>
						<?php foreach($request as $value) :
							  $date  = explode(" ", $value['created_at']);
							  $created_date = $date[0];
							  $created_time = $date[1];
							  if($value['request_type'] == "time_in"){
							  	$type = "การลงเวลาเข้าทำงาน";
							  }else if($value['request_type'] == "break_out"){
							  	$type = "การลงเลาพักกลางวัน";
							  }else if($value['request_type'] == "break_in"){
							  	$type = "การลงเวลาเข้าทำงานช่วงบ่าย";
							  }else if($value['request_type'] == "time_out"){
							  	$type = "การลงเวลาออกงาน";
							  }
						?>
						<tr>
							<td><?php echo $value['request_date'] ?></td>
							<td><?php echo $type?></td>
							<td><?php echo $created_time?></td>
							<td><?php echo $value['reason']?></td>
							<td>
								<span class="label <?php echo ($value['status'] == 1 ? 'label-primary' : ($value['status'] == 3 ? 'label-danger' : 'label-warning')); ?>"><?php echo ($value['status'] == 1 ? 'อนุมัติ' : ($value['status'] == 3 ? 'ไม่อนุมัติ' : 'กำลังรอ')); ?>
                                </span>
							</td>
							<td style="text-align: end;">
								<i class="btn fa <?php echo ($value['status'] == 2 ? 'fa-pencil' : 'hide'); ?> edit-data-request-timestamp" data-id="<?php echo $value['id'] ?>"></i>
								<i class="btn fa fa-trash delete-data" data-href="<?php echo route('timestamp.delete_request_history.post',$value['id']);?>"></i>
								<i class="btn fa fa-eye view-request-timestamp" data-id="<?php echo $value['id'] ?>"></i>
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
<div id="edit-request-time-stamp" data-url="<?php echo route('request_history.edit_request_time_stamp.post')?>"></div>
<?php echo csrf_field()?>