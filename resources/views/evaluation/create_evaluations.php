<section class="content-header">
	<h1>
		สร้างแบบประเมิน |
		<small> Create Evaluation</small>
	</h1>
</section><br>
<section>
	<div class="content">
		<div class="row">
			<div class="col-md-12">
				<div class="panel panel-default">
					<div class="panel-body">
						<label>ชื่อแบบการประเมิน </label>
						<input type="text" name="add-name" class="form-control" placeholder="ชื่อแบบการประเมิน..."><br>
					</div>
				</div>
			</div>
		</div>
		<div class="pull-right">
			<div class="btn-group">
				<button class="btn btn-success pull-right format-answer" type="button"><i class="fa fa-circle-thin"></i> ดูรูปแบบคำตอบ</button>
			</div>
			<div class="btn-group">
				<button class="btn btn-info pull-right add-part"><i class="glyphicon glyphicon-plus"></i> เพิ่มตอน</button>
			</div>
		</div><br><br>

		
		<div class="row" id="group-part">
			<div class="col-md-12 new-part">
				<div class="panel panel-default">
					<div class="panel-body">
						
						<label>ชื่อตอน </label>
						<input type="text" name="add-name" class="form-control" placeholder="ชื่อตอน..."><br>
						<label>คำถาม</label>
						<button class="btn btn-success pull-right add-more" style="width: 63px;" type="button"><i class="glyphicon glyphicon-plus"></i> เพิ่ม</button>

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
							<label>เลือกรูปแบบคำตอบ</label>
							<select class="form-control" style="width: 100%;">
								<option selected="selected">เลือกรูปแบบ...</option>
								<option>รูปแบบ 1</option>
								<option>รูปแบบ 2</option>
							</select>
							<br>
							<label>เปอร์เซนต์คะแนน (%)</label>
							<input type="number" name="percen" class="form-control" placeholder="30">
					</div>
				</div>
			</div>
		</div>
		<div class="pull-right">
			<div class="btn-group">
				<button type="button" class='btn btn-success'> บันทึก
				</button>
			</div>
			<div class="btn-group">
				
				<button type="button" class='btn btn-danger btn-cancel'> ยกเลิก
				</button>
			</div>
		</div><br><br>
	</div>
</section>

<!-- data -->
<div id="ajax-center-url" data-url="<?php echo route('evaluation.ajax_center.post')?>"></div>
<?php echo csrf_field()?>
