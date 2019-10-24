<section class="content-header">
	<h3>
		การลงเวลาย้อนหลัง |
		<small> Time Stamp Request</small>
	</h3>
</section>
<section class="content">
	<div class="row">
		<div class="col-md-12">
			<div class="box box-danger">
				<div class="box-header">
					รายการคำร้อง
					<div class="box-tools">
						<div class="input-group input-group-sm" style="width: 150px;">
							<input type="text" name="table_search" class="form-control pull-right" placeholder="ค้นหาชื่อ">

							<div class="input-group-btn">
								<button type="submit" class="btn btn-default"><i class="fa fa-search"></i></button>
							</div>
						</div>
					</div>
				</div>

				<div class="box-body table-responsive no-padding">
					<table class="table table-hover">
						<tr>
							<th>#</th>
							<th>ชื่อ-สกุล</th>
							<th>รหัสพนักงาน</th>
							<th>ว/ด/ป</th>
							<th>รายละเอียด</th>
							<th></th>
							<th></th>
							<th>สถานะ</th>
						</tr>
						<?php $count = 0;?>
						<?php foreach($request as $value) : ?>
						<?php $count = $count +1;?>
						<tr>

							<td><?php echo $count?></td>
							<td><?php echo $value->employee['first_name']?> <?php echo $value->employee['last_name']?></td>
							<td><?php echo $value['id_employee']?></td>
							<td><?php echo $value['delay_time']?></td>
							<td>
								<i class="fa fa-eye fa-lg btn view-data-request-time-stamp" data-id="<?php echo $value['id']?>"></i>
							</td>
							<td>
								<button class="btn btn-primary form-control btn-confirm-data-request-time-stamp <?php echo ($value['status'] == 1 ? 'disabled' : ($value['status'] == 3 ? 'disabled' : '')); ?>" data-id="<?php echo $value['id']?>">อนุมัติ
                                </button>
							</td>
							<td>
								<button class="btn btn-danger form-control btn-cancel-data-request-time-stamp <?php echo ($value['status'] == 1 ? 'disabled' : ($value['status'] == 3 ? 'disabled' : '')); ?>" data-id="<?php echo $value['id']?>">ไม่อนุมัติ
                                </button>
							</td>
							<td>
								<span class="label <?php echo ($value['status'] == 1 ? 'label-primary' : ($value['status'] == 3 ? 'label-danger' : 'label-warning')); ?>"><?php echo ($value['status'] == 1 ? 'อนุมัติ' : ($value['status'] == 3 ? 'ไม่อนุมัติ' : 'กำลังรอ')); ?>
                                </span>
							</td>
						</tr>
						<?php endforeach?>
						<tr>
							<td>2</td>
							<td>ชนะชัย  ชุ่มชื่น</td>
							<td>59</td>
							<td>11-7-2014 19:08:00</td>
							<td><i class="fa fa-eye fa-lg btn"></i></td>
							<td><button class="btn btn-primary form-control btn-confirm disabled">อนุมัติ</button></td>
							<td><button class="btn btn-danger form-control btn-cancel disabled">ไม่อนุมัติ</button></td>
							<td><span class="label label-primary">อนุมัติ</span></td>
						</tr>
					</table>
				</div>
			</div>
		</div>
	</div>
</section>
<div id="ajax-center-url" data-url="<?php echo route('time_stamp.ajax_center.post')?>"></div>
<div id="confirm-data-request-time-stamp" data-url="<?php echo route('time_stamp.confirm-data-request-time-stamp.post')?>"></div>
<div id="cancel-data-request-time-stamp" data-url="<?php echo route('time_stamp.cancel-data-request-time-stamp.post')?>"></div>
<?php echo csrf_field()?>