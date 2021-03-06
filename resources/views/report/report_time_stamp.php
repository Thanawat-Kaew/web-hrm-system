<section class="content-header">
	<h3>
		การบันทึกเวลา |
		<small> Time Sheets</small>
		<div class="btn-group pull-right">
			<a href="<?php echo route("report.index.get")?>">
				<button type="button" name="back-page" class='btn btn-success dropdown-toggle'><i class="fa fa-reply"></i> กลับ
				</button>
			</a>
		</div>
	</h3>
</section>
<section class="content">
	<!-- <a href="<?php //echo route('report.test.get')?>">ssss</a> -->
	<div class="row">
		<div class="col-xs-12">
			<div class="box box-danger">
				<div class="box-header with-border">
					<div class="col-md-6">
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

							<?php }else{?> <!-- ไม่ใช่แผนก hr -->
									<input type="text" style="border-radius: 5px;" readonly class="form-control hide"value="<?php echo $current_employee['id_department']?>" id="report-department">
									<input type="text" style="border-radius: 5px;" readonly class="form-control"value="<?php echo $department['name']?>">

							<?php }?>
							</div>
						</div>
					</div>
					<div class="col-md-3 pull-right"><br>
						<div class="form-group pull-right">
							<a type="button" class="btn btn-danger genPDF_time_stamp">
								<i class="fa fa-file-pdf-o"></i> Export to PDF
							</a>
						</div>
					</div>
					<div class="col-md-3"><br>
						<!-- <select class="form-control select2 select2-hidden-accessible hide list_name_employee " style="width: 100%;border-radius: 5px;  margin-top: 5px;" data-select2-id="9" tabindex="-1" aria-hidden="true" id="name_employee">
									<option value="">เลือกชื่อพนักงาน...</option>
								</select> -->
						<?php if($current_employee['id_department'] != "hr0001"){?>
							<select class="form-control select2 select2-hidden-accessible" style="width: 100%;border-radius: 5px;  margin-top: 5px;" data-select2-id="9" tabindex="-1" aria-hidden="true" id="name_employee">
									<option value="">เลือกชื่อพนักงาน...</option>
									<?php foreach($list_employee as $list_employees):?>
										<option value="<?php echo $list_employees->id_employee?>"><?php echo $list_employees->first_name?> <?php echo $list_employees->last_name?></option>
									<?php endforeach ?>
								</select>
						<?php }else{ ?>
							<select class="form-control select2 select2-hidden-accessible hide list_name_employee " style="width: 100%;border-radius: 5px;  margin-top: 5px;" data-select2-id="9" tabindex="-1" aria-hidden="true" id="name_employee">
									<option value="">เลือกชื่อพนักงาน...</option>
								</select>
						<?php }?>

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
								<input type="text" readonly class="form-control datepicker" placeholder="เลือกวันที่..." style="background-color: white" id="select_start_date">
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
								<input type="text" readonly class="form-control datepicker" placeholder="เลือกวันที่..." style="background-color: white" id="select_end_date">
							</div>
						</div>
					</div>
					<div class="col-md-3">
						<div class="form-group">
							<label>เริ่มเวลา</label>
							<div class="input-group time">
								<div class="input-group-addon">
									<i class="fa fa-clock-o"></i>
								</div>
								<input type="text" readonly class="form-control timePicker1" placeholder="เลือกเวลา..." style="background-color: white" id="select_start_time" value="">
							</div>
						</div>
					</div>
					<div class="col-md-3">
						<div class="form-group">
							<label>ถึงเวลา</label>
							<div class="input-group time">
								<div class="input-group-addon">
									<i class="fa fa-clock-o"></i>
								</div>
								<input type="text" readonly class="form-control timePicker2" placeholder="เลือกเวลา..." style="background-color: white" id="select_end_time">
							</div>
						</div>
					</div>

					<div class="col-md-12">
						 <button id="btn-search" class="btn btn-primary pull-right"><i class="fa fa-search"></i> Search</button>
					</div>
				</div>
			</div>
			<div class="box box-info"><br>
				<div class="box-body table-responsive no-padding">
					<div class="row" id="data-timestamp">
					<table id="myTable" class="table table-hover">
						<thead>
							<tr>
								<th>Name</th>
								<th>Department</th>
								<th>Position</th>
								<th>Date</th>
								<th>Time-In</th>
								<th>Break-Out</th>
								<th>Break-In</th>
								<th>Time-Out</th>
								<th>Total(hr)</th>
							</tr>
						</thead>
						<?php foreach($timestamp as $value):?>
							<?php if(isset($value->employee->department)):?>
							<tr>
								<td style="color: blue; padding-left: 30px; cursor:pointer;" class="name_employee" data-id="<?php echo $value->employee->id_employee?>"><?php echo $value->employee->first_name?> <?php echo $value->employee->last_name;?></td>
								<td><?php echo $value->employee->department->name;?></td>
								<td><?php echo $value->employee->Position->name;?></td>
								<td><?php echo $value->date;?></td>
								<td><?php echo (!empty($value->time_in) ? $value->time_in : '-');?></td>
								<td><?php echo (!empty($value->break_out) ? $value->break_out : '-');?></td>
								<td><?php echo (!empty($value->break_in) ? $value->break_in : '-');?></td>
								<td><?php echo (!empty($value->time_out) ? $value->time_out : '-');?></td>
								<?php
									$start 	= strtotime($value->time_in);
									$end    = strtotime($value->time_out);
									if(!empty($start) && !empty($end)){
										$total_hour = intval(($end - $start)/3600);
										$mins = (int)(($end - $start) / 60);
								?>
									<td style="color: red"><?php echo $total_hour?></td>
								<?php }else{ ?>
									<td style="color: red">-</td>
								<?php } ?>
							</tr>
							<?php endif?>
						<?php endforeach ?>
					</table>
					</div>
				</div>
			</div>
		</div>
	</div>
</section>
<div id="ajax-center-url" data-url="<?php echo route('report.ajax_center.post')?>"></div>
<div id="ajax-center-url-pdf" data-url="<?php echo route('report.pdf.pdf_time_stamp.post')?>"></div>
<div id="send_email" data-url="<?php echo route('evaluation.send_email.post')?>"></div>
<?php echo csrf_field()?>


