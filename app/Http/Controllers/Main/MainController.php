<?php

namespace App\Http\Controllers\Main;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
//use Illuminate\Support\Facades\Session;
use App\Services\Employee\Employee;
use App\Services\Employee\EmployeeObject;
use App\Services\Request\RequestChangeData;
use App\Services\Request\Status;
use App\Services\Request\RequestTimeStamp;
use App\Services\Leaves\Leaves;
use App\Services\Evaluation\CreateEvaluation;

class MainController extends Controller
{
	public function main()
    {
    	if(\Session::has('current_employee')){
            $current_employee = \Session::get('current_employee');
            //sd($current_employee->toArray());
		}
        $waiting_status             = 2;

        $sum_request_change_data    = 0;
        $request_change_data        = RequestChangeData::where('status', $waiting_status)->get();
        //sd($request_change_data->toArray());
        $count_request_change_data  = $request_change_data->count();
        $sum_request_change_data    = $sum_request_change_data + $count_request_change_data;
        //sd($sum_request_change_data);

        $sum_request_time_stamp     = 0;
        $request_time_stamp         = RequestTimeStamp::where('approvers', $current_employee->id_employee)->where('status', $waiting_status)->get();
        //sd($request_time_stamp->toArray());
        $count_request_time_stamp   = $request_time_stamp->count();
        $sum_request_time_stamp     = $sum_request_time_stamp + $count_request_time_stamp;

        $sum_request_leave          = 0;
        $request_leave              = Leaves::where('status_leave', $waiting_status)->where('approvers', $current_employee->id_employee)->get();
        //sd($request_leave->toArray());
        $count_request_leave        = $request_leave->count();
        $sum_request_leave          = $sum_request_leave + $count_request_leave;

        $sum_confirm_create_evaluation = 0;
        $confirm_create_evaluation  = CreateEvaluation::where('status', $waiting_status)->where('confirm_send_create_evaluation',1)->get();
        //sd($confirm_create_evaluation->toArray());
        $count_confirm_create_evaluation = $confirm_create_evaluation->count();
        $sum_confirm_create_evaluation = $sum_confirm_create_evaluation + $count_confirm_create_evaluation;

        if($current_employee['id_department'] == "hr0001"){
            $sum_request = $sum_request_change_data + $sum_request_time_stamp + $sum_request_leave + $sum_confirm_create_evaluation;
        }else{
            $sum_request = $sum_request_time_stamp + $sum_request_leave;
        }
        return view('main', compact('current_employee', 'sum_request_change_data', 'sum_request_time_stamp', 'sum_request_leave', 'sum_confirm_create_evaluation', 'sum_request'));
    }

    public function admin_main()
    {
        return view('admin.admin_main');
    }
}

