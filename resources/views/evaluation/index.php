<section class="content-header">
	<h3>
		การประเมินผล |
		<small> Evaluation</small>
	</h3>
</section>
<section class="content">
	<div class="row">
		<div class="col-md-12" >
			<?php if(\Session::has('message')) :?>
				<div class="alert alert-info alert-dismissible" role="alert">
					<p><button type="button" class="close" data-dismiss="alert" aria-hidden="true">&times;</button>
					<?php echo \Session::get('message') ?></p>
				</div>
			<?php endif ?>
		</div>
		<div class="col-xs-12">
			<div class="row">
				<?php if($current_employee->id_department == "hr0001"){?>
					<div class="btn-group pull-right new-evaluation">
						<button type="button" name="add-evaluation" class='btn btn-success dropdown-toggle add-evaluation'><i class="fa fa-plus"></i> สร้างแบบประเมิน
						</button>
					</div>
					<div class="btn-group pull-right history_create_evaluations">
						<div class="btn-group pull-right">
							<a href="<?php echo route("evaluation.history_create_evaluations.get")?>">
								<button class="btn btn-info dropdown-toggle" type="button"><i class="fa fa-history"></i> ประวัติการสร้าง</button>
							</a>
						</div>
					</div>
				<?php } ?>
			<?php if($current_employee->id_position == 2 && $current_employee->id_department == "hr0001"){?>
				<!-- ตั้งเงื่อนไขการมองเห็น -->
				<div class="btn-group pull-right confirm_send_create_evaluations"> <!-- ถ้าเป็นหัวหน้า hr จะมีปุ่มไปหน้ายืนยันการส่ง -->
					<div class="btn-group pull-right">
						<a href="<?php echo route("evaluation.confirm_send_create_evaluations.get")?>">
							<button class="btn btn-danger dropdown-toggle" type="button"><i class="fa fa-check"></i> ยืนยันการส่ง</button>
						</a>
					</div>
				</div>
				<div class="btn-group pull-right check_emp_evaluations"> <!-- ถ้าเป็นหัวหน้า hr จะมีปุ่มไปหน้าเช็คจำนวนคนที่ถูกประเมินตามแผนก -->
					<div class="btn-group pull-right">
						<a href="<?php echo route('evaluation.check_count_evaluations_emp')?>">
							<button class="btn btn-warning dropdown-toggle" type="button"><i class="fa fa-group (alias)"></i> ตรวจสอบพนักงาน</button>
						</a>
					</div>
				</div>
			<?php } ?>
			</div>
			<div class="box box-info">
				<div class="box-header">
					<h4 class="box-title">แบบประเมิน</h4>
				</div>
				<?php //echo $department ;?>
				<div class="box-body table-responsive no-padding">
					<table id="myTable" class="table table-hover">
						<thead>
							<tr>
								<th>รหัสแบบประเมิน</th>
								<!-- <th>ประจำปี</th> -->
								<th>ชื่อแบบประเมิน</th>
								<th>วันที่สร้าง</th>
								<th>วันที่เปิดการประเมิน</th>
								<th>วันที่สิ้นสุดการประเมิน</th>
								<th>เหลือพนักงานที่ต้องประเมิน</th>
								<th>ประเมิน</th>
								<?php if($current_employee->id_position == 2 && $current_employee->id_department == "hr0001" ):?>
								<th>กำหนดเวลา</th>
								<?php endif ?>
								<th>ดูแบบประเมิน</th>
								<?php if($current_employee->id_position == 2 && $current_employee->id_department == "hr0001" ):?>
									<th>ลบ</th>
								<?php endif ?>
							</tr>
						</thead>
						<?php if(!empty($evaluations)):?>
							<?php
								$no = 0;
								foreach($evaluations as $evaluation):
									$year = explode('-', $evaluation->years);
									$today = date('Y-m-d');
									$check_range_date_evaluation = false; // กำหนดตัวแปร check ว่าอยู่ในช่วงการประเมิน
									if($today >= $evaluation->start_date_evaluation && $today <= $evaluation->end_date_evaluation){
										// ถ้าอยู่ในช่วงการประเมิน จะมีค่าเป็น true
										$check_range_date_evaluation = true;
									}else{
										// ถ้าไม่อยู่ในช่วงการประเมิน จะมีค่าเป็น false
										$check_range_date_evaluation = false;
									}
							?>
							<tr class="row-create-evaluation">
								<td><?php echo sprintf("%06d", $evaluation->id_topic); ?></td>
								<!-- <td><?php /*echo $year[0]*/ ?></td> -->
								<td><?php echo $evaluation->topic_name?></td>
								<td><?php echo $evaluation->years?></td>
								<td>
									<?php echo (!empty($evaluation->start_date_evaluation) ? $evaluation->start_date_evaluation : '')?>
								</td>
								<td>
									<?php echo (!empty($evaluation->end_date_evaluation) ? $evaluation->end_date_evaluation : '')?>
								</td>
								<td>
									<?php
										if(isset($check_emp_eva[$no])){
											$answer = $count_emp - $check_emp_eva[$no];
											if($answer == 0){
												echo "ท่านได้ประเมินครบแล้ว";
											}else{
												echo $answer." คน";
											}
										}else{
											echo $count_emp." คน";
										}
									?>
								</td>
							<?php if($current_employee->id_position == 2){?>
								<td>
									<a href="<?php echo route('evaluation.human_assessment.get', $evaluation->id_topic)?>">
										<button type="button" class='btn btn-warning assessment <?php echo ($check_range_date_evaluation == false ) ? 'hide' : '' ?>'>
											<i class="fa fa-check-square-o"></i> ประเมิน
										</button>
									</a>
								</td>
							<?php } ?>
								<!-- <td>
									<a href="<?php //echo route('evaluation.view_create_evaluations_for_index.get', $evaluation->id_topic) ?>"><i class="fa fa-eye fa-lg view-create-evaluation" style="color: black;" data-id="<?php //echo $evaluation["id_topic"]?>"></i></a>
								</td> -->
								<?php if($current_employee->id_position == 2 && $current_employee->id_department == "hr0001" ):?>
								<td>
									<i class="btn fa fa-clock-o fa-lg set_time" data-id_topic="<?php echo $evaluation->id_topic?>"></i>
								</td>
								<?php endif ?>
								<td style="cursor:pointer">
									<!-- <input type="text" id="value_id_eval" name="value_id_eval" value="<?php /*echo $evaluation->id_topic*/ ?>" class="hidden"> -->
									<i class="fa fa-eye fa-lg view-create-evaluation" style="color: black;" data-id_view="<?php echo $evaluation["id_topic"]?>"></i>
									<!-- a href="<?php //echo route('evaluation.view_create_evaluations_for_index.get', $evaluation->id_topic) ?>"><i class="fa fa-eye fa-lg view-create-evaluation" style="color: black;" data-id="<?php //echo $evaluation["id_topic"]?>"></i></a> -->
								</td>

								<?php if($current_employee->id_position == 2 && $current_employee->id_department == "hr0001" ):?>
									<td><a><i class="fa fa-trash fa-lg btn-remove-topic" data-href="<?php echo route('evaluation.index.post',$evaluation['id_topic']);?>"></i></a>
									</td>
								<?php endif ?>
							</tr>
							<?php $no = $no +1?>
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
<div id="set-start_date_end_date_evaluation-url" data-url="<?php echo route('evaluation.set_start_date_end_date_evaluations.post')?>"></div>
<div id="view-create-evaluation-url" data-url="<?php //echo route('evaluation.view_create_evaluations.get')?>"></div>
<?php echo csrf_field() ?>

<!-- data-href="<?php echo $evaluation->id_topic; ?>" -->