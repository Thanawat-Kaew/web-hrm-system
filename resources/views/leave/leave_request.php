<section class="content-header">
	<h3>
		คำร้องขอลา |
		<small> Leaves Request</small>
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
					<table id="mydatatables" class="table table-hover table-striped table-bordered">
						<thead>
							<tr>
								<th>#</th>
								<th>ชื่อ-สกุล</th>
								<th>วันที่ดำเนินการ</th>
								<th>ประเภทการลา</th>
								<th>จำนวน (ชั่วโมง)</th>
								<th>รายละเอียด</th>
								<th style="width: 20px"></th>
								<th>สถานะ</th>
							</tr>
						</thead>
						<?php $count = 0;?>
						<?php foreach($request as $key => $value) : ?>
							<?php $count = $count +1;
							$date  = explode(" ", $value['created_at']);
							$created_date = $date[0]; ?>
							<?php if(\Session::has('current_employee')) :?>
								<tbody>
									<tr>
										<?php $current_employee = \Session::get('current_employee') ?>
										<td><?php echo $count?></td>
										<td><?php echo $value->employee['first_name']?> <?php echo $value->employee['last_name']?></td>
										<td><?php echo $created_date?></td>
										<td><?php echo $value->leaves_type->leaves_name?></td>
										<td><?php echo $value['total_leave']?></td>
										<td>
											<i class="fa fa-eye fa-lg btn view-data-request-leaves" data-id="<?php echo $value['id_leave']?>"></i>
										</td>
										<td style="width: 20px">
											<button style="width: auto;" class="btn btn-primary form-control btn-confirm-data-request-leave <?php echo ($value['status_leave'] == 1 ? 'hide' : ($value['status_leave'] == 3 ? 'hide' : '')); ?>" data-id="<?php echo $value['id_leave']?>">อนุมัติ
											</button>

											<button style="width: auto;" class="btn btn-danger form-control btn-cancel-data-request-leave <?php echo ($value['status_leave'] == 1 ? 'hide' : ($value['status_leave'] == 3 ? 'hide' : '')); ?>" data-id="<?php echo $value['id_leave']?>">ไม่อนุมัติ
											</button>
										</td>
										<td>
											<span class="label <?php echo ($value['status_leave'] == 1 ? 'label-primary' : ($value['status_leave'] == 3 ? 'label-danger' : 'label-warning')); ?>"><?php echo ($value['status_leave'] == 1 ? 'อนุมัติ' : ($value['status_leave'] == 3 ? 'ไม่อนุมัติ' : 'กำลังรอ')); ?>
										</span>
									</td>
								</tr>
							</tbody>
						<?php endif ?>
					<?php endforeach?>

					<tfoot>
						<tr>
							<th>#</th>
							<th>ชื่อ-สกุล</th>
							<th>วันที่ดำเนินการ</th>
							<th>ประเภทการลา</th>
							<th>จำนวน (วัน)</th>
							<th>รายละเอียด</th>
							<th style="width: 20px"></th>
							<th>สถานะ</th>
						</tr>
					</tfoot>
				</table>
			</div>
		</div>
	</div>
</div>
</section>
<div id="ajax-center-url" data-url="<?php echo route('leave.ajax_center.post')?>"></div>
<?php echo csrf_field()?>
<div id="confirm-data-request-leave" data-url="<?php echo route('leaves.confirm-data-request-leave.post')?>"></div>
<div id="cancel-data-request-leave" data-url="<?php echo route('leaves.cancel-data-request-leave.post')?>"></div>
