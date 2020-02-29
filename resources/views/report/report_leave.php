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
								<select class="form-control select2 select2-hidden-accessible" style="width: 100%;border-radius: 5px;" data-select2-id="9" tabindex="-1" aria-hidden="true" id="report-department">
									<option value="">เลือกแผนก...</option>
									<option value="all">เลือกทุกแผนก</option>
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
			
			<div class="box box-info">
				<div class="box-header">
					<h3 class="box-title">ประวัติการลา</h3>
				</div>
				<!-- /.box-header -->
				<div class="box-body table-responsive no-padding">
					<table class="table table-hover">
						<tr>
							<th>Name</th>
							<th>Department</th>
							<th>Position</th>
							<th>วันที่ขอลา</th>
							<th>ประเภทการลา</th>
							<th>เริ่มวันที่</th>
							<th>สิ้นสุดวันที่</th>
							<th>เหตุผลการลา</th>
							
						</tr>
						<?php for ($i=0; $i < 8; $i++) { ?>
						<tr>
							<td style="color: blue">ธนวัฒน์ แก้วล้อมวัง</td>
							<td>engineer</td>
							<td>Web Developer</td>
							<td>11-7-2014</td>
							<td>ลาป่วย</td>
							<td>11-7-2014</td>
							<td>15-7-2014</td>
							<td>อาเจียน</td>
							
						</tr>
						<?php } ?>
					</table>
				</div>
				<!-- /.box-body -->
			</div>
			<!-- /.box -->
		</div>
	</div>
</section>
