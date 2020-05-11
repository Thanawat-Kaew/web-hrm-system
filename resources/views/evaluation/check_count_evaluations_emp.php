<section class="content-header">
	<h3>
		ตรวจสอบตกหล่นของพนักงาน |
		<small> Missed inspection</small>
	</h3>
	<div class="col-sm-3 col-xs-12 pull-right input-group-sm">
        <select class="form-control select2 " style="width: 100%;" id="topic_name" >
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
			<div class="col-md-4 col-sm-2" >
				<div class="box box-warning" style="border-radius: 5px;">
					<div class="box-header with-border">
						<h3 class="box-title">แผนก 1</h3>
						<div class="box-tools pull-right">
							<button type="button" class="btn btn-box-tool" data-widget="collapse"><i class="fa fa-minus"></i></button>
						</div>
					</div>
					<div class="box-body">
						<div class="col-md-12">
							<div class="col-xs-6" style="border-right: inset; text-align: center;">
								<span class="glyphicon glyphicon-user" style="font-size: 30px;"></span>
								<p>ทั้งหมด 30 คน</p>
							</div>
							<div class="col-xs-6" style="text-align: center;">
								<span class="glyphicon glyphicon-check" style="font-size: 30px; color: green;"></span>
								<p>สำเร็จ 29 คน</p>
							</div>
						</div>
					</div>
					<div class="box-footer no-padding  ">
						<ul class="nav nav-stacked send_message">
							<li class="">
								<a href="#" style="margin: 5px border: 1px; color : #F76608;" data-id_department="12">
									<center>
										<span class="glyphicon glyphicon-send"></span> แจ้งข้อผิดพลาด
									</center>
								</a>
							</li>
						</ul>
					</div>
				</div>
			</div>
			<div class="col-md-4 col-sm-2">
				<div class="box box-primary" style="border-radius: 5px;">
					<div class="box-header with-border">
						<h3 class="box-title">แผนก 2</h3>
						<div class="box-tools pull-right">
							<button type="button" class="btn btn-box-tool" data-widget="collapse"><i class="fa fa-minus"></i></button>
						</div>
					</div>
					<div class="box-body">
						<div class="col-md-12">
							<div class="col-xs-6" style="border-right: inset; text-align: center;">
								<span class="glyphicon glyphicon-user" style="font-size: 30px;"></span>
								<p>ทั้งหมด 30 คน</p>
							</div>
							<div class="col-xs-6" style="text-align: center;">
								<span class="glyphicon glyphicon-check" style="font-size: 30px; color: green;"></span>
								<p>สำเร็จ 30 คน</p>
							</div>
						</div>
					</div>
					<div class="box-footer no-padding">
						<ul class="nav nav-stacked">
							<li>
								<a readonly style="margin: 5px border: 1px; color : #3c8dbc;">
									<center>
										<span class="glyphicon glyphicon-ok"></span> สำเร็จ
									</center>
								</a>
							</li>
						</ul>
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