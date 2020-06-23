<head>
	<style type="text/css">
		.modal{
			border-radius: 10px;
		}
	</style>
</head>
<section class="content-header">
	<h3>
		ตรวจสอบตกหล่นของพนักงาน |
		<small> Missed inspection</small>
	</h3>
		<div class="btn-group pull-right">
			<a href="<?php echo route("evaluation.index.get")?>">
				<button type="button" name="back-page" style="height: 38px;" class='btn btn-success dropdown-toggle'><i class="fa fa-reply"></i> กลับ
				</button>
			</a>
		</div>
	<div class="col-sm-3 col-xs-12 pull-right input-group-sm">
		<?php //sd($topic_data->toArray());?>
		<?php if(isset($current_topic)){?>
			<input type="hidden" name="" id="current_topic" value="<?php echo $current_topic ?>">
			<select class="form-control select2 " style="width: 100%; height: 38px; font-size: 16px;" id="topic_name" >
				<option value="">กรุณาเลือกหัวข้อการประเมิน</option>
				<?php foreach($topic_data as $value):?>
					<option value="<?php echo $value->id_topic ?>" <?php echo (($value['id_topic'] == $current_topic) ? 'selected' : '') ?> ><?php echo $value->topic_name ?></option>
				<?php endforeach ?>
			</select>
		<?php }else{?>
			<select class="form-control select2 " style="width: 100%; height: 38px; font-size: 16px;" id="topic_name" >
				<option value="">กรุณาเลือกหัวข้อการประเมิน</option>
				<?php foreach($topic_data as $value):?>
					<option value="<?php echo $value->id_topic ?>"><?php echo $value->topic_name ?></option>
				<?php endforeach ?>
			</select>
		<?php }?>
	</div>
</section>
<section class="content">
	<hr>
	<div class="box-body">
		<div class="row" id="show_data">
		<?php if(isset($current_topic)){?>
			<?php //sd($topic_data->toArray());
				$count_department = $department->count();
			?>
			<?php for($i=0; $i<$count_department; $i++){ ?>
			<div class="col-md-4 col-sm-2">
                <div class="box box-warning" style="border-radius: 5px;">
                    <div class="box-header with-border">
                        <h3 class="box-title">แผนก <?php echo $department[$i]->name;?></h3>
                        <div class="box-tools pull-right">
                            <button type="button" class="btn btn-box-tool" data-widget="collapse">
                                <i class="fa fa-minus"></i>
                            </button>
                        </div>
                    </div>
                    <div class="box-body">
                        <div class="col-md-12">
                            <div class="col-xs-6" style="border-right: inset; text-align: center;">
                                <span class="glyphicon glyphicon-user" style="font-size: 30px;"></span>
                                <?php $count_employee = $employee[$i]->count(); ?>
                                    <p>ทั้งหมด <?php echo $count_employee?> คน</p>
                            </div>
                            <div class="col-xs-6" style="text-align: center;">
                                <span class="glyphicon glyphicon-check" style="font-size: 30px; color: green;"></span>
                                    <p>สำเร็จ <?php echo (isset($count_by_department[$i]) ?  $count_by_department[$i] : "0" )?> คน</p>
                                 </div>
                            </div>
                        </div>
                        <div class="box-footer no-padding">
                             <ul class="nav nav-stacked send_message" >
                                 <li class="">
                                     <a href="#" style="margin: 5px border: 1px; color : #F76608;"  data-id_department="<?php echo $department[$i]->id_department?>" class="form_email">
                                        <center>
                                             <span class="glyphicon glyphicon-send"></span> แจ้งข้อผิดพลาด
                                        </center>
                                    </a>
                                </li>
                            </ul>
                        </div>
                    </div>
                </div>
            <?php }?>
		<?php }else{ ?>
			<div class="error-page">
				<div class="col-md-8 col-md-offset-2">
					<div class="error-content">
						<h4><i class="fa fa-warning text-yellow"></i> กรุณาเลือกหัวข้อการประเมิน</h4>
					</div>
				</div>
			</div>
		</div>
		<?php } ?>
	</div>
</section>

<!-- data -->
<div id="ajax-center-url" data-url="<?php echo route('evaluation.ajax_center.post')?>"></div>
<div id="send_email" data-url="<?php echo route('evaluation.send_email.post')?>"></div>
<?php echo csrf_field() ?>