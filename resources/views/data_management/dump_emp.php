<!doctype html>
<html lang="en">
<head>
	<meta http-equiv="Content-Type" content="text/html; charset=utf-8"/>
	<title>PDF_All_EMP</title>

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
			line-height: 1pt;
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

<h1 style="font-size: 50px;">All employees 
	<p style="font-size: 16px; text-align: right;"> Exported Date : <?php echo $getDate ?></p>
</h1>
<hr>
<h4>count : <?php echo $employee->count();?></h4>
<h4>gender : Male <?php echo $employee->where('gender' ,'ชาย')->count(); ?> , Female <?php echo $employee->where('gender' ,'หญิง')->count(); ?> </h4>
<hr>
<table>
	<thead>
		<tr>
			<th>department</th>
			<th>count.</th>
			<th>percentage.</th>
		</tr>		
	</thead>
<?php $count_emp = $employee->count() ?>

<?php foreach ($get_count_dept as $value) :?>
	<tbody>
		<tr>
			<td style="text-align: left; padding-left: 10px;"><?php echo $value->department->name?></td>
			<td><?php echo $value->total?> คน</td>
			<td style="color: red;"><?php echo $value->total*100/$count_emp?> %</td>
		</tr>
	</tbody>
<?php endforeach ?>
</table>
<hr>
<table>
	<thead>
		<tr>
			<th style="width: 30px;">#</th>
			<th style="width: 150px;">Name</th>
			<th style="width: 40px;">ID</th>
			<th>Department</th>
			<th style="width: 80px;">Position</th>
			<th style="width: 170px;">Email</th>
			<th style="width: 90px;">Tel.</th>
		</tr>
	</thead>
	<?php $no = 1 ?>
	<?php foreach($employee as $_employee) : ?>
		<tbody>
			<tr>
				<td><?php echo $no++ ?></td>
				<td style="text-align: left; padding-left: 10px;"><?php echo $_employee['first_name'] ?> <?php echo $_employee['last_name'] ?></td>
				<td><?php echo $_employee['id_employee'] ?></td>
				<td><?php echo $_employee->department['name'] ?></td>
				<td><?php echo $_employee->position['name'] ?></td>
				<td style="text-align: left; padding-left: 10px;"><?php echo $_employee['email'] ?></td>
				<td><?php echo $_employee['tel'] ?></td>
			</tr>
		</tbody>
	<?php endforeach?>
</table>
<hr>
<footer>
	Copyright &copy; <?php echo date("Y"); ?> EngCom-RU. All rights reserved.
</footer>
</body>
</html>