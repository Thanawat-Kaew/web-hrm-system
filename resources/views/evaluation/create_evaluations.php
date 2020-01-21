<section class="content-header">
	<h3>
		สร้างแบบประเมิน |
		<small> Create Evaluation</small>
	</h3>
</section><br>
<section>
	<form action="<?php echo route('evaluation.post_add.post'); ?>" method="POST" id="save-evaluation">
	<?php echo csrf_field()?>
	<h1 class="text-right" style="padding-right: 30px;">รหัสแบบประเมินที่ : <?php echo isset($id_new_evaluation) ? sprintf("%06d", $id_new_evaluation): '' ?></h1>
	<div class="content">
		<div class="row">
			<div class="col-md-12">
				<div class="panel panel-default">
					<div class="panel-body">
						<label>ชื่อแบบการประเมิน </label>
						<input type="hidden" name="id_topic" value="<?php echo $id_new_evaluation ?>">
						<input type="text" name="name-evaluation-<?php echo $id_new_evaluation; ?>" class="form-control required" placeholder="ชื่อแบบการประเมิน...">
						<label class="text-error name-evaluation<?php echo $id_new_evaluation; ?>-text-error" id="name-evaluation<?php echo $id_new_evaluation; ?>-text-error"></label>
						<br>
					</div>
				</div>
			</div>
		</div>
		<div class="pull-right">
			<div class="btn-group">
				<button class="btn btn-success pull-right format-answer" type="button"><i class="fa fa-circle-thin"></i> ดูรูปแบบคำตอบ</button>
			</div>
			<div class="btn-group">
				<button type="button" class="btn btn-info pull-right add-part"><i class="glyphicon glyphicon-plus"></i> เพิ่มตอน</button>
			</div>
		</div><br><br>
		<?php if(!empty($check_data)){
			foreach ($check_data->parts as $key => $value) {
				?>
				<div class="new-part">
                <div class="panel panel-default">
                <div class="box-tools pull-right">
                    <button type="button" class="btn btn-box-tool btn-remove-part" data-widget="remove"><i class="fa fa-remove"></i></button>
                </div>
                    <div class="panel-body">
                    	<input type="hidden" name="id_evaluation" value="<?php echo $id_new_evaluation ?>">
                    	<input type="hidden" name="chapter" value="<?php echo $value->chapter ?>">
                    	<input type="hidden" name="id_part-<?php echo $id_new_evaluation.'-'.$value->id_part;?>" value="<?php echo $value->id_part; ?>">
                    	<input type="hidden" name="total-question-<?php echo $id_new_evaluation.'-'.$value->chapter;?>" value="1" id="total-question-<?php echo $id_new_evaluation.'-'.$value->chapter;?>">
                        <label>ชื่อตอน </label>
                        <input type="text" name="name-parts-<?php echo $id_new_evaluation.'-'.$value->chapter;?>" class="form-control required" placeholder="ชื่อตอน...">
                        <label class="text-error name-parts-<?php echo $id_new_evaluation.'-'.$value->chapter;?>-text-error" id="name-parts-<?php echo $id_new_evaluation.'-'.$value->chapter;?>-text-error"></label><br>
                        <label>คำถาม</label>
                        <button class="btn btn-success pull-right add-more" style="width: 63px;" type="button"><i class="glyphicon glyphicon-plus"></i> เพิ่ม</button>

                         <div class="control-group input-group" style="margin-top:10px">
                             <input type="text" name="name-question-<?php echo $id_new_evaluation.'-'.$value->chapter.'-1'; ?>[]" id="name-question-<?php echo $id_new_evaluation.'-'.$value->chapter."-1"; ?>" class="form-control required question" placeholder="คำถาม">
                             <div class="input-group-btn">
                                 <button class="btn btn-warning remove" type="button"><i class="glyphicon glyphicon-remove"></i> ลบ</button>
                             </div>
                         </div>
                         <label class="text-error name-question-<?php echo $id_new_evaluation.'-'.$value->chapter."-1"; ?>-text-error" id="name-question-<?php echo $id_new_evaluation.'-'.$value->chapter."-1"; ?>-text-error"></label>
                         <div class="selected-question"></div>

                        <br>
                            <label>เลือกรูปแบบคำตอบ</label>
                            <select class="form-control required" name="type_answer-<?php echo $id_new_evaluation.'-'.$value->chapter; ?>" style="width: 100%;">
                                <option selected="selected" value="">เลือกรูปแบบ...</option>
                                <?php foreach($answer_type as $answer) :?>
                                	<option value="<?php echo $answer->id_answer_format?>"><?php echo $answer->answer_format_name?></option>
                                <?php endforeach ?>
                            </select>
                            <label class="text-error type_answer-<?php echo $id_new_evaluation.'-'.$value->chapter; ?>-text-error" id="type_answer-<?php echo $id_new_evaluation.'-'.$value->chapter; ?>-text-error"></label>
                            <br>
                            <label>เปอร์เซนต์คะแนน (%)</label>
                            <input type="number" name="percent-<?php echo $id_new_evaluation.'-'.$value->chapter; ?>" class="form-control required" placeholder="30">
                            <label class="text-error percent-<?php echo $id_new_evaluation.'-'.$value->chapter; ?>-text-error" id="percent-<?php echo $id_new_evaluation.'-'.$value->chapter; ?>-text-error"></label>
                    </div>
                </div>
            </div>
		<?php	}
		}else{
			echo "none";
		}
		?>
		<div class="row" id="group-part">
			<div class="col-md-12 new-part">
			</div>
		</div>
		<div class="pull-right">
			<div class="btn-group">
				<button type="button" class='btn btn-success btn-save'> บันทึก
				</button>
			</div>
			<div class="btn-group">

				<button type="button" class='btn btn-danger btn-cancel'> ยกเลิก
				</button>
			</div>
		</div><br><br>
	</div>
	</form>
</section>

<!-- data -->
<div id="ajax-center-url" data-url="<?php echo route('evaluation.ajax_center.post')?>"></div>
<div id="id-evaluation" data-value="<?php echo isset($id_new_evaluation) ? $id_new_evaluation : '' ?>"></div>
<?php echo csrf_field()?>
