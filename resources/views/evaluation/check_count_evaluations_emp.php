<section class="content-header">
	<h3>
		ตรวจสอบตกหล่นของพนักงาน |
		<small> Missed inspection</small>
	</h3>
	<div class="col-sm-3 col-xs-12 pull-right input-group-sm">
		<select class="form-control select2 " style="width: 100%; height: 40px; font-size: 16px;" id="topic_name" >
			<option value="">กรุณาเลือกหัวข้อการประเมิน</option>
			<?php foreach($topic_data as $value):?>
				<option value="<?php echo $value->id_topic ?>"><?php echo $value->topic_name ?></option>
			<?php endforeach ?>
		</select>
	</div>
</section>
<section class="content">
	<hr>
	<div class="box-body">
		<div class="row" id="show_data">
			<div class="error-page">
				<div class="col-md-8 col-md-offset-2">
					<div class="error-content">
						<h4><i class="fa fa-warning text-yellow"></i> กรุณาเลือกหัวข้อการประเมิน</h4>
					</div>
				</div>
			</div>
		</div>
	</div>
</section>

<!-- data -->
<div id="ajax-center-url" data-url="<?php echo route('evaluation.ajax_center.post')?>"></div>
<div id="send_email" data-url="<?php echo route('evaluation.send_email.post')?>"></div>
<?php echo csrf_field() ?>