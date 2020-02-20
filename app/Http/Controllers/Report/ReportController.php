<?php

namespace App\Http\Controllers\Report;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Services\Employee\Employee;
use App\Services\Position\Position;
use App\Services\Department\Department;
use App\Services\TimeStamp\TimeStamp;
use App\Services\Forms\FormTimestampWhenChangeDepartment;

class ReportController extends Controller
{
	public function index()
    {
    	return $this->useTemplate('report.index');
    }

    public function reportTimeStamp()
    {
        $department      = Department::all();
        $timestamp       = TimeStamp::with('employee', 'employee.department', 'employee.position')->get();
        //sd($timestamp[0]->employee->toArray());
        //sd($timestamp->toArray());
        //sd($timestamp->count());
    	return $this->useTemplate('report.report_time_stamp', compact('department', 'timestamp'));
    }

    public function reportLeave()
    {
    	return $this->useTemplate('report.report_leave');
    }

    public function reportEvaluation()
    {
    	return $this->useTemplate('report.report_evaluations');
    }

    public function reportOverview()
    {
    	return $this->useTemplate('report.report_overview');
    }

    public function ajaxCenter(Request $request)
    {
        $method = $request->get('method');
        switch ($method) {
            case 'getFormTimestampWhenChangeDepartment':
                $department     = $request->get('department');
                $employees       = Employee::with('timestamp', 'department', 'position')->where('id_department', $department)->get();
                //sd($employees->toArray());
                //sd($e->toArray());
                //$employees      = TimeStamp::with('employee')->where('employee.id_department', $department)->get();
                //sd($employees[19]->timestamp[0]->time_in);
                /*if(!empty($employees[19]->timestamp[1])){
                    echo "123";
                }exit();*/
                $form_repo      = new FormTimestampWhenChangeDepartment;
                $get_form_emp   = $form_repo->getFormTimestampWhenChangeDepartment($employees);
                return response()->json(['status'=> 'success','data'=> $get_form_emp]);
            break;

            default:
                # code...
            break;
        }
    }

}