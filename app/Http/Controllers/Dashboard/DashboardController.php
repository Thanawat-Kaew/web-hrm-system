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
use App\Services\Request\RequestLeaves;
use App\Services\Request\Status;
use App\Services\TimeStamp\TimeStamp;
use App\Services\Evaluation\Evaluation;
use App\Services\Evaluation\ResultEvaluation;
use App\Services\Evaluation\CreateEvaluation;

class DashboardController extends Controller
{
	public function dashboard()
    {
    	date_default_timezone_set('Asia/Bangkok');
		// $get_date_now = date("Y-m-d");
		$get_date_now = '2020-01-05';
		// $get_time_now = date('H:i:s');
		$get_time_now = '09:00:00';
		// sd($get_time_now);
		// $get_date_now = ('2019-11-02');

        // $get_count_emp  = Employee::where('gender','ชาย')->count();
        $get_count_emp  = Employee::all();
        // sd($get_count_emp);
        // $get_count_dept = Employee::with('department')->get();
        // $get_count_dept = Employee::all()->groupBy('id_department')->count();
        $get_count_dept = Department::with('employee')->get();
        // $get_count_dept = Department::with('employee')->get();
        // sd($get_count_dept->toArray());
        $get_count_timestamp = TimeStamp::where('date',$get_date_now)->count(); //มาทำงานทั้งหมด
        $get_count_timestamp_late = TimeStamp::where('date',$get_date_now)->where('time_in','>',$get_time_now)->count(); //มาทำงานสาย
        $get_count_timestamp_on_time = TimeStamp::where('date',$get_date_now)->where('time_in','=',$get_time_now)->count(); //มาทำงานตรงเวลา
        $get_count_timestamp_early = TimeStamp::where('date',$get_date_now)->where('time_in','<',$get_time_now)->count(); //มาทำงานก่อนเวลา

        // sd($get_count_timestamp_late->toArray());

        $get_count_leave = Leaves::where('start_leave',$get_date_now)->count();
        // sd($get_count_leave);
        
    	return $this->useTemplate('dashboard.dashboard',compact('get_count_emp','get_count_timestamp','get_count_timestamp_late','get_count_timestamp_on_time','get_count_timestamp_early','get_count_leave','get_count_dept'));
    }
}