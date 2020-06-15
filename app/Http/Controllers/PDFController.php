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
use Illuminate\Support\Facades\DB;


class PDFController extends Controller
{
    public function generatePDF_DumpEmp(Request $request)
    {
        date_default_timezone_set('Asia/Bangkok');
        $id_departments     = $request->get('id_department');
        $getDate            = date("Y-m-d");

        if ($id_departments == "") {
            $employee       = Employee::with('department','position','education')
                                            ->where('id_status','1')
                                            ->orderBy('id_department', 'asc')
                                            ->get();

            $get_count_dept = Employee::groupBy('id_department')
                                            ->where('id_status','1')
                                            ->select('id_department', DB::raw('count(*) as total'))
                                            ->with('department')
                                            ->get();

            $pdf            = PDF::loadView('data_management.dump_emp',compact('employee','id_departments','get_count_dept','getDate'));

        return $pdf->stream("dump_emp_all.pdf");

        }else{

            $employee_all   = Employee::with('department','position','education')
                                            ->where('id_status','1')
                                            ->orderBy('id_department', 'asc')
                                            ->get();

            $employee       = Employee::with('department','position','education')
                                            ->where('id_status','1')
                                            ->where('id_department',$id_departments)
                                            ->orderBy('id_department', 'asc')
                                            ->get();

            $get_count_dept = Employee::groupBy('id_department')
                                            ->where('id_status','1')
                                            ->where('id_department',$id_departments)
                                            ->select('id_department', DB::raw('count(*) as total'))
                                            ->with('department')
                                            ->get();

            $pdf             = PDF::loadView('data_management.dump_emp',compact('employee','employee_all','id_departments','get_count_dept','getDate'));

        return $pdf->stream("dump_emp.pdf");
        }
    }

    public function generatePDF_view_scroe(Request $request, $id_topic)
    {
        if(\Session::has('current_employee')){
            $current_employee = \Session::get('current_employee');
        }

        date_default_timezone_set('Asia/Bangkok');
        $getDate            = date("Y-m-d");

        $name_department    = Department::with('employee')
                                            ->where('id_department', $current_employee['id_department'])
                                            ->first(); 

        $id_department      = $current_employee->id_employee;
        $evaluations        = CreateEvaluation::where('status', 1)->get();
        $id_topic_          = $id_topic;

        $id_topic           = CreateEvaluation::with('employee')
                                                    ->where('id_topic', $id_topic_)
                                                    ->first();

        $emp_evaluation     = Evaluation::with('employee', 'employee.department', 'employee.position', 
                                                'resultevaluation', 'createevaluation')
                                            ->where('id_assessment_person', $id_department)
                                            ->where('id_topic',$id_topic_)
                                            ->get();

        $get_topic_detail   = CreateEvaluation::where('id_topic',$id_topic_)->first();

        $pdf                = PDF::loadView('evaluation.view_score',compact('getDate','emp_evaluation','list_name','id_topic', 'count_array_list_name', 'keep_array_list_name','evaluations','get_topic_detail','current_employee','name_department'));

        return $pdf->stream("view_score.pdf");
    }

	public function generatePDF_evaluation(Request $request)
	{      
        if(\Session::has('current_employee')){
            $current_employee = \Session::get('current_employee');
        }

		$department          = $request->has('department') ? $request->get('department') : '';
        $topic_name          = $request->has('topic_name') ? $request->get('topic_name') : ''; // ส่งค่ามาเป็น id_topic
        $id_employee         = $request->has('id_employee') ? '' : $request->get('id_employee');
        $start_date          = $request->get('start_date');
        $new_start_date      = date("Y-m-d", strtotime($start_date));
        $end_date            = $request->get('end_date');
        $new_end_date        = date("Y-m-d", strtotime($end_date));
        $start_number        = $request->get('start_number');
        $end_number          = $request->get('end_number');
        $getDate            = date("Y-m-d");
        $getTime            = date("h:i:sa");

        $topic_names  = CreateEvaluation::where('status', 1)->where('id_topic',$topic_name)->get();
        $emp_evaluation     = Evaluation::with('employee.position','resultevaluation', 'createevaluation');
          if(!empty($department)){
                    $emp_evaluation =   $emp_evaluation->with(['employee.department' => function($q) use($department){
                        $q->where('id_department', $department);
                    }]);
                } else{
                    $emp_evaluation = $emp_evaluation->with('employee.department');
                }

                if(!empty($topic_name)){
                    $emp_evaluation = $emp_evaluation->where('id_topic', $topic_name);
                }

                if(!empty($id_employee)){
                    $emp_evaluation = $emp_evaluation->where('id_assessor', $id_employee);
                }

                if(!empty($start_date)){
                    $emp_evaluation = $emp_evaluation->where('date', '>=', $new_start_date);
                }

                if(!empty($end_date)){
                    $emp_evaluation = $emp_evaluation->where('date', '<=', $new_end_date);
                }

                if(!empty($start_number)){
                    $emp_evaluation = $emp_evaluation->where('percent', '>=', $start_number);
                    $emp_evaluation = $emp_evaluation->orderBy('percent', 'desc');
                }

                if(!empty($end_number)){
                    $emp_evaluation = $emp_evaluation->where('percent', '<=', $end_number);
                    $emp_evaluation = $emp_evaluation->orderBy('percent', 'desc');
                }
                $emp_evaluation = $emp_evaluation->orderBy('id_assessor', 'asc')->get();

 // $emp_evaluation1     = Evaluation::with('employee.position','resultevaluation', 'createevaluation','employee.department')->get();
// sd( $emp_evaluation->toArray());


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

		$pdf = PDF::loadView('report.pdf.pdf_evaluations', compact('emp_evaluation', 'count_first_name', 'count_last_name', 'count_name_evaluation','get_department_name','topic_name','start_date','new_start_date','end_date','new_end_date','start_number','end_number','getDate','getTime','topic_names'));
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
        $id_employee_select = $request->get('id_employee');

		$emp_leaves   	= Leaves::with('employee.position');
		$emp_leaves 	= $emp_leaves->with('leaves_type');

		 if(!empty($department)){
            $emp_leaves =   $emp_leaves->with(['employee.department' => function($q) use($department){
                $q->where('id_department', $department);
            }]);

        } else{
            $emp_leaves = $emp_leaves->with('employee.department');
        }

        if (!empty($id_employee_select)) {
            $emp_leaves = $emp_leaves->where('id_employee', $id_employee_select);
            
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
        $department          = $request->has('department') ? $request->get('department') : '';
        $id_employee         = $request->get('id_employee');
        $start_date          = $request->get('start_date');
        $new_start_date      = date("Y-m-d", strtotime($start_date));
        $end_date            = $request->get('end_date');
        $new_end_date        = date("Y-m-d", strtotime($end_date));
        $start_time          = $request->get('start_time');
        $new_start_time      = date("H:i:s", strtotime($start_time));
        $end_time            = $request->get('end_time');
        $new_end_time        = date("H:i:s", strtotime($end_time));
        $getDate            = date("Y-m-d");
        $getTime            = date("h:i:sa");
        $get_department_name = Department::where('id_department',$department)->get();

        $emp_timestamp     = TimeStamp::with('employee.position');

        if(!empty($department)){
            $emp_timestamp =   $emp_timestamp->with(['employee.department' => function($q) use($department){
                $q->where('id_department', $department);
            }]);
        } else{
            $emp_timestamp = $emp_timestamp->with('employee.department');
        }

        if(!empty($id_employee)){
            $emp_timestamp = $emp_timestamp->where('id_employee', $id_employee);
        }

        if(!empty($start_date)){
            $emp_timestamp = $emp_timestamp->where('date', '>=', $new_start_date);
        }

        if(!empty($end_date)){
            $emp_timestamp = $emp_timestamp->where('date', '<=', $new_end_date);
        }

        if(!empty($start_time)){
            $emp_timestamp = $emp_timestamp->where('time_in', '>=', $new_start_time);
        }

        if(!empty($end_time)){
            $emp_timestamp = $emp_timestamp->where('time_out', '<=', $new_end_time);
        }

        $emp_timestamp = $emp_timestamp->orderBy('date', 'asc');
        $emp_timestamp = $emp_timestamp->get();


		$pdf = PDF::loadView('report.pdf.pdf_time_stamp', compact('emp_timestamp','department','start_date','new_start_date','end_date','new_end_date','start_time','new_start_time','end_time','new_end_time','getDate','getTime','get_department_name'));

		return $pdf->stream("PDF_Time_Stamp.pdf");
	}
}