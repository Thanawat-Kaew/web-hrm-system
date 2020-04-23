<!doctype html>
<html lang="en">
<head>
	<meta http-equiv="Content-Type" content="text/html; charset=utf-8"/>
	<title>PDF_EVALUATION</title>

	<style>
		footer {
			position: fixed; 
			bottom: -30px; 
			left: 0px; 
			right: 0px;
			height: 50px; 
			color: black;
			text-align: center;
			line-height: 35px;
		}
		@font-face {
			font-family: 'THSarabunNew';
			font-style: normal;
			font-weight: normal;
			src: url("{{ public_path('fonts/THSarabunNew.ttf') }}") format('truetype');
		}
		@font-face {
			font-family: 'THSarabunNew';
			font-style: normal;
			font-weight: bold;
			src: url("{{ public_path('fonts/THSarabunNew Bold.ttf') }}") format('truetype');
		}
		@font-face {
			font-family: 'THSarabunNew';
			font-style: italic;
			font-weight: normal;
			src: url("{{ public_path('fonts/THSarabunNew Italic.ttf') }}") format('truetype');
		}
		@font-face {
			font-family: 'THSarabunNew';
			font-style: italic;
			font-weight: bold;
			src: url("{{ public_path('fonts/THSarabunNew BoldItalic.ttf') }}") format('truetype');
		}

		body {
			font-family: "THSarabunNew";
		}

		table {
			font-family: "THSarabunNew";
			border-collapse: collapse;
			width: 100%;
			font-size: 18px;
		}

		td, th {
			border: 1px solid gray;
			text-align: center;
			padding: 0px;
			line-height: 12pt;
		}

		tr:nth-child(even) {
			background-color: #dddddd;
		}

		.page_break { 
			page-break-after: always; 
		}

		h1,h2,h3,h4 {
			line-height: 3pt;
		}

	</style>
</head>
<body style="margin-top: 50px;">
	<script type="text/php">
		if ( isset($pdf) ) {
		// OLD 
		// $font = Font_Metrics::get_font("helvetica", "bold");
		// $pdf->page_text(72, 18, "{PAGE_NUM} of {PAGE_COUNT}", $font, 6, array(255,0,0));
		// v.0.7.0 and greater
		$x = 765;
		$y = 50;
		$text = "หน้า {PAGE_NUM} จาก {PAGE_COUNT}";
		$font = $fontMetrics->get_font("THSarabun", "normal");
		$size = 12;
		$color = array(255,0,0);
		$word_space = 0.0;  //  default
		$char_space = 0.0;  //  default
		$angle = 0.0;   //  default
		$pdf->page_text($x, $y, $text, $font, $size, $color, $word_space, $char_space, $angle);
	}
</script>

<h1 style="font-size: 50px;">EVALUATION REPORT 
	<p style="font-size: 16px; text-align: right;"> Reported Date : <?php echo $getDate ?> | <?php echo $getTime ?></p>
</h1>
<hr>

<h4 style="font-size: 20px;">Department : 
	<?php foreach ($get_department_name as $value) { ?>
		<span style="color: red;"><?php echo $value['name'] ?></span>
		<?php }?> |  
		หัวข้อการประเมิน : 
		<?php foreach ($topic_names as $value1) :?>
		<span style="color: red;"><?php echo ($value1 == "")? "" : $value1['topic_name'] ?></span>
		<?php endforeach ?>
	</h4>
	
	<h4 style="font-size: 20px;">เริ่มวันที่ : <span style="color: red;"><?php echo ($start_date == "")? "" : $start_date ?></span>  |  ถึงวันที่ : <span style="color: red;"><?php echo ($end_date == "")? "" : $end_date ?></span>
	</h4>

	<h4 style="font-size: 20px;">ช่วงผลการประเมิน : <span style="color: red;"><?php echo ($start_number == "")? "" : $start_number ?></span>  ถึง : <span style="color: red;"><?php echo ($end_number == "")? "" : $end_number ?></span>
	</h4>

	<table>
		<thead>
			<tr>
				<th>ID</th>
				<th>Name</th>
				<th>Department</th>
				<th>Position</th>
				<th>วันที่ประเมิน</th>
				<th>ผู้ประเมิน</th>
				<th>หัวข้อการประเมิน</th>
				<th>คะแนนการประเมิน</th>
				<th>จากคะแนนเต็ม</th>
				<th>คิดเป็นร้อยละ</th>
			</tr>
		</thead>

<?php   $no = 0; ?>
        <?php $count_assessor = $emp_evaluation->count(); ?>
            <?php for ($i=0; $i < $count_assessor; $i++) { ?>
                <?php if(!empty($emp_evaluation[$i]->employee->department)){?>
				<tr>
					<td style="color: blue; text-align: left; padding: 2px;"> 
					<?php echo $emp_evaluation[$i]->employee->id_employee?>
				</td>
					<td style="color: blue; text-align: left; padding: 2px;"> 
					<?php echo $emp_evaluation[$i]->employee->first_name ?> <?php echo $emp_evaluation[$i]->employee->last_name ?>
				</td>
				<td>
					<?php echo $emp_evaluation[$i]->employee->department->name ?>
				</td>
				<td>
					<?php echo $emp_evaluation[$i]->employee->position->name ?>
				</td>
				<td>
					<?php echo $emp_evaluation[$i]->date ?>
				</td>
				<td style=" text-align: left; padding: 2px;">
					<?php echo $count_first_name[$no] ?> <?php echo $count_last_name[$no] ?>
				</td>
				<td style=" text-align: left; padding: 2px;">
					<?php echo $count_name_evaluation[$no] ?>
				</td>
				<td>
					<?php echo $emp_evaluation[$i]->result_evaluation ?>
				</td>
				<td>
					<?php echo $emp_evaluation[$i]->from_the_full_score ?>
				</td>
				<td style="color: red; font-style: bold; ">
					<?php echo $emp_evaluation[$i]->percent ?>%
				</td>
			</tr>
			<?php $no++; ?>
		<?php } ?>
	<?php } ?> 
</table>
<hr>
<footer>
	Copyright &copy; <?php echo date("Y"); ?> EngCom-RU. All rights reserved.
</footer>
</body>
</html>