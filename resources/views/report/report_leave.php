<header>
	<style type="text/css">
		#myTable_filter{
			display: none !important;
		}
	</style>
</header>
<section class="content-header">
	<h3>
		การลา |
		<small> Leave</small>
	</h3>
</section>
<section class="content">
	<div class="row">
		<div class="col-xs-12">
			<div class="box box-danger">
				<div class="box-header with-border">
					<div class="col-md-6">
						<div class="form-group">
							<label>Department</label>
							<div class="form-group" data-select2-id="13">
								<?php if($current_employee['id_department'] == "hr0001"){?>
									<select class="form-control select2 select2-hidden-accessible" style="width: 100%;border-radius: 5px;" data-select2-id="9" tabindex="-1" aria-hidden="true" id="report-department">
										<option value="">เลือกแผนก...</option>
										<?php foreach($department as $departments):?>

											<option value="<?php echo $departments['id_department']?>"><?php echo $departments['name']?></option>
										<?php endforeach ?>
									</select>
								<?php }else{?>
									
									<input type="text" style="border-radius: 5px;" id="report-department" class="form-control"value="<?php echo $current_employee['id_department']?>">
								<?php }?>
							</div>
						</div>
					</div>
					<div class="col-md-3 pull-right"><br>
						<div class="form-group pull-right">
							<a type="button" class="btn btn-primary genPDF_leave">
								<i class="fa fa-file-pdf-o"></i> Export to PDF
							</a>
						</div>
					</div>
				</div>
				<div class="box-body">
					<div class="col-md-3">
						<div class="form-group">
							<label>ประเภทการลา</label>
							<select class="form-control select2 select2-hidden-accessible" style="width: 100%;border-radius: 5px;" data-select2-id="9" tabindex="-1" aria-hidden="true" id="select_leaves_type">
								<option value="">เลือกประเภท...</option>
								<?php foreach($leaves_type as $value):?>
									<option value="<?php echo $value['id_leaves_type']?>"><?php echo $value['leaves_name']?></option>
								<?php endforeach ?>
							</select>
						</div>
					</div>
					<div class="col-md-3">
						<div class="form-group">
							<label>รูปแบบการลา</label>
							<select class="form-control select2 select2-hidden-accessible" style="width: 100%;border-radius: 5px;" data-select2-id="9" tabindex="-1" aria-hidden="true" id="select_leaves_format">
								<option class="form-control" value="<?php echo $value['id_department']?>">เลือกรูปแบบ...</option>
								<?php foreach($leaves_format as $value):?>
									<option value="<?php echo $value['id_leaves_format']?>"><?php echo ($value['name'] == 'full' ? "เต็มวัน":($value['name'] == 'half' ? "ครึ่งวัน":"ชั่วโมง"))?></option>
								<?php endforeach ?>
							</select>
						</div>
					</div>
					<div class="col-md-3">
						<div class="form-group">
							<label>เริ่มวันที่</label>
							<div class="input-group date">
								<div class="input-group-addon">
									<i class="fa fa-calendar"></i>
								</div>
								<input type="text" readonly class="form-control datepicker" placeholder="เลือกวันที่..." style="background-color: white" id="select_start_date">
							</div>
						</div>
					</div>
					<div class="col-md-3">
						<div class="form-group">
							<label>สิ้นสุดวันที่</label>
							<div class="input-group date">
								<div class="input-group-addon">
									<i class="fa fa-calendar"></i>
								</div>
								<input type="text" readonly class="form-control datepicker" placeholder="เลือกวันที่..." style="background-color: white" id="select_end_date">
							</div>
						</div>
					</div>
					<div class="col-md-12">
						<button id="btn-search" class="btn btn-primary pull-right"><i class="fa fa-search"></i> Search</button>
					</div>
				</div>
			</div>
			
			<div class="box box-info"><br>
				<!-- /.box-header -->
				<div class="box-body table-responsive no-padding">
					<div class="row" id="data-leaves">
						<table id="myTable" class="table table-hover">
							<thead>
								<tr>
									<th>Name</th>
									<th>Department</th>
									<th>Position</th>
									<th>ประเภทการลา</th>
									<th>เริ่มวันที่</th>
									<th>สิ้นสุดวันที่</th>
									<th>จำนวน</th>

								</tr>
							</thead>
							<?php foreach ($datas as $key => $value): ?>
								<?php if(isset($value->employee->department)):?>
									<tr>
										<td style="color: blue"><?php echo $value->employee->first_name?> <?php echo $value->employee->last_name;?></td>
										<td><?php echo $value->employee->department->name;?></td>
										<td><?php echo $value->employee->Position->name;?></td>
										<td><?php echo $value->leaves_type->leaves_name;?></td>
										<td><?php echo $value->start_leave;?></td>
										<td><?php echo $value->end_leave;?></td>
										<?php if ($value->id_leaves_format == '1'): ?>
											<td style="color: red;"><?php echo $value->total_leave/8 ;?> วัน</td>
										<?php endif ?>
										<?php if ($value->id_leaves_format == '2'): ?>
											<td style="color: orange;"><!-- <?php echo $value->total_leave ;?> -->ครึ่งวัน</td>
										<?php endif ?>
										<?php if ($value->id_leaves_format == '3'): ?>
											<td style="color: green;"><?php echo $value->total_leave ;?> ชั่วโมง</td>
										<?php endif ?>
									</tr>
								<?php endif?>
							<?php endforeach?>
						</table>
					</div>
				</div>
			</div>
		</div>
	</div>
</section>

<div id="ajax-center-url" data-url="<?php echo route('report.ajax_center.post')?>"></div>
<div id="ajax-center-url-pdf" data-url="<?php echo route('report.pdf.pdf_leave.post')?>"></div>
<?php echo csrf_field()?>