<?php

namespace App\Http\Controllers\Report;

use Illuminate\Http\Request;
use App\Services\Forms\FormTimestampWhenChangeDepartment;
use App\Services\Forms\FormLeavesWhenChangeDepartment;
use App\Services\Forms\FormEvaluationWhenChangeDepartment;
use App\Services\Forms\FormViewEvaluation;
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
use App\Services\Evaluation\Part;
use App\Services\Evaluation\Question;
use App\Services\Evaluation\AnswerFormat;
use App\Services\Evaluation\AnswerDetails;

class ReportController extends Controller
{
	public function index()
    {
    	return $this->useTemplate('report.index');
    }

    public function reportTimeStamp()
    {
        if(\Session::has('current_employee')){
            $current_employee = \Session::get('current_employee');
        }

        if($current_employee['id_department'] !== "hr0001"){  // ไม่ใช่แผนก hr จะมองไม่เห็น dropdown เลือกแผนก
            $department  = $current_employee['id_department'];
            $timestamp   = TimeStamp::with('employee', 'employee.position')
                            ->with(['employee.department' => function($q) use($department){
                                $q->where('id_department', $department);
                            }])->orderBy('date', 'desc')->get();
            //sd($timestamp->toArray());
        }else{
            $department      = Department::all();
            $timestamp       = TimeStamp::with('employee', 'employee.department', 'employee.position')->orderBy('date', 'desc')->get();
        }
    	return $this->useTemplate('report.report_time_stamp', compact('department', 'timestamp', 'current_employee'));
    }

    public function reportLeave()
    {
        if(\Session::has('current_employee')){
            $current_employee = \Session::get('current_employee');
        }

        $department      = Department::all();
        $leaves_type       = LeavesType::all();
        $leaves_format      = LeavesFormat::all();
        $id_employee = $current_employee['id_employee'];
        $id_department = $current_employee['id_department'];

        if($current_employee['id_department'] !== "hr0001"){
            $datas = Leaves::with(['employee' => function ($q) use ($id_department){
                            $q->with('department')->where('id_department', $id_department);
                            $q->with('position');}])
                        ->with('leaves_type')
                        ->get();
                        // sd($datas->toArray());
        }else{
            $datas = Leaves::with(['employee' => function ($q) use ($id_employee){
                            $q->with('department');
                            $q->with('position');}])
                        ->with('leaves_type')
                        ->get();
        }

    	return $this->useTemplate('report.report_leave',compact('datas','department','leaves_type','leaves_format','current_employee'));
    }

    public function reportEvaluation()
    {
        $department  = Department::all(); /*เลือกเอาชื่อมาทุกแผนก*/

        /*$assessor    = Evaluation::with('employee', 'employee.department', 'employee.position', 'resultevaluation')
                        ->with(['createevaluation' => function($q){
                            $q->orderBy('created_at', 'desc');
                        }])->orderBy('id_assessor', 'asc')->get();*/

        $assessor    = Evaluation::with('employee', 'employee.department', 'employee.position', 'resultevaluation', 'createevaluation')
                        ->orderBy('id_assessor', 'asc')->orderBy('id_topic', 'desc')->get();
         /*เชื่อม Database ตั้งงื่อนไข้ว่า เรียง id จากน้อยไปมาก และเรียงจาก id_topic จากมากไปน้อย*/

        $array_assessment = array();
        $array_id_topic   = array();
        foreach ($assessor as $value){ /*วน loop*/
                $array_assessment[] = $value->id_assessment_person; /* เก็บ id ผู้ประเมิน*/
                $array_id_topic[]   = $value->id_topic; /*เก็บ id หัวเรื่อง*/
        }

        $count_assessment       = count($array_assessment); /*ทำการนับจำนวนผู้ประเมิน*/
        $count_first_name       = [];
        $count_last_name        = [];
        $count_name_evaluation  = [];
        for($i=0; $i<$count_assessment; $i++){
            $assessment         = Employee::where('id_employee', $array_assessment[$i])->first();/*หา id ผู้ประเมิน*/
            $count_first_name[] = $assessment->first_name; /*เอาชื่อมา*/
            $count_last_name[]  = $assessment->last_name; /*เอานามสกุลมา*/
            $name_evaluation    = CreateEvaluation::where('id_topic', $array_id_topic[$i])->first(); /*หา id หัวเรื่อง*/
            $count_name_evaluation[] = $name_evaluation->topic_name; /*เอาชื่อมา*/
        }

        // sd($count_name_evaluation);
        $topic_name  = CreateEvaluation::where('status', 1)->get();
        // sd($topic_name->toArray());
    	return $this->useTemplate('report.report_evaluations', compact('assessor', 'count_first_name', 'count_last_name', 'count_name_evaluation', 'department', 'topic_name'));
    }

    public function reportOverview()
    {
        // $get_count_emp  = Employee::where('gender','ชาย')->count();
        $get_count_emp  = Employee::all();
        // sd($get_count_emp);
        // $get_count_dept = Employee::with('department')->get();
        $get_count_dept = Employee::all()->groupBy('id_department')->count();
        // $get_count_dept = Employee::with('department')->groupBy('id_department')->get();
        // sd($get_count_dept);

    	return $this->useTemplate('report.report_overview',compact('get_count_emp'));
    }

    public function ajaxCenter(Request $request)
    {
        $method = $request->get('method');
        switch ($method) {
            case 'getFormTimestampWhenChangeDepartment':
                $department          = $request->has('department') ? $request->get('department') : '';
                $start_date          = $request->get('start_date');
                $new_start_date      = date("Y-m-d", strtotime($start_date));
                $end_date            = $request->get('end_date');
                $new_end_date        = date("Y-m-d", strtotime($end_date));
                $start_time          = $request->get('start_time');
                $new_start_time      = date("H:i:s", strtotime($start_time));
                $end_time            = $request->get('end_time');
                $new_end_time        = date("H:i:s", strtotime($end_time));
                if(empty($department)){ // กรณีเลือกทุกแผนก
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
                }else{ // กรณีเลือกเฉาะแผนก
                    /*$emp_timestamp   = TimeStamp::with('employee', 'employee.position')
                                        ->with(['employee.department' => function($q) use($department){
                        $q->where('id_department', $department);
                    }]);*/
                    /*if(!empty($start_date) && !empty($end_date)) {
                        $emp_timestamp = $emp_timestamp->whereBetween('date', [$new_start_date,$new_end_date]);
                    }else if(!empty($start_date)){
                        $emp_timestamp = $emp_timestamp->where('date','>=', $new_start_date);
                    }else if(!empty($end_date)){
                        $emp_timestamp = $emp_timestamp->where('date','<=', $new_end_date);
                    }
                    $emp_timestamp = $emp_timestamp->orderBy('date', 'asc')->get();*/
                   //sd($emp_timestamp->toArray());
                    if(!empty($start_date) && !empty($end_date) && !empty($start_time) && !empty($end_time) ){ // ใส่ค่าทั้ง 4 ช่อง
                        //echo "10";
                        $emp_timestamp   = TimeStamp::with('employee', 'employee.position')
                                                        ->with(['employee.department' => function($q) use($department){
                                                                $q->where('id_department', $department);}])
                                                        ->whereBetween('date', [$new_start_date,$new_end_date])
                                                        ->where('time_in', '>=', $new_start_time)
                                                        ->where('time_out', '<', $new_end_time)
                                                        ->orderBy('date', 'asc')
                                                        ->get();
// sd($emp_timestamp->toArray());
                        /*$emp_timestamp = $emp_timestamp->whereBetween('date', [$new_start_date,$new_end_date])->where('time_in', '>=', $new_start_time)->where('time_out', '<=', $new_end_time)->orderBy('date', 'asc')->get();*/

                        //sd($emp_timestamp->toArray());
                    }else if(!empty($start_date) && !empty($end_date) && !empty($start_time)){
                        $emp_timestamp   = TimeStamp::with('employee', 'employee.position')
                                        ->with(['employee.department' => function($q) use($department){
                        $q->where('id_department', $department);
                        }])->whereBetween('date', [$new_start_date,$new_end_date])->where('time_in', '>=', $new_start_time)->orderBy('date', 'asc')->get();
                        //sd($emp_timestamp->toArray());
                        //echo "9";
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
                        //echo "8";
                    }else if(!empty($start_date) && !empty($start_time)){
                        $emp_timestamp   = TimeStamp::with('employee', 'employee.position')
                                        ->with(['employee.department' => function($q) use($department){
                        $q->where('id_department', $department);
                        }])->where('date', '>=', $new_start_date)->where('time_in', '>=', $new_start_time)->orderBy('date', 'asc')->get();
                        //echo "7";
                    }else if(!empty($start_date) && !empty($end_time)){
                        $emp_timestamp   = TimeStamp::with('employee', 'employee.position')
                                        ->with(['employee.department' => function($q) use($department){
                        $q->where('id_department', $department);
                        }])->where('date', '>=', $new_start_date)->where('time_out', '<', $new_end_time)->orderBy('date', 'asc')->get();
                        //echo "6";
                    }else if(!empty($end_time)){
                        $emp_timestamp   = TimeStamp::with('employee', 'employee.position')
                                        ->with(['employee.department' => function($q) use($department){
                        $q->where('id_department', $department);
                        }])->where('time_out', '<', $new_end_time)->orderBy('date', 'desc')->get();
                        //echo "5";
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
                        //echo "3";
                    }else if(!empty($start_date)){
                        $emp_timestamp   = TimeStamp::with('employee', 'employee.position')
                                                ->with(['employee.department' => function($q) use($department){
                                                    $q->where('id_department', $department);
                                                }])->where('date', '>=', $new_start_date)->orderBy('date', 'desc')->get();
                        //echo "2";
                    }else{
                        $emp_timestamp   = TimeStamp::with('employee', 'employee.position')
                                            ->with(['employee.department' => function($q) use($department){
                                                $q->where('id_department', $department);
                                                }])
                                            ->orderBy('date', 'desc')->get();
                        //echo "1";
                        //$emp_timestamp = $emp_timestamp->orderBy('date', 'desc')->get();
                    }
                }

                $form_repo       = new FormTimestampWhenChangeDepartment;
                $get_form_emp    = $form_repo->getFormTimestampWhenChangeDepartment($emp_timestamp);
                return response()->json(['status'=> 'success','data'=> $get_form_emp]);

            break;

           case 'getFormLeavesWhenChangeDepartment':

                    if(\Session::has('current_employee')){
                        $current_employee = \Session::get('current_employee');
                    }

                    $id_employee = $current_employee['id_employee'];
                    $id_department = $current_employee['id_department'];
                    $department         = $request->has('department') ? $request->get('department') : '';
                    $leaves_type        = $request->get('leaves_type');
                    $leaves_format      = $request->get('leaves_format');
                    $start_date         = $request->get('start_date');
                    $new_start_date     = date("Y-m-d", strtotime($start_date));
                    $end_date           = $request->get('end_date');
                    $new_end_date       = date("Y-m-d", strtotime($end_date));

                    if(empty($department)){
                        if(!empty($leaves_type) && !empty($leaves_format) && !empty($start_date) && !empty($end_date) ){
                            $emp_leaves   = Leaves::with(['employee' => function ($q) use ($id_employee){
                                                        $q->with('department');
                                                        $q->with('position');}])
                                                    ->with('leaves_type')
                                                    ->where('id_leaves_type', '=', $leaves_type)
                                                    ->where('id_leaves_format', '=', $leaves_format)
                                                    ->where('start_leave', '>=', $new_start_date)
                                                    ->where('end_leave', '<=', $new_end_date)
                                                    ->orderBy('start_leave', 'asc')
                                                    ->get();
                        }else if(!empty($leaves_type) && !empty($leaves_format) && !empty($start_date)){
                            $emp_leaves   = Leaves::with(['employee' => function ($q) use ($id_employee){
                                                        $q->with('department');
                                                        $q->with('position');}])
                                                    ->with('leaves_type')
                                                    ->where('id_leaves_type', '=', $leaves_type)
                                                    ->where('id_leaves_format', '=', $leaves_format)
                                                    ->where('start_leave', '>=', $new_start_date)
                                                    ->orderBy('start_leave', 'asc')
                                                    ->get();
                        }else if(!empty($leaves_type) && !empty($leaves_format) && !empty($end_date) ){
                            $emp_leaves   = Leaves::with(['employee' => function ($q) use ($id_employee){
                                                        $q->with('department');
                                                        $q->with('position');}])
                                                    ->with('leaves_type')
                                                    ->where('id_leaves_type', '=', $leaves_type)
                                                    ->where('id_leaves_format', '=', $leaves_format)
                                                    ->where('end_leave', '<=', $new_end_date)
                                                    ->orderBy('start_leave', 'asc')
                                                    ->get();
                        }else if(!empty($leaves_type) && !empty($leaves_format)){
                            $emp_leaves   = Leaves::with(['employee' => function ($q) use ($id_employee){
                                                        $q->with('department');
                                                        $q->with('position');}])
                                                    ->with('leaves_type')
                                                    ->where('id_leaves_type', '=', $leaves_type)
                                                    ->where('id_leaves_format', '=', $leaves_format)
                                                    ->orderBy('start_leave', 'asc')
                                                    ->get();
                        }else if(!empty($leaves_type) && !empty($start_date) && !empty($end_date) ){
                            $emp_leaves   = Leaves::with(['employee' => function ($q) use ($id_employee){
                                                        $q->with('department');
                                                        $q->with('position');}])
                                                    ->with('leaves_type')
                                                    ->where('id_leaves_type', '=', $leaves_type)
                                                    ->where('start_leave', '>=', $new_start_date)
                                                    ->where('end_leave', '<=', $new_end_date)
                                                    ->orderBy('start_leave', 'asc')
                                                    ->get();
                        }else if(!empty($leaves_type) && !empty($start_date)){
                            $emp_leaves   = Leaves::with(['employee' => function ($q) use ($id_employee){
                                                        $q->with('department');
                                                        $q->with('position');}])
                                                    ->with('leaves_type')
                                                    ->where('id_leaves_type', '=', $leaves_type)
                                                    ->where('end_leave', '>=', $new_start_date)
                                                    ->orderBy('start_leave', 'asc')
                                                    ->get();
                        }else if(!empty($leaves_type) && !empty($end_date) ){
                            $emp_leaves   = Leaves::with(['employee' => function ($q) use ($id_employee){
                                                        $q->with('department');
                                                        $q->with('position');}])
                                                    ->with('leaves_type')
                                                    ->where('id_leaves_type', '=', $leaves_type)
                                                    ->where('end_leave', '<=', $new_end_date)
                                                    ->orderBy('start_leave', 'asc')
                                                    ->get();
                        }else if(!empty($leaves_type)){
                            $emp_leaves   = Leaves::with(['employee' => function ($q) use ($id_employee){
                                                        $q->with('department');
                                                        $q->with('position');}])
                                                    ->with('leaves_type')
                                                    ->where('id_leaves_type', '=', $leaves_type)
                                                    ->orderBy('start_leave', 'asc')
                                                    ->get();
                        }else if(!empty($leaves_format) && !empty($start_date) && !empty($end_date)){
                            $emp_leaves   = Leaves::with(['employee' => function ($q) use ($id_employee){
                                                        $q->with('department');
                                                        $q->with('position');}])
                                                    ->with('leaves_format')
                                                    ->where('id_leaves_format', '=', $leaves_format)
                                                    ->where('start_leave', '>=', $new_start_date)
                                                    ->where('end_leave', '<=', $new_end_date)
                                                    ->orderBy('start_leave', 'asc')
                                                    ->get();
                        }else if(!empty($leaves_format) && !empty($start_date)){
                            $emp_leaves   = Leaves::with(['employee' => function ($q) use ($id_employee){
                                                        $q->with('department');
                                                        $q->with('position');}])
                                                    ->with('leaves_format')
                                                    ->where('id_leaves_format', '=', $leaves_format)
                                                    ->where('start_leave', '>=', $new_start_date)
                                                    ->orderBy('start_leave', 'asc')
                                                    ->get();
                        }else if(!empty($leaves_format) && !empty($end_date) ){
                            $emp_leaves   = Leaves::with(['employee' => function ($q) use ($id_employee){
                                                        $q->with('department');
                                                        $q->with('position');}])
                                                    ->with('leaves_format')
                                                    ->where('id_leaves_format', '=', $leaves_format)
                                                    ->where('end_leave', '<=', $new_end_date)
                                                    ->orderBy('start_leave', 'asc')
                                                    ->get();
                        }else if(!empty($leaves_format)){
                            $emp_leaves   = Leaves::with(['employee' => function ($q) use ($id_employee){
                                                        $q->with('department');
                                                        $q->with('position');}])
                                                    ->with('leaves_format')
                                                    ->where('id_leaves_format', '=', $leaves_format)
                                                    ->orderBy('start_leave', 'asc')
                                                    ->get();
                        }else if(!empty($start_date) && !empty($end_date) ){
                            $emp_leaves   = Leaves::with(['employee' => function ($q) use ($id_employee){
                                                        $q->with('department');
                                                        $q->with('position');}])
                                                    ->where('start_leave', '>=', $new_start_date)
                                                    ->where('end_leave', '<=', $new_end_date)
                                                    ->orderBy('start_leave', 'asc')
                                                    ->get();
                        }else if(!empty($start_date)){
                            $emp_leaves   = Leaves::with(['employee' => function ($q) use ($id_employee){
                                                        $q->with('department');
                                                        $q->with('position');}])
                                                    ->where('start_leave', '>=', $new_start_date)
                                                    ->orderBy('start_leave', 'asc')
                                                    ->get();
                        }else if(!empty($end_date)){
                            $emp_leaves   = Leaves::with(['employee' => function ($q) use ($id_employee){
                                                        $q->with('department');
                                                        $q->with('position');}])
                                                    ->where('end_leave', '<=', $new_end_date)
                                                    ->orderBy('start_leave', 'asc')
                                                    ->get();
                        }else{
                            $emp_leaves   = Leaves::with(['employee' => function ($q) use ($id_employee){
                                                        $q->with('department');
                                                        $q->with('position');}])
                                                    ->with('leaves_type')
                                                    ->orderBy('start_leave', 'asc')
                                                    ->get();
                        }
                    }else {
                         if(!empty($leaves_type) && !empty($leaves_format) && !empty($start_date) && !empty($end_date) ){
                            $emp_leaves   = Leaves::with('employee', 'employee.position')
                                                ->with(['employee.department' => function($q) use($department){
                                                    $q->where('id_department', $department);}])
                                                ->with('leaves_type')
                                                ->where('id_leaves_type', '=', $leaves_type)
                                                ->with('leaves_format')
                                                ->where('id_leaves_format', '=', $leaves_format)
                                                ->where('start_leave', '>=', $new_start_date)
                                                ->where('end_leave', '<=', $new_end_date)
                                                ->orderBy('start_leave', 'asc')
                                                ->get();
                         }
                        else if(!empty($leaves_type) && !empty($leaves_format) && !empty($start_date) ){
                            $emp_leaves   = Leaves::with('employee', 'employee.position')
                                                ->with(['employee.department' => function($q) use($department){
                                                    $q->where('id_department', $department);}])
                                                ->with('leaves_type')
                                                ->where('id_leaves_type', '=', $leaves_type)
                                                ->with('leaves_format')
                                                ->where('id_leaves_format', '=', $leaves_format)
                                                ->where('start_leave', '>=', $new_start_date)
                                                ->orderBy('start_leave', 'asc')
                                                ->get();
                         }
                         else if(!empty($leaves_type) && !empty($leaves_format) && !empty($end_date) ){
                            $emp_leaves   = Leaves::with('employee', 'employee.position')
                                                ->with(['employee.department' => function($q) use($department){
                                                    $q->where('id_department', $department);}])
                                                ->with('leaves_type')
                                                ->where('id_leaves_type', '=', $leaves_type)
                                                ->with('leaves_format')
                                                ->where('id_leaves_format', '=', $leaves_format)
                                                ->where('end_leave', '<=', $new_end_date)
                                                ->orderBy('start_leave', 'asc')
                                                ->get();
                         }
                         else if(!empty($leaves_type) && !empty($leaves_format)){
                            $emp_leaves   = Leaves::with('employee', 'employee.position')
                                                ->with(['employee.department' => function($q) use($department){
                                                    $q->where('id_department', $department);}])
                                                ->with('leaves_type')
                                                ->where('id_leaves_type', '=', $leaves_type)
                                                ->with('leaves_format')
                                                ->where('id_leaves_format', '=', $leaves_format)
                                                ->orderBy('start_leave', 'asc')
                                                ->get();
                         }
                         else if(!empty($leaves_type) && !empty($start_date) && !empty($end_date) ){
                            $emp_leaves   = Leaves::with('employee', 'employee.position')
                                                ->with(['employee.department' => function($q) use($department){
                                                    $q->where('id_department', $department);}])
                                                ->with('leaves_type')
                                                ->where('id_leaves_type', '=', $leaves_type)
                                                ->where('start_leave', '>=', $new_start_date)
                                                ->where('end_leave', '<=', $new_end_date)
                                                ->orderBy('start_leave', 'asc')
                                                ->get();
                         }
                         else if(!empty($leaves_type) && !empty($start_date)){
                            $emp_leaves   = Leaves::with('employee', 'employee.position')
                                                ->with(['employee.department' => function($q) use($department){
                                                    $q->where('id_department', $department);}])
                                                ->with('leaves_type')
                                                ->where('id_leaves_type', '=', $leaves_type)
                                                ->where('start_leave', '>=', $new_start_date)
                                                ->orderBy('start_leave', 'asc')
                                                ->get();
                         }
                         else if(!empty($leaves_type) && !empty($end_date) ){
                            $emp_leaves   = Leaves::with('employee', 'employee.position')
                                                ->with(['employee.department' => function($q) use($department){
                                                    $q->where('id_department', $department);}])
                                                ->with('leaves_type')
                                                ->where('id_leaves_type', '=', $leaves_type)
                                                ->where('end_leave', '<=', $new_end_date)
                                                ->orderBy('start_leave', 'asc')
                                                ->get();
                         }
                         else if(!empty($leaves_type)){
                            $emp_leaves   = Leaves::with('employee', 'employee.position')
                                                ->with(['employee.department' => function($q) use($department){
                                                    $q->where('id_department', $department);}])
                                                ->with('leaves_type')
                                                ->where('id_leaves_type', '=', $leaves_type)
                                                ->orderBy('start_leave', 'asc')
                                                ->get();
                         }
                         else if(!empty($leaves_format) && !empty($start_date) && !empty($end_date) ){
                            $emp_leaves   = Leaves::with('employee', 'employee.position')
                                                ->with(['employee.department' => function($q) use($department){
                                                    $q->where('id_department', $department);}])
                                                ->with('leaves_format')
                                                ->where('id_leaves_format', '=', $leaves_format)
                                                ->where('start_leave', '>=', $new_start_date)
                                                ->where('end_leave', '<=', $new_end_date)
                                                ->orderBy('start_leave', 'asc')
                                                ->get();
                         }
                         else if(!empty($leaves_format) && !empty($start_date)){
                            $emp_leaves   = Leaves::with('employee', 'employee.position')
                                                ->with(['employee.department' => function($q) use($department){
                                                    $q->where('id_department', $department);}])
                                                ->with('leaves_format')
                                                ->where('id_leaves_format', '=', $leaves_format)
                                                ->where('start_leave', '>=', $new_start_date)
                                                ->orderBy('start_leave', 'asc')
                                                ->get();
                         }
                         else if(!empty($leaves_format) && !empty($end_date) ){
                            $emp_leaves   = Leaves::with('employee', 'employee.position')
                                                ->with(['employee.department' => function($q) use($department){
                                                    $q->where('id_department', $department);}])
                                                ->with('leaves_format')
                                                ->where('id_leaves_format', '=', $leaves_format)
                                                ->where('end_leave', '<=', $new_end_date)
                                                ->orderBy('start_leave', 'asc')
                                                ->get();
                         }
                         else if(!empty($leaves_format) ){
                            $emp_leaves   = Leaves::with('employee', 'employee.position')
                                                ->with(['employee.department' => function($q) use($department){
                                                    $q->where('id_department', $department);}])
                                                ->with('leaves_format')
                                                ->where('id_leaves_format', '=', $leaves_format)
                                                ->orderBy('start_leave', 'asc')
                                                ->get();
                         }
                         else if(!empty($start_date) && !empty($end_date) ){
                            $emp_leaves   = Leaves::with('employee', 'employee.position')
                                                ->with(['employee.department' => function($q) use($department){
                                                    $q->where('id_department', $department);}])
                                                ->where('start_leave', '>=', $new_start_date)
                                                ->where('end_leave', '<=', $new_end_date)
                                                ->orderBy('start_leave', 'asc')
                                                ->get();
                         }
                         else if(!empty($start_date)){
                            $emp_leaves   = Leaves::with('employee', 'employee.position')
                                                ->with(['employee.department' => function($q) use($department){
                                                    $q->where('id_department', $department);}])
                                                ->where('start_leave', '>=', $new_start_date)
                                                ->orderBy('start_leave', 'asc')
                                                ->get();
                         }
                         else if(!empty($end_date) ){
                            $emp_leaves   = Leaves::with('employee', 'employee.position')
                                                ->with(['employee.department' => function($q) use($department){
                                                    $q->where('id_department', $department);}])
                                                ->where('end_leave', '<=', $new_end_date)
                                                ->orderBy('start_leave', 'asc')
                                                ->get();
                         }
                        else{
                            $emp_leaves   = Leaves::with('employee', 'employee.position')
                                                ->with(['employee.department' => function($q) use($department){
                                                    $q->where('id_department', $department);}])
                                                ->orderBy('start_leave', 'asc')
                                                ->get();
                            }
                    }
                $form_repo       = new FormLeavesWhenChangeDepartment;
                $get_form_leave    = $form_repo->getFormLeavesWhenChangeDepartment($emp_leaves);
                return response()->json(['status'=> 'success','data'=> $get_form_leave]);
                break;


            case 'getFormEvaluationWhenChangeDepartment':
                $department          = $request->has('department') ? $request->get('department') : '';
                $topic_name          = $request->has('topic_name') ? $request->get('topic_name') : ''; // ส่งค่ามาเป็น id_topic
                $start_date          = $request->get('start_date');
                $new_start_date      = date("Y-m-d", strtotime($start_date));
                $end_date            = $request->get('end_date');
                $new_end_date        = date("Y-m-d", strtotime($end_date));
                $start_number        = $request->get('start_number');
                $end_number          = $request->get('end_number');

                if(empty($department)){// กรณีเลือกทุกแผนก
                    if(empty($topic_name)){ // กรณีเลือกทุกหัวข้อ
                        if(empty($start_date) && empty($end_date) && empty($start_number) && empty($end_number)){
                            $emp_evaluation = Evaluation::with('employee', 'employee.department', 'employee.position', 'resultevaluation', 'createevaluation')->orderBy('id_assessor', 'asc')->orderBy('id_topic', 'desc')->get();
                        }else if(empty($start_date) && empty($end_date) && empty($start_number) && !empty($end_number)){
                            $emp_evaluation = Evaluation::with('employee', 'employee.department', 'employee.position', 'resultevaluation', 'createevaluation')->where('percent', '<=', $end_number)->orderBy('percent', 'desc')->get();
                        }else if(empty($start_date) && empty($end_date) && !empty($start_number) && empty($end_number)){
                            $emp_evaluation = Evaluation::with('employee', 'employee.department', 'employee.position', 'resultevaluation', 'createevaluation')->where('percent', '>=', $start_number)->orderBy('percent', 'desc')->get();
                        }else if(empty($start_date) && !empty($end_date) && empty($start_number) && empty($end_number)){
                            $emp_evaluation = Evaluation::with('employee', 'employee.department', 'employee.position', 'resultevaluation', 'createevaluation')->where('date', '<=', $new_end_date)->orderBy('date', 'asc')->get();
                        }else if(!empty($start_date) && empty($end_date) && empty($start_number) && empty($end_number)){
                            $emp_evaluation = Evaluation::with('employee', 'employee.department', 'employee.position', 'resultevaluation', 'createevaluation')->where('date', '>=', $new_start_date)->orderBy('date', 'asc')->get();
                        }else if(!empty($start_date) && empty($end_date) && empty($start_number) && !empty($end_number)){
                            $emp_evaluation = Evaluation::with('employee', 'employee.department', 'employee.position', 'resultevaluation', 'createevaluation')->where('date', '>=', $new_start_date)->where('percent', '>=', $end_number)->orderBy('date', 'asc')->get();
                        }else if(!empty($start_date) && empty($end_date) && !empty($start_number) && empty($end_number)){
                            $emp_evaluation = Evaluation::with('employee', 'employee.department', 'employee.position', 'resultevaluation', 'createevaluation')->where('date', '>=', $new_start_date)->where('percent', '<=', $start_number)->orderBy('date', 'asc')->get();
                        }elseif(!empty($start_date) && !empty($end_date) && empty($start_number) && empty($end_number)){
                            $emp_evaluation = Evaluation::with('employee', 'employee.department', 'employee.position', 'resultevaluation', 'createevaluation')->whereBetween('date', [$new_start_date,$new_end_date])->orderBy('date', 'asc')->get();
                        }else if(!empty($start_date) && !empty($end_date) && empty($start_number) && !empty($end_number)){
                            $emp_evaluation = Evaluation::with('employee', 'employee.department', 'employee.position', 'resultevaluation', 'createevaluation')->whereBetween('date', [$new_start_date,$new_end_date])->where('percent', '>=', $end_number)->orderBy('date', 'asc')->get();
                        }else if(!empty($start_date) && !empty($end_date) && !empty($start_number) && empty($end_number)){
                            $emp_evaluation = Evaluation::with('employee', 'employee.department', 'employee.position', 'resultevaluation', 'createevaluation')->whereBetween('date', [$new_start_date,$new_end_date])->where('percent', '<=', $start_number)->orderBy('date', 'asc')->get();
                        }else if(!empty($start_date) && !empty($end_date) && !empty($start_number) && !empty($end_number)){
                            $emp_evaluation = Evaluation::with('employee', 'employee.department', 'employee.position', 'resultevaluation', 'createevaluation')->whereBetween('date', [$new_start_date,$new_end_date])->whereBetween('percent', [$start_number, $end_number])->orderBy('date', 'asc')->get();
                        }
                    }else{ // กรณีระบุหัวเรื่องการประเมิน
                        if(empty($start_date) && empty($end_date) && empty($start_number) && empty($end_number)){
                            $emp_evaluation = Evaluation::with('employee')->where('id_topic', $topic_name)->orderBy('id_assessor', 'asc')->get();
                        }else if(empty($start_date) && empty($end_date) && empty($start_number) && !empty($end_number)){
                            $emp_evaluation = Evaluation::with('employee', 'employee.department', 'employee.position', 'resultevaluation', 'createevaluation')->where('percent', '<=', $end_number)->orderBy('percent', 'desc')->where('id_topic', $topic_name)->get();
                        }else if(empty($start_date) && empty($end_date) && !empty($start_number) && empty($end_number)){
                            $emp_evaluation = Evaluation::with('employee', 'employee.department', 'employee.position', 'resultevaluation', 'createevaluation')->where('percent', '>=', $start_number)->where('id_topic', $topic_name)->orderBy('percent', 'desc')->get();
                        }else if(empty($start_date) && !empty($end_date) && empty($start_number) && empty($end_number)){
                            $emp_evaluation = Evaluation::with('employee', 'employee.department', 'employee.position', 'resultevaluation', 'createevaluation')->where('date', '<=', $new_end_date)->where('id_topic', $topic_name)->orderBy('date', 'asc')->get();
                        }else if(!empty($start_date) && empty($end_date) && empty($start_number) && empty($end_number)){
                            $emp_evaluation = Evaluation::with('employee', 'employee.department', 'employee.position', 'resultevaluation', 'createevaluation')->where('date', '>=', $new_start_date)->where('id_topic', $topic_name)->orderBy('date', 'asc')->get();
                        }else if(!empty($start_date) && empty($end_date) && empty($start_number) && !empty($end_number)){
                            $emp_evaluation = Evaluation::with('employee', 'employee.department', 'employee.position', 'resultevaluation', 'createevaluation')->where('date', '>=', $new_start_date)->where('percent', '>=', $end_number)->where('id_topic', $topic_name)->orderBy('date', 'asc')->get();
                        }else if(!empty($start_date) && empty($end_date) && !empty($start_number) && empty($end_number)){
                            $emp_evaluation = Evaluation::with('employee', 'employee.department', 'employee.position', 'resultevaluation', 'createevaluation')->where('date', '>=', $new_start_date)->where('percent', '<=', $start_number)->where('id_topic', $topic_name)->orderBy('date', 'asc')->get();
                        }elseif(!empty($start_date) && !empty($end_date) && empty($start_number) && empty($end_number)){
                            $emp_evaluation = Evaluation::with('employee', 'employee.department', 'employee.position', 'resultevaluation', 'createevaluation')->whereBetween('date', [$new_start_date,$new_end_date])->where('id_topic', $topic_name)->orderBy('date', 'asc')->get();
                        }else if(!empty($start_date) && !empty($end_date) && empty($start_number) && !empty($end_number)){
                            $emp_evaluation = Evaluation::with('employee', 'employee.department', 'employee.position', 'resultevaluation', 'createevaluation')->whereBetween('date', [$new_start_date,$new_end_date])->where('percent', '>=', $end_number)->where('id_topic', $topic_name)->orderBy('date', 'asc')->get();
                        }else if(!empty($start_date) && !empty($end_date) && !empty($start_number) && empty($end_number)){
                            $emp_evaluation = Evaluation::with('employee', 'employee.department', 'employee.position', 'resultevaluation', 'createevaluation')->whereBetween('date', [$new_start_date,$new_end_date])->where('percent', '<=', $start_number)->where('id_topic', $topic_name)->orderBy('date', 'asc')->get();
                        }else if(!empty($start_date) && !empty($end_date) && !empty($start_number) && !empty($end_number)){
                            $emp_evaluation = Evaluation::with('employee', 'employee.department', 'employee.position', 'resultevaluation', 'createevaluation')->whereBetween('date', [$new_start_date,$new_end_date])->whereBetween('percent', [$start_number, $end_number])->where('id_topic', $topic_name)->orderBy('date', 'asc')->get();
                        }
                    }
                }else{ // กรณีเลือกแผนก
                    if(empty($topic_name)){ // กรณีเลือกทุกหัวข้อ
                        if(empty($start_date) && empty($end_date) && empty($start_number) && empty($end_number)){
                            $emp_evaluation = Evaluation::with('employee')
                                            ->with(['employee.department' => function($q) use($department){
                                                $q->where('id_department', $department);
                                            }])->orderBy('id_assessor', 'asc')->orderBy('id_topic', 'desc')->get();
                        }else if(empty($start_date) && empty($end_date) && empty($start_number) && !empty($end_number)){
                            $emp_evaluation = Evaluation::with('employee', 'employee.position', 'resultevaluation', 'createevaluation')->with(['employee.department' => function($q) use($department){
                                                $q->where('id_department', $department);
                                            }])->where('percent', '<=', $end_number)->orderBy('percent', 'desc')->get();

                        }else if(empty($start_date) && empty($end_date) && !empty($start_number) && empty($end_number)){
                            $emp_evaluation = Evaluation::with('employee', 'employee.position', 'resultevaluation', 'createevaluation')->with(['employee.department' => function($q) use($department){
                                                $q->where('id_department', $department);
                                            }])->where('percent', '>=', $start_number)->orderBy('percent', 'desc')->get();

                        }else if(empty($start_date) && !empty($end_date) && empty($start_number) && empty($end_number)){
                            $emp_evaluation = Evaluation::with('employee', 'employee.position', 'resultevaluation', 'createevaluation')->with(['employee.department' => function($q) use($department){
                                                $q->where('id_department', $department);
                                            }])->where('date', '<=', $new_end_date)->orderBy('date', 'asc')->get();
                        }else if(!empty($start_date) && empty($end_date) && empty($start_number) && empty($end_number)){
                            $emp_evaluation = Evaluation::with('employee', 'employee.position', 'resultevaluation', 'createevaluation')->with(['employee.department' => function($q) use($department){
                                                $q->where('id_department', $department);
                                            }])->where('date', '>=', $new_start_date)->orderBy('date', 'asc')->get();
                        }else if(!empty($start_date) && empty($end_date) && empty($start_number) && !empty($end_number)){
                            $emp_evaluation = Evaluation::with('employee', 'employee.position', 'resultevaluation', 'createevaluation')->with(['employee.department' => function($q) use($department){
                                                $q->where('id_department', $department);
                                            }])->where('date', '>=', $new_start_date)->where('percent', '>=', $end_number)->orderBy('date', 'asc')->get();
                        }else if(!empty($start_date) && empty($end_date) && !empty($start_number) && empty($end_number)){
                            $emp_evaluation = Evaluation::with('employee', 'employee.position', 'resultevaluation', 'createevaluation')->with(['employee.department' => function($q) use($department){
                                                $q->where('id_department', $department);
                                            }])->where('date', '>=', $new_start_date)->where('percent', '<=', $start_number)->orderBy('date', 'asc')->get();
                        }elseif(!empty($start_date) && !empty($end_date) && empty($start_number) && empty($end_number)){
                            $emp_evaluation = Evaluation::with('employee', 'employee.position', 'resultevaluation', 'createevaluation')->with(['employee.department' => function($q) use($department){
                                                $q->where('id_department', $department);
                                            }])->whereBetween('date', [$new_start_date,$new_end_date])->orderBy('date', 'asc')->get();
                        }else if(!empty($start_date) && !empty($end_date) && empty($start_number) && !empty($end_number)){
                            $emp_evaluation = Evaluation::with('employee', 'employee.position', 'resultevaluation', 'createevaluation')->with(['employee.department' => function($q) use($department){
                                                $q->where('id_department', $department);
                                            }])->whereBetween('date', [$new_start_date,$new_end_date])->where('percent', '>=', $end_number)->orderBy('date', 'asc')->get();
                        }else if(!empty($start_date) && !empty($end_date) && !empty($start_number) && empty($end_number)){
                            $emp_evaluation = Evaluation::with('employee', 'employee.position', 'resultevaluation', 'createevaluation')->with(['employee.department' => function($q) use($department){
                                                $q->where('id_department', $department);
                                            }])->whereBetween('date', [$new_start_date,$new_end_date])->where('percent', '<=', $start_number)->orderBy('date', 'asc')->get();
                        }else if(!empty($start_date) && !empty($end_date) && !empty($start_number) && !empty($end_number)){
                            $emp_evaluation = Evaluation::with('employee', 'employee.position', 'resultevaluation', 'createevaluation')->with(['employee.department' => function($q) use($department){
                                                $q->where('id_department', $department);
                                            }])->whereBetween('date', [$new_start_date,$new_end_date])->whereBetween('percent', [$start_number, $end_number])->orderBy('date', 'asc')->get();
                        }
                    }else{ // กรณีระบุหัวเรื่องการประเมิน
                        if(empty($start_date) && empty($end_date) && empty($start_number) && empty($end_number)){
                            $emp_evaluation = Evaluation::with('employee')->with(['employee.department' => function($q) use($department){
                                                $q->where('id_department', $department);
                                            }])->where('id_topic', $topic_name)->orderBy('id_assessor', 'asc')->get();
                        }else if(empty($start_date) && empty($end_date) && empty($start_number) && !empty($end_number)){
                            $emp_evaluation = Evaluation::with('employee', 'employee.position', 'resultevaluation', 'createevaluation')->where('percent', '<=', $end_number)->with(['employee.department' => function($q) use($department){
                                                $q->where('id_department', $department);
                                            }])->where('id_topic', $topic_name)->orderBy('percent', 'desc')->get();
                        }else if(empty($start_date) && empty($end_date) && !empty($start_number) && empty($end_number)){
                            $emp_evaluation = Evaluation::with('employee', 'employee.position', 'resultevaluation', 'createevaluation')->with(['employee.department' => function($q) use($department){
                                                $q->where('id_department', $department);
                                            }])->where('percent', '>=', $start_number)->where('id_topic', $topic_name)->orderBy('percent', 'desc')->get();
                        }else if(empty($start_date) && !empty($end_date) && empty($start_number) && empty($end_number)){
                            $emp_evaluation = Evaluation::with('employee', 'employee.position', 'resultevaluation', 'createevaluation')->with(['employee.department' => function($q) use($department){
                                                $q->where('id_department', $department);
                                            }])->where('date', '<=', $new_end_date)->where('id_topic', $topic_name)->orderBy('date', 'asc')->get();
                        }else if(!empty($start_date) && empty($end_date) && empty($start_number) && empty($end_number)){
                            $emp_evaluation = Evaluation::with('employee', 'employee.position', 'resultevaluation', 'createevaluation')->with(['employee.department' => function($q) use($department){
                                                $q->where('id_department', $department);
                                            }])->where('date', '>=', $new_start_date)->where('id_topic', $topic_name)->orderBy('date', 'asc')->get();
                        }else if(!empty($start_date) && empty($end_date) && empty($start_number) && !empty($end_number)){
                            $emp_evaluation = Evaluation::with('employee', 'employee.position', 'resultevaluation', 'createevaluation')->with(['employee.department' => function($q) use($department){
                                                $q->where('id_department', $department);
                                            }])->where('date', '>=', $new_start_date)->where('percent', '>=', $end_number)->where('id_topic', $topic_name)->orderBy('date', 'desc')->orderBy('date', 'asc')->get();
                        }else if(!empty($start_date) && empty($end_date) && !empty($start_number) && empty($end_number)){
                            $emp_evaluation = Evaluation::with('employee', 'employee.position', 'resultevaluation', 'createevaluation')->with(['employee.department' => function($q) use($department){
                                                $q->where('id_department', $department);
                                            }])->where('date', '>=', $new_start_date)->where('percent', '<=', $start_number)->where('id_topic', $topic_name)->orderBy('date', 'asc')->get();
                        }else if(!empty($start_date) && !empty($end_date) && empty($start_number) && empty($end_number)){
                            $emp_evaluation = Evaluation::with('employee', 'employee.position', 'resultevaluation', 'createevaluation')->with(['employee.department' => function($q) use($department){
                                                $q->where('id_department', $department);
                                            }])->whereBetween('date', [$new_start_date,$new_end_date])->where('id_topic', $topic_name)->orderBy('date', 'asc')->get();
                        }else if(!empty($start_date) && !empty($end_date) && empty($start_number) && !empty($end_number)){
                            $emp_evaluation = Evaluation::with('employee', 'employee.position', 'resultevaluation', 'createevaluation')->with(['employee.department' => function($q) use($department){
                                                $q->where('id_department', $department);
                                            }])->whereBetween('date', [$new_start_date,$new_end_date])->where('percent', '>=', $end_number)->where('id_topic', $topic_name)->orderBy('date', 'asc')->get();
                        }else if(!empty($start_date) && !empty($end_date) && !empty($start_number) && empty($end_number)){
                            $emp_evaluation = Evaluation::with('employee', 'employee.position', 'resultevaluation', 'createevaluation')->with(['employee.department' => function($q) use($department){
                                                $q->where('id_department', $department);
                                            }])->whereBetween('date', [$new_start_date,$new_end_date])->where('percent', '<=', $start_number)->where('id_topic', $topic_name)->orderBy('date', 'asc')->get();
                        }else if(!empty($start_date) && !empty($end_date) && !empty($start_number) && !empty($end_number)){
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

                $form_repo       = new FormEvaluationWhenChangeDepartment;
                $get_form_emp    = $form_repo->getFormEvaluationWhenChangeDepartment($emp_evaluation, $count_first_name, $count_last_name, $count_name_evaluation);
                return response()->json(['status'=> 'success','data'=> $get_form_emp]);
            break;

            case 'getViewEvaluarion': /*ดูลายละเอียดการประเมิน*/
                $id_evaluation       = $request->get('id');
                $id_topic            = $request->get('id_topic');
                $detail_evaluation   = ResultEvaluation::with('evaluation', 'evaluation.employee')->where('id_evaluation', $id_evaluation)->get();
                //sd($detail_evaluation->toArray());
                $evaluation_data     = CreateEvaluation::with('parts', 'parts.question', 'parts.answerformat')->where('id_topic', $id_topic)->first();
                //sd($evaluation_data->toArray());
                //sd($evaluation_data->parts[0]->answerformat->id_answer_format);
                $count_answerformat  = AnswerDetails::where('id_answer_format', $evaluation_data->answerformat->id_answer_format)->get();



                //$part                = Part::with('question', 'answerformat.answerdetails')->where('id_topic', $id_topic)->get();
                //sd($part->toArray());
                $form_repo           = new FormViewEvaluation;
                $get_form_view_eva   = $form_repo->getFormViewEvaluation($detail_evaluation, $evaluation_data);
                return response()->json(['status'=> 'success','data'=> $get_form_view_eva]);
            break;

            default:
                # code...
            break;
        }
    }
}