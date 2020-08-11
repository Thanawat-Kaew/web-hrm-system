<section class="content-header">
	<div class="box-header">
		<h3>
			บันทึกประวัติ |
			<small> LOG</small>
		</h3>
	</div>
</section>
<section class="content">
	<div class="row">
		<div class="col-md-12 btn-group dropup pull-right ">
			<a href="<?php echo route("admin.log_history.get")?>">
				<button href="" type="button" name="view-history" class='btn btn-warning pull-right dropdown-toggle view-history'><i class="fa fa-history"></i> History
				</button>
			</a>
		</div>
	</div>
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
										<th>Department</th>
										<th>Position</th>
										<th>Deleted By</th>
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
										<td><?php echo $employee[$i]->employee->first_name?> <?php echo $employee[$i]->employee->last_name?></td>
										<td><?php echo $employee[$i]->employee->department->name?></td>
										<td><?php echo $employee[$i]->employee->position->name?></td>
										<td><?php echo $count_first_name[$i]?> <?php echo $count_last_name[$i]?></td>
										<td><?php echo $date;?></td>
										<td>
											<button style="width: auto;" class="btn btn-primary form-control confirm-delete-employee" data-id="<?php echo $employee[$i]->id;?>">อนุมัติ</button>
											<button style="width: auto;" class="btn btn-danger form-control cancel-delete-employee" data-id="<?php echo $employee[$i]->id;?>">ไม่อนุมัติ</button>
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
<div id="confirm-delete-employee-url" data-url="<?php echo route('admin.confirm-delete-employee.post')?>"></div>
<div id="cancel-delete-employee-url" data-url="<?php echo route('admin.cancel-delete-employee.post')?>"></div>
<?php echo csrf_field()?>