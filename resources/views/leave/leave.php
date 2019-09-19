<section class="content-header">
	<h1>
		การลา |
		<small> Leave</small>
	</h1>
</section>
<section class="content">
	<!-- Info boxes -->
	<div class="row">
		<div class="col-md-4 col-sm-6 col-xs-12">
			<div class="info-box">
				<span class="info-box-icon bg-yellow"><i class="">20</i></span>

				<div class="info-box-content">
					<span class="info-box-text">คงเหลือ</span>
					<span class="info-box-number">ลากิจ</span>
				</div>
				<!-- /.info-box-content -->
			</div>
			<!-- /.info-box -->
		</div>
		<!-- /.col -->
		<div class="col-md-4 col-sm-6 col-xs-12">
			<div class="info-box">
				<span class="info-box-icon bg-green"><i class="">15</i></span>
				<div class="info-box-content">
					<span class="info-box-text">คงเหลือ</span>
					<span class="info-box-number">ลาป่วย</span>
				</div>
				<!-- /.info-box-content -->
			</div>
			<!-- /.info-box -->
		</div>
		<!-- /.col -->
		<div class="col-md-4 col-sm-6 col-xs-12 pull-right">
			
		</div>
	</div>
	<!-- /.row -->
	<div class="row">
		<div class="col-xs-12">
			<div class="row">
				<div class="btn-group dropup pull-right ">
					<button href="" type="button" name="add-leave" class='btn btn-success dropdown-toggle add-leave'><i class="fa fa-plus"></i> New Record
					</button>
				</div>
			</div>
			<div class="box box-info">
				<div class="box-header">
					<h3 class="box-title">ประวัติการลา</h3>

					<div class="box-tools">
						<div class="input-group input-group-sm" style="width: 150px;">
							<input type="text" name="table_search" class="form-control pull-right" placeholder="Search">

							<div class="input-group-btn">
								<button type="submit" class="btn btn-default"><i class="fa fa-search"></i></button>
							</div>
						</div>
					</div>
				</div>


				<!-- /.box-header -->
				<div class="box-body table-responsive no-padding">
					<table class="table table-hover">
						<tr>
							<th>วันที่ขอลา</th>
							<th>ประเภทการลา</th>
							<th>วันที่ลา</th>
							<th>เหตุผลการลา</th>
							<th>สถานะ</th>
							<th>แก้ไข</th>
							<th>ลบ</th>
						</tr>
						<tr>
							<td>11-7-2014</td>
							<td>ลาป่วย</td>
							<td>11-7-2014</td>
							<td>Bacon ipsum dolor sit amet salami venison chicken flank fatback doner.</td>
							<td><span class="label label-success">Approved</span></td>
							<td><a><button class="btn btn-warning form-control disabled"><i class="fa fa-pencil btn disabled"></i></button></td>
							<td><button class="btn btn-danger form-control disabled"><i class="fa fa-trash btn disabled"></i></button></td>
						</tr>
						<tr>
							<td>11-7-2014</td>
							<td>ลาป่วย</td>
							<td>11-7-2014</td>
							<td>Bacon ipsum dolor sit amet salami venison chicken flank fatback doner.</td>
							<td><span class="label label-info">Waiting</span></td>
							<td><span class="btn btn-warning form-control"><i class="fa fa-pencil btn"></i></span></td>
							<td><span class="btn btn-danger form-control"><i class="fa fa-trash btn"></i></span></td>
						</tr>
						<tr>
							<td>11-7-2014</td>
							<td>ลากิจ</td>
							<td>11-7-2014</td>
							<td>Bacon ipsum dolor sit amet salami venison chicken flank fatback doner.</td>
							<td><span class="label label-info">Waiting</span></td>
							<td><button class="btn btn-warning form-control"><i class="fa fa-pencil btn"></i></button></td>
							<td><button class="btn btn-danger form-control"><i class="fa fa-trash btn"></i></button></td>
						</tr>
						<tr>
							<td>11-7-2014</td>
							<td>ลากิจ</td>
							<td>11-7-2014</td>
							<td>Bacon ipsum dolor sit amet salami venison chicken flank fatback doner.</td>
							<td><span class="label label-danger">Cancel</span></td>
							<td><button class="btn btn-warning form-control disabled"><i class="fa fa-pencil btn disabled"></i></button></td>
							<td><button class="btn btn-danger form-control disabled"><i class="fa fa-trash btn disabled"></i></button></td>
						</tr>
						<tr>
							<td>11-7-2014</td>
							<td>ลากิจ</td>
							<td>11-7-2014</td>
							<td>Bacon ipsum dolor sit amet salami venison chicken flank fatback doner.</td>
							<td><span class="label label-danger">Cancel</span></td>
							<td><button class="btn btn-warning form-control disabled"><i class="fa fa-pencil btn disabled"></i></button></td>
							<td><button class="btn btn-danger form-control disabled"><i class="fa fa-trash btn disabled"></i></button></td>
						</tr>
					</table>
				</div>
				<!-- /.box-body -->

				

			</div>
			<!-- /.box -->
		</div>
	</div>
</section>

<!-- data -->
<div id="ajax-center-url" data-url="<?php echo route('leave.ajax_center')?>"></div>
<?php echo csrf_field()?>
