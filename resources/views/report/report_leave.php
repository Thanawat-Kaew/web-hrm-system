<section class="content-header">
	<h1>
		การลา |
		<small> Leave</small>
	</h1>
</section>
<section class="content">
	<div class="row">
		<div class="col-xs-12">
			<div class="box box-header">
				<div class="col-md-4">
					<div class="form-group">
						<label>เริ่มวันที่</label>
						<div class="input-group date">
							<div class="input-group-addon">
								<i class="fa fa-calendar"></i>
							</div>
							<input type="text" readonly class="form-control datepicker">
						</div>
					</div>
				</div>
				<div class="col-md-4">
					<div class="form-group">
						<label>ถึงวันที่</label>
						<div class="input-group date">
							<div class="input-group-addon">
								<i class="fa fa-calendar"></i>
							</div>
							<input type="text" readonly class="form-control datepicker">
						</div>
					</div>
				</div>
				<div class="btn-group col-md-4 col-xs-12">
					<button href="" type="button" style="margin-top : 25px;" class='btn btn-info form-control'><i class="fa fa-search"></i> ค้นหา
					</button>
				</div>
			</div>
			<div class="row add-leave-time-clock">
				<div class="btn-group dropup-new-record pull-right ">
					<button href="" type="button" class='btn btn-danger dropdown-toggle add-new-record' data-toggle="dropdown"><i class="fa fa-file-pdf-o"></i> Export to PDF
					</button>
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
							<th>สถานะ</th>
							<th>แก้ไข</th>
							<th>ลบ</th>
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
							<td><span class="label label-success">Approved</span></td>
							<td><button class="btn btn-warning form-control disabled"><i class="fa fa-pencil btn disabled"></i></button></td>
							<td><button class="btn btn-danger form-control disabled"><i class="fa fa-trash btn disabled"></i></button>
							</td>
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
