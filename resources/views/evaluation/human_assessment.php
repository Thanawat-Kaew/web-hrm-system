<section class="content-header">
	<h3>
		รายชื่อพนักงาน |
		<small> Employee List</small>
	</h3>
</section>
<section class="content">
	<div class="row">
		<div class="col-md-12" >
			<?php if(\Session::has('message')) :?>
				<div class="alert alert-info alert-dismissible" role="alert">
					<p><button type="button" class="close" data-dismiss="alert" aria-hidden="true">&times;</button>
					<?php echo \Session::get('message') ?><p>
				</div>
			<?php endif ?>
		</div>
		<div class="col-xs-12">
			<?php if($current_employee->id_position) : ?>
				<div class="row" style="margin-bottom: 5px;">
					<div class="btn-group pull-right">
						<a target="_blank" href="<?php echo route('evaluation.view_score', $id_topic) ?>">
							<button class="btn btn-info" style="margin-right: 15px;">ดูผลคะแนน</button>
						</a>
					</div>
				</div>
			<?php endif ?>
			<div class="box box-info box_name_emp">
				<div class="box-body">
					<table class="table table-bordered table-hover" id="myTable">
						<tbody>
							<tr>
								<th style="width: 10px">รหัสพนักงาน</th>
								<th style="text-align: left;">ชื่อ-สกุล</th>
								<th style="width: 40px">สถานะ</th>
								<th>ดู</th>
								<th>แก้ไข</th>
							</tr>
							<?php $count_list_name = $list_name->count();?> <!-- นับจำนวนพนักงาน -->
							<?php for($i=0; $i<$count_list_name; $i++){?>
								<tr>
									<td><?php echo $list_name[$i]->id_employee ?></td>
									<?php if($list_name[$i]->evaluation_hasmany->count() > 0){?> <!-- กรณีประเมินแล้ว จะมีค่ามากกว่า 0-->
									<?php $count_eva_has = $list_name[$i]->evaluation_hasmany->count();?> <!-- นับจำนวนหัวข้อที่พนักงานคนที่ถูกประเมิน -->
									<?php $count = 0;?>
									<?php for($j=0; $j<$count_eva_has; $j++){?>
										<?php if($list_name[$i]->evaluation_hasmany[$j]->id_topic == $id_topic->id_topic){?> <!-- กรณีรหัสผู้ถูกประเมินตรงกับ id_topic ของหัวเรื่อง -->
										<?php $count += 1;?>
									<?php }?>
								<?php }?>
								<?php if($count > 0){?> <!-- กรณีพนักงานคนนี้มีการประมินแล้วตรงกับหัวข้อการประเมินนี้ -->
								<td style="text-align: left;"><b><?php echo $list_name[$i]->first_name ?> <?php echo $list_name[$i]->last_name ?></b>
								</td>
								<td><span class="badge bg-green">สำเร็จ</span></td>
								<td style="color: blue; cursor:pointer" >
									<i class="fa fa-eye fa-lg view-evaluation" style="color: black;" data-id="<?php echo $list_name[$i]->id_employee?>" data-id_topic="<?php echo $id_topic->id_topic?>">
									</i>
								</td>
								<td style="color: blue; cursor:pointer" >
									<a href="<?php echo route('evaluation.edit_assessment.get', [$list_name[$i]->id_employee, $id_topic->id_topic])?>">
										<i class="btn fa fa-lg fa-pencil edit-evaluation"></i>
									</a>
								</td>
								<?php }else{?> <!-- กรณีพนักงานคนนี้มีการประมินแล้วไม่ตรงกับหัวข้อการประเมินนี้ -->
								<td style="text-align: left;"><a href="<?php echo route('evaluation.assessment.get', [$list_name[$i]->id_employee, $id_topic->id_topic])?>"><b><?php echo $list_name[$i]->first_name ?> <?php echo $list_name[$i]->last_name ?></b></a>
								</td>
								<td><span class="badge bg-red">ยังไม่ประเมิน</span></td>
							<?php } ?>
							<?php //echo $count;?>
							<?php }else{ ?> <!-- กรณียังไม่ประเมินแล้ว -->
							<td style="text-align: left;"><a href="<?php echo route('evaluation.assessment.get', [$list_name[$i]->id_employee, $id_topic->id_topic])?>"><b><?php echo $list_name[$i]->first_name ?> <?php echo $list_name[$i]->last_name ?></b></a>
							</td>
							<td><span class="badge bg-red">ยังไม่ประเมิน</span></td>
						<?php } ?>

					</tr>
				<?php } ?>

			</tbody>
		</table>
	</div>
</div>
</div>
</div>
</section>

<!-- data -->
<div id="ajax-center-url" data-url="<?php echo route('evaluation.ajax_center.post')?>"></div>
<?php echo csrf_field() ?>