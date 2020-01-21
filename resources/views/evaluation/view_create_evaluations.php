<section class="content-header">
	<h3>
		ดูแบบประเมิน |
		<small> Create Evaluation</small>
	</h3>
</section><br>
<section>
	<h1 class="text-right" style="padding-right: 30px;">รหัสแบบประเมินที่ : <?php echo sprintf("%06d", $view_create_evaluation['id_topic']) ?></h1>
	<div class="content">
		<div class="row">
			<div class="col-md-12">
				<div class="panel panel-default">
					<div class="panel-body">
						<label>ชื่อแบบการประเมิน </label>
						<input type="text" name="name-evaluation" class="form-control" value="<?php echo $view_create_evaluation['topic_name'] ?>" disabled>
						<br>
					</div>
				</div>
			</div>
		</div>
		<br><br>
		<?php
			foreach ($view_create_evaluation->parts as  $value) {
				//sd($value->toArray());
				//sd($value->question['question_name']);
				?>
				<div class="new-part">
                <div class="panel panel-default">
                    <div class="panel-body">
                        <label>ชื่อตอน </label>
                        <input type="text" name="name-parts" class="form-control required" value="<?php echo $value['part_name']?>" disabled >
                        <br>
                        <label>คำถาม</label>
                        <?php foreach($value->question as $name_question ):
                        	//sd($name_question->toArray());
                        	//sd($name_question['question_name']);
                        ?>
                        <div class="control-group input-group" style="margin-top:10px">
                             <input type="text" name="name-question" id="name-question" class="form-control" value="<?php echo $name_question['question_name'] ?>" disabled>
                         </div>
                         <div class="selected-question"></div>
                     <?php endforeach ?>
                        <br>
                            <label>เลือกรูปแบบคำตอบ</label>

                            	<input type="text" name="name-question" id="type-question" class="form-control" value="<?php echo $value->answerformat['answer_format_name'] ?>" disabled>

                            <br>
                            <label>เปอร์เซนต์คะแนน (%)</label>
                            <input type="number" name="percent" class="form-control required" value="<?php echo $value['percent'] ?>" disabled>
                    </div>
                </div>
            </div>
        <?php } ?>
		<br><br>
	</div>
</section>