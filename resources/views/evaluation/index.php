<section class="content-header">
	<h1>
		การประเมินผล |
		<small> Evaluation</small>
	</h1>
</section>
<section class="content">
	<div class="row">
		<div class="col-xs-12">
			<div class="row">
				<div class="btn-group pull-right new-evaluation">
          <a class="add-evaluation" href="<?php echo route('evaluation.create_evaluations.get')?>">
					<button type="button" name="add-evaluation" class='btn btn-success dropdown-toggle add-evaluation'><i class="fa fa-plus"></i> New Evaluation
					</button>
        </a>
				</div>
			</div>
			<div class="box box-info">
				<div class="box-header">
					<h3 class="box-title">ประวัติการประเมิน</h3>

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
							<td>แบบประเมินพิจารณาขึ้นเงินเดือน ประจำปี 2019</td>
							<td>11-7-2014</td>
							<td><span class="label label-success">Approved</span></td>
							<td><button class="btn btn-info form-control"><i class="fa fa-eye"></i></button></td>
							<td><button class="btn btn-warning form-control"><i class="fa fa-pencil"></i></button></td>
							<td><button class="btn btn-danger form-control"><i class="fa fa-trash"></i></button>
							</td>
						</tr>
					</table>
				</div>
				<!-- /.box-body -->
			</div>
			<!-- /.box -->
		</div>
	</div>
</section>