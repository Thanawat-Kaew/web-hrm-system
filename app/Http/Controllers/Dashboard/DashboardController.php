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

class DashboardController extends Controller
{
	public function dashboard()
    {
    	date_default_timezone_set('Asia/Bangkok');
		$get_date_now = date("Y-m-d");
		$get_time_now = '09:00:00';
        $get_count_emp  = Employee::all();
        $get_count_timestamp = TimeStamp::where('date',$get_date_now)->count(); //มาทำงานทั้งหมด
        $get_count_timestamp_late = TimeStamp::where('date',$get_date_now)->where('time_in','>',$get_time_now)->count(); //มาทำงานสาย
        $get_count_timestamp_on_time = TimeStamp::where('date',$get_date_now)->where('time_in','=',$get_time_now)->count(); //มาทำงานตรงเวลา
        $get_count_timestamp_early = TimeStamp::where('date',$get_date_now)->where('time_in','<',$get_time_now)->count(); //มาทำงานก่อนเวลา

        $get_count_leave = Leaves::where('start_leave',$get_date_now)->count();
        $get_count_dept = Employee::groupBy('id_department')->select('id_department', DB::raw('count(*) as total'))->with('department')->get();
        $department      = Department::all();


    	return $this->useTemplate('dashboard.dashboard',compact('department','get_count_emp','get_count_timestamp','get_count_timestamp_late','get_count_timestamp_on_time','get_count_timestamp_early','get_count_leave','get_count_dept'));
    }

    public function ajaxCenter(Request $request)
    {
        $method = $request->get('method');
        switch ($method) {
            case 'getFormChangeDepartmentDashboard':

                $department      = $request->get('department');
                // sd($department);

                if ($department != "") {
                    $get_count_emp  = Employee::where('id_department',$department)->get();
                } else {
                    
                    $get_count_emp  = Employee::all();

                }


                $form_repo      = new FormChangeDepartmentDashboard;
                $form_add_emp   = $form_repo->getFormChangeDepartmentDashboard($get_count_emp);
                return response()->json(['status'=> 'success','data'=> $form_add_emp]);
            break;
            case 'variable':
                # code...
            break;
        }
    }
}