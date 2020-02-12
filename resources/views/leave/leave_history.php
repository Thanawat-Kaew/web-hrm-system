<section class="content-header">
	<h3>
		การลา |
		<small> Leave</small>
	</h3>
</section>
<section class="content">
	<div class="row">
		<div class="col-xs-12">
			<div class="box box-info">
				<div class="box-header">
					<h3 class="box-title">ประวัติการลา</h3>
					<div class="box-tools">
						<div class="input-group input-group-sm" style="width: 150px;">
							<input type="text" id="myInput" name="table_search" class="form-control pull-right" placeholder="Search">

							<div class="input-group-btn">
								<button type="submit" class="btn btn-default"><i class="fa fa-search"></i></button>
							</div>
						</div>
					</div>
				</div>

				<div class="box-body table-responsive no-padding">
					<table id="myTable" class="table table-striped table-bordered" style="width:100%">
						<thead>
							<tr>
								<th>#</th>
								<th>วันที่ดำเนินการ</th>
								<th>ประเภทการลา</th>
								<th>เวลา</th>
								<th>เหตุผล</th>
								<th>สถานะ</th>
								<th></th>
							</tr>
						</thead>
						<?php $count = 0;?>
						<?php foreach($request as $key => $value) : ?>
							<?php $count = $count +1;
							$date  = explode(" ", $value['created_at']);
							$created_date = $date[0];
							$created_time = $date[1]; ?>
							<?php if(\Session::has('current_employee')) :?>
								<tbody>	
									<tr>
										<?php $current_employee = \Session::get('current_employee') ?>
										<td><?php echo $count?></td>
										<td><?php echo $created_date?></td>
										<td><?php echo $value->leaves_type->leaves_name?></td>
										<td><?php echo $created_time?></td>
										<td><?php echo $value['reason']?></td>
										<td>
											<span class="label <?php echo ($value['status_leave'] == 1 ? 'label-primary' : ($value['status_leave'] == 3 ? 'label-danger' : 'label-warning')); ?>"><?php echo ($value['status_leave'] == 1 ? 'อนุมัติ' : ($value['status_leave'] == 3 ? 'ไม่อนุมัติ' : 'กำลังรอ')); ?>
										</span>
									</td>
									<td style="text-align: end;">
										<i class="btn fa fa-lg <?php echo ($value['status_leave'] == 2 ? 'fa-pencil' : 'hide'); ?> edit-data-request-leave" data-id="<?php echo $value['id_leave'] ?>"></i>
										<i class="btn fa fa-lg fa-trash delete-data" data-href="<?php echo route('leaves.delete_leave_history.post',$value['id_leave']);?>" style="color: red;"></i>
										<i class="btn fa fa-lg fa-eye view-request-leave" data-id="<?php echo $value['id_leave'] ?>"></i>
									</td>
								</tr>
							</tbody>
						<?php endif ?>
					<?php endforeach?>
				</table>
			</div>
		</div>
	</div>
</div>
</section>
<div id="ajax-center-url" data-url="<?php echo route('leave.ajax_center.post')?>"></div>
<div id="edit-request-leave" data-url="<?php echo route('request_history.edit_request_leave.post')?>"></div>
<?php echo csrf_field()?>