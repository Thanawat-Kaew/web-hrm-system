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
        /*$department = "hr0001";
        $a  = Employee::with(['department' => function($q) use($department){
            $q->where('id_department', $department);
        }])->where('id_department', $department)->orderBy('id_employee', 'desc')->get();
        sd($a->toArray());*/

        /*$a = Employee::with('department')->where('department.id_department', "en0001")->get();
        sd($a);*/
    	return $this->useTemplate('report.index');
    }

    public function reportTimeStamp()
    {
        $department      = Department::all();
        $timestamp       = TimeStamp::with('employee', 'employee.department', 'employee.position')->orderBy('date', 'desc')->get();
        //$emp_timestamp       = TimeStamp::with('employee', 'employee.department', 'employee.position')->orderBy('date', 'desc')->get();
        //sd($timestamp[0]->employee->toArray());
        //sd($emp_timestamp->count());
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
                        $q->where('id_department', $department);
                        }])->whereBetween('date', [$new_start_date,$new_end_date])->where('time_in', '>=', $new_start_time)->where('time_out', '<', $new_end_time)->orderBy('date', 'asc')->get();

                        /*$emp_timestamp = $emp_timestamp->whereBetween('date', [$new_start_date,$new_end_date])->where('time_in', '>=', $new_start_time)->where('time_out', '<=', $new_end_time)->orderBy('date', 'asc')->get();*/

                        //sd($emp_timestamp->toArray());
                    }else if(!empty($start_date) && !empty($end_date) && !empty($start_time)){
                        $emp_timestamp   = TimeStamp::with('employee', 'employee.position')
                                        ->with(['employee.department' => function($q) use($department){
                        $q->where('id_department', $department);
                        }])->whereBetween('date', [$new_start_date,$new_end_date])->where('time_in', '>=', $new_start_time)->orderBy('date', 'asc')->get();
                        //sd($emp_timestamp->toArray());
                        //echo "9";
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
                        }])->orderBy('date', 'desc')->get();
                        //echo "1";
                        //$emp_timestamp = $emp_timestamp->orderBy('date', 'desc')->get();
                    }
                    //exit();
                }
                //exit();
                $form_repo       = new FormTimestampWhenChangeDepartment;
                $get_form_emp    = $form_repo->getFormTimestampWhenChangeDepartment($emp_timestamp);
                return response()->json(['status'=> 'success','data'=> $get_form_emp]);

            break;

            default:
                # code...
            break;
        }
    }

}