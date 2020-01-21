<section class="content-header">
	<h3>
		การประเมินผล |
		<small> Evaluation</small>
	</h3>
</section>
<section class="content">
	<div class="row">
		<div class="col-xs-12">
			<div class="row">
				<div class="btn-group pull-right new-evaluation">
					<button type="button" name="add-evaluation" class='btn btn-success dropdown-toggle add-evaluation'><i class="fa fa-plus"></i> สร้างแบบประเมิน
					</button>
				</div>
				<div class="btn-group pull-right assess-evaluation">
					<button type="button" class='btn btn-warning assessment'><i class="fa fa-check-square-o"></i> ประเมิน
					</button>
				</div>
			</div>
			<div class="box box-info">
				<div class="box-header">
					<h4 class="box-title">ประวัติการสร้างแบบประเมิน</h4>

					<div class="box-tools">
						<div class="input-group input-group-sm" style="width: 150px;">
							<input type="text" name="table_search" class="form-control pull-right" placeholder="Search">

							<div class="input-group-btn">
								<button type="submit" class="btn btn-default"><i class="fa fa-search"></i></button>
							</div>
						</div>
					</div>
				</div>
				<div class="box-body table-responsive no-padding">
					<table class="table table-hover">
						<tr>
							<th>รหัสแบบประเมิน</th>
							<th>ประจำปี</th>
							<th>ชื่อแบบประเมิน</th>
							<th>วันที่สร้าง</th>
							<th>สถานะ</th>
							<th>ดู</th>
							<th>แก้ไข</th>
							<th>ลบ</th>
						</tr>
						<?php if(!empty($evaluations)):?>
							<?php foreach($evaluations as $evaluation): //sd($evaluation->toArray());
								$year = explode('-', $evaluation->years);
								//sd($year[0]);
							?>
								<tr>
									<td><?php echo sprintf("%06d", $evaluation->id_topic); ?></td>
									<td><?php echo $year[0]?></td>
									<td><?php echo $evaluation->topic_name?></td>
									<td><?php echo $evaluation->years?></td>
									<td><span class="label label-success">Approved</span></td>
									<td><a href="<?php echo route('evaluation.view_create_evaluations.get', $evaluation->id_topic)?>"><button class="btn btn-info form-control view-create-evaluation"  data-id="<?php echo $evaluation["id_topic"]?>"><i class="fa fa-eye"></i></button></a></td>
									<td><a href="<?php echo route('evaluation.edit_evaluations.get', $evaluation->id_topic)?>"><button class="btn btn-warning form-control"><i class="fa fa-pencil"></i></button></a></td>
									<td><button class="btn btn-danger form-control"><i class="fa fa-trash"></i></button>
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
<div id="view-create-evaluation-url" data-url="<?php //echo route('evaluation.view_create_evaluations.get')?>"></div>
<?php echo csrf_field() ?>