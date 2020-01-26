<section class="content-header">
	<h3>
		แก้ไข้แบบประเมิน |
		<small> Create Evaluation</small>
	</h3>
</section><br>
<section>
	<form action="<?php echo route('evaluation.post_edit.post'); ?>" method="POST" id="save-evaluation">
	<?php echo csrf_field()?>
	<h1 class="text-right" style="padding-right: 30px;">รหัสแบบประเมินที่ : <?php echo sprintf("%06d", $edit_evaluation['id_topic']) ?></h1>
	<div class="content">
		<div class="row">
			<div class="col-md-12">
				<div class="panel panel-default">
					<div class="panel-body">
						<label>ชื่อแบบการประเมิน </label>
						<input type="text" name="name-evaluation-<?php echo $edit_evaluation['id_topic'] ?>" class="form-control" value="<?php echo $edit_evaluation['topic_name'] ?>" >
						<label class="text-error name-evaluation-<?php echo $edit_evaluation['id_topic'] ?>-text-error" id="name-evaluation-<?php echo $edit_evaluation['id_topic']; ?>-text-error"></label>
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
		<?php
			foreach ($edit_evaluation->parts as  $value) {
				//sd($value->toArray());
                //sd($value->question->count());
				//sd($value->answerformat->id_answer_format);
				//sd($value->question->count());
				//sd($value->question['question_name']); // ใช่ไม่ได้
				?>

				<div class="new-part">
                <div class="panel panel-default">
                <div class="box-tools pull-right">
                    <button type="button" class="btn btn-box-tool btn-remove-part" data-widget="remove" data-id="<?php echo $value->id_part; ?>"><i class="fa fa-remove"></i></button>
                </div>
                    <div class="panel-body">
                    	<input type="hidden" name="id_evaluation" value="<?php echo $edit_evaluation['id_topic'] ?>">
                    	<input type="hidden" name="chapter" value="<?php echo $value->chapter ?>">
                    	<input type="hidden" name="id_part-<?php echo $edit_evaluation['id_topic'].'-'.$value->id_part;?>" value="<?php echo $value->id_part; ?>">
                    	<input type="hidden" name="total-question-<?php echo $edit_evaluation['id_topic'].'-'.$value->chapter;?>" value="<?php echo ($value->question->count() == 0) ? '1' : $value->question->count() ?>" id="total-question-<?php echo $edit_evaluation['id_topic'].'-'.$value->chapter;?>"> <!-- จำนวนคำถามถ้าไม่มีให้เป็น 1 ถ้ามีก็ count จำนวนนั้นมา-->
                        <label>ชื่อตอน </label>
                        <?php
                        	if(!empty($value->part_name)){  /*ของเดิม*/
                        ?>
                        <input type="text" name="name-parts-<?php echo $edit_evaluation['id_topic'].'-'.$value->chapter;?>" class="form-control required" value="<?php echo $value['part_name']?>">
                        <label class="text-error name-parts-<?php echo $edit_evaluation['id_topic'].'-'.$value->chapter;?>-text-error" id="name-parts-<?php echo $edit_evaluation['id_topic'].'-'.$value->chapter;?>-text-error"></label>
                        <br>
                    	<?php }else{ ?> <!-- ขอใหม่ (กดเพิ่มตอน) -->
                    	<input type="text" name="name-parts-<?php echo $edit_evaluation['id_topic'].'-'.$value->chapter;?>" class="form-control required" placeholder="ชื่อตอน" >
                        <label class="text-error name-parts-<?php echo $edit_evaluation['id_topic'].'-'.$value->chapter;?>-text-error" id="name-parts-<?php echo $edit_evaluation['id_topic'].'-'.$value->chapter;?>-text-error"></label>
                        <br>
                    	<?php } ?>
                        <label>คำถาม</label>
                        <button class="btn btn-success pull-right add-more" style="width: 63px;" type="button"><i class="glyphicon glyphicon-plus"></i> เพิ่ม</button>
                        <?php
                        	if($value->question->count() > 0){   /*ถ้าคำถามมากว่า 0 */
                        		foreach($value->question as $name_question ){
                        	//sd($name_question->toArray());
                        	//sd($name_question['question_name']);
                        ?>

                        <div class="control-group input-group" style="margin-top:10px">
                             <input type="text" name="name-question-<?php echo $edit_evaluation['id_topic'].'-'.$value->chapter.'-'.$name_question['number_order']; ?>[]" id="name-question-<?php echo $edit_evaluation['id_topic'].'-'.$value->chapter.'-'.$name_question['number_order']; ?>[]" class="form-control required question" value="<?php echo $name_question['question_name']?>" >
                             <div class="input-group-btn">
                                <?php if($name_question['number_order'] == "1"){?> <!-- คำถามที่1 ลบไม่ได้ -->
                                 <button class="btn btn-warning " type="button" data-id="<?php echo $name_question['id_question']?>"><i class="glyphicon glyphicon-remove"></i> ลบ</button>
                                <?php }else{ ?>
                                <button class="btn btn-warning remove" type="button" data-id="<?php echo $name_question['id_question']?>"><i class="glyphicon glyphicon-remove"></i> ลบ</button>
                                <?php } ?>
                             </div>
                         </div>
                         <label class="text-error name-question-<?php echo $edit_evaluation['id_topic'].'-'.$value->chapter.'-'.$name_question['number_order']; ?>-text-error" id="name-question-<?php echo $edit_evaluation['id_topic'].'-'.$value->chapter.'-'.$name_question['number_order']; ?>-text-error"></label>
                        <?php
                    			}
                    	?>
                    		<div class="selected-question"></div>
                    	<?php
                        	}else{ /*กรณีน้อยกว่า 0*/
                        ?>
                        <div class="control-group input-group" style="margin-top:10px">
                             <input type="text" name="name-question-<?php echo $edit_evaluation['id_topic'].'-'.$value->chapter.'-1'; ?>[]" id="name-question-<?php echo $edit_evaluation['id_topic'].'-'.$value->chapter.'-1'; ?>[]" class="form-control required question" placeholder="คำถาม">
                             <div class="input-group-btn">
                                 <button class="btn btn-warning " type="button"><i class="glyphicon glyphicon-remove"></i> ลบ</button>
                             </div>
                         </div>
                         <label class="text-error name-question-<?php echo $edit_evaluation['id_topic'].'-'.$value->chapter.'-1'; ?>-text-error" id="name-question-<?php echo $edit_evaluation['id_topic'].'-'.$value->chapter.'-1'; ?>-text-error"></label>
                         <div class="selected-question"></div>
                        <?php }?>
                        <br>
                            <label>เลือกรูปแบบคำตอบ</label>
                            	<select class="form-control required" name="type_answer-<?php echo $edit_evaluation['id_topic'].'-'.$value->chapter; ?>" style="width: 100%;">
                                <?php if(isset($value->answerformat->id_answer_format)){ ?> <!-- กรณีมีรูปแบบคำตอบอยู่แล้ว -->
                                	<?php foreach($answer_type as $answer) :?>
                                		<option value="<?php echo $answer['id_answer_format']?>" <?php echo (($value->answerformat['id_answer_format']) == $answer['id_answer_format']) ? 'selected' : '' ?>><?php echo $answer['answer_format_name']?></option>
                                	<?php endforeach ?>
                                <?php }else{ ?> <!-- กรณีไม่มีรูปแบบคำตอบอยู่แล้ว (กดเพิ่มตอน) -->
                                	<option selected="selected" value="">เลือกรูปแบบ...</option>
                                	<?php foreach($answer_type as $answer) :?>
                                		<option value="<?php echo $answer->id_answer_format?>"><?php echo $answer->answer_format_name?></option>
                                	<?php endforeach ?>

                                <?php } ?>
                            </select>
                            <label class="text-error type_answer-<?php echo $edit_evaluation['id_topic'].'-'.$value->chapter; ?>-text-error" id="type_answer-<?php echo $edit_evaluation['id_topic'].'-'.$value->chapter; ?>-text-error"></label>
                            <br>
                            <label>เปอร์เซนต์คะแนน (%)</label>
                            <?php
                        		if(!empty($value->percent)){ /* percent ของเดิม*/
                        	?>
                            <input type="number" name="percent-<?php echo $edit_evaluation['id_topic'].'-'.$value->chapter; ?>" class="form-control required" value="<?php echo $value['percent'] ?>">
                            <label class="text-error percent-<?php echo $edit_evaluation['id_topic'].'-'.$value->chapter; ?>-text-error" id="percent-<?php echo $edit_evaluation['id_topic'].'-'.$value->chapter; ?>-text-error"></label>
                        	<?php }else {?> <!-- กรณีกดเพิ่มตอน -->
                        	<input type="number" name="percent-<?php echo $edit_evaluation['id_topic'].'-'.$value->chapter; ?>" class="form-control required" placeholder="30">
                            <label class="text-error percent-<?php echo $edit_evaluation['id_topic'].'-'.$value->chapter; ?>-text-error" id="percent-<?php echo $edit_evaluation['id_topic'].'-'.$value->chapter; ?>-text-error"></label>
                        	<?php }?>
                    </div>
                </div>
            </div>
        <?php } ?>
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

<div id="ajax-center-url" data-url="<?php echo route('evaluation.ajax_center.post')?>"></div>
<div id="id-evaluation" data-value="<?php echo isset($edit_evaluation['id_topic']) ? $edit_evaluation['id_topic'] : '' ?>"></div>
<?php echo csrf_field()?>