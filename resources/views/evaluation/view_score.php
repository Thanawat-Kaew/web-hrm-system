<!doctype html>
<html lang="en">
<head>
	<meta http-equiv="Content-Type" content="text/html; charset=utf-8"/>
	<title>PDF_LEAVE</title>

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

		h1,h2,h3,h4,p {
			line-height: 2pt;
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
            $x = 518;
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

	<h1 style="font-size: 50px;">View score evaluations
		<p style="font-size: 16px; text-align: right;"> Date : <?php echo $getDate?> | <?php echo $getTime?></p>
	</h1>
	<hr>
	<h4 style="font-size: 20px;">แผนก :
		<span style="color: red;"><?php echo $name_department['name'] ?></span>
	</h4>
	<h4 style="font-size: 20px;">ประจำปี : 
		<?php $year = explode('-', $get_topic_detail->years); ?>
		<span style="color: red;"><?php echo $year[0]?></span>
	</h4>
	<h4 style="font-size: 20px;">ชื่อแบบประเมิน : 
		<span style="color: red;"><?php echo $get_topic_detail->topic_name ?></span>
	</h4>
	<h4 style="font-size: 20px;">ผู้ประเมิน : 
		<span style="color: red;"><?php echo $current_employee->first_name ?> <?php echo $current_employee->last_name ?></span>
	</h4>
	<?php $count_emp_eval = $emp_evaluation->count() ?>
	<?php if ($count_emp_eval != 0 ): ?>
	<table>
		<thead>
			<tr>
				<th style="width: 30px;">#</th>
				<th>ชื่อ-สกุล</th>
				<th style="width: 80px;">รหัสพนักงาน</th>
				<th style="width: 80px;">คะแนนเต็ม</th>
				<th style="width: 150px;">ผลคะแนน</th>
				<th style="width: 150px;">คิดเป็นร้อยละ (%)</th>
			</tr>
		</thead>
		<?php $n = 1;?>
		<tbody>
			<?php foreach ($emp_evaluation as $value2 ) :?>
			<tr>
				<td><?php echo $n++ ?></td>
				<td style="text-align: left; padding-left: 10px;" ><?php echo $value2->employee->first_name ?>  <?php echo $value2->employee->last_name ?></td>
				<td><?php echo $value2->id_assessor ?></td>
				<td><?php echo $value2->from_the_full_score ?></td>
				<td><?php echo $value2->result_evaluation ?></td>
				<td style="color: red;"><?php echo round(($value2->result_evaluation*100)/$value2->from_the_full_score,2) ?>%</td>
			</tr>
			<?php endforeach ?>
		</tbody>
	</table>
	<hr>
	<?php endif ?>
	<?php if ($count_emp_eval <= 0 ): ?>
		<p style="text-align: center; font-size: 20px;">No Data.</p>
		<p style="text-align: center;">คุณยังไม่มีการประเมินผลพนักงาน</p>
	<?php endif ?>

<footer>
	Copyright &copy; <?php echo date("Y"); ?> EngCom-RU. All rights reserved.
</footer>
</body>
</html>