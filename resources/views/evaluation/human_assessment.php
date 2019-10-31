<body class="content_human_assessment">
	<section class="content">
		<div class="row">
			<div class="col-md-10 col-md-offset-1">
				<div class="content-header content_header_human">
					<h3>รายชื่อพนักงาน</h3>
				</div>
				<div class="box box-info box_name_emp">
					<div class="content ">
						<div class="box-body">
							<div class="input-group col-md-3 pull-right">
								<input type="text" name="q" class="form-control" placeholder="Search...">
								<span class="input-group-btn">
									<button type="submit" name="search" id="search-btn" class="btn btn-flat">
										<i class="fa fa-search"></i>
									</button>
								</span>
							</div><br><br>
							<table class="table table-bordered table-hover">
								<tbody>
									<tr>
										<th style="width: 10px">รหัส</th>
										<th style="text-align: left;">ชื่อ-สกุล</th>
										<th style="width: 40px">สถานะ</th>
									</tr>
									<?php for ($i=1; $i <= 7 ;$i++) { ?>
										<tr>
											<td>1</td>
											<td style="text-align: left;"><a href="<?php echo route('evaluation.assessment.get')?>"><b>ธนวัฒน์  แก้วล้อมวัง</b>	</a></td>
											<td><span class="badge bg-green">สำเร็จ</span></td>
										</tr>
									<?php } ?>
									<?php for ($i=1; $i <= 5 ;$i++) { ?>
										<tr>
											<td>1</td>
											<td style="text-align: left;"><a href="<?php echo route('evaluation.assessment.get')?>"><b>ชนะชัย  ชุ่มชื่น</b>	</a></td>
											<td><span class="badge bg-red">ยังไม่ประเมิน</span></td>
										</tr>
									<?php } ?>
								</tbody>
							</table>
						</div>
					</div>
				</div>
			</div>
		</div>
	</section>
</body>