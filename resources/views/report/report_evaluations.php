<section class="content-header">
	<h3>
		การประเมิน |
		<small> Evaluations</small>
	</h3>
</section>
<section class="content">
	<div class="row">
		<div class="col-xs-12">
			<div class="box box-danger">
				<div class="box-header with-border">
					<div class="col-md-3">
						<div class="form-group">
							<label>Department</label>
							<div class="form-group" data-select2-id="13">
								<select class="form-control select2 select2-hidden-accessible" style="width: 100%;border-radius: 5px;" data-select2-id="9" tabindex="-1" aria-hidden="true" id="report-department">
									<option value="">เลือกแผนก...</option>
									<?php foreach($department as $departments):?>
									<option value="<?php echo $departments['id_department']?>"><?php echo $departments['name']?></option>
									<?php endforeach ?>
								</select>
							</div>
						</div>
					</div>
					<div class="col-md-3">
						<div class="form-group">
							<label>เลือกหัวข้อการประเมิน</label>
							<div class="form-group" data-select2-id="13">
								<select class="form-control select2 select2-hidden-accessible" style="width: 100%;border-radius: 5px;" data-select2-id="9" tabindex="-1" aria-hidden="true" id="report-topic-name">
									<option value="">เลือกชื่อแบบประเมิน...</option>
									<?php foreach($topic_name as $topic_names):?>
									<option value="<?php echo $topic_names['id_topic']?>"><?php echo $topic_names['topic_name']?></option>
									<?php endforeach ?>
								</select>
							</div>
						</div>
					</div>
					<div class="col-md-3 pull-right"><br>
						<div class="form-group pull-right">
							<button href="" type="button" class="btn btn-danger dropdown-toggle" data-toggle="dropdown" style="margin-right: 5px;"><i class="fa fa-file-pdf-o"></i> Export to PDF
							</button>
						</div>
					</div>
				</div>
				<div class="box-body">
					<div class="col-md-3">
						<div class="form-group">
							<label>เรื่มวันที่</label>
							<div class="input-group date">
								<div class="input-group-addon">
									<i class="fa fa-calendar"></i>
								</div>
								<input type="text" readonly class="form-control datepicker" id="select_start_date" placeholder="เลือกวันที่..." style="background-color: white">
							</div>
						</div>
					</div>
					<div class="col-md-3">
						<div class="form-group">
							<label>ถึงวันที่</label>
							<div class="input-group date">
								<div class="input-group-addon">
									<i class="fa fa-calendar"></i>
								</div>
								<input type="text" readonly class="form-control datepicker" id="select_end_date" placeholder="เลือกวันที่..." style="background-color: white">
							</div>
						</div>
					</div>
					<div class="col-md-6" style="border-style: double; border-radius: 5px; border-color: red;">
						<div class="col-md-6">
							<div class="form-group">
								<label>ช่วงผลการประเมิน</label>
								<input type="text" class="form-control" id="start_number" placeholder="เริ่ม" style="background-color: white; border-radius: 5px;">
							</div>
						</div>
						<div class="col-md-6">
							<div class="form-group">
								<label> </label>
								<input type="text" class="form-control" id="end_number" placeholder="ถึง" style="background-color: white; border-radius: 5px;">
							</div>
						</div>
					</div>
					<div class="col-md-12" style="margin-top: 10px;">
						<button id="btn-search" class="btn btn-primary pull-right"><i class="fa fa-search"></i> Search</button>
					</div>
				</div>
			</div>

			<div class="box box-info">
				<div class="box-header">
					<h3 class="box-title">ประวัติการลา</h3>
				</div>
				<!-- /.box-header -->
				<div class="box-body table-responsive no-padding">
					<div class="row" id="data-evaluation">
					<table class="table table-hover">
						<tr>
							<th>Name</th>
							<th>Department</th>
							<th>Position</th>
							<th>วันที่ประเมิน</th>
							<th>ผู้ประเมิน</th>
							<th>หัวข้อการประเมิน</th>
							<th>คะแนนการประเมิน</th>
							<th>จากคะแนนเต็ม</th>
							<th>คิดเป็นร้อยละ (%)</th>

						</tr>
						<?php $no = 0; ?>
						<?php $count_assessor = $assessor->count();?>
						<?php for ($i=0; $i < $count_assessor; $i++) { ?>
							<?php //if(!empty($assessor[$i])):?>
							<tr>
								<td style="color: blue"><?php echo $assessor[$i]->employee->first_name;?><?php echo $assessor[$i]->employee->last_name;?></td>
								<td><?php echo $assessor[$i]->employee->department->name?></td>
								<td><?php echo $assessor[$i]->employee->position->name?></td>
								<td><?php echo $assessor[$i]->date?></td>
								<td><?php echo $count_first_name[$no];?> <?php echo $count_last_name[$no];?></td>
								<td><?php echo $count_name_evaluation[$no];?></td>
								<td><?php echo $assessor[$i]->result_evaluation;?></td>
								<td><?php echo $assessor[$i]->from_the_full_score;?></td>
								<td><?php echo $assessor[$i]->percent;?>%</td>
							</tr>
							<?php $no++; ?>
							<?php //endif ?>
						<?php } ?>
					</table>
					</div>
				</div>
				<!-- /.box-body -->
			</div>
			<!-- /.box -->
		</div>
	</div>
</section>
<div id="ajax-center-url" data-url="<?php echo route('report.ajax_center.post')?>"></div>
<?php echo csrf_field()?>
