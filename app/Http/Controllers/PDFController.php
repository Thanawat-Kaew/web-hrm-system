<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Services\Forms\FormTimestampWhenChangeDepartment;
use App\Services\Forms\FormLeavesWhenChangeDepartment;
use App\Services\Forms\FormEvaluationWhenChangeDepartment;
use App\Http\Requests;
use App\Http\Controllers\Controller;
use App\Services\Forms\FormLeave;
use App\Services\Leaves\Leaves;
use App\Services\Leaves\DayOffYears;
use App\Services\Leaves\DetailDayOffYear;
use App\Services\Leaves\LeavesType;
use App\Services\Leaves\LeavesFormat;
use App\Services\Leaves\LeavesRequirements;
use App\Services\Employee\Employee;
use App\Services\Department\Department;
use App\Services\Position\Position;
use App\Services\Employee\EmployeeObject;
use App\Services\Company\Company;
use App\Services\Forms\FormViewDataRequestLeaves;
use App\Services\Forms\FormViewRequestLeaves;
use App\Services\Forms\FormEditRequestLeaves;
use App\Services\Request\RequestLeaves;
use App\Services\Request\Status;
use App\Services\TimeStamp\TimeStamp;
use App\Services\Evaluation\Evaluation;
use App\Services\Evaluation\ResultEvaluation;
use App\Services\Evaluation\CreateEvaluation;
use PDF;

class PDFController extends Controller
{
	public function generatePDF_evaluation(Request $request)
	{
		date_default_timezone_set('Asia/Bangkok');
		$department          = $request->has('department') ? $request->get('department') : '';
        $topic_name          = $request->has('topic_name') ? $request->get('topic_name') : ''; // ส่งค่ามาเป็น id_topic
        $start_date          = $request->get('start_date');
        $new_start_date      = date("Y-m-d", strtotime($start_date));
        $end_date            = $request->get('end_date');
        $new_end_date        = date("Y-m-d", strtotime($end_date));
        $start_number        = $request->get('start_number');
        $end_number          = $request->get('end_number');
        $getDate 			 = date("Y-m-d");
		$getTime			 = date("h:i:sa");

        if(empty($department)){// กรณีเลือกทุกแผนก
            if(empty($topic_name)){ // กรณีเลือกทุกหัวข้อ
                if(empty($start_date) && empty($end_date) && empty($start_number) && empty($end_number)){
                    //echo "1";
                    $emp_evaluation = Evaluation::with('employee')->orderBy('date', 'asc')->get();
                }else if(empty($start_date) && empty($end_date) && empty($start_number) && !empty($end_number)){
                    //echo "2";
                    $emp_evaluation = Evaluation::with('employee', 'employee.department', 'employee.position', 'resultevaluation', 'createevaluation')->where('percent', '<=', $end_number)->orderBy('percent', 'asc')->get();
                }else if(empty($start_date) && empty($end_date) && !empty($start_number) && empty($end_number)){
                    //echo "3";
                    $emp_evaluation = Evaluation::with('employee', 'employee.department', 'employee.position', 'resultevaluation', 'createevaluation')->where('percent', '>=', $start_number)->orderBy('percent', 'asc')->get();
                }else if(empty($start_date) && !empty($end_date) && empty($start_number) && empty($end_number)){
                    //echo "4";
                    $emp_evaluation = Evaluation::with('employee', 'employee.department', 'employee.position', 'resultevaluation', 'createevaluation')->where('date', '<=', $new_end_date)->orderBy('date', 'asc')->get();
                    //sd($emp_evaluation->toArray());
                }else if(!empty($start_date) && empty($end_date) && empty($start_number) && empty($end_number)){
                    //echo "5";
                    $emp_evaluation = Evaluation::with('employee', 'employee.department', 'employee.position', 'resultevaluation', 'createevaluation')->where('date', '>=', $new_start_date)->orderBy('date', 'asc')->get();
                }else if(!empty($start_date) && empty($end_date) && empty($start_number) && !empty($end_number)){
                    //echo "6";
                    $emp_evaluation = Evaluation::with('employee', 'employee.department', 'employee.position', 'resultevaluation', 'createevaluation')->where('date', '>=', $new_start_date)->where('percent', '>=', $end_number)->orderBy('date', 'asc')->get();
                }else if(!empty($start_date) && empty($end_date) && !empty($start_number) && empty($end_number)){
                    //echo "7";
                    $emp_evaluation = Evaluation::with('employee', 'employee.department', 'employee.position', 'resultevaluation', 'createevaluation')->where('date', '>=', $new_start_date)->where('percent', '<=', $start_number)->orderBy('date', 'asc')->get();
                }elseif(!empty($start_date) && !empty($end_date) && empty($start_number) && empty($end_number)){
                    //echo "8";
                    $emp_evaluation = Evaluation::with('employee', 'employee.department', 'employee.position', 'resultevaluation', 'createevaluation')->whereBetween('date', [$new_start_date,$new_end_date])->orderBy('date', 'asc')->get();
                }else if(!empty($start_date) && !empty($end_date) && empty($start_number) && !empty($end_number)){
                    //echo "9";
                    $emp_evaluation = Evaluation::with('employee', 'employee.department', 'employee.position', 'resultevaluation', 'createevaluation')->whereBetween('date', [$new_start_date,$new_end_date])->where('percent', '>=', $end_number)->orderBy('date', 'asc')->get();
                }else if(!empty($start_date) && !empty($end_date) && !empty($start_number) && empty($end_number)){
                    //echo "10";
                    $emp_evaluation = Evaluation::with('employee', 'employee.department', 'employee.position', 'resultevaluation', 'createevaluation')->whereBetween('date', [$new_start_date,$new_end_date])->where('percent', '<=', $start_number)->orderBy('date', 'asc')->get();
                }else if(!empty($start_date) && !empty($end_date) && !empty($start_number) && !empty($end_number)){
                    //echo "11";
                    $emp_evaluation = Evaluation::with('employee', 'employee.department', 'employee.position', 'resultevaluation', 'createevaluation')->whereBetween('date', [$new_start_date,$new_end_date])->whereBetween('percent', [$start_number, $end_number])->orderBy('date', 'asc')->get();
                }
            }else{ // กรณีระบุหัวเรื่องการประเมิน
                if(empty($start_date) && empty($end_date) && empty($start_number) && empty($end_number)){
                    //echo "1";
                    $emp_evaluation = Evaluation::with('employee')->where('id_topic', $topic_name)->orderBy('date', 'asc')->get();
                }else if(empty($start_date) && empty($end_date) && empty($start_number) && !empty($end_number)){
                    //echo "2";
                    $emp_evaluation = Evaluation::with('employee', 'employee.department', 'employee.position', 'resultevaluation', 'createevaluation')->where('percent', '<=', $end_number)->orderBy('percent', 'asc')->where('id_topic', $topic_name)->get();
                }else if(empty($start_date) && empty($end_date) && !empty($start_number) && empty($end_number)){
                    //echo "3";
                    $emp_evaluation = Evaluation::with('employee', 'employee.department', 'employee.position', 'resultevaluation', 'createevaluation')->where('percent', '>=', $start_number)->where('id_topic', $topic_name)->orderBy('percent', 'asc')->get();
                }else if(empty($start_date) && !empty($end_date) && empty($start_number) && empty($end_number)){
                    //echo "4";
                    $emp_evaluation = Evaluation::with('employee', 'employee.department', 'employee.position', 'resultevaluation', 'createevaluation')->where('date', '<=', $new_end_date)->where('id_topic', $topic_name)->orderBy('date', 'asc')->get();
                }else if(!empty($start_date) && empty($end_date) && empty($start_number) && empty($end_number)){
                    //echo "5";
                    $emp_evaluation = Evaluation::with('employee', 'employee.department', 'employee.position', 'resultevaluation', 'createevaluation')->where('date', '>=', $new_start_date)->where('id_topic', $topic_name)->orderBy('date', 'asc')->get();
                }else if(!empty($start_date) && empty($end_date) && empty($start_number) && !empty($end_number)){
                    //echo "6";
                    $emp_evaluation = Evaluation::with('employee', 'employee.department', 'employee.position', 'resultevaluation', 'createevaluation')->where('date', '>=', $new_start_date)->where('percent', '>=', $end_number)->where('id_topic', $topic_name)->orderBy('date', 'asc')->get();
                }else if(!empty($start_date) && empty($end_date) && !empty($start_number) && empty($end_number)){
                    //echo "7";
                    $emp_evaluation = Evaluation::with('employee', 'employee.department', 'employee.position', 'resultevaluation', 'createevaluation')->where('date', '>=', $new_start_date)->where('percent', '<=', $start_number)->where('id_topic', $topic_name)->orderBy('date', 'asc')->get();
                }elseif(!empty($start_date) && !empty($end_date) && empty($start_number) && empty($end_number)){
                    //echo "8";
                    $emp_evaluation = Evaluation::with('employee', 'employee.department', 'employee.position', 'resultevaluation', 'createevaluation')->whereBetween('date', [$new_start_date,$new_end_date])->where('id_topic', $topic_name)->orderBy('date', 'asc')->get();
                }else if(!empty($start_date) && !empty($end_date) && empty($start_number) && !empty($end_number)){
                    //echo "9";
                    $emp_evaluation = Evaluation::with('employee', 'employee.department', 'employee.position', 'resultevaluation', 'createevaluation')->whereBetween('date', [$new_start_date,$new_end_date])->where('percent', '>=', $end_number)->where('id_topic', $topic_name)->orderBy('date', 'asc')->get();
                }else if(!empty($start_date) && !empty($end_date) && !empty($start_number) && empty($end_number)){
                    //echo "10";
                    $emp_evaluation = Evaluation::with('employee', 'employee.department', 'employee.position', 'resultevaluation', 'createevaluation')->whereBetween('date', [$new_start_date,$new_end_date])->where('percent', '<=', $start_number)->where('id_topic', $topic_name)->orderBy('date', 'asc')->get();
                }else if(!empty($start_date) && !empty($end_date) && !empty($start_number) && !empty($end_number)){
                    //echo "11";
                    $emp_evaluation = Evaluation::with('employee', 'employee.department', 'employee.position', 'resultevaluation', 'createevaluation')->whereBetween('date', [$new_start_date,$new_end_date])->whereBetween('percent', [$start_number, $end_number])->where('id_topic', $topic_name)->orderBy('date', 'asc')->get();
                }
            }
        }else{ // กรณีเลือกแผนก
            if(empty($topic_name)){ // กรณีเลือกทุกหัวข้อ
                if(empty($start_date) && empty($end_date) && empty($start_number) && empty($end_number)){
                    $emp_evaluation = Evaluation::with('employee')
                                    ->with(['employee.department' => function($q) use($department){
                                        $q->where('id_department', $department);
                                    }])->orderBy('date', 'asc')->get();

                }else if(empty($start_date) && empty($end_date) && empty($start_number) && !empty($end_number)){
                    //echo "2";
                    $emp_evaluation = Evaluation::with('employee', 'employee.position', 'resultevaluation', 'createevaluation')->with(['employee.department' => function($q) use($department){
                                        $q->where('id_department', $department);
                                    }])->where('percent', '<=', $end_number)->orderBy('percent', 'asc')->get();

                }else if(empty($start_date) && empty($end_date) && !empty($start_number) && empty($end_number)){
                    //echo "3";
                    $emp_evaluation = Evaluation::with('employee', 'employee.position', 'resultevaluation', 'createevaluation')->with(['employee.department' => function($q) use($department){
                                        $q->where('id_department', $department);
                                    }])->where('percent', '>=', $start_number)->orderBy('percent', 'asc')->get();

                }else if(empty($start_date) && !empty($end_date) && empty($start_number) && empty($end_number)){
                    //echo "4";
                    $emp_evaluation = Evaluation::with('employee', 'employee.position', 'resultevaluation', 'createevaluation')->with(['employee.department' => function($q) use($department){
                                        $q->where('id_department', $department);
                                    }])->where('date', '<=', $new_end_date)->orderBy('date', 'asc')->get();
                }else if(!empty($start_date) && empty($end_date) && empty($start_number) && empty($end_number)){
                    //echo "5";
                    $emp_evaluation = Evaluation::with('employee', 'employee.position', 'resultevaluation', 'createevaluation')->with(['employee.department' => function($q) use($department){
                                        $q->where('id_department', $department);
                                    }])->where('date', '>=', $new_start_date)->orderBy('date', 'asc')->get();
                }else if(!empty($start_date) && empty($end_date) && empty($start_number) && !empty($end_number)){
                    //echo "6";
                    $emp_evaluation = Evaluation::with('employee', 'employee.position', 'resultevaluation', 'createevaluation')->with(['employee.department' => function($q) use($department){
                                        $q->where('id_department', $department);
                                    }])->where('date', '>=', $new_start_date)->where('percent', '>=', $end_number)->orderBy('date', 'asc')->get();
                }else if(!empty($start_date) && empty($end_date) && !empty($start_number) && empty($end_number)){
                    //echo "7";
                    $emp_evaluation = Evaluation::with('employee', 'employee.position', 'resultevaluation', 'createevaluation')->with(['employee.department' => function($q) use($department){
                                        $q->where('id_department', $department);
                                    }])->where('date', '>=', $new_start_date)->where('percent', '<=', $start_number)->orderBy('date', 'asc')->get();
                }elseif(!empty($start_date) && !empty($end_date) && empty($start_number) && empty($end_number)){
                    //echo "8";
                    $emp_evaluation = Evaluation::with('employee', 'employee.position', 'resultevaluation', 'createevaluation')->with(['employee.department' => function($q) use($department){
                                        $q->where('id_department', $department);
                                    }])->whereBetween('date', [$new_start_date,$new_end_date])->orderBy('date', 'asc')->get();
                }else if(!empty($start_date) && !empty($end_date) && empty($start_number) && !empty($end_number)){
                    //echo "9";
                    $emp_evaluation = Evaluation::with('employee', 'employee.position', 'resultevaluation', 'createevaluation')->with(['employee.department' => function($q) use($department){
                                        $q->where('id_department', $department);
                                    }])->whereBetween('date', [$new_start_date,$new_end_date])->where('percent', '>=', $end_number)->orderBy('date', 'asc')->get();
                }else if(!empty($start_date) && !empty($end_date) && !empty($start_number) && empty($end_number)){
                    //echo "10";
                    $emp_evaluation = Evaluation::with('employee', 'employee.position', 'resultevaluation', 'createevaluation')->with(['employee.department' => function($q) use($department){
                                        $q->where('id_department', $department);
                                    }])->whereBetween('date', [$new_start_date,$new_end_date])->where('percent', '<=', $start_number)->orderBy('date', 'asc')->get();
                }else if(!empty($start_date) && !empty($end_date) && !empty($start_number) && !empty($end_number)){
                    //echo "11";
                    $emp_evaluation = Evaluation::with('employee', 'employee.position', 'resultevaluation', 'createevaluation')->with(['employee.department' => function($q) use($department){
                                        $q->where('id_department', $department);
                                    }])->whereBetween('date', [$new_start_date,$new_end_date])->whereBetween('percent', [$start_number, $end_number])->orderBy('date', 'asc')->get();
                }
            }else{ // กรณีระบุหัวเรื่องการประเมิน
                if(empty($start_date) && empty($end_date) && empty($start_number) && empty($end_number)){
                    //echo "1";
                    $emp_evaluation = Evaluation::with('employee')->with(['employee.department' => function($q) use($department){
                                        $q->where('id_department', $department);
                                    }])->where('id_topic', $topic_name)->orderBy('date', 'asc')->get();
                }else if(empty($start_date) && empty($end_date) && empty($start_number) && !empty($end_number)){
                    //echo "2";
                    $emp_evaluation = Evaluation::with('employee', 'employee.position', 'resultevaluation', 'createevaluation')->where('percent', '<=', $end_number)->with(['employee.department' => function($q) use($department){
                                        $q->where('id_department', $department);
                                    }])->where('id_topic', $topic_name)->orderBy('date', 'asc')->get();
                }else if(empty($start_date) && empty($end_date) && !empty($start_number) && empty($end_number)){
                    //echo "3";
                    $emp_evaluation = Evaluation::with('employee', 'employee.position', 'resultevaluation', 'createevaluation')->with(['employee.department' => function($q) use($department){
                                        $q->where('id_department', $department);
                                    }])->where('percent', '>=', $start_number)->where('id_topic', $topic_name)->orderBy('date', 'asc')->get();
                }else if(empty($start_date) && !empty($end_date) && empty($start_number) && empty($end_number)){
                    //echo "4";
                    $emp_evaluation = Evaluation::with('employee', 'employee.position', 'resultevaluation', 'createevaluation')->with(['employee.department' => function($q) use($department){
                                        $q->where('id_department', $department);
                                    }])->where('date', '<=', $new_end_date)->where('id_topic', $topic_name)->orderBy('date', 'asc')->get();
                }else if(!empty($start_date) && empty($end_date) && empty($start_number) && empty($end_number)){
                    //echo "5";
                    $emp_evaluation = Evaluation::with('employee', 'employee.position', 'resultevaluation', 'createevaluation')->with(['employee.department' => function($q) use($department){
                                        $q->where('id_department', $department);
                                    }])->where('date', '>=', $new_start_date)->where('id_topic', $topic_name)->orderBy('date', 'asc')->get();
                }else if(!empty($start_date) && empty($end_date) && empty($start_number) && !empty($end_number)){
                    //echo "6";
                    $emp_evaluation = Evaluation::with('employee', 'employee.position', 'resultevaluation', 'createevaluation')->with(['employee.department' => function($q) use($department){
                                        $q->where('id_department', $department);
                                    }])->where('date', '>=', $new_start_date)->where('percent', '>=', $end_number)->where('id_topic', $topic_name)->orderBy('date', 'desc')->orderBy('date', 'asc')->get();
                }else if(!empty($start_date) && empty($end_date) && !empty($start_number) && empty($end_number)){
                    //echo "7";
                    $emp_evaluation = Evaluation::with('employee', 'employee.position', 'resultevaluation', 'createevaluation')->with(['employee.department' => function($q) use($department){
                                        $q->where('id_department', $department);
                                    }])->where('date', '>=', $new_start_date)->where('percent', '<=', $start_number)->where('id_topic', $topic_name)->orderBy('date', 'asc')->get();
                }else if(!empty($start_date) && !empty($end_date) && empty($start_number) && empty($end_number)){
                    //echo "8";
                    $emp_evaluation = Evaluation::with('employee', 'employee.position', 'resultevaluation', 'createevaluation')->with(['employee.department' => function($q) use($department){
                                        $q->where('id_department', $department);
                                    }])->whereBetween('date', [$new_start_date,$new_end_date])->where('id_topic', $topic_name)->orderBy('date', 'asc')->get();
                }else if(!empty($start_date) && !empty($end_date) && empty($start_number) && !empty($end_number)){
                    //echo "9";
                    $emp_evaluation = Evaluation::with('employee', 'employee.position', 'resultevaluation', 'createevaluation')->with(['employee.department' => function($q) use($department){
                                        $q->where('id_department', $department);
                                    }])->whereBetween('date', [$new_start_date,$new_end_date])->where('percent', '>=', $end_number)->where('id_topic', $topic_name)->orderBy('date', 'asc')->get();
                }else if(!empty($start_date) && !empty($end_date) && !empty($start_number) && empty($end_number)){
                    //echo "10";
                    $emp_evaluation = Evaluation::with('employee', 'employee.position', 'resultevaluation', 'createevaluation')->with(['employee.department' => function($q) use($department){
                                        $q->where('id_department', $department);
                                    }])->whereBetween('date', [$new_start_date,$new_end_date])->where('percent', '<=', $start_number)->where('id_topic', $topic_name)->orderBy('date', 'asc')->get();
                }else if(!empty($start_date) && !empty($end_date) && !empty($start_number) && !empty($end_number)){
                    //echo "11";
                    $emp_evaluation = Evaluation::with('employee', 'employee.position', 'resultevaluation', 'createevaluation')->with(['employee.department' => function($q) use($department){
                                        $q->where('id_department', $department);
                                    }])->whereBetween('date', [$new_start_date,$new_end_date])->whereBetween('percent', [$start_number, $end_number])->where('id_topic', $topic_name)->orderBy('date', 'asc')->get();
                }
            }
        }


        $array_assessment = array();
        $array_id_topic   = array();
        foreach ($emp_evaluation as $value){
            $array_assessment[] = $value->id_assessment_person;
            $array_id_topic[]   = $value->id_topic;
        }

        $count_assessment       = count($array_assessment);
        $count_first_name       = [];
        $count_last_name        = [];
        $count_name_evaluation  = [];
        for($i=0; $i<$count_assessment; $i++){
            $assessment         = Employee::where('id_employee', $array_assessment[$i])->first();
            $count_first_name[] = $assessment->first_name;
            $count_last_name[]  = $assessment->last_name;
            $name_evaluation    = CreateEvaluation::where('id_topic', $array_id_topic[$i])->first();
            $count_name_evaluation[] = $name_evaluation->topic_name;
        }

        $get_department_name = Department::where('id_department',$department)->get();

		$pdf = PDF::loadView('report.pdf.pdf_evaluations', compact('emp_evaluation', 'count_first_name', 'count_last_name', 'count_name_evaluation','get_department_name','topic_name','start_date','new_start_date','end_date','new_end_date','start_number','end_number','getDate','getTime'));
		$pdf->setPaper('A4', 'landscape');
		return $pdf->stream("PDF_EVALUATION.pdf");

	}

	public function generatePDF_leave(Request $request)
	{
		if(\Session::has('current_employee')){
			$current_employee = \Session::get('current_employee');
		}

		date_default_timezone_set('Asia/Bangkok');
		$id_employee 		= $current_employee['id_employee'];
		$id_department 		= $current_employee['id_department'];
		$department         = $request->has('department') ? $request->get('department') : '';
		$leaves_type        = $request->get('leaves_type');
		$leaves_format      = $request->get('leaves_format');
		$start_date         = $request->get('start_date');
		$new_start_date     = date("Y-m-d", strtotime($start_date));
		$end_date           = $request->get('end_date');
		$new_end_date       = date("Y-m-d", strtotime($end_date));
		$getDate 			= date("Y-m-d");
		$getTime			= date("h:i:sa");

		$emp_leaves   	= Leaves::with('employee.position');
		$emp_leaves 	= $emp_leaves->with('leaves_type');

		if(!empty($department)){
			$emp_leaves =	$emp_leaves->with(['employee.department' => function($q) use($department){
				$q->where('id_department', $department);
			}]);
		} else{
			$emp_leaves = $emp_leaves->with('employee.department');
		}

		
		if(!empty($leaves_type)){
			$emp_leaves = $emp_leaves->where('id_leaves_type', '=', $leaves_type);
		}

		if(!empty($leaves_format)){
			$emp_leaves = $emp_leaves->where('id_leaves_format', '=', $leaves_format);
		}

		if(!empty($start_date) && !empty($end_date)){
			$emp_leaves = $emp_leaves->where('start_leave', '>=', $new_start_date);
			$emp_leaves = $emp_leaves->where('end_leave', '<=', $new_end_date);

		}

		$emp_leaves = $emp_leaves->orderBy('start_leave', 'asc');
		$emp_leaves = $emp_leaves->get();
		
		$get_department_name = Department::where('id_department',$department)->get();
		$get_leaves_type = LeavesType::where('id_leaves_type',$leaves_type)->get();


		$pdf = PDF::loadView('report.pdf.pdf_leave', compact('emp_leaves','getDate','department','leaves_type','leaves_format','new_start_date','new_end_date','start_date','end_date','get_leaves_type','get_department_name','getTime'));

		return $pdf->stream("PDF_Leave.pdf");
		
	}

	public function generatePDF_time_stamp(Request $request)
	{
		date_default_timezone_set('Asia/Bangkok');
		$department        	= $request->has('department') ? $request->get('department') : '';
        $start_date        	= $request->get('start_date');
        $new_start_date    	= date("Y-m-d", strtotime($start_date));
        $end_date          	= $request->get('end_date');
        $new_end_date      	= date("Y-m-d", strtotime($end_date));
        $start_time        	= $request->get('start_time');
        $new_start_time    	= date("H:i:s", strtotime($start_time));
        $end_time          	= $request->get('end_time');
        $new_end_time      	= date("H:i:s", strtotime($end_time));
        $getDate 			= date("Y-m-d");
		$getTime			= date("h:i:sa");

        if(empty($department)){
            if(!empty($start_date) && !empty($end_date) && !empty($start_time) && !empty($end_time) ){ // ใส่ค่าทั้ง 4 ช่อง
                $emp_timestamp   = TimeStamp::with('employee', 'employee.department', 'employee.position')->whereBetween('date', [$new_start_date,$new_end_date])->where('time_in', '>=', $new_start_time)->where('time_out', '<', $new_end_time)->orderBy('date', 'asc')->get();

            }else if(!empty($start_date) && !empty($end_date) && !empty($start_time)){
               $emp_timestamp   = TimeStamp::with('employee', 'employee.department', 'employee.position')->whereBetween('date', [$new_start_date,$new_end_date])->where('time_in', '>=', $new_start_time)->orderBy('date', 'asc')->get();

            }else if(!empty($start_date) && !empty($end_date) && !empty($end_time)){
                $emp_timestamp   = TimeStamp::with('employee', 'employee.department', 'employee.position')->whereBetween('date', [$new_start_date,$new_end_date])->where('time_out', '<=', $new_end_time)->orderBy('date', 'asc')->get();

            }else if(!empty($start_date) && !empty($end_date)){
                $emp_timestamp   = TimeStamp::with('employee', 'employee.department', 'employee.position')->whereBetween('date', [$new_start_date,$new_end_date])->orderBy('date', 'asc')->get();

            }else if(!empty($start_date) && !empty($start_time)){
                $emp_timestamp   = TimeStamp::with('employee', 'employee.department', 'employee.position')->where('date', '>=', $new_start_date)->where('time_in', '>=', $new_start_time)->orderBy('date', 'asc')->get();

            }else if(!empty($start_date) && !empty($end_time)){
                $emp_timestamp   = TimeStamp::with('employee', 'employee.department', 'employee.position')->where('date', '>=', $new_start_date)->where('time_out', '<', $new_end_time)->orderBy('date', 'asc')->get();

            }else if(!empty($end_time)){
                $emp_timestamp   = TimeStamp::with('employee', 'employee.department', 'employee.position')->where('time_out', '<=', $new_end_time)->orderBy('time_out', 'asc')->get();

            }else if(!empty($start_time)){
                $emp_timestamp   = TimeStamp::with('employee', 'employee.department', 'employee.position')->where('time_in', '>=', $new_start_time)->orderBy('time_in', 'asc')->get();

            }else if(!empty($end_date)){
                //echo "3";
                $emp_timestamp   = TimeStamp::with('employee', 'employee.department', 'employee.position')->where('date', '<=', $new_end_date)->orderBy('date', 'asc')->get();

            }else if(!empty($start_date)){
                $emp_timestamp   = TimeStamp::with('employee', 'employee.department', 'employee.position')->where('date', '>=', $new_start_date)->orderBy('date', 'asc')->get();

            }else{
                $emp_timestamp   = TimeStamp::with('employee', 'employee.department', 'employee.position')->orderBy('date', 'desc')->get();
            }
            //$emp_timestamp   = TimeStamp::with('employee', 'employee.department', 'employee.position')->orderBy('date', 'desc')->get();
        }else{ 
            if(!empty($start_date) && !empty($end_date) && !empty($start_time) && !empty($end_time) ){ // ใส่ค่าทั้ง 4 ช่อง
                $emp_timestamp   = TimeStamp::with('employee', 'employee.position')
                                                ->with(['employee.department' => function($q) use($department){
                                                        $q->where('id_department', $department);}])
                                                ->whereBetween('date', [$new_start_date,$new_end_date])
                                                ->where('time_in', '>=', $new_start_time)
                                                ->where('time_out', '<', $new_end_time)
                                                ->orderBy('date', 'asc')
                                                ->get();

            }else if(!empty($start_date) && !empty($end_date) && !empty($start_time)){
                $emp_timestamp   = TimeStamp::with('employee', 'employee.position')
                                ->with(['employee.department' => function($q) use($department){
                $q->where('id_department', $department);
                }])->whereBetween('date', [$new_start_date,$new_end_date])->where('time_in', '>=', $new_start_time)->orderBy('date', 'asc')->get();
               
            }else if(!empty($start_date) && !empty($end_date) && !empty($end_time)){
                $emp_timestamp   = TimeStamp::with('employee', 'employee.position')
                                ->with(['employee.department' => function($q) use($department){
                $q->where('id_department', $department);
                }])->whereBetween('date', [$new_start_date,$new_end_date])->where('time_out', '<=', $new_end_time)->orderBy('date', 'asc')->get();

            }else if(!empty($start_date) && !empty($end_date)){
                $emp_timestamp   = TimeStamp::with('employee', 'employee.position')
                                ->with(['employee.department' => function($q) use($department){
                $q->where('id_department', $department);
                }])->whereBetween('date', [$new_start_date,$new_end_date])->orderBy('date', 'asc')->get();

            }else if(!empty($start_date) && !empty($start_time)){
                $emp_timestamp   = TimeStamp::with('employee', 'employee.position')
                                ->with(['employee.department' => function($q) use($department){
                $q->where('id_department', $department);
                }])->where('date', '>=', $new_start_date)->where('time_in', '>=', $new_start_time)->orderBy('date', 'asc')->get();

            }else if(!empty($start_date) && !empty($end_time)){
                $emp_timestamp   = TimeStamp::with('employee', 'employee.position')
                                ->with(['employee.department' => function($q) use($department){
                $q->where('id_department', $department);
                }])->where('date', '>=', $new_start_date)->where('time_out', '<', $new_end_time)->orderBy('date', 'asc')->get();

            }else if(!empty($end_time)){
                $emp_timestamp   = TimeStamp::with('employee', 'employee.position')
                                ->with(['employee.department' => function($q) use($department){
                $q->where('id_department', $department);
                }])->where('time_out', '<', $new_end_time)->orderBy('date', 'desc')->get();

            }else if(!empty($start_time)){
                $emp_timestamp   = TimeStamp::with('employee', 'employee.position')
                                ->with(['employee.department' => function($q) use($department){
                $q->where('id_department', $department);
                }])->where('time_in', '>=', $new_start_time)->orderBy('date', 'asc')->get();
                //echo "4";
            }else if(!empty($end_date)){
                $emp_timestamp   = TimeStamp::with('employee', 'employee.position')
                                ->with(['employee.department' => function($q) use($department){
                $q->where('id_department', $department);
                }])->where('date', '<=', $new_end_date)->orderBy('date', 'desc')->get();

            }else if(!empty($start_date)){
                $emp_timestamp   = TimeStamp::with('employee', 'employee.position')
                                        ->with(['employee.department' => function($q) use($department){
                                            $q->where('id_department', $department);
                                        }])->where('date', '>=', $new_start_date)->orderBy('date', 'desc')->get();

            }else{
                $emp_timestamp   = TimeStamp::with('employee', 'employee.position')
                                    ->with(['employee.department' => function($q) use($department){
                                        $q->where('id_department', $department);
                                        }])
                                    ->orderBy('date', 'desc')->get();
             
            }
        }

        $get_department_name = Department::where('id_department',$department)->get();

		$pdf = PDF::loadView('report.pdf.pdf_time_stamp', compact('emp_timestamp','department','start_date','new_start_date','end_date','new_end_date','start_time','new_start_time','end_time','new_end_time','getDate','getTime','get_department_name'));

		return $pdf->stream("PDF_Time_Stamp.pdf");
	}
}