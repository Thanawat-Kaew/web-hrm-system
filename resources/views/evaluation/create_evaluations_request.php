<section class="content-header">
	<h3>
		การขออนุมัติการสร้างแบบประเมิน |
		<small> The Approves Created Evaluation Request</small>
	</h3>
</section>
<section class="content">
	<div class="row">
		<div class="col-md-12">
			<div class="box box-danger">
				<div class="box-header">
					รายการขออนุมัติ
					<div class="box-tools">
						<div class="input-group input-group-sm" style="width: 150px;">
							<input type="text" id="myInput" name="table_search" class="form-control pull-right" placeholder="ค้นหาชื่อแบบประเมิน" style="width: auto;">

							<div class="input-group-btn">
								<button type="submit" class="btn btn-default"><i class="fa fa-search"></i></button>
							</div>
						</div>
					</div>
				</div>

				<div class="box-body table-responsive no-padding">
					<table id="myTable" class="table table-hover table-striped table-bordered">
						<thead>
							<tr>
								<th>#</th>
								<th>ผู้สร้าง</th>
								<th>รหัสแบบประเมิน</th>
								<th>ชื่อแบบประเมิน</th>
								<th>ประจำปี</th>
								<th>วันที่สร้าง</th>
								<th>รายละเอียด</th>
								<th style="width: 20px"></th>
								<th>สถานะ</th>
							</tr>
						</thead>

						<tbody>
							<?php $no = 0;?>
							<?php foreach($evaluations as $value):?>
							<?php $no++;?>
							<?php $year = explode('-', $value->years);?>
							<tr>
								<td><?php echo $no;?></td>
								<td><?php echo $value->employee->first_name;?> <?php echo $value->employee->last_name;?></td>
								<td><?php echo sprintf("%06d", $value->id_topic);?></td>
								<td><?php echo $value->topic_name;?></td>
								<td><?php echo $year[0]?></td>
								<td><?php echo $value->years?></td>
								<td>
									<a href="<?php echo route('evaluation.view_create_evaluations.get', $value->id_topic)?>"><i class="fa fa-eye fa-lg btn-view" data-id="<?php echo $value['id_topic'] ?>"></i>
									</a>
								</td>
								<td style="width: 20px">
									<?php if($value->status == 2):?>
										<button style="width: auto;" class="btn btn-primary form-control btn-confrim" data-id="<?php echo $value->id_topic;?>">อนุมัติ
										</button>
										<button style="width: auto;" class="btn btn-danger form-control btn-cancel" data-id="<?php echo $value->id_topic;?>">ไม่อนุมัติ
										</button>
									<?php endif ?>
								</td>
								<td><span class="label <?php echo ($value['status'] == 1 ? 'label-success' : ($value['status'] == 3 ? 'label-danger' : 'label-warning')); ?>"><?php echo ($value['status'] == 1 ? 'อนุมัติ' : ($value['status'] == 3 ? 'ไม่อนุมัติ' : 'กำลังรอ')); ?>
									</span>
								</td>
							</tr>
							<?php endforeach ?>
							<tr>
								<td>1</td>
								<td>ประชา สันติ</td>
								<td>000020</td>
								<td>แบบประเมินผลประจำปี XXXX</td>
								<td>2023</td>
								<td>2022-12-25</td>
								<td><i class="fa fa-eye fa-lg btn"></i></td>
								<td style="width: 20px">
									<button style="width: auto;" class="btn btn-primary form-control">อนุมัติ
									</button>
									<button style="width: auto;" class="btn btn-danger form-control">ไม่อนุมัติ
									</button>
								</td>
								<td><span class="label label-warning">กำลังรอ</span></td>
							</tr>

							<tr>
								<td>2</td>
								<td>ประชา สันติ</td>
								<td>000020</td>
								<td>แบบประเมินผลประจำปี XXXX</td>
								<td>2024</td>
								<td>2023-12-25</td>
								<td><i class="fa fa-eye fa-lg btn"></i></td>
								<td style="width: 20px">
									<button style="width: auto;" class="btn btn-primary form-control">อนุมัติ
									</button>
									<button style="width: auto;" class="btn btn-danger form-control">ไม่อนุมัติ
									</button>
								</td>
								<td><span class="label label-danger">ไม่อนุมัติ</span></td>
							</tr>
							<tr>
								<td>3</td>
								<td>ประชา สันติ</td>
								<td>000020</td>
								<td>แบบประเมินผลประจำปี XXXX</td>
								<td>2025</td>
								<td>2024-12-25</td>
								<td><i class="fa fa-eye fa-lg btn"></i></td>
								<td style="width: 20px">
									<button style="width: auto;" class="btn btn-primary form-control">อนุมัติ
									</button>
									<button style="width: auto;" class="btn btn-danger form-control">ไม่อนุมัติ
									</button>
								</td>
								<td><span class="label label-success">อนุมัติ</span></td>
							</tr>
						</tbody>
					</table>
				</div>
			</div>
		</div>
	</div>
</section>
<div id="ajax-center-url" data-url="<?php echo route('evaluation.ajax_center.post')?>"></div>
<div id="confirm-create-evaluation" data-url="<?php echo route('evaluation.confirm-create-evaluation.post')?>"></div>
<div id="cancel-create-evaluation" data-url="<?php echo route('evaluation.cancel-create-evaluation.post')?>"></div>
<?php echo csrf_field()?>