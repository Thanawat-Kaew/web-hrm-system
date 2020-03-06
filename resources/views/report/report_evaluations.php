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
					<div class="col-md-6" style="border-style: double; border-radius: 5px; border-color: red;">
						<div class="col-md-6">
							<div class="form-group">
								<label>ช่วงผลการประเมิน</label>
								<input type="text" class="form-control" placeholder="เริ่ม" style="background-color: white; border-radius: 5px;">
							</div>
						</div>
						<div class="col-md-6">
							<div class="form-group">
								<label> </label>
								<input type="text" class="form-control" placeholder="ถึง" style="background-color: white; border-radius: 5px;">
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
					<table class="table table-hover">
						<tr>
							<th>Name</th>
							<th>Department</th>
							<th>Position</th>
							<th>วันที่ประเมิน</th>
							<th>ผู้ประเมิน</th>
							<th>คะแนนการประเมิน</th>
							<th>จากคะแนนเต็ม</th>
							<th>คิดเป็นร้อยละ (%)</th>
							
						</tr>
						<?php for ($i=0; $i < 8; $i++) { ?>
							<tr>
								<td style="color: blue">ธนวัฒน์ แก้วล้อมวัง</td>
								<td>engineer</td>
								<td>Web Developer</td>
								<td>11-7-2014</td>
								<td>ศักดิ์ทิพย์ สมเพียร</td>
								<td>60 (คะแนน)</td>
								<td>60 (คะแนน)</td>
								<td>100%</td>

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
