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
    	date_default_timezone_set('Asia/Bangkok');
		$get_date_now = date("Y-m-d");
		$get_time_now = '09:00:00';
        $get_count_emp  = Employee::where('id_status','1')->get();
        $get_count_timestamp = TimeStamp::where('date',$get_date_now)->count(); //มาทำงานทั้งหมด

        $get_count_timestamp = TimeStamp::where('date',$get_date_now)->count(); //มาทำงานทั้งหมด

        $get_count_timestamp_late = TimeStamp::where('date',$get_date_now)->where('time_in','>',$get_time_now)->count(); //มาทำงานสาย
        $get_count_timestamp_on_time = TimeStamp::where('date',$get_date_now)->where('time_in','<=',$get_time_now)->count(); //มาทำงานตรงเวลา

        $get_count_leave = Leaves::where('start_leave',$get_date_now)->count();
        $get_count_dept = Employee::groupBy('id_department')->where('id_status','1')->select('id_department', DB::raw('count(*) as total'))->with('department')->get();
        $department      = Department::all();

        $group_age = DB::table('employee')->where('id_status','1')->select(DB::raw('CEIL(DATEDIFF(NOW(), DATE(date_of_birth))/365) as age'))->get();

    	return $this->useTemplate('dashboard.dashboard',compact('department','get_count_emp','get_count_timestamp','get_count_timestamp_late','get_count_timestamp_on_time','get_count_leave','get_count_dept','get_date_now','group_age'));
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