<?php
namespace App\Services\Forms;

use App\Services\Employee\EmployeeObject;
class FormDumpEmp
{
	public function getFormDumpEmp($departments){

		$form = '<div class="row">';
		$form .= '<div class="col-md-12">';
		$form .= '<div class="col-md-10 col-md-offset-1">';
		$form .='<select class="form-control select2 select2-hidden-accessible" style="border-radius: 5px; height: 40px; font-size: 18px;" id="departments_pdf" data-dependent="header">';
		$form .='<option value="">ทั้งหมด</option>';
		foreach($departments as $department) {
			$form .='<option value="'.$department['id_department'].'"> '.$department["name"].' </option>';
		}
		$form .='</select>';
		$form .='</div>';
		$form .='</div>';
		$form .='</div>';

		return $form;
	}


}