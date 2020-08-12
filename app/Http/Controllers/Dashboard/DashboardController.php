<?php

namespace App\Http\Controllers\Dashboard;

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
use App\Services\Forms\FormChangeDepartmentDashboard;
use App\Services\Request\RequestLeaves;
use App\Services\Request\Status;
use App\Services\TimeStamp\TimeStamp;
use App\Services\Evaluation\Evaluation;
use App\Services\Evaluation\ResultEvaluation;
use App\Services\Evaluation\CreateEvaluation;
use Illuminate\Support\Facades\DB;
use Carbon\Carbon;

class DashboardController extends Controller
{
	public function dashboard()
    {
        session_start();
        if(isset($_SESSION['status'])){
            if(isset($_SESSION["get_session_dep"])){
                unset($_SESSION["get_session_dep"]);
            }
            if(isset($_SESSION["get_session_topic"])){
                unset($_SESSION["get_session_topic"]);
            }
        }

    	date_default_timezone_set('Asia/Bangkok');
		$get_date_now = date("Y-m-d");
		$get_time_now = '09:00:00';
        $get_count_emp  = Employee::where('id_status','1')->get();
        $get_count_timestamp = TimeStamp::where('date',$get_date_now)->count(); //มาทำงานทั้งหมดของวัน

        $get_count_timestamp_late = TimeStamp::where('date',$get_date_now)->where('time_in','>',$get_time_now)->count(); //มาทำงานสาย
        $get_count_timestamp_on_time = TimeStamp::where('date',$get_date_now)->where('time_in','<=',$get_time_now)->count(); //มาทำงานตรงเวลา

        $get_count_leave = Leaves::where('start_leave',$get_date_now)->count();
        $get_count_dept = Employee::groupBy('id_department')->where('id_status','1')->select('id_department', DB::raw('count(*) as total'))->with('department')->get();
        $department      = Department::all();

        $group_age = DB::table('employee')->where('id_status','1')->select(DB::raw('CEIL(DATEDIFF(NOW(), DATE(date_of_birth))/365) as age'))->get();


        //Leaves summary
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
                ->join('leaves_type','leaves.id_leaves_type','=','leaves_type.id_leaves_type')
                ->groupBy('leaves_type.id_leaves_type')
                ->get();

        $count_format_leaves = DB::table('leaves','leaves_format')
                ->select(DB::raw('count(leaves.id_leaves_format) as total_format_leaves'),'leaves_format.name')
                ->join('leaves_format','leaves.id_leaves_format','=','leaves_format.id_leaves_format')
                ->groupBy('leaves_format.id_leaves_format')
                ->get();
        //End Leaves Summary

        //Timastamp Summary
            $count_dept_timestamp = DB::table('time_stamp','employee','department')
                ->select(DB::raw('count(employee.id_employee) as total'), 'department.id_department','department.name')
                ->join('employee', 'time_stamp.id_employee', '=', 'employee.id_employee')
                ->join('department', 'employee.id_department', '=', 'department.id_department')
                ->groupBy('department.id_department')
                ->get();
            $count_come_timestamp = TimeStamp::where('time_in','<=',$get_time_now)->count();//มาทำงานทันเวลา
            $count_late_timestamp = TimeStamp::where('time_in','>',$get_time_now)->count();//มาทำงานสาย
            $count_not_timestamp = TimeStamp::where('time_in','=',NULL)->count();//ขาด
            $count_timestamp_all = TimeStamp::count(); //มาทำงานทั้งหมด
        //End Timestamp Summary

    	return $this->useTemplate('dashboard.dashboard',compact('department','get_count_emp','get_count_timestamp','get_count_timestamp_late','get_count_timestamp_on_time','get_count_leave','get_count_dept','get_date_now','group_age','count_dept','count_posit','count_type_leaves','count_format_leaves','count_dept_timestamp','count_come_timestamp','count_timestamp_all','count_late_timestamp','count_not_timestamp'));
    }

    public function ajaxCenter(Request $request)
    {
        $method = $request->get('method');
        switch ($method) {
            case 'getFormChangeDepartmentDashboard':

                date_default_timezone_set('Asia/Bangkok');
                $get_date_now = date("Y-m-d");
                $get_time_now = '09:00:00';

                $department      = $request->get('department');

                if ($department != "") {
                    $get_count_emp  = Employee::where('id_department',$department)->where('id_status','1')->get();
                    // sd($get_count_emp);

                    $count_timestamp = TimeStamp::with(['employee' => function ($q) use ($department){
                                                        $q->with('department')
                                                        ->where('id_department', $department);}])
                                                    ->where('date',$get_date_now)
                                                    ->get(); //มาทำงานทั้งหมด

                    $count_t_emp = $count_timestamp->count(); // พนักงานใน timestamp
                        $get_count_timestamp = 0;
                            for($i=0; $i < $count_t_emp; $i++){
                                if(!empty($count_timestamp[$i]->employee)){
                                    $get_count_timestamp+=1;
                                }
                            } //echo $get_count_timestamp; exit();

                    $count_timestamp_late = TimeStamp::with(['employee' => function ($q) use ($department){
                                                                $q->with('department')->where('id_status','1')
                                                                ->where('id_department', $department);}])
                                                            ->where('date',$get_date_now)
                                                            ->where('time_in','>',$get_time_now)
                                                            ->get(); //มาทำงานสาย

                     $count_t_late_emp = $count_timestamp_late->count(); // พนักงานใน timestamp
                        $get_count_timestamp_late = 0;
                            for($i=0; $i < $count_t_late_emp; $i++){
                                if(!empty($count_timestamp_late[$i]->employee)){
                                    $get_count_timestamp_late+=1;
                                }
                            } //echo $get_count_timestamp_late; exit();


                    $count_timestamp_on_time = TimeStamp::with(['employee' => function ($q) use ($department){
                                                                $q->with('department')->where('id_status','1')
                                                                ->where('id_department', $department);}])
                                                            ->where('date',$get_date_now)
                                                            ->where('time_in','<=',$get_time_now)
                                                            ->get(); //มาทำงานตรงเวลา

                    $count_on_t_emp = $count_timestamp_on_time->count(); // พนักงานใน timestamp
                        $get_count_timestamp_on_time = 0;
                            for($i=0; $i < $count_on_t_emp; $i++){
                                if(!empty($count_timestamp_on_time[$i]->employee)){
                                    $get_count_timestamp_on_time+=1;
                                }
                            } //echo $get_count_timestamp_on_time; exit();

                    $count_leave = Leaves::with(['employee' => function ($q) use ($department){
                                                            $q->with('department')->where('id_status','1')
                                                            ->where('id_department', $department);}])
                                                        ->where('start_leave',$get_date_now)
                                                        ->get();

                    $count_on_t_emp = $count_leave->count(); // พนักงานใน timestamp
                        $get_count_leave = 0;
                            for($i=0; $i < $count_on_t_emp; $i++){
                                if(!empty($count_leave[$i]->employee)){
                                    $get_count_leave+=1;
                                }
                            } //echo $get_count_leave; exit();

                    $group_age = DB::table('employee','department')->select(DB::raw('CEIL(DATEDIFF(NOW(), DATE(date_of_birth))/365) as age'))->where('id_department',$department)->get();
                } else {

                    $get_count_emp  = Employee::where('id_status','1')->get();
                    $get_count_timestamp = TimeStamp::where('date',$get_date_now)
                                                    ->count(); //มาทำงานทั้งหมด

                    $get_count_timestamp_late = TimeStamp::where('date',$get_date_now)
                                                            ->where('time_in','>',$get_time_now)
                                                            ->count(); //มาทำงานสาย

                    $get_count_timestamp_on_time = TimeStamp::where('date',$get_date_now)
                                                                ->where('time_in','<=',$get_time_now)
                                                                ->count(); //มาทำงานตรงเวลา

                    $get_count_leave = Leaves::where('start_leave',$get_date_now)->count();

                    $group_age = DB::table('employee')->where('id_status','1')->select(DB::raw('CEIL(DATEDIFF(NOW(), DATE(date_of_birth))/365) as age'))->get();
                    }


                $form_repo      = new FormChangeDepartmentDashboard;
                $form_add_emp   = $form_repo->getFormChangeDepartmentDashboard($get_count_emp,$group_age,$get_count_timestamp,$get_count_timestamp_late,$get_count_timestamp_on_time,$get_count_leave);
                return response()->json(['status'=> 'success','data'=> $form_add_emp]);
            break;
            case 'variable':
                # code...
            break;
        }
    }
}