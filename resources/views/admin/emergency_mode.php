<section class="content-header">
	<div class="box-header">
		<h4>
			การจัดการรูปแบบสภาวะสถานการณ์ไม่ปกติ |
			<small> Unusual situation mode Manage</small>
		</h4>
	</div>
</section>
<section class="content">
	<div class="row">
		<div class="col-md-12">
			<div class="box box-danger">
				<div class="box-body">
					<div class="box-body table-responsive no-padding">
						<table id="myTable" class="table table-hover table-striped">
							<tr>
								<th>FUNCTION</th>
								<th>OPEN</th>
								<th>CLOSE</th>
							</tr>
							<tr>
								<td style="font-size: 16px;">โหมดสภาวะสถานการณ์ไม่ปกติ/ Unusual situation mode.</td>

								<td><input type="radio" id="open_mode" class="iradio_flat-green flat-green open_mode" <?php echo ($get_company->emergency_status == '1')?'checked':'' ?> name="iCheck" value="1"></td>
								<td><input type="radio" id="close_mode" class="iradio_flat-green flat-red close_mode" <?php echo ($get_company->emergency_status == '0')?'checked':'' ?> name="iCheck" value="0"></td>
							</tr>
						</table>
					</div>
				</div>
			</div>
		</div>
	</div>
</section>
<div id="set-emergency" data-url="<?php echo route('admin.set_emergency.post')?>"></div>
<?php echo csrf_field()?>