<?php
namespace App\Services\Forms;

use App\Services\Employee\EmployeeObject;
class FormLeave
{
	public static function getFormLeave($leaves_type, $header,$leaves_format,$company_info){
        $form_leave  = '<div class="box-body">';
        $form_leave .='ประเภท';
        $form_leave .= '<div class="input-group name_user">';
                $form_leave .= '<div class="input-group-addon">';
                        $form_leave .= '<i class="fa fa-navicon"></i>';
                $form_leave .='</div>';
                $form_leave .= '<select class="form-control select2 required" id="edit-input-leave-type" style="width: 100%;">';
                $form_leave .= '<option value="">'.'เลือกประเภทการลา...'.'</option>';
               foreach($leaves_type as $value) {
                    $form_leave .= '<option value="'.$value['id_leaves_type'].'">'.$value['leaves_name'].'</option>';
                }  
                $form_leave .= '</select>';
        $form_leave .='</div>';
                $form_leave .= '<label class="text-error" id="edit-input-leave-type-text-error">';
            $form_leave .= '</label><br>';
        $form_leave .='รูปแบบ<br>';
        $form_leave .= '<div class="form-group">';
                $form_leave .= '<div class="col-sm-9">';
                        $form_leave .= '<label class="group-display">';
                                $form_leave .= '<input type="radio" name="format_leaves" id="full_day" value="'.$leaves_format[0]['id_leaves_format'].'" class="flat-red full_day"> ลาเต็มวัน';
                        $form_leave .= '</label>&nbsp&nbsp';
                         $form_leave .= '<label class="text-error" id="full_day-text-error">';
                        $form_leave .= '</label>';
                        $form_leave .= '<label class="group-display">';
                                $form_leave .= '<input type="radio" name="format_leaves" id="half" value="'.$leaves_format[1]['id_leaves_format'].'" class="flat-red half"> ลาครึ่งวัน';
                        $form_leave .= '</label>&nbsp&nbsp';
                         $form_leave .= '<label class="text-error" id="half_morning-text-error">';
                        $form_leave .= '</label>';
                        $form_leave .= '<label class="group-display">';
                                $form_leave .= '<input type="radio" name="format_leaves" id="hour" value="'.$leaves_format[2]['id_leaves_format'].'" class="flat-red hour"> ลารายชั่วโมง';
                        $form_leave .= '</label>&nbsp&nbsp';
                         $form_leave .= '<label class="text-error" id="half_afternoon-text-error">';
                        $form_leave .= '</label>';
                $form_leave .='</div>';
        $form_leave .='</div><br>';

// full_day_leave
        $form_leave .= '<div class="full_day_leave hide col-md-12">';
            $form_leave .= '<div class="col-md-6">';
                    $form_leave .='เริ่มวันที่';
                    $form_leave .= '<div class="input-group col-md-12">';
                            $form_leave .= '<div class="input-group-addon">';
                                    $form_leave .= '<i class="fa fa-calendar"></i>';
                            $form_leave .='</div>';
                            $form_leave .= '<input type="text" value="" id="input-form_datetime" readonly class="form_datetime form-control">';
                    $form_leave .='</div>';
                    $form_leave .= '<label class="text-error" id="input-form_datetime-text-error">';
                $form_leave .= '</label><br>';
                
                    $form_leave .='ถึงวันที่';
                    $form_leave .= '<div class="input-group col-md-12">';
                            $form_leave .= '<div class="input-group-addon">';
                                    $form_leave .= '<i class="fa fa-calendar"></i>';
                            $form_leave .='</div>';
                            $form_leave .= '<input type="text" value="" id="input-form_datetime1" readonly class="form_datetime1 form-control">';
                    $form_leave .='</div>';
                     $form_leave .= '<label class="text-error" id="input-form_datetime1-text-error">';
                $form_leave .= '</label><br>';
                $form_leave .= '</div>';
                 $form_leave .= '<div class="col-md-6">';
                    $form_leave .='เวลาเริ่ม (default)';
                    $form_leave .= '<div class="input-group col-md-12">';
                            $form_leave .= '<div class="input-group-addon">';
                                    $form_leave .= '<i class="fa fa-clock-o"></i>';
                            $form_leave .='</div>';
                            $form_leave .= '<input type="text" id="start_time_f" value="09:00" readonly class="form-control">';
                    $form_leave .='</div><br>';
                      $form_leave .='เวลาสิ้นสุด (default)';
                    $form_leave .= '<div class="input-group col-md-12">';
                            $form_leave .= '<div class="input-group-addon">';
                                    $form_leave .= '<i class="fa fa-clock-o"></i>';
                            $form_leave .='</div>';
                            $form_leave .= '<input id="end_time_f" type="text" value="18:00" readonly class="form-control">';
                    $form_leave .='</div>';

            $form_leave .='</div>';
            $form_leave .='</div>';

// half_leave
             $form_leave .= '<div class="half_morning_leave hide">';
                $form_leave .= '<div class="col-md-6">';
                $form_leave .='วันที่';
                $form_leave .= '<div class="input-group col-md-12">';
                        $form_leave .= '<div class="input-group-addon">';
                                $form_leave .= '<i class="fa fa-calendar"></i>';
                        $form_leave .='</div>';
                        $form_leave .= '<input type="text" value="" id="input-form_datetime2" readonly class="form-control form_datetime2">';
                $form_leave .='</div>';
                $form_leave .= '<label class="text-error" id="input-form_datetime2-text-error">';
            $form_leave .= '</label><br>';
                $form_leave .='</div><br>';
                $form_leave .= '<div class="col-md-3">';
                        $form_leave .= '<input type="radio" name="format_leave" id="" value="1" class="flat-red half_morning"> ช่วงเช้า';
                        $form_leave .= '<input type="hidden" name="" id="start_time_h_m" value="'.$company_info->working_time->work_in_morning->start.'">';
                        $form_leave .= '<input type="hidden" name="" id="end_time_h_m" value="'.$company_info->working_time->work_in_morning->end.'">';
                $form_leave .='</div>';
                $form_leave .= '<div class="col-md-3">';
                        $form_leave .= '<input type="radio" name="format_leave" id="" value="2" class="flat-red half_afternoon"> ช่วงบ่าย';
                          $form_leave .= '<input type="hidden" name="" id="start_time_h_a" value="'.$company_info->working_time->work_in_afternoon->start.'">';
                          $form_leave .= '<input type="hidden" name="" id="end_time_h_a" value="'.$company_info->working_time->work_in_afternoon->end.'">';
                $form_leave .='</div>';
                $form_leave .='</div>';
                $form_leave .='</div>';
                $form_leave .='</div>';
                $form_leave .='</div>';

// hour_leave
                  $form_leave .= '<div class="half_afternoon_leave hide">';
                $form_leave .= '<div class="col-md-6">';
                $form_leave .='วันที่';
                $form_leave .= '<div class="input-group col-md-12">';
                        $form_leave .= '<div class="input-group-addon">';
                                $form_leave .= '<i class="fa fa-calendar"></i>';
                        $form_leave .='</div>';
                        $form_leave .= '<input type="text" value="" id="input-form_datetime3" readonly class="form-control form_datetime3">';
                $form_leave .='</div>';
                $form_leave .= '<label class="text-error" id="input-form_datetime3-text-error">';
            $form_leave .= '</label><br>';
                $form_leave .='</div>';
                $form_leave .= '<div class="col-md-6">';
                $form_leave .='เวลาเริ่ม';
                $form_leave .= '<div class="input-group col-md-12">';
                        $form_leave .= '<div class="input-group-addon">';
                                $form_leave .= '<i class="fa fa-clock-o"></i>';
                        $form_leave .='</div>';
                        $form_leave .= '<input id="start_time_hour" type="text" value="" readonly class="form-control">';
                $form_leave .='</div><br>';
                  $form_leave .='เวลาสิ้นสุด';
                $form_leave .= '<div class="input-group col-md-12">';
                        $form_leave .= '<div class="input-group-addon">';
                                $form_leave .= '<i class="fa fa-clock-o"></i>';
                        $form_leave .='</div>';
                        $form_leave .= '<input id="end_time_hour" type="text" value="" readonly class="form-control">';
                $form_leave .='</div>';
                $form_leave .='</div>';


            $form_leave .='</div><br>';
        // $form_leave .= '<div class="total_num hide">';
        //$form_leave .= 'รวมจำนวน <i style="font-size: 30px; color: red" class="result hide" id="edit-input-form_total_num" value="5"> 0 </i> วัน';
        //  $form_leave .= '<label class="text-error hide" id="edit-input-form_total_num-text-error">';
        //     $form_leave .= '</label><br><hr>';
        // $form_leave .= '</div><br>';
          $form_leave .='เหตุผลการลา<br>';
          $form_leave .='<textarea class="form-control textarea g-disable-input required" placeholder="Type..." rows="5" id="edit-input-reason-leave-reason"></textarea>';
           $form_leave .= '<label class="text-error" id="edit-input-reason-leave-reason-text-error">';
            $form_leave .= '</label>';
           $form_leave .= '<h4>ผู้อนุมัติ</h4>';
          $form_leave .= '<div class="input-group col-md-12 approved">';
                $form_leave .= '<div class="input-group-addon">';
                    $form_leave .= '<i class="fa fa-user"></i>';
                $form_leave .= '</div>';
                $form_leave .= '<input type="text" value="'.$header->first_name.' '.$header->last_name.'" readonly class="form-control" id="approved">';
                $form_leave .= '<input type="hidden" value="'.$header->id_employee.'" readonly class="form-control" id="approved-id">';
            $form_leave .= '</div>';

        return $form_leave;
    }

}