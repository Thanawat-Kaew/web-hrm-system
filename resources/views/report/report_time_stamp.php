<section class="content-header">
	<h3>
		การบันทึกเวลา |
		<small> Time Sheets</small>
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
								<select class="form-control select2 select2-hidden-accessible" style="width: 100%;border-radius: 5px;" data-select2-id="9" tabindex="-1" aria-hidden="true" id="report-department">
									<option value="">เลือกแผนก...</option>
									<option value="all">เลือกทุกแผนก</option>
								<?php foreach($department as $departments):?>
									<option value="<?php echo $departments['id_department']?>"><?php echo $departments['name']?></option>
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
								<input type="text" readonly class="form-control datepicker" placeholder="เลือกวันที่..." style="background-color: white">
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
								<input type="text" readonly class="form-control datepicker" placeholder="เลือกวันที่..." style="background-color: white">
							</div>
						</div>
					</div>
					<div class="col-md-3">
						<div class="form-group">
							<label>เริ่มเวลา</label>
							<div class="input-group date">
								<div class="input-group-addon">
									<i class="fa fa-clock-o"></i>
								</div>
								<input type="text" readonly class="form-control timePicker1" placeholder="เลือกเวลา..." style="background-color: white">
							</div>
						</div>
					</div>
					<div class="col-md-3">
						<div class="form-group">
							<label>ถึงเวลา</label>
							<div class="input-group date">
								<div class="input-group-addon">
									<i class="fa fa-clock-o"></i>
								</div>
								<input type="text" readonly class="form-control timePicker2" placeholder="เลือกเวลา..." style="background-color: white">
							</div>
						</div>
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
						<?php foreach($timestamp as $value): ?>
							<tr>
								<td style="color: blue"><?php echo $value->employee->first_name?> <?php echo $value->employee->last_name;?></td>
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
									if(!empty($end)){
										$total_hour = intval(($end - $start)/3600);
										$mins = (int)(($end - $start) / 60);
									}
								?>
								<td style="color: red"><?php echo (!empty($total_hour) ? $total_hour : '-')?></td>
							</tr>
						<?php endforeach ?>
					</table>
					</div>
				</div>
			</div>
		</div>
	</div>
</section>
<div id="ajax-center-url" data-url="<?php echo route('report.ajax_center.post')?>"></div>
<?php echo csrf_field()?>