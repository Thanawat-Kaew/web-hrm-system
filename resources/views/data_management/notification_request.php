<section class="content-header">
	<h3>
		การจัดการคำร้อง |
		<small> Amendment Manage</small>
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
							<input type="text" id="myInput" name="table_search" class="form-control pull-right" placeholder="ค้นหาชื่อ">

							<div class="input-group-btn">
								<button type="submit" class="btn btn-default"><i class="fa fa-search"></i></button>
							</div>
						</div>
					</div>
				</div>

				<div class="box-body table-responsive no-padding">
					<table id="myTable" class="table table-hover">
						<tr>
							<th>#</th>
							<th>ชื่อ-สกุล</th>
							<th>เรื่อง</th>
							<th>ว/ด/ป</th>
							<th>รายละเอียด</th>
							<th style="width: 20px;"></th>
							<th>สถานะ</th>
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
								<button style="width: auto;" class="btn btn-primary form-control btn-confirm-data-request <?php echo ($value['status'] == 1 ? 'hide' : ($value['status'] == 3 ? 'hide' : '')); ?>" data-id="<?php echo $value['id']?>">อนุมัติ
                                </button>
								<button style="width: auto;" class="btn btn-danger form-control btn-cancel-data-request <?php echo ($value['status'] == 1 ? 'hide' : ($value['status'] == 3 ? 'hide' : '')); ?>" data-id="<?php echo $value['id']?>" data-href="<?php echo route('personal_info.delete_employee.post',$value['id']);?>">ไม่อนุมัติ
                                    </button>
							</td>
							<td>
								<span class="label <?php echo ($value['status'] == 1 ? 'label-primary' : ($value['status'] == 3 ? 'label-danger' : 'label-warning')); ?>"><?php echo ($value['status'] == 1 ? 'อนุมัติ' : ($value['status'] == 3 ? 'ไม่อนุมัติ' : 'กำลังรอ')); ?>
                                </span>
							</td>
						</tr>
						<?php endforeach ?>
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