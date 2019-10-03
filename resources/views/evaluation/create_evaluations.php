<section class="content-header">
	<h1>
		สร้างแบบประเมิน |
		<small> Create Evaluation</small>
	</h1>
</section><br>
<section>
	<div class="container">
		<button class="btn btn-info pull-right add-part"><i class="glyphicon glyphicon-plus"></i> เพิ่มตอน</button><br><br>
		<div class="row" id="group-part">
			<div class="col-md-12 new-part">
				<div class="panel panel-default">
					<div class="panel-body">
						
						<label>ชื่อตอน </label>
						<input type="text" name="add-name" class="form-control" placeholder="ชื่อตอน..."><br>
						<label>คำถาม</label>
						<button class="btn btn-success pull-right add-more btn-sm" type="button"><i class="glyphicon glyphicon-plus"></i> เพิ่ม</button>

						<div class="control-group input-group" style="margin-top:10px">
							<input type="text" name="addmore[]" class="form-control" placeholder="คำถาม">
							<div class="input-group-btn"> 
								<button class="btn btn-warning remove" type="button"><i class="glyphicon glyphicon-remove"></i> ลบ</button>
							</div>
						</div>
						<div class="selected-question"></div>

						<div class="copy hide">
							<div class="control-group input-group" style="margin-top:10px">
								<input type="text" name="addmore[]" class="form-control" placeholder="คำถาม">
								<div class="input-group-btn"> 
									<button class="btn btn-warning remove" type="button"><i class="glyphicon glyphicon-remove"></i> ลบ</button>
								</div>
							</div>
						</div><br>
						<div class="col-md-6">
							<label>เลือกรูปแบบคำตอบ</label>
							<select class="form-control" style="width: 100%;">
								<option selected="selected">เลือกรูปแบบ...</option>
								<option>รูปแบบ 1</option>
								<option>รูปแบบ 2</option>
								<option>รูปแบบ 3</option>
							</select>
							<br>
						</div>
						<div class="col-md-6">
							<label>เปอร์เซนต์ (%)</label>
							<input type="number" name="percen" class="form-control" placeholder="30">
						</div>
					</div>
				</div>
			</div>
		</div>
		<div class="pull-right">
			<div class="btn-group">
				<button type="button" class='btn btn-success'></i> บันทึก
				</button>
			</div>
			<div class="btn-group">
				<button type="button" class='btn btn-danger'> ยกเลิก
				</button>
			</div>
		</div>
	</div>
</section>

<!-- data -->
<div id="ajax-center-url" data-url="<?php echo route('evaluation.ajax_center.post')?>"></div>
<?php echo csrf_field()?>
