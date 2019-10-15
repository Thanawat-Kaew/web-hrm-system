<section class="content-header">
	<h1>
		การจัดการคำร้อง |
		<small> Amendment Manage</small>
	</h1>
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
							<th>เรื่อง</th>
							<th>ว/ด/ป</th>
							<th>รายละเอียด</th>
							<th>สถานะ</th>
							<th></th>
							<th></th>
						</tr>
						<?php $count = 0;?>
						<?php foreach($request as $value) : ?>
						<?php $count = $count + 1;?>
						<tr>
							<td><?php echo $count?></td>
							<td><?php echo $value['first_name'] ?> <?php echo $value['last_name'] ?></td>
							<td><?php echo $value['reason']?></td>
							<td><?php echo $value['created_at'] ?></td>
							<td><i class="fa fa-eye fa-lg btn view-data-request" data-id="<?php echo $value['id']?>"></i></td>
							<td>
								<span class="label <?php echo ($value['status'] == 1 ? 'label-primary' : ($value['status'] == 3 ? 'label-danger' : '')); ?>"><?php echo ($value['status'] == 1 ? 'อนุมัติ' : ($value['status'] == 3 ? 'ไม่อนุมัติ' : '')); ?>
                                </span>
							</td>
							<td>
								<button class="btn btn-primary form-control btn-confirm-data-request <?php echo ($value['status'] == 1 ? 'disabled' : ($value['status'] == 3 ? 'disabled' : '')); ?>" data-id="<?php echo $value['id']?>">อนุมัติ
                                </button>
							</td>
							<td>
								<button class="btn btn-danger form-control btn-cancel-data-request <?php echo ($value['status'] == 1 ? 'disabled' : ($value['status'] == 3 ? 'disabled' : '')); ?>" data-id="<?php echo $value['id']?>" data-href="<?php echo route('personal_info.delete_employee.post',$value['id']);?>">ไม่อนุมัติ
                                    </button>
							</td>
						</tr>
						<?php endforeach?>
						<tr>
							<td>2</td>
							<td>ชนะชัย  ชุ่มชื่น</td>
							<td>ขอเปลี่ยนแปลงข้อมูลส่วนตัว</td>
							<td>11-7-2014 19:08:00</td>
							<td><i class="fa fa-eye fa-lg btn" ></i></td>
							<td><span class="label label-primary">อนุมัติ</span></td>
							<td><button class="btn btn-primary form-control btn-confirm disabled">อนุมัติ</button></td>
							<td><button class="btn btn-danger form-control btn-cancel disabled">ไม่อนุมัติ</button></td>
						</tr>
					</table>
				</div>
			</div>
		</div>
	</div>
</section>
<div id="ajax-center-url" data-url="<?php echo route('data_manage.ajax_center.post')?>"></div>
<div id="confirm-ajax-center-url" data-url="<?php echo route('data_manage.confirm_data_request.post')?>"></div>
<div id="cancel-ajax-center-url" data-url="<?php echo route('data_manage.cancel_data_request.post')?>"></div>
<?php echo csrf_field()?>