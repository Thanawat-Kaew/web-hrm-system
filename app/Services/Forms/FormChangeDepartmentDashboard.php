<?php
namespace App\Services\Forms;

use App\Services\Employee\EmployeeObject;
class FormChangeDepartmentDashboard
{
	 public static function getFormChangeDepartmentDashboard($get_count_emp,$group_age){
	 	$form_total_emp ='';
      	$form_gender ='';
      	$form_age ='';

			$form_total_emp ='<div class="box-header with-border">';
			$form_total_emp .='<h3 class="box-title">Total Employees.</h3>';
			$form_total_emp .='</div>';
			$form_total_emp .='<div class="box-body no-padding">';
				$form_total_emp .='<div class="row" style="height: 230px;">';
					$form_total_emp .='<div class="col-md-12">';
						$form_total_emp .='<div style="text-align: center; margin-top: 40px;">';
							$form_total_emp .='<span style="font-size: 100px;">'.$get_count_emp->count().'</span>';
						$form_total_emp .='</div>';
					$form_total_emp .='</div>';
				$form_total_emp .='</div>';
			$form_total_emp .='</div>';

				$form_gender .='<div class="box-header with-border">';
					$form_gender .='<h3 class="box-title">Gender.</h3>';
				$form_gender .='</div>';
				$form_gender .='<div id="container" style="height: 230px;"></div>';
				$form_gender .='<script type="text/javascript">anychart.onDocumentReady(function() {';
					$form_gender .='var chart = anychart.bar();';
					$form_gender .='chart.title("");';
					$form_gender .='chart.data([';
						$form_gender .='{x: "ชาย", value: '.$get_count_emp->where("gender" ,"ชาย")->count() .'},';
						$form_gender .='{x: "หญิง", value: '.$get_count_emp->where("gender" ,"หญิง")->count() .' },';
						$form_gender .=']);';
					$form_gender .='chart.container("container");';
					$form_gender .='chart.labels().fontSize(20);';
					$form_gender .='chart.draw();});';
				$form_gender .='</script>';

				$form_age .='<div class="box-header with-border">';
					$form_age .='<h3 class="box-title">Employees by Age Groups.</h3>';
				$form_age .='</div>';

				$age_min_20	= $group_age->where('age','>=',1)->where('age','<=',20)->count();
				$age_21_30	= $group_age->where('age','>=',21)->where('age','<=',30)->count();
				$age_31_40	= $group_age->where('age','>=',31)->where('age','<=',40)->count();
				$age_41_50	= $group_age->where('age','>=',41)->where('age','<=',50)->count();
				$age_max_50	= $group_age->where('age','>=',51)->count();
				$count_emp = $get_count_emp->count(); 

				$form_age .='<table class="table table-bordered">';
					$form_age .='<thead>';
						$form_age .='<tr>';
							$form_age .='<th>Age</th>';
							$form_age .='<th>Progress</th>';
							$form_age .='<th></th>';
							$form_age .='<th>Employee</th>';
						$form_age .='</tr>';
					$form_age .='</thead>';
					$form_age .='<tbody>';
						$form_age .='<tr>';
							$form_age .='<td><20</td>';
							$form_age .='<td>';
								$form_age .='<div class="progress progress-xs progress-striped active">';
									$form_age .='<div class="progress-bar progress-bar-success" style="width: '.round(($age_min_20*100)/$count_emp,2)."%".'"></div>';
								$form_age .='</div>';
							$form_age .='</td>';
							$form_age .='<td>';
								$form_age .='<span class="badge bg-green">'.round(($age_min_20*100)/$count_emp,2) .' %</span>';
							$form_age .='</td>';
							$form_age .='<td>'.$age_min_20.' คน</td>';
						$form_age .='</tr>';
						$form_age .='<tr>';
							$form_age .='<td>21-30</td>';
							$form_age .='<td>';
								$form_age .='<div class="progress progress-xs progress-striped active">';
									$form_age .='<div class="progress-bar progress-bar-danger" style="width: '.round(($age_21_30*100)/$count_emp,2)."%".'"></div>';
								$form_age .='</div>';
							$form_age .='</td>';
							$form_age .='<td>';
								$form_age .='<span class="badge bg-red">'.round(($age_21_30*100)/$count_emp,2) .' %</span>';
							$form_age .='</td>';
							$form_age .='<td>'.$age_21_30.' คน</td>';
						$form_age .='</tr>';
						$form_age .='<tr>';
							$form_age .='<td>31-40</td>';
							$form_age .='<td>';
								$form_age .='<div class="progress progress-xs progress-striped active">';
									$form_age .='<div class="progress-bar progress-bar-primary" style="width: '.round(($age_31_40*100)/$count_emp,2)."%".';"></div>';
								$form_age .='</div>';
							$form_age .='</td>';
							$form_age .='<td>';
								$form_age .='<span class="badge bg-blue">'.round(($age_31_40*100)/$count_emp,2).' %</span>';
							$form_age .='</td>';
							$form_age .='<td>'.$age_31_40.' คน</td>';
						$form_age .='</tr>';
						$form_age .='<tr>';
							$form_age .='<td>41-50</td>';
							$form_age .='<td>';
								$form_age .='<div class="progress progress-xs progress-striped active">';
									$form_age .='<div class="progress-bar progress-bar-info" style="width: '.round(($age_41_50*100)/$count_emp,2)."%".';"></div>';
								$form_age .='</div>';
							$form_age .='</td>';
							$form_age .='<td>';
								$form_age .='<span class="badge bg-aqua">'.round(($age_41_50*100)/$count_emp,2).' %</span>';
							$form_age .='</td>';
							$form_age .='<td>'.$age_41_50.' คน</td>';
						$form_age .='</tr>';
						$form_age .='<tr>';
							$form_age .='<td>>51</td>';
							$form_age .='<td>';
								$form_age .='<div class="progress progress-xs progress-striped active">';
									$form_age .='<div class="progress-bar progress-bar-warning" style="width: '.round(($age_max_50*100)/$count_emp,2)."%".';"></div>';
								$form_age .='</div>';
							$form_age .='</td>';
							$form_age .='<td>';
								$form_age .='<span class="badge bg-orange">'.round(($age_max_50*100)/$count_emp,2).' %</span>';
							$form_age .='</td>';
							$form_age .='<td>'.$age_max_50.' คน</td>';
						$form_age .='</tr>';
					$form_age .='</tbody>';
				$form_age .='</table>';


        return ['form_total_emp' => $form_total_emp, 'form_gender' => $form_gender, 'form_age' => $form_age];

	 }
}