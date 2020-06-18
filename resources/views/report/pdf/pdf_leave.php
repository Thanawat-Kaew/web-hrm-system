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

	<h1 style="font-size: 50px;">LEAVES REPORT 
		<p style="font-size: 16px; text-align: right;"> Reported Date : <?php echo $getDate ?> | <?php echo $getTime ?></p>
	</h1>
	<hr>

	<h4 style="font-size: 20px;">Department : 
		<?php foreach ($get_department_name as $value) { ?>
			<span style="color: red;"><?php echo $value['name'] ?></span>
		<?php }?> 
	</h4>
	
	<h4 style="font-size: 20px;">ประเภทการลา : 
		<?php foreach($get_leaves_type as $value1 ) { ?>
			<span style="color: red;"><?php echo $value1['leaves_name'] ?>
		</span>			
		<?php } ?> | รูปแบบการลา : 
		<span style="color: red;"><?php echo ($leaves_format == '1') ? 'เต็มวัน' : ($leaves_format == '2') ? 'ครึ่งวัน' : ($leaves_format == '3') ? 'ชั่วโมง' : "" ;?>
	</span>
</h4>
<h4 style="font-size: 20px;">เริ่มวันที่ : <span style="color: red;"><?php echo ($start_date == "")? "" : $start_date ?></span>  |  ถึงวันที่ : <span style="color: red;"><?php echo ($end_date == "")? "" : $end_date ?></span>
</h4>
<!-- <hr> -->
<table>
	<thead>
		<tr>
			<th>#</th>
			<th>Name</th>
			<th>Department</th>
			<th>Position</th>
			<th>ประเภทการลา</th>
			<th>เริ่มวันที่</th>
			<th>สิ้นสุดวันที่</th>
			<th>จำนวน</th>
		</tr>
	</thead>
	<?php $no = 1 ?>
	<?php $count_emp = $emp_leaves->count();?>
	<?php for ($i=0; $i < $count_emp ; $i++) { ?> 
		<?php if(!empty($emp_leaves[$i]->employee->department)){ ?> 
			<?php $d=1; ?> 
			<?php $e=2; ?> 
			<?php $u=3; ?> 
			<tr>
				<td><?php echo $no++ ?></td>
				<td style="color: blue; text-align: left;
			padding: 2px;"> 
					<?php echo $emp_leaves[$i]->employee->first_name ?> <?php echo $emp_leaves[$i]->employee->last_name ?>
				</td>
				<td>
					<?php echo $emp_leaves[$i]->employee->department->name ?>
				</td>
				<td>
					<?php echo $emp_leaves[$i]->employee->Position->name ?>

				</td>
				<td>
					<?php echo $emp_leaves[$i]->leaves_type->leaves_name ?>
				</td>
				<td>
					<?php echo $emp_leaves[$i]->start_leave ?>
				</td>
				<td>
					<?php echo $emp_leaves[$i]->end_leave ?>
				</td>
				<?php if($emp_leaves[$i]->leaves_format->id_leaves_format == $d) { ?> 
					<td style="color: red;"><?php echo ($emp_leaves[$i]->total_leave/8) ?> วัน</td>
				<?php } ?>
				<?php if($emp_leaves[$i]->leaves_format->id_leaves_format == $e) { ?> 
					<td style="color: orange;"> ครึ่งวัน</td>
				<?php } ?>
				<?php if($emp_leaves[$i]->leaves_format->id_leaves_format == $u) { ?> 
					<td style="color: green;"><?php echo $emp_leaves[$i]->total_leave ?> ชั่วโมง</td>
				<?php } ?>
			</tr>
		<?php } ?>
	<?php } ?> 
</table>
<hr>
<footer>
	Copyright &copy; <?php echo date("Y"); ?> EngCom-RU. All rights reserved.
</footer>
</body>
</html>