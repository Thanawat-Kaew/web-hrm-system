<section class="content-header">
	<h3>
		การขอลงเวลาย้อนหลัง |
		<small> Time Stamp Request</small>
	</h3>
</section>
<section class="content">
	<div class="row">
		<div class="col-md-12">
			<div class="box box-danger">
				<div class="box-header">
					รายการคำร้อง
					<!-- <div class="box-tools">
						<div class="input-group input-group-sm" style="width: 150px;">
							<input type="text" name="table_search" class="form-control pull-right" placeholder="ค้นหาชื่อ">

							<div class="input-group-btn">
								<button type="submit" class="btn btn-default"><i class="fa fa-search"></i></button>
							</div>
						</div>
					</div> -->
				</div>

				<div class="box-body table-responsive no-padding">
					<table id="myTable" class="table table-hover table-striped table-bordered">
						<thead>
							<tr>
								<th>#</th>
								<th>ชื่อ-สกุล</th>
								<th>รหัสพนักงาน</th>
								<th>วันที่ลงเวลาย้อนหลัง</th>
								<th>รายละเอียด</th>
								<th style="width: 20px"></th>
								<th>สถานะ</th>
							</tr>
						</thead>
						<?php $count = 0;?>
						<?php foreach($request as $value) : ?>
							<?php $count = $count +1;
							$date  = explode(" ", $value['created_at']);
							$created_date = $date[0];
							?>
								<tr class="aa">
									<td><?php echo $count?></td>
									<td><?php echo $value->employee['first_name']?> <?php echo $value->employee['last_name']?></td>
									<td><?php echo $value['id_employee']?></td>
									<td><?php echo $created_date?></td>
									<td>
										<i class="fa fa-eye fa-lg btn view-data-request-time-stamp" data-id="<?php echo $value['id']?>"></i>
									</td>
									<td style="width: 20px">
										<button style="width: auto;" class="btn btn-primary form-control btn-confirm-data-request-time-stamp <?php echo ($value['status'] == 1 ? 'hide' : ($value['status'] == 3 ? 'hide' : '')); ?>" data-id="<?php echo $value['id']?>">อนุมัติ
										</button>
										<button style="width: auto;" class="btn btn-danger form-control btn-cancel-data-request-time-stamp <?php echo ($value['status'] == 1 ? 'hide' : ($value['status'] == 3 ? 'hide' : '')); ?>" data-id="<?php echo $value['id']?>">ไม่อนุมัติ
										</button>
									</td>
									<td>
										<span class="label <?php echo ($value['status'] == 1 ? 'label-primary' : ($value['status'] == 3 ? 'label-danger' : 'label-warning')); ?>"><?php echo ($value['status'] == 1 ? 'อนุมัติ' : ($value['status'] == 3 ? 'ไม่อนุมัติ' : 'กำลังรอ')); ?>
									</span>
								</td>
							</tr>
					<?php endforeach?>
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