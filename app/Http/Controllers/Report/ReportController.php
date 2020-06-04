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
use Illuminate\Support\Facades\DB;
use App\Services\Forms\FormEmail;
use Illuminate\Support\Facades\Mail;

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
            $id_department  = $current_employee['id_department'];
            $department     = Department::where('id_department', $id_department)->first(); //ชื่อแผนก
            $timestamp      = TimeStamp::with('employee', 'employee.position')
                            ->with(['employee.department' => function($q) use($id_department){
                                $q->where('id_department', $id_department);
                            }])->orderBy('date', 'desc')->get(); //รายชื่อพนักงานที่ลงเวลา
            $list_employee  = Employee::where('id_department', $id_department)->get(); //รายชื่อพนักงานที่ตรงแผนก
        }else{
            $department      = Department::all();
            $timestamp       = TimeStamp::with('employee', 'employee.department', 'employee.position')->orderBy('date', 'desc')->get();
        }
    	return $this->useTemplate('report.report_time_stamp', compact('department', 'timestamp', 'current_employee', 'list_employee'));
    }

    public function test()
    {
        return $this->useTemplate('report.test');
    }

    public function reportLeave()
    {
        if(\Session::has('current_employee')){
            $current_employee = \Session::get('current_employee');
        }

        $department         = Department::all();
        $leaves_type        = LeavesType::all();
        $leaves_format      = LeavesFormat::all();
        $id_employee        = $current_employee['id_employee'];
        $id_department      = $current_employee['id_department'];

        if($current_employee['id_department'] !== "hr0001"){
            $datas = Leaves::with(['employee' => function ($q) use ($id_department){
                            $q->with('department')->where('id_department', $id_department);
                            $q->with('position');}])
                        ->with('leaves_type')
                        ->get();
            $list_employee  = Employee::where('id_department', $id_department)->get(); //รายชื่อพนักงานที่ตรงแผนก
            $department     = Department::where('id_department', $id_department)->first(); //ชื่อแผนก


        }else{
            $datas = Leaves::with(['employee' => function ($q) use ($id_employee){
                            $q->with('department');
                            $q->with('position');}])
                        ->with('leaves_type')
                        ->get();

            $count_dept = DB::table('leaves','employee','department')
                    ->select(DB::raw('count(employee.id_employee) as total'), 'department.id_department','department.name')
                    ->join('employee', 'leaves.id_employee', '=', 'employee.id_employee')
                    ->join('department', 'employee.id_department', '=', 'department.id_department')
                    ->groupBy('department.id_department')
                    ->get();

            $count_posit = DB::table('leaves','employee','position')
                    ->select(DB::raw('count(employee.id_position) as total_posit'),'position.name')
                    ->join('employee','leaves.id_employee','=','employee.id_employee')
                    ->join('position','employee.id_position','=','position.id_position')
                    ->groupBy('position.id_position')
                    ->get();

            $count_type_leaves = DB::table('leaves','leaves_type')
                    ->select(DB::raw('count(leaves.id_leaves_type) as total_type_leaves'),'leaves_type.leaves_name')
                    // ->select(DB::raw('count(leaves.id_leaves_format) as total_format_leaves'),'leaves_format.name')
                    ->join('leaves_type','leaves.id_leaves_type','=','leaves_type.id_leaves_type')
                    // ->join('leaves_format','leaves_format.id_leaves_format','=','leaves_format.id_leaves_format')
                    ->groupBy('leaves_type.id_leaves_type')
                    ->get();

            $count_format_leaves = DB::table('leaves','leaves_format')
                    ->select(DB::raw('count(leaves.id_leaves_format) as total_format_leaves'),'leaves_format.name')
                    ->join('leaves_format','leaves.id_leaves_format','=','leaves_format.id_leaves_format')
                    ->groupBy('leaves_format.id_leaves_format')
                    ->get();

        }
    	return $this->useTemplate('report.report_leave',compact('datas','department','leaves_type','leaves_format','current_employee','count_dept','count_posit','count_type_leaves','count_format_leaves'));

    }

    public function reportEvaluation()
    {
        if(\Session::has('current_employee')){
            $current_employee = \Session::get('current_employee');
        }

        if($current_employee['id_department'] !== "hr0001"){  // ไม่ใช่แผนก hr จะมองไม่เห็น dropdown เลือกแผนก
            //$department  = $current_employee['id_department'];
            $id_department  = $current_employee['id_department'];
            $department     = Department::where('id_department', $id_department)->first(); //ชื่อแผนก
            $assessor       = Evaluation::with('employee', 'employee.position', 'resultevaluation', 'createevaluation')
                            ->with(['employee.department' => function($q) use($id_department){
                                $q->where('id_department', $id_department);
                            }])
                            ->orderBy('id_assessor', 'asc')
                            ->orderBy('id_topic', 'desc')
                            ->get();

            //$id_department  = $current_employee['id_department'];
            //$department     = Department::where('id_department', $id_department)->first(); //ชื่อแผนก
            /*$timestamp      = TimeStamp::with('employee', 'employee.position')
                            ->with(['employee.department' => function($q) use($id_department){
                                $q->where('id_department', $id_department);
                            }])->orderBy('date', 'desc')->get(); //รายชื่อพนักงานที่ลงเวลา*/
            $list_employee  = Employee::where('id_department', $id_department)->get(); //รายชื่อพนักงานที่ตรงแผนก


        }else{
            $department  = Department::all(); /*เลือกเอาชื่อมาทุกแผนก*/
            $assessor    = Evaluation::with('employee', 'employee.department', 'employee.position', 'resultevaluation', 'createevaluation')
                        ->orderBy('id_assessor', 'asc')->orderBy('id_topic', 'desc')->get();
            /*เชื่อม Database ตั้งเงื่อนไขว่า เรียง id จากน้อยไปมาก และเรียงจาก id_topic จากมากไปน้อย*/
        }


        $array_assessment = array();
        $array_id_topic   = array();
        foreach ($assessor as $value){ //วน loop
                $array_assessment[] = $value->id_assessment_person; //เก็บ id ผู้ประเมิน
                $array_id_topic[]   = $value->id_topic; //เก็บ id หัวเรื่อง
        }

        $count_assessment       = count($array_assessment); //ทำการนับจำนวนผู้ประเมิน
        //$count_first_name       = [];
        //$count_last_name        = [];
        $count_name_evaluation  = [];
        for($i=0; $i<$count_assessment; $i++){
            $assessment         = Employee::where('id_employee', $array_assessment[$i])->first();//หา id ผู้ประเมิน
            //$count_first_name[] = $assessment->first_name; //เอาชื่อมา
            //$count_last_name[]  = $assessment->last_name; //เอานามสกุลมา
            $name_evaluation    = CreateEvaluation::where('id_topic', $array_id_topic[$i])->first(); //หา id หัวเรื่อง
            $count_name_evaluation[] = $name_evaluation->topic_name; //เอาชื่อมา
        }

        // sd($count_name_evaluation);
        $topic_name  = CreateEvaluation::where('status', 1)->get();
        // sd($topic_name->toArray());
    	return $this->useTemplate('report.report_evaluations', compact('assessor', 'count_name_evaluation', 'department', 'topic_name', 'current_employee', 'list_employee'));
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
                $id_employee         = $request->get('id_employee');
                $start_date          = $request->get('start_date');
                $new_start_date      = date("Y-m-d", strtotime($start_date));
                $end_date            = $request->get('end_date');
                $new_end_date        = date("Y-m-d", strtotime($end_date));
                $start_time          = $request->get('start_time');
                $new_start_time      = date("H:i:s", strtotime($start_time));
                $end_time            = $request->get('end_time');
                $new_end_time        = date("H:i:s", strtotime($end_time));

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

                $form_repo       = new FormTimestampWhenChangeDepartment;
                $get_form_emp    = $form_repo->getFormTimestampWhenChangeDepartment($emp_timestamp);
                return response()->json(['status'=> 'success','data'=> $get_form_emp]);

            break;

           case 'getFormLeavesWhenChangeDepartment':

                    if(\Session::has('current_employee')){
                        $current_employee = \Session::get('current_employee');
                    }

                    date_default_timezone_set('Asia/Bangkok');
                    $id_employee        = $current_employee['id_employee'];
                    $id_department      = $current_employee['id_department'];
                    $department         = $request->has('department') ? $request->get('department') : '';
                    $leaves_type        = $request->get('leaves_type');
                    $leaves_format      = $request->get('leaves_format');
                    $start_date         = $request->get('start_date');
                    $new_start_date     = date("Y-m-d", strtotime($start_date));
                    $end_date           = $request->get('end_date');
                    $new_end_date       = date("Y-m-d", strtotime($end_date));
                    $getDate            = date("Y-m-d");
                    $getTime            = date("h:i:sa");

                    $emp_leaves         = Leaves::with('employee.position');
                    $emp_leaves         = $emp_leaves->with('leaves_type');
                    $id_employee_select = $request->get('id_employee');

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

                $form_repo       = new FormLeavesWhenChangeDepartment;
                $get_form_leave    = $form_repo->getFormLeavesWhenChangeDepartment($emp_leaves);
                return response()->json(['status'=> 'success','data'=> $get_form_leave]);
                break;


            case 'getFormEvaluationWhenChangeDepartment':
                $department          = $request->has('department') ? $request->get('department') : '';
                $topic_name          = $request->has('topic_name') ? $request->get('topic_name') : ''; // ส่งค่ามาเป็น id_topic
                $id_employee         = $request->has('id_employee') ? $request->get('id_employee') : '';
                $start_date          = $request->get('start_date');
                $new_start_date      = date("Y-m-d", strtotime($start_date));
                $end_date            = $request->get('end_date');
                $new_end_date        = date("Y-m-d", strtotime($end_date));
                $start_number        = $request->get('start_number');
                $end_number          = $request->get('end_number');


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

            case 'getViewEvaluation': /*ดูลายละเอียดการประเมิน*/
                $id_employee       = $request->get('id_employee');
                $id_topic          = $request->get('id_topic');
                $evaluation_data   = CreateEvaluation::with('parts', 'parts.question', 'answerformat', 'answerformat.answerdetails')->where('id_topic', $id_topic)->first();
                $evaluation_details = Evaluation::with('resultevaluation')->where('id_assessor', $id_employee)->where('id_topic', $id_topic)->first();
                $form_repo           = new FormViewEvaluation;
                $get_form_view_eva   = $form_repo->getFormViewEvaluation($evaluation_data, $evaluation_details);
                return response()->json(['status'=> 'success','data'=> $get_form_view_eva]);
            break;


            case 'getFormNameEmployee':
                $id_department  = $request->get('department');
                //sd($id_department);
                $name_emp       = Employee::where('id_department', $id_department)->get();
                return response()->json(['status'=> 'success','data'=> $name_emp]);
            break;

            case 'getFormEmail': // Form กรอกข้อมูลของ email
                $id_employee = $request->get('id_employee');
                $reciver       = Employee::where('id_employee', $id_employee)->first();
                $form_repo     = new FormEmail;
                $get_form      = $form_repo->getFormEmail($reciver);
                return response()->json(['status'=> 'success','data'=> $get_form]);
            break;

            default:
                # code...
            break;
        }
    }
}