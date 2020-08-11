<?php

function helperDateFormatForProduct($datetime, $lang = 'en')
{
	if (empty($datetime)) return '';

	switch ($lang) {
		case 'th':
			$result = date('d --- /// H:i:s', strtotime($datetime));
			$m 		= getMonthThai(date('m', strtotime($datetime)));
			$y 		= substr(date('Y', strtotime($datetime)) + 543, 2);
			return str_replace('///', $y, str_replace('---', $m, $result));
			break;

		default:

			return date('d M y H:i:s', strtotime($datetime));
			break;
	}
}

function helperDateFormatForNotification($datetime, $lang = 'en')
{
	if (empty($datetime)) return '';

	$match_date 	= new DateTime(date('Y-m-d', strtotime($datetime)));
	$current_date 	= new DateTime(date('Y-m-d'));
	$interval 		= $current_date->diff($match_date);
	$datetime 		= new DateTime(date('Y-m-d H:i:s', strtotime($datetime)));

	switch ($interval->days) {
		case 0:
			switch ($lang) {
				case 'en':
	    			return 'Today at '.date_format($datetime, 'H:i');
					break;
				case 'th':
	    			return 'วันนี้ เวลา '.date_format($datetime, 'H:i').' น.';
					break;
			}
		break;

		case 1:
			switch ($lang) {
				case 'en':
	    			return 'Yesterday at '.date_format($datetime, 'H:i');
					break;
				case 'th':
	    			return 'เมื่อวาน เวลา '.date_format($datetime, 'H:i').' น.';
					break;
			}
		break;

		default:
			switch ($lang) {
				case 'en':
			    	return date_format($datetime, 'M d').' at '.date_format($datetime, 'H:i');
					break;
				case 'th':
	    			return date_format($datetime, 'd').' '.getMonthThai(date_format($datetime, 'm')).' เวลา '.date_format($datetime, 'H:i').' น.';
					break;
			}
		break;
	}

	return $datetime;
}

function helperDateFormatForDashboard($datetime, $lang = 'en')
{
	if (empty($datetime)) return '';

	$match_date 	= new DateTime(date('Y-m-d', strtotime($datetime)));
	$current_date 	= new DateTime(date('Y-m-d'));
	$interval 		= (int)$current_date->diff($match_date)->format("%R%a");
	$datetime 		= new DateTime(date('Y-m-d H:i:s', strtotime($datetime)));

	switch ($interval) {
		case 0:
			switch ($lang) {
				case 'en':
	    			return 'Today at '.date_format($datetime, 'H:i');
					break;
				case 'th':
	    			return 'วันนี้ เวลา '.date_format($datetime, 'H:i').' น.';
					break;
			}
		break;

		case +1:
			switch ($lang) {
				case 'en':
	    			return 'Tomorrow at '.date_format($datetime, 'H:i');
					break;
				case 'th':
	    			return 'พรุ่งนี้ เวลา '.date_format($datetime, 'H:i').' น.';
					break;
			}
		break;

		case -1:
			switch ($lang) {
				case 'en':
	    			return 'Yesterday at '.date_format($datetime, 'H:i');
					break;
				case 'th':
	    			return 'เมื่อวาน เวลา '.date_format($datetime, 'H:i').' น.';
					break;
			}
		break;

		default:
			switch ($lang) {
				case 'en':
			    	return date_format($datetime, 'M d').' at '.date_format($datetime, 'H:i');
					break;
				case 'th':
	    			return date_format($datetime, 'd').' '.getMonthThai(date_format($datetime, 'm')).' เวลา '.date_format($datetime, 'H:i').' น.';
					break;
			}
		break;
	}

	return $datetime;
}

function getMonthThai($m)
{
	$month = ['ม.ค.', 'ก.พ.', 'มี.ค.', 'เม.ย.', 'พ.ค.', 'มิ.ย.', 'ก.ค.', 'ส.ค.', 'ก.ย.', 'ต.ค.', 'พ.ย.', 'ธ.ค.'];
	return (isset($month[$m - 1])) ? $month[$m - 1] : $m;
}