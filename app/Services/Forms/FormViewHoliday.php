<?php
namespace App\Services\Forms;

use App\Services\Employee\EmployeeObject;
class FormViewHoliday
{
	public static function getFormViewHoliday($detail_day_off_year){
		$form ='<div class="callout callout-info" style="font-size:25px;">'.Date('Y').'	<div class="pull-right" style="font-size:16px;"> จำนวน '.$detail_day_off_year->count().' วัน</div></div>';
		$form .='<table class="table select-options table-hover table-bordered table-responsive" id="myTable" style=" padding: 0px;">';
			$form .='<tr class="header">';
				$form .='<th>#</th>';
				$form .='<th>รายการ</th>';
				$form .='<th>วันที่ (ปี-เดือน-วัน)</th>';
			$form .='</tr>';
			$count = 0;
			foreach($detail_day_off_year as $value):
				$form .='<tr>'; 
					$form .='<td> '.$count = $count+1.;'</td>';
					$compensate = ($value->compensate) ? 'ชดเชย':'';
					$form .='<td style="text-align:left;">'.$compensate.$value->day_off_year['name'].'</td>';
					$form .='<td>'.$value->date .'</td>';
				$form .='</tr>';
			endforeach;
			if(count($detail_day_off_year)== 0):
				$form .='<tr>';
					$form .='<td colspan="7" style="text-align: center;"> Data not found.</td>';
				$form .='</tr>';
			endif;
		$form .='</table>';

		return $form;
	}
}