<section class="content-header">
	<h3>
		ประวัติการขอลงเวลาย้อนหลัง |
		<small> History of past time requests</small>
	</h3>
	<div class="btn-group pull-right">
		<a href="<?php echo route("time_stamp.index.get")?>">
			<button type="button" name="back-page" class='btn btn-success dropdown-toggle'><i class="fa fa-reply"></i> กลับ
			</button>
		</a>
	</div>
</section>
<section class="content">
	<div class="row">
		<div class="col-xs-12">
			<div class="box box-info"><br>
				<div class="box-body table-responsive no-padding">
					<table class="table table-hover" id="myTable">
						<thead>
							<tr>
								<th>วันที่</th>
								<th>ประเภท</th>
								<th>เวลา</th>
								<th>เหตุผล</th>
								<th>สถานะ</th>
								<th></th>
							</tr>
						</thead>
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
								<td><?php echo $value['created_at'] ?></td>
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
			</div>
		</div>
	</div>
</section>
<div id="ajax-center-url" data-url="<?php echo route('time_stamp.ajax_center.post')?>"></div>
<div id="edit-request-time-stamp" data-url="<?php echo route('request_history.edit_request_time_stamp.post')?>"></div>
<?php echo csrf_field()?>