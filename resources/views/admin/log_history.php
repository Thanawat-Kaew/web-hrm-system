<section class="content-header">
	<div class="box-header">
		<h3>
			ประวัติการลบ |
			<small> Delete History</small>
		</h3>
	</div>
</section>
<section class="content">
	<div class="row">
		<div class="col-md-12">
			<div class="box box-danger">
				<div class="box-body">
					<div class="form-group">
						<div class="col-md-12 table-responsive no-padding">
							<table id="myTable" class="table">
								<thead>
									<tr>
										<th>ID</th>
										<th>Name</th>
										<th>Lastname</th>
										<th>Department</th>
										<th>Position</th>
										<th>Deleted By name</th>
										<th>Date</th>
										<th></th>
									</tr>
								</thead>
								<tbody>
									<?php $count_employee = $employee->count();?>
									<?php for($i=0; $i<$count_employee; $i++){?>
										<?php $date = date('d-m-Y', strtotime($employee[$i]->date));?>
									<tr>
										<th><?php echo $employee[$i]->id_employee?></th>
										<td><?php echo $employee[$i]->first_name?></td>
										<td><?php echo $employee[$i]->last_name?></td>
										<td><?php echo $employee[$i]->department?></td>
										<td><?php echo $employee[$i]->position?></td>
										<td><?php echo $employee[$i]->delete_by_first_name?> <?php echo $employee[$i]->delete_by_last_name?></td>
										<td><?php echo $date;?></td>
										<td>
											<?php if($employee[$i]->id_status == 1){?>
												<span class="label label-success">success</span>
											<?php }else if($employee[$i]->id_status == 3){?>
												<span class="label label-danger">cancel</span>
											<?php } ?>
										</td>
									</tr>
									<?php } ?>
								</tbody>
							</table>
						</div>
					</div>
				</div>
			</div>
		</div>
	</div>
</section>