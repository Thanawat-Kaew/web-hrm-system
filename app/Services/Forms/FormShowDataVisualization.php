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
					        $form .='var chart = anychart.line();';
					        $form .='chart.padding([10, 20, 5, 20]);';
					        $form .='chart.animation(true);';
					        $form .='chart.crosshair(true);';
					        $form .='chart.title("กราฟสรุปผลแสดงช่วงค่าคะแนน/รายบุคคล");';
					        $form .='chart.yAxis().title("Percentage of result");';
					        $form .='var logScale = anychart.scales.log();';
					        $form .='logScale.minimum(1).maximum(1000);';
					        $form .='chart.yScale(logScale);';
					        $form .='var dataSet = anychart.data.set([';
					        foreach ($request_data as $value) {
					          	$form .='["'.$value->createevaluation->topic_name.'", "'.$value->percent.'"],';
					        }
					        $form .=']);';
					        $form .='var firstSeriesData = dataSet.mapAs({ x: 0, value: 1 });';
					        $form .='var series;';
					        $form .='series = chart.line(firstSeriesData);';
					        foreach ($request_data as $value) {

					        	$form .='series.name("'.$value->employee->first_name.' '.$value->employee->last_name.'");';
					    	}
					        $form .='series.labels().enabled(true).anchor("left-bottom").padding(5);';
					        $form .='series.markers(true);';
					        $form .='chart.legend().enabled(true).fontSize(13).padding([0, 0, 20, 0]);';
					        $form .='chart.container("content_one_person");';
					        $form .='chart.draw();';
					      $form .='});';
					$form .='</script>';

				}
				//--------------------------------------------------------------------------------------------
// 				if ($select_format == "2") {
// 		       //  	foreach ($request_data as $value2) {
// 		       //  		$a = $value2->where('percent','>=','80')->count();
// 		       //  		$b = $value2->where('percent','<=','79')->where('percent','>=','60')->count();
// 		       //  		$c = $value2->where('percent','<=','59')->where('percent','>=','40')->count();
// 		       //  		$d = $value2->where('percent','<=','39')->where('percent','>=','0')->count();
		          		
// 					    // // sd($value2->toArray());  
// 		       //    	} 

// 					$form .='<div id="content_one_department" style="height: 500px"></div>';
// 					  	$form .='<script>';
// 					      	$form .='anychart.onDocumentReady(function () {';
// 					        	$form .='var dataSet = anychart.data.set([';
// 					        	//----------------------------------------------------------- แต่ละแบบประเมิน


// $count_assessor = $request_data->count();
//                 //sd($count_assessor);
//             for ($i=0; $i < $count_assessor; $i++) {
//                 if(!empty($request_data[$i]->employee->department)){

// 					        	// foreach ($request_data[$i] as $value2) {
// 				       	$a = $request_data[$i]->where('percent','>=','80')->count();
// 		        		$b = $request_data[$i]->where('percent','<=','79')->where('percent','>=','60')->count();
// 		        		$c = $request_data[$i]->where('percent','<=','59')->where('percent','>=','40')->count();
// 		        		$d = $request_data[$i]->where('percent','<=','39')->where('percent','>=','0')->count();

// 					          		// $form .='["'.$request_data->createevaluation->topic_name.'", '.$a.', '.$b.', '.$c.', '.$d.'],';
// 		        		$form .='["'.$$request_data[$i]->createevaluation->topic_name.'", '.$a.', '.$b.', '.$c.', '.$d.'],';
// 					          	// }
// 					          }
// 					      }

// 					        	$form .=']);';
// 					        $form .='var firstSeriesData = dataSet.mapAs({ x: 0, value: 1 });';
// 					        $form .='var secondSeriesData = dataSet.mapAs({ x: 0, value: 2 });';
// 					        $form .='var thirdSeriesData = dataSet.mapAs({ x: 0, value: 3 });';
// 					        $form .='var fourthSeriesData = dataSet.mapAs({ x: 0, value: 4 });';
// 					        $form .='var chart = anychart.bar();';
// 					        $form .='chart.animation(true);';
// 					        $form .='chart.padding([10, 40, 5, 20]);';
// 					        $form .='chart.title("Top 3 Products with Region Sales Data");';
// 					        $form .='chart.yScale().minimum(0);';
// 					        $form .='chart.xAxis().labels().rotation(0).padding([0, 0, 20, 0]);';
// 					        $form .='chart.yAxis().labels().format("{%Value}{groupsSeparator: }");';
// 					        $form .='chart.yAxis().title("Revenue in Dollars");';
// 					        $form .='var setupSeries = function (series, name) {';
// 					          	$form .='series.name(name);';
// 					          	$form .='series.hovered().labels(false);';
// 					         	$form .='series';
// 						            $form .='.labels()';
// 						            $form .='.enabled(true)';
// 						            $form .='.position("right-center")';
// 						            $form .='.anchor("left-center")';
// 						            $form .='.format("{%Value}{groupsSeparator: }");';
// 					          	$form .='series';
// 						            $form .='.tooltip()';
// 						            $form .='.position("right")';
// 						            $form .='.anchor("left-center")';
// 						            $form .='.offsetX(5)';
// 						            $form .='.offsetY(0)';
// 						            $form .='.titleFormat("{%X}")';
// 						            $form .='.format("{%SeriesName} : {%Value}{groupsSeparator: }");';
// 					        $form .='};';
// 					        $form .='var series;';

// 					        $form .='series = chart.bar(firstSeriesData);';
// 					        $form .='setupSeries(series, "80-100%");';

// 					        $form .='series = chart.bar(secondSeriesData);';
// 					        $form .='setupSeries(series, "60-79%");';

// 					        $form .='series = chart.bar(thirdSeriesData);';
// 					        $form .='setupSeries(series, "40-59%");';

// 					        $form .='series = chart.bar(fourthSeriesData);';
// 					        $form .='setupSeries(series, "0-39%");';

// 					        $form .='chart.legend().enabled(true).fontSize(13).padding([0, 0, 20, 0]);';
// 					        $form .='chart.interactivity().hoverMode("single");';
// 					        $form .='chart.tooltip().positionMode("point");';
// 					        $form .='chart.container("content_one_department");';
// 					        $form .='chart.draw();';
// 					      $form .='});';
// 					$form .='</script>';
// 				}
				//-------------------------------------------------------------------------------------
				if ($select_format == "3") {
		       //  	foreach ($request_data as $value2) {
		       //  		$a = $value2->where('percent','>=','80')->count();
		       //  		$b = $value2->where('percent','<=','79')->where('percent','>=','60')->count();
		       //  		$c = $value2->where('percent','<=','59')->where('percent','>=','40')->count();
		       //  		$d = $value2->where('percent','<=','39')->where('percent','>=','0')->count();
		          		
					    // // sd($value2->toArray());  
		       //    	} 

					$form .='<div id="content_one_department" style="height: 500px"></div>';
					  	$form .='<script>';
					      	$form .='anychart.onDocumentReady(function () {';
					        	$form .='var dataSet = anychart.data.set([';
					        	//----------------------------------------------------------- แต่ละแบบประเมิน




					        	foreach ($request_data as $value3) {
				       	$a = $value3->where('id_topic','=',$value3->id_topic)->where('percent','>=','80')->count();
		        		$b = $value3->where('id_topic','=',$value3->id_topic)->where('percent','<=','79')->where('percent','>=','60')->count();
		        		$c = $value3->where('id_topic','=',$value3->id_topic)->where('percent','<=','59')->where('percent','>=','40')->count();
		        		$d = $value3->where('id_topic','=',$value3->id_topic)->where('percent','<=','39')->where('percent','>=','0')->count();
					          		// $form .='["'.$request_data->createevaluation->topic_name.'", '.$a.', '.$b.', '.$c.', '.$d.'],';
		        		$form .='["'.$value3->createevaluation->topic_name.'", '.$a.', '.$b.', '.$c.', '.$d.'],';
					          	}

					        	$form .=']);';
					        $form .='var firstSeriesData = dataSet.mapAs({ x: 0, value: 1 });';
					        $form .='var secondSeriesData = dataSet.mapAs({ x: 0, value: 2 });';
					        $form .='var thirdSeriesData = dataSet.mapAs({ x: 0, value: 3 });';
					        $form .='var fourthSeriesData = dataSet.mapAs({ x: 0, value: 4 });';
					        $form .='var chart = anychart.bar();';
					        $form .='chart.animation(true);';
					        $form .='chart.padding([10, 40, 5, 20]);';
					        $form .='chart.title("กราฟสรุปผลแสดงช่วงค่าคะแนน/บริษัท");';
					        $form .='chart.yScale().minimum(0);';
					        $form .='chart.xAxis().labels().rotation(0).padding([0, 0, 20, 0]);';
					        $form .='chart.yAxis().labels().format("{%Value}{groupsSeparator: }");';
					        $form .='chart.yAxis().title("จำนวนพนักงาน (คน)");';
					        $form .='var setupSeries = function (series, name) {';
					          	$form .='series.name(name);';
					          	$form .='series.hovered().labels(false);';
					         	$form .='series';
						            $form .='.labels()';
						            $form .='.enabled(true)';
						            $form .='.position("right-center")';
						            $form .='.anchor("left-center")';
						            $form .='.format("{%Value}{groupsSeparator: }");';
					          	$form .='series';
						            $form .='.tooltip()';
						            $form .='.position("right")';
						            $form .='.anchor("left-center")';
						            $form .='.offsetX(5)';
						            $form .='.offsetY(0)';
						            $form .='.titleFormat("{%X}")';
						            $form .='.format("{%SeriesName} : {%Value}{groupsSeparator: }");';
					        $form .='};';
					        $form .='var series;';

					        $form .='series = chart.bar(firstSeriesData);';
					        $form .='setupSeries(series, "80-100%");';

					        $form .='series = chart.bar(secondSeriesData);';
					        $form .='setupSeries(series, "60-79%");';

					        $form .='series = chart.bar(thirdSeriesData);';
					        $form .='setupSeries(series, "40-59%");';

					        $form .='series = chart.bar(fourthSeriesData);';
					        $form .='setupSeries(series, "0-39%");';

					        $form .='chart.legend().enabled(true).fontSize(16).padding([0, 0, 20, 0]);';
					        $form .='chart.interactivity().hoverMode("single");';
					        $form .='chart.tooltip().positionMode("point");';
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