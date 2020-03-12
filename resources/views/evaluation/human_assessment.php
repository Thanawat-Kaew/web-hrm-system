<body class="content_human_assessment">
	<section class="content">
		<div class="row">
			<div class="col-md-10 col-md-offset-1">
				<div class="content-header content_header_human">
					<?php echo $id_topic->id_topic; ?>
					<h3>รายชื่อพนักงาน</h3>
				</div>
				<div class="box box-info box_name_emp">
					<div class="content ">
						<div class="box-body">
							<div class="input-group col-md-3 pull-right">
								<input type="text" id="myInput" name="q" class="form-control search" placeholder="ค้นหาชื่อ..." style="border-radius: 5px;">
								<!-- <span class="input-group-btn">
									<button type="submit" name="search" id="search-btn" class="btn btn-flat">
										<i class="fa fa-search"></i>
									</button>
								</span> -->
							</div><br><br>
							<table class="table table-bordered table-hover" id="myTable">
								<tbody>
									<tr>
										<th style="width: 10px">รหัสพนักงาน</th>
										<th style="text-align: left;">ชื่อ-สกุล</th>
										<th style="width: 40px">สถานะ</th>
									</tr>
									<?php $count_list_name = $list_name->count();?> <!-- นับจำนวนพนักงาน -->
									<?php for($i=0; $i<$count_list_name; $i++){?>
										<tr>
											<td><?php echo $list_name[$i]->id_employee ?></td>
											<?php if($list_name[$i]->evaluation_hasmany->count() > 0){?> <!-- กรณีประเมินแล้ว จะมีค่ามากกว่า 0-->
											<?php $count_eva_has = $list_name[$i]->evaluation_hasmany->count();?> <!-- นับจำนวนหัวข้อที่พนักงานคนที่ถูกประเมิน -->
												<?php $count = 0;?>
												<?php for($j=0; $j<$count_eva_has; $j++){?>
													<?php if($list_name[$i]->evaluation_hasmany[$j]->id_topic == $id_topic->id_topic){?> <!-- กรณีรหัสผู้ถูกประเมินตรงกับ id_topic ของหัวเรื่อง -->
														<?php $count += 1;?>
													<?php }?>
												<?php }?>
												<?php if($count > 0){?> <!-- กรณีพนักงานคนนี้มีการประมินแล้วตรงกับหัวข้อการประเมินนี้ -->
													<td style="text-align: left;"><b><?php echo $list_name[$i]->first_name ?> <?php echo $list_name[$i]->last_name ?></b>
														</td>
														<td><span class="badge bg-green">สำเร็จ</span></td>
												<?php }else{?> <!-- กรณีพนักงานคนนี้มีการประมินแล้วไม่ตรงกับหัวข้อการประเมินนี้ -->
													<td style="text-align: left;"><a href="<?php echo route('evaluation.assessment.get', [$list_name[$i]->id_employee, $id_topic->id_topic])?>"><b><?php echo $list_name[$i]->first_name ?> <?php echo $list_name[$i]->last_name ?></b></a>
													</td>
													<td><span class="badge bg-red">ยังไม่ประเมิน</span></td>
												<?php } ?>
												<?php //echo $count;?>
											<?php }else{ ?> <!-- กรณียังไม่ประเมินแล้ว -->
												<td style="text-align: left;"><a href="<?php echo route('evaluation.assessment.get', [$list_name[$i]->id_employee, $id_topic->id_topic])?>"><b><?php echo $list_name[$i]->first_name ?> <?php echo $list_name[$i]->last_name ?></b></a>
												</td>
												<td><span class="badge bg-red">ยังไม่ประเมิน</span></td>
											<?php } ?>
										</tr>
									<?php } ?>
										<tr>
											<td>1</td>
											<td style="text-align: left;"><b>ธนวัฒน์  แก้วล้อมวัง</b>	</td>
											<td><span class="badge bg-green">สำเร็จ</span></td>
										</tr>
										<tr>
											<td>1</td>
											<td style="text-align: left;"><b>ชนะชัย  ชุ่มชื่น</b></td>
											<td><span class="badge bg-red">ยังไม่ประเมิน</span></td>
										</tr>
								</tbody>
							</table>
						</div>
					</div>
				</div>
			</div>
		</div>
	</section>
</body>