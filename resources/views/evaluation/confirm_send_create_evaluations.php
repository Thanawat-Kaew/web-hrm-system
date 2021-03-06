<section class="content-header">
	<h3>
		การประเมินผล |
		<small> Evaluation</small>
	</h3>
</section>
<style type="text/css">
	.btn-trash:hover {
	background-color: red;
}

.btn-trash {
	border-color: red;
}

</style>
<section class="content">
	<div class="row">
		<div class="col-md-12" >
			<?php if(\Session::has('message')) :?>
				<div class="alert alert-info alert-dismissible" role="alert">
					<button type="button" class="close" data-dismiss="alert" aria-hidden="true">&times;</button>
					<?php echo \Session::get('message') ?>
				</div>
			<?php endif ?>
		</div>
		<div class="col-xs-12">
			<?php if($current_employee->id_department == "hr0001"){?>
				<div class="row button_group">
					<?php if($current_employee->id_position == "2"){?>
					<div class="btn-group pull-right new-evaluation">
						<a href="<?php echo route("evaluation.index.get")?>">
							<button type="button" name="back-page" class='btn btn-success dropdown-toggle'><i class="fa fa-reply"></i> กลับ
							</button>
						</a>
					</div>
					<?php }?>
					<?php if($current_employee->id_position == "1"){?>
					<div class="btn-group pull-right new-evaluation">
						<button type="button" name="add-evaluation" class='btn btn-success dropdown-toggle add-evaluation'><i class="fa fa-plus"></i> สร้างแบบประเมิน
						</button>
					</div>
					<?php }?>
					<div class="btn-group pull-right history_create_evaluations button_history_create_evaluations">
						<div class="btn-group pull-right">
							<a href="<?php echo route("evaluation.history_create_evaluations.get")?>">
								<button class="btn btn-info dropdown-toggle" type="button"><i class="fa fa-history"></i> ประวัติการสร้าง</button>
							</a>
						</div>
					</div>
				</div>
			<?php } ?>
			<div class="box box-info">
				<div class="box-header">
					<h4 class="box-title">ส่งแบบประเมิน</h4>
				</div>
				<div class="box-body table-responsive no-padding">
					<table id="myTable" class="table table-hover">
						<thead>
						<tr>
							<th>รหัสแบบประเมิน</th>
							<th>ประจำปี</th>
							<th>ชื่อแบบประเมิน</th>
							<th>วันที่สร้าง</th>
							<th>ยืนยันการส่ง</th>
							<th>ดู</th>
							<th>แก้ไข</th>
							<th>ลบ</th>
						</tr>
					</thead>
						<?php if(!empty($evaluations)):?>
							<?php foreach($evaluations as $evaluation): //sd($evaluation->toArray());
							$year = explode('-', $evaluation->years);
								//sd($year[0]);
							?>
								<tr class="row-create-evaluation">
								<td><?php echo sprintf("%06d", $evaluation->id_topic); ?></td>
								<td><?php echo $year[0]?></td>
								<td><?php echo $evaluation->topic_name?></td>
								<td><?php echo $evaluation->years?></td>
								<td>
									<i class="btn fa fa-lg fa-check post-confirm-send-create-evaluation" data-id="<?php echo $evaluation['id_topic']?>"></i>
								</td>
								<td>
									<a href="<?php echo route('evaluation.view_create_evaluations_for_index.get', $evaluation->id_topic) ?>">
										<i class="fa fa-eye fa-lg view-create-evaluation" style="color: black;" data-id="<?php echo $evaluation["id_topic"]?>"></i>
									</a>
								</td>
								<td>
									<a href="<?php echo route('evaluation.edit_evaluations.get', $evaluation->id_topic)?>">
										<i class="btn fa fa-lg <?php echo ($evaluation['status'] == 2 ? 'fa-pencil' : ($evaluation['status'] == NULL ? 'fa-pencil' : 'hide')); ?> edit-create-evaluation" data-id="<?php echo $evaluation['id_topic'] ?>"></i>
									</a>
								</td>
								<td>
									<a>
										<i class="fa fa-trash fa-lg btn-remove-topic" data-href="<?php echo route('evaluation.index.post',$evaluation['id_topic']);?>">
										</i>
									</a>
								</td>
							</tr>
						<?php endforeach?>
					<?php endif?>
				</table>
			</div>
		</div>
	</div>
</div>
</section>


<!-- data -->
<div id="ajax-center-url" data-url="<?php echo route('evaluation.ajax_center.post')?>"></div>
<div id="add-evaluation-url" data-url="<?php echo route('evaluation.create_evaluations.get')?>"></div>
<div id="post_confirm-create-evaluations" data-url="<?php echo route('evaluation.post_confirm_send_create_evaluations.post')?>"></div>
<?php echo csrf_field() ?>
