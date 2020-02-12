<?php
namespace App\Http\Controllers\Leave;
use Illuminate\Http\Request;
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

class LeaveController extends Controller
{
	public function leave()
    {
        if(\Session::has('current_employee')){
            $current_employee = \Session::get('current_employee');
        }

        $data = Leaves::with('employee','leaves_type')
                            ->where('id_employee', $current_employee['id_employee'])
                            ->where('status_leave', 1)
                            ->orderBy('id_leave', 'desc')
                            ->get();

        $leaves_type    = LeavesType::all();
        // $header         = Employee::with('company','leaves')
        //                                         ->where('id_position', 2)
        //                                         ->where('id_department', $current_employee['id_department'])
        //                                         ->first();
                                                // d($header->toArray());
                                                
        // $leaves_info    = $header->leaves;
        // $company_info   = !empty($company->info)? json_decode($company->info): [];
        // $leaves_info    = $company_info->leaves_info;
        // sd($leaves_info->toArray());
        $www = LeavesRequirements::get();
        // d($www->toArray());
        // $ddd = $www->day_require;
        // $leaves_require = LeavesRequirements::with('leaves_type')->where('id_leaves_type',$ddd)->get();
        // sd($leaves_require->toArray());

        
        return $this->useTemplate('leave.leave' ,compact('data','leaves_type'/*,'leaves_info'*//*,'leaves_require'*/));
    }

    public function leave_history()
    {
        if(\Session::has('current_employee')){
            $current_employee   = \Session::get('current_employee');
        }

        $request                = Leaves::with('employee','leaves_type')
                                            ->where('id_employee', $current_employee['id_employee'])
                                            ->orderBy('id_leave', 'desc')
                                            ->get();
        return $this->useTemplate('leave.leave_history',compact('request'));
    }

    public function leave_request()
    {
        if(\Session::has('current_employee')){
            $current_employee   = \Session::get('current_employee');
        }

        $request = Leaves::with('employee')
                            ->where('approvers', $current_employee['id_employee'])
                            ->orderBy('id_leave', 'desc')
                            ->get();
       
        return $this->useTemplate('leave.leave_request',compact('request'));
    }

    public function leave_set_holiday()
    {
        $day_off_year           = DayOffYears::all();
        $id                     = DayOffYears::get('id');
        $detail_day_off_year    = DetailDayOffYear::with('day_off_year')
                                                    ->whereIn('id_day_off_year',$id)
                                                    ->get();

        return view('leave.set_holiday',compact('day_off_year','detail_day_off_year'));
    }

    public function addSetHoliday(Request $request)
    {
        if(\Session::has('current_employee')){
                    $current_employee   = \Session::get('current_employee');
        }
        
        $set_year                   = $request->get('set_year');
        $set_holiday_day            = $request->get('set_holiday_day');
        $check_stop_compensation    = $request->get('check_stop_compensation');
        $set_date                   = $request->get('set_date');

        $check_set_holiday          = DetailDayOffYear::where('date', $set_date)
                                                        ->where('year',$set_year)
                                                        ->first();

        if (!empty($check_set_holiday)) {
            return json_encode(['status' => 'failed', 'message' => "errors"]);
        }

        $request_set_holiday                            = new DetailDayOffYear;
        $request_set_holiday->id_day_off_year           = $set_holiday_day;
        $request_set_holiday->compensate                = $check_stop_compensation;
        $request_set_holiday->date                      = $set_date; 
        $request_set_holiday->year                      = $set_year;
        $request_set_holiday->save();
        
        return json_encode(['status' => 'success', 'message' => "success"]);

    }

    public function ajaxCenter(Request $request)
    {
    	$method = $request->get('method');
        switch ($method) {
            case 'getFormLeave':

                if(\Session::has('current_employee')){
                    $current_employee   = \Session::get('current_employee');
                }

                $leaves_type        = LeavesType::all();
                $leaves_format      = LeavesFormat::all();
                $header             = Employee::with('company')
                                                ->where('id_position', 2)
                                                ->where('id_department', $current_employee['id_department'])
                                                ->first();

                $company            = $header->company;
                $company_info       = !empty($company->info)? json_decode($company->info): [];
                $form_repo          = new FormLeave;
                $form_leave         = $form_repo->getFormLeave($leaves_type,$header,$leaves_format,$company_info);

                return response()->json(['status'=> 'success','data'=> $form_leave]);

            break;

            case 'getViewDataRequestLeaves': // ดูข้อมูลที่ร้องขอการลงเวลาย้อนหลัง // ดูของลูกน้อง

                if(\Session::has('current_employee')){
                    $current_employee   = \Session::get('current_employee');
                }

                $leaves_type        = LeavesType::all();
                $leaves_format      = LeavesFormat::all();
                $id                 = $request->get('id');
                $data               = Leaves::with('employee','leaves_type')
                                                ->where('id_leave',$id)
                                                ->get();

                $header             = Employee::with('company','leaves')
                                                    ->where('id_position', 2)
                                                    ->where('id_department', $current_employee['id_department'])
                                                    ->first();

                $company            = $header->company;
                $company_info       = !empty($company->info)? json_decode($company->info): [];
                $company_time       = $company_info->working_time;
                $form_repo          = new FormViewDataRequestLeaves;
                $form_leave         = $form_repo->getViewDataRequestLeaves($data,$company_time,$leaves_type,$header,$leaves_format,$company_info);

                return response()->json(['status'=> 'success','data'=> $form_leave]);

            break;

            case 'getViewRequestLeaves': 

                if(\Session::has('current_employee')){
                    $current_employee   = \Session::get('current_employee');
                }

                $leaves_type        = LeavesType::all();
                $leaves_format      = LeavesFormat::all();
                $id                 = $request->get('id');

                $data               = Leaves::with('employee','leaves_type')
                                                ->where('id_leave',$id)
                                                ->get();

                $header             = Employee::with('company','leaves')
                                                ->where('id_position', 2)
                                                ->where('id_department', $current_employee['id_department'])
                                                ->first();

                $company            = $header->company;
                $company_info       = !empty($company->info)? json_decode($company->info): [];
                $company_time       = $company_info->working_time;
                $form_repo          = new FormViewRequestLeaves;
                $form_leave         = $form_repo->getViewRequestLeaves($data,$company_time,$leaves_type,$header,$leaves_format,$company_info);

                return response()->json(['status'=> 'success','data'=> $form_leave]);

            break;

            case 'getEditRequestLeaves':

                if(\Session::has('current_employee')){
                    $current_employee   = \Session::get('current_employee');
                }

                $leaves_type        = LeavesType::all();
                $leaves_format      = LeavesFormat::all();
                $id                 = $request->get('id');
                $data               = Leaves::with('employee','leaves_type')
                                                ->where('id_leave',$id)
                                                ->get();

                $header             = Employee::with('company','leaves')
                                                ->where('id_position', 2)
                                                ->where('id_department', $current_employee['id_department'])
                                                ->first();

                $company            = $header->company;
                $company_info       = !empty($company->info)? json_decode($company->info): [];
                $company_time       = $company_info->working_time;
                $form_repo          = new FormEditRequestLeaves;
                $form_leave         = $form_repo->getEditRequestLeaves($data,$company_time,$leaves_type,$header,$leaves_format,$company_info);

                return response()->json(['status'=> 'success','data'=> $form_leave]);

            break;
            
            default:
                # code...
            break;
        }
    }

    public function addRequestLeave(Request $request){

        if(\Session::has('current_employee')){
            $current_employee = \Session::get('current_employee');
        }
        sd($request->all());
        $leave_type             = $request->get('leave_type');          //ประเภทการลา เช่น ลาป่วย ลาพักร้อน
        $format_leaves          = $request->get('format_leaves');       //รูปแบบการลา เช่น ลาเต็มวัน ลาครึ่งวัน
        $format_leave_m_a       = $request->get('format_leave_m_a');    //ช่วงการลา ช่วงเช้า ช่วงบ่าย
        $start_date_f           = $request->get('start_date_f');        //วันที่เริ่มลาเต็มวัน
        $end_date_f             = $request->get('end_date_f');          //วันที่สิ้นสุดลาเต็มวัน
        $start_time_f           = $request->get('start_time_f');        //เวลาเริ่มเต็มวัน
        $end_time_f             = $request->get('end_time_f');          //เวลาสิ้นสุดเต็มวัน
        $half_date              = $request->get('half_morning_date');   //วันที่เริ่มลาครึ่งวัน
        $hour_date              = $request->get('half_afternoon_date'); //วันที่ลาครึ่ง ชม.
        $start_time_h_m         = $request->get('start_time_h_m');      //เวลาเริ่มครึ่งวันเช้า
        $end_time_h_m           = $request->get('end_time_h_m');        //เวลาสิ้นสุดครึ่งวันเช้า
        $start_time_h_a         = $request->get('start_time_h_a');      //เวลาเริ่มครึ่งวันบ่าย
        $end_time_h_a           = $request->get('end_time_h_a');        //เวลาสิ้นสุดครึ่งวันบ่าย
        $start_time_hour        = $request->get('start_time_hour');     //เวลาเริ่มลาราย ชม.
        $end_time_hour          = $request->get('end_time_hour');       //เวลาสิ้นสุดลาราย ชม.
        $reason_leave           = $request->get('reason_leave');        //เหตุผลการลา
        $approvers              = $request->get('approvers');           //ผู้อนุมัติ
        $total_leaves_f         = $request->get('total_num_f');         //สรุปจำนวนลาเต็มวัน
        $total_leaves_m_a       = $request->get('total_num_m_a');       //สรุปจำนวนลาครึ่งวัน
        $total_leaves_hour      = $request->get('total_num_hour');      //สรุปจำนวนลาราย ชม.

        $strtotime_start_date       = strtotime($start_date_f);
        $strtotime_end_date         = strtotime($end_date_f);
        $strtotime_start_date_h_m   = strtotime($half_date);
        $strtotime_end_date_h_m     = strtotime($half_date);
        $strtotime_start_date_h_a   = strtotime($hour_date);
        $strtotime_end_date_h_a     = strtotime($hour_date);

        if ($format_leaves == 1) {
            $check_holiday = $this->checkHoliday($start_date_f,$end_date_f);
        } else if($format_leaves == 2) {
            $check_holiday = $this->checkHoliday($half_date,$half_date);
        } else if ($format_leaves == 3) {
            $check_holiday = $this->checkHoliday($hour_date,$hour_date);
        } else{
            $check_holiday = 1;
        }
        
            if ($check_holiday) {
                return json_encode(['status' => 'failed', 'message' => "errors"]);
                
            }      

        // SWITCH CASE
        if ($format_leaves == 1 ) {

            $leaves_check_full_day = Leaves::with('employee')
                                            ->where('id_employee',$current_employee['id_employee'])   
                                            ->where('start_leave','<=',$start_date_f)
                                            ->where('end_leave','>=',$end_date_f)
                                            ->get();

            if (count($leaves_check_full_day) != 0 ) {
                return json_encode(['status' => 'failed', 'message' => "errors"]);
            }

                $request_leave                          = new Leaves; // case ลาเต็มวัน
                $request_leave->id_employee             = $current_employee['id_employee'];
                $request_leave->id_leaves_type          = $leave_type; 
                $request_leave->id_leaves_format        = $format_leaves; 
                $request_leave->start_leave             = $start_date_f;    
                $request_leave->end_leave               = $end_date_f;
                $request_leave->start_time              = $start_time_f;
                $request_leave->end_time                = $end_time_f;
                $request_leave->reason                  = $reason_leave;  
                $request_leave->approvers               = $approvers;
                $request_leave->status_leave            = 2;
                $request_leave->total_leave             = $total_leaves_f;
                $request_leave->save();
                return json_encode(['status' => 'success', 'message' => "success"]);

        } else if($format_leaves == 2 ){

            $leaves_check_half    = Employee::with(['leaves' => function($q) use($half_date){
                                                $q->where('start_leave','<=',$half_date);
                                                $q->where('end_leave','>=',$half_date);}])->with('company')
                                                ->where('id_employee',$current_employee['id_employee'])
                                                ->first();

            if (!empty($leaves_check_half)) {
                $current_leave = $leaves_check_half->leaves;

                if (!empty($current_leave)) {

                    $check_error = 0 ;
                    foreach ($current_leave as $leave) {

                        if ($format_leave_m_a == 1) { //morning
                            if ($start_time_h_m == $leave['start_time'] || $start_time_h_m == $leave['end_time'] ) {
                                $check_error++;
                            }

                        } else { //afternoon

                            if ($start_time_h_a == $leave['start_time'] || $end_time_h_a == $leave['end_time'] ) {
                                $check_error++;
                            }
                        }
                    }
                    if ($check_error == 0 ) {

                        $request_leave                          = new Leaves; // case ลาครึ่งวัน
                        $request_leave->id_employee             = $current_employee['id_employee'];
                        $request_leave->id_leaves_type          = $leave_type; 
                        $request_leave->id_leaves_format        = $format_leaves; 
                        $request_leave->start_leave             = $half_date;   
                        $request_leave->end_leave               = $half_date;

                        if ($format_leave_m_a == 1) {
                            $request_leave->start_time          = $start_time_h_m;
                            $request_leave->end_time            = $end_time_h_m;
                        } else {
                            $request_leave->start_time          = $start_time_h_a;
                            $request_leave->end_time            = $end_time_h_a;
                        }

                        $request_leave->reason                  = $reason_leave;  
                        $request_leave->approvers               = $approvers;
                        $request_leave->status_leave            = 2;
                        $request_leave->total_leave             = $total_leaves_m_a;
                        $request_leave->save();

                        return json_encode(['status' => 'success', 'message' => "success"]);
                    }

                    return json_encode(['status' => 'failed', 'message' => "errors"]);

                } else {

                    $request_leave                          = new Leaves; // case ลาครึ่งวัน
                    $request_leave->id_employee             = $current_employee['id_employee'];
                    $request_leave->id_leaves_type          = $leave_type; 
                    $request_leave->id_leaves_format        = $format_leaves; 
                    $request_leave->start_leave             = $half_date;   
                    $request_leave->end_leave               = $half_date;

                    if ($format_leave_m_a == 1) {
                        $request_leave->start_time          = $start_time_h_m;
                        $request_leave->end_time            = $end_time_h_m;
                    } else {
                        $request_leave->start_time          = $start_time_h_a;
                        $request_leave->end_time            = $end_time_h_a;
                    }

                    $request_leave->reason                  = $reason_leave;  
                    $request_leave->approvers               = $approvers;
                    $request_leave->status_leave            = 2;
                    $request_leave->total_leave             = $total_leaves_m_a;
                    $request_leave->save();

                    return json_encode(['status' => 'success', 'message' => "success"]);
                }
            }

        } else if ($format_leaves == 3 ){

            $leaves_check_hour    = Employee::with(['leaves' => function($q) 
                                                use($hour_date,$start_time_hour,$end_time_hour){
                                                    $q->where('start_leave','<=',$hour_date);
                                                    $q->where('end_leave','>=',$hour_date);
                                                    $q->where('start_time','<=',$start_time_hour);
                                                    $q->where('end_time','>=',$end_time_hour);}])
                                                ->with('company')
                                                ->where('id_employee',$current_employee['id_employee'])
                                                ->first();

            if (count($leaves_check_hour->leaves) != 0) {

                return json_encode(['status' => 'failed', 'message' => "errors"]);
            }

                $request_leave                          = new Leaves; // case ลาราย ชม.
                $request_leave->id_employee             = $current_employee['id_employee'];
                $request_leave->id_leaves_type          = $leave_type; 
                $request_leave->id_leaves_format        = $format_leaves; 
                $request_leave->start_leave             = $hour_date;   
                $request_leave->end_leave               = $hour_date;
                $request_leave->start_time              = $start_time_hour;
                $request_leave->end_time                = $end_time_hour;
                $request_leave->reason                  = $reason_leave;  
                $request_leave->approvers               = $approvers;
                $request_leave->status_leave            = 2;
                $request_leave->total_leave             = $total_leaves_hour;
                $request_leave->save();

                return json_encode(['status' => 'success', 'message' => "success"]);
            }
        }
    

    public function confirmDataRequestLeave(Request $request)  // อนุมัติ
    {
        $id                     = $request->get('id');
        $confirm                = Leaves::find($id);
        $confirm->status_leave  = 1;
        $confirm->save();
    }

    public function cancelDataRequestLeave(Request $request)  // ไม่อนุมัติ
    {
        $id                             = $request->get('id');
        $reason_reject                  = $request->get('reason_reject');
        $confirm                        = Leaves::find($id);
        $confirm->status_leave          = 3;
        $confirm->reason_approvers      = $reason_reject;
        $confirm->save();

    }

    public function editRequestLeave(Request $request){ // แก้ไขข้อมูลที่ร้องขอการลา

        if(\Session::has('current_employee')){
            $current_employee = \Session::get('current_employee');
        }

        $id                         = $request->get('id');
        $id_leave_type              = $request->get('leave_type'); 
        $format_leave_three_time    = $request->get('format_leave_three_time');
        $format_range               = $request->get('format_range');
        $start_date_full            = $request->get('start_date_full');
        $end_date_full              = $request->get('end_date_full');
        $start_time_full            = $request->get('start_time_full');
        $end_time_full              = $request->get('end_time_full');
        $half_date                  = $request->get('half_date');
        $start_time_morning         = $request->get('start_time_morning');
        $end_time_morning           = $request->get('end_time_morning');
        $start_time_afternoon       = $request->get('start_time_afternoon');
        $end_time_afternoon         = $request->get('end_time_afternoon');
        $hour_date                  = $request->get('hour_date');
        $start_time_hour            = $request->get('start_time_hour');
        $end_time_hour              = $request->get('end_time_hour');
        $reason_leave               = $request->get('reason_leave');
        $approvers                  = $request->get('approvers');

        $val_df_full                = $request->get('val_df_full');                 
        $val_df_half                = $request->get('val_df_half');                 
        $val_df_hour                = $request->get('val_df_hour'); 

        // SWITCH CASE
        if ($format_leave_three_time == 1 ) {

            $leaves_check_full_day = Leaves::with('employee')
                                            ->where('id_employee',$current_employee['id_employee'])   
                                            ->where('start_leave','<=',$start_date_f)
                                            ->where('end_leave','>=',$end_date_f)
                                            ->get();

            if (count($leaves_check_full_day) != 0 ) {
                return json_encode(['status' => 'failed', 'message' => "errors"]);
            }

                $request_leave                          = Leaves::find($id); 
                $request_leave->id_employee             = $current_employee['id_employee'];
                $request_leave->id_leaves_type          = $id_leave_type; 
                $request_leave->id_leaves_format        = $format_leave_three_time; 
                $request_leave->start_leave             = $start_date_full;    
                $request_leave->end_leave               = $end_date_full;
                $request_leave->start_time              = $start_time_full;
                $request_leave->end_time                = $end_time_full;
                $request_leave->reason                  = $reason_leave;  
                $request_leave->approvers               = $approvers;
                $request_leave->status_leave            = 2;
                $request_leave->total_leave             = $val_df_full;
                $request_leave->save();

                return json_encode(['status' => 'success', 'message' => "success"]);

        } else if($format_leave_three_time == 2 ){

            $leaves_check_half    = Employee::with(['leaves' => function($q) use($half_date){
                                                    $q->where('start_leave','<=',$half_date);
                                                    $q->where('end_leave','>=',$half_date);}])
                                                ->with('company')
                                                ->where('id_employee',$current_employee['id_employee'])
                                                ->first();

            if (!empty($leaves_check_half)) {
                $current_leave = $leaves_check_half->leaves;

                if (!empty($current_leave)) {

                    $check_error = 0 ;
                    foreach ($current_leave as $leave) {

                        if ($format_range == 1) { //morning
                            if ($start_time_morning == $leave['start_time'] || $end_time_morning == $leave['end_time'] ) {
                                $check_error++;
                            }

                        } else { //afternoon

                            if ($start_time_afternoon == $leave['start_time'] || $end_time_afternoon == $leave['end_time'] ) {
                                $check_error++;
                            }
                        }
                    }
                    if ($check_error == 0 ) {

                        $request_leave                          = Leaves::find($id); 
                        $request_leave->id_employee             = $current_employee['id_employee'];
                        $request_leave->id_leaves_type          = $id_leave_type; 
                        $request_leave->id_leaves_format        = $format_leave_three_time; 
                        $request_leave->start_leave             = $half_date;   
                        $request_leave->end_leave               = $half_date;

                        if ($format_range == 1) {
                            $request_leave->start_time          = $start_time_morning;
                            $request_leave->end_time            = $end_time_morning;
                        } else {
                            $request_leave->start_time          = $start_time_afternoon;
                            $request_leave->end_time            = $end_time_afternoon;
                        }

                        $request_leave->reason                  = $reason_leave;  
                        $request_leave->approvers               = $approvers;
                        $request_leave->status_leave            = 2;
                        $request_leave->total_leave             = $val_df_half;
                        $request_leave->save();

                        return json_encode(['status' => 'success', 'message' => "success"]);
                    }

                    return json_encode(['status' => 'failed', 'message' => "errors"]);

                } else {

                    $request_leave                          = Leaves::find($id); 
                    $request_leave->id_employee             = $current_employee['id_employee'];
                    $request_leave->id_leaves_type          = $id_leave_type; 
                    $request_leave->id_leaves_format        = $format_leave_three_time; 
                    $request_leave->start_leave             = $half_date;   
                    $request_leave->end_leave               = $half_date;

                    if ($format_range == 1) {
                        $request_leave->start_time          = $start_time_morning;
                        $request_leave->end_time            = $end_time_morning;
                    } else {
                        $request_leave->start_time          = $start_time_afternoon;
                        $request_leave->end_time            = $end_time_afternoon;
                    }

                    $request_leave->reason                  = $reason_leave;  
                    $request_leave->approvers               = $approvers;
                    $request_leave->status_leave            = 2;
                    $request_leave->total_leave             = $val_df_half;
                    $request_leave->save();

                    return json_encode(['status' => 'success', 'message' => "success"]);
                }
            }

        } else if ($format_leave_three_time == 3 ){

            $leaves_check_hour    = Employee::with(['leaves' => function($q) 
                                                use($hour_date,$start_time_hour,$end_time_hour){
                                                    $q->where('start_leave','<=',$hour_date);
                                                    $q->where('end_leave','>=',$hour_date);
                                                    $q->where('start_time','<=',$start_time_hour);
                                                    $q->where('end_time','>=',$end_time_hour);}])
                                                ->with('company')
                                                ->where('id_employee',$current_employee['id_employee'])
                                                ->first();

            if (count($leaves_check_hour->leaves) != 0) {

                return json_encode(['status' => 'failed', 'message' => "errors"]);
            }

                $request_leave                          = Leaves::find($id);
                $request_leave->id_employee             = $current_employee['id_employee'];
                $request_leave->id_leaves_type          = $id_leave_type; 
                $request_leave->id_leaves_format        = $format_leave_three_time; 
                $request_leave->start_leave             = $hour_date;   
                $request_leave->end_leave               = $hour_date;
                $request_leave->start_time              = $start_time_hour;
                $request_leave->end_time                = $end_time_hour;
                $request_leave->reason                  = $reason_leave;  
                $request_leave->approvers               = $approvers;
                $request_leave->status_leave            = 2;
                $request_leave->total_leave             = $val_df_hour;
                $request_leave->save();

                return json_encode(['status' => 'success', 'message' => "success"]);
        }
    }

    public function postDeleteLeaveHistory($id){

        $request_leave_history  = Leaves::with('employee')
                                            ->where('id_leave', $id)
                                            ->first();

        if(!empty($request_leave_history)){

            $request_leave_history->delete();
            return['status'     => 'success', 'message' => 'Delete complete.'];
        } else {
            return['status'     => 'failed','message'   =>'Not found.'];
        }
    }

    public function postDeleteSetHoliday($id){

        $check_set_holiday = DetailDayOffYear::where('id', $id)
                                                ->first();

        if(!empty($check_set_holiday)){

            $check_set_holiday->delete();
            return['status'     => 'success', 'message' => 'Delete complete.'];
        } else {
            return['status'     => 'failed','message'   =>'Not found.'];
        }
    }

    public function checkHoliday($start_date,$end_date)
    {
        $check_holiday  = DetailDayOffYear::where('date','<=',$start_date)
                                            ->where('date','>=',$end_date)
                                            ->get();
        if ($check_holiday->count() != 0) {
            return true;
        } else {
             return false;
        }
    }
}