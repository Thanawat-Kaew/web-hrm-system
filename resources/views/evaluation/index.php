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
					<a class="add-evaluation" href="<?php echo route('evaluation.create_evaluations.get')?>">
						<button type="button" name="add-evaluation" class='btn btn-success dropdown-toggle add-evaluation'><i class="fa fa-plus"></i> สร้างแบบประเมิน
						</button>
					</a>
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
						<tr>
							<td>0001</td>
							<td>2019</td>
							<td>แบบประเมินผลการปฏิบัติงานของพนักงานประจาปี 2019</td>
							<td>11-7-2014</td>
							<td><span class="label label-success">Approved</span></td>
							<td><button class="btn btn-info form-control"><i class="fa fa-eye"></i></button></td>
							<td><button class="btn btn-warning form-control"><i class="fa fa-pencil"></i></button></td>
							<td><button class="btn btn-danger form-control"><i class="fa fa-trash"></i></button>
							</td>
						</tr>
					</table>
				</div>
			</div>
		</div>
	</div>
</section>
