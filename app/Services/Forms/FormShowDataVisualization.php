<?php
namespace App\Services\Forms;

use App\Services\Employee\EmployeeObject;
class FormShowDataVisualization
{
	public static function getFormShowDataVisualization($request_data,$select_format,$request_department2){

		$form ='<div class="box-body no-padding">';
			$form .='<div class="row">';
				$form .='<div class="col-md-12">';
				//------------------------------------------------------------------------------------------
				if ($select_format == "1") {

					$form .='<div id="content_one_person" style="height: 500px;"></div>';
					  $form .='<script>';
					       	$form .='anychart.onDocumentReady(function () {';
						        $form .='var chart = anychart.column();';
						        $form .='chart.animation(true);';
						        $form .='chart.title("กราฟสรุปผลแสดงช่วงค่าคะแนน/รายบุคคล");';
						        $form .='var series = chart.column([';

						        foreach ($request_data as $value) {
					          		$form .='["'.$value->createevaluation->topic_name.'", "'.$value->percent.'"],';
					        	}
						       
						        $form .=']);';
						        $form .='series.tooltip().titleFormat("{%X}");';
						        $form .='series';
						          $form .='.tooltip()';
						          $form .='.position("center-top")';
						          $form .='.anchor("center-bottom")';
						          $form .='.offsetX(0)';
						          $form .='.offsetY(5)';
						          $form .='.format("{%Value}{groupsSeparator: }");';
						        $form .='chart.yScale().minimum(0).maximum(100);';
						        $form .='chart.yAxis().labels().format("{%Value}{groupsSeparator: }");';
						        $form .='chart.tooltip().positionMode("point");';
						        $form .='chart.interactivity().hoverMode("by-x");';
						        $form .='chart.xAxis().title("Evaluations.");';
						        $form .='chart.yAxis().title("Percentage of result.");';
						        $form .='chart.container("content_one_person");';
						        $form .='chart.draw();';
						    $form .='});';
					$form .='</script>';

				}
			// -------------------------------------------------------------------------------------
				if ($select_format == "3") {
		    
					$form .='<div id="content_one_department" style="height: 550px"></div>';
					  	$form .='<script>';

						$form .='anychart.onDocumentReady(function () {';
					        $form .='var chartData = {';
					          $form .='title: "กราฟสรุปผลแสดงช่วงค่าคะแนน/รายบริษัท",';
					          $form .='header: ["#", "0-39%", "40-59%", "60-79%", "80-100%"],';
					          $form .='rows: [';

										foreach ($request_data as $value3) {
									       	$a = $value3->where('id_topic','=',$value3->id_topic)->where('percent','>=','80')->count();
							        		$b = $value3->where('id_topic','=',$value3->id_topic)->where('percent','<=','79')->where('percent','>=','60')->count();
							        		$c = $value3->where('id_topic','=',$value3->id_topic)->where('percent','<=','59')->where('percent','>=','40')->count();
							        		$d = $value3->where('id_topic','=',$value3->id_topic)->where('percent','<=','39')->where('percent','>=','0')->count();

					            				$form .='["'.$value3->createevaluation->topic_name.'", '.$d.', '.$c.', '.$b.', '.$a.'],';
					           			}
					          $form .=']';
					        $form .='};';
					        $form .='var chart = anychart.column();';
					        $form .='chart.data(chartData);';
					        $form .='chart.animation(true);';
					        $form .='chart.yAxis().labels().format("{%Value}{groupsSeparator: }");';
					        $form .='chart.yAxis().title("จำนวนพนักงาน/คน");';
					        $form .='chart';
					          $form .='.labels()';
					          $form .='.enabled(true)';
					          $form .='.position("center-top")';
					          $form .='.anchor("center-bottom")';
					          $form .='.format("{%Value}{groupsSeparator: }");';
					        $form .='chart.hovered().labels(false);';
					        $form .='chart.legend().enabled(true).fontSize(13).padding([0, 0, 20, 0]);';
					        $form .='chart.interactivity().hoverMode("single");';
					        $form .='chart';
					          $form .='.tooltip()';
					          $form .='.positionMode("point")';
					          $form .='.position("center-top")';
					          $form .='.anchor("center-bottom")';
					          $form .='.offsetX(0)';
					          $form .='.offsetY(5)';
					          $form .='.titleFormat("{%X}")';
					          $form .='.format("{%SeriesName} : {%Value}{groupsSeparator: }");';
					        $form .='chart.maxPointWidth("10%");';
					        $form .='chart.container("content_one_department");';
					        $form .='chart.draw();';
					    $form .='});';

					$form .='</script>';
				}

				$form .='</div>';
			$form .='</div>';
		$form .='</div>';

		return $form;
	}
}