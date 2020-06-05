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
								<?php if($current_employee['id_department'] == "hr0001"){?>
								<select class="form-control select2 select2-hidden-accessible choice_department" style="width: 100%;border-radius: 5px;" data-select2-id="9" tabindex="-1" aria-hidden="true" id="report-department">
									<option value="">เลือกแผนก...</option>
									<?php foreach($department as $departments):?>
									<option value="<?php echo $departments['id_department']?>"><?php echo $departments['name']?></option>
									<?php endforeach ?>
								</select>
								<?php }else{?><!-- ไม่ใช่แผนก hr -->
									<input type="text" style="border-radius: 5px;" class="form-control"value="<?php echo $department['name']?>" readonly>
									<input type="text" style="border-radius: 5px;" class="form-control hide"value="<?php echo $current_employee['id_department']?>" id="report-department" readonly>
								<?php }?>
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
							<a type="button" class="btn btn-danger genPDF_evaluation">
								<i class="fa fa-file-pdf-o"></i> Export to PDF
							</a>
						</div>
					</div>
				<?php if($current_employee['id_department'] == "hr0001"){?>
					<div class="col-md-3 hide div_list_name_employee">
						<div class="form-group">
							<label>รายชื่อพนักงาน</label>
							<div class="form-group" data-select2-id="13">
								<select class="form-control select2 select2-hidden-accessible hide list_name_employee" style="width: 100%;border-radius: 5px;" data-select2-id="9" tabindex="-1" aria-hidden="true" id="name_employee">
								</select>
							</div>
						</div>
					</div>
				<?php }else if($current_employee['id_department'] != "hr0001"){?> <!-- ไม่ใช่แผนก hr -->
					<div class="col-md-3">
						<div class="form-group">
							<label>รายชื่อพนักงาน</label>
							<div class="form-group" data-select2-id="13">
								<select class="form-control select2 select2-hidden-accessible" style="width: 100%;border-radius: 5px;" data-select2-id="9" tabindex="-1" aria-hidden="true" id="name_employee">
									<option value="">เลือกลายชื่อพนักงาน...</option>
									<?php foreach($list_employee as $list_employees):?>
									<option value="<?php echo $list_employees->id_employee?>"><?php echo $list_employees->first_name?> <?php echo $list_employees->last_name?>
									</option>
									<?php endforeach ?>
								</select>
							</div>
						</div>
					</div>
				<?php }?>
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
			<div class="box box-info"><br>
				<div class="box-body table-responsive no-padding">
					<div class="row" id="data-evaluation">
					<table class="table table-hover" id="myTable">
						<thead>
							<tr>
								<th>ID</th>
								<th>ชื่อ-สกุล</th>
								<th>แผนก</th>
								<!-- <th>ต่ำแหน่ง</th> -->
								<th>วันที่ประเมิน</th>
								<!-- <th>ผู้ประเมิน</th> -->
								<th>หัวข้อการประเมิน</th>
								<th>รหัสแบบประเมิน</th>
								<th>คะแนนการประเมิน</th>
								<th>จากคะแนนเต็ม</th>
								<th>คิดเป็น(%)</th>
							</tr>
						</thead>
						<?php $no = 0; ?>
						<?php $count_assessor = $assessor->count();?>
						<?php for ($i=0; $i < $count_assessor; $i++) { ?>
							<?php if(!empty($assessor[$i]->employee->department)){?>
								<tr>
									<td><?php echo $assessor[$i]->id_assessor?></td>
									<td style="color: blue; cursor:pointer; text-align: left;" class="name view-evaluation" data-id="<?php echo $assessor[$i]->employee->id_employee?>" data-id_topic="<?php echo $assessor[$i]->id_topic?>"><?php echo $assessor[$i]->employee->first_name;?> <?php echo $assessor[$i]->employee->last_name;?></td>
									<td><?php echo $assessor[$i]->employee->department->name?></td>
									<td><?php echo $assessor[$i]->date?></td>
									<td><?php echo $count_name_evaluation[$no];?></td>
									<td><?php echo $assessor[$i]->id_topic?></td>
									<td><?php echo $assessor[$i]->result_evaluation;?></td>
									<td><?php echo $assessor[$i]->from_the_full_score;?></td>
									<td><?php echo $assessor[$i]->percent;?>%</td>
								</tr>
							<?php $no++; ?>
							<?php } ?>
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
<div id="ajax-center-url-pdf" data-url="<?php echo route('report.pdf.pdf_evaluations.post')?>"></div>
<?php echo csrf_field()?>