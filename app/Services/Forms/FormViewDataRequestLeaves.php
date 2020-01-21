<?php
namespace App\Services\Forms;

use App\Services\Employee\EmployeeObject;
class FormViewDataRequestLeaves
{
	 public static function getViewDataRequestLeaves($data,$company_time,$leaves_type, $header,$leaves_format,$company_info){  
        $form_leave  = '<div class="box-body">';
        $form_leave .='ประเภท';
        $form_leave .= '<div class="input-group name_user">';
                $form_leave .= '<div class="input-group-addon">';
                        $form_leave .= '<i class="fa fa-navicon"></i>';
                $form_leave .='</div>';
              
               foreach($data as $value) {
                    $form_leave .= '<input type="text" class="form-control" readonly value="'.$value->leaves_type->leaves_name.'">';
                }  
            $form_leave .='</div>';
            $form_leave .= '<label class="text-error" id="edit-input-leave-type-text-error">';
            $form_leave .= '</label><br>';

           foreach($data as $value) {
                if($value['id_leaves_format'] == 1){ // full_day_leave
                     $form_leave .='รูปแบบ<br>';
                    $form_leave .= '<div class="form-group">';
                            $form_leave .= '<div class="col-sm-9">';
                                    $form_leave .= '<label class="group-display">';
                                            $form_leave .= '<input type="radio" name="format_leaves" id="full_day" value="'.$leaves_format[0]['id_leaves_format'].'" checked class="flat-red full_day"> ลาเต็มวัน';
                                    $form_leave .= '</label>&nbsp&nbsp';                                      
                            $form_leave .='</div>';
                    $form_leave .='</div><br>';

                    $form_leave .= '<div class="full_day_leaves col-md-12">';
                        $form_leave .= '<div class="col-md-6">';
                                $form_leave .='เริ่มวันที่';
                                $form_leave .= '<div class="input-group col-md-12">';
                                        $form_leave .= '<div class="input-group-addon">';
                                                $form_leave .= '<i class="fa fa-calendar"></i>';
                                        $form_leave .='</div>';
                                        $form_leave .= '<input type="text" value="'.$value['start_leave'].'" id="input-form_datetime" readonly class="form-control">';
                                $form_leave .='</div><br>';
                                $form_leave .='ถึงวันที่';
                                $form_leave .= '<div class="input-group col-md-12">';
                                        $form_leave .= '<div class="input-group-addon">';
                                                $form_leave .= '<i class="fa fa-calendar"></i>';
                                        $form_leave .='</div>';
                                        $form_leave .= '<input type="text" value="'.$value['end_leave'].'" id="input-form_datetime1" readonly class="form-control">';
                                $form_leave .='</div><br>';
                                
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
                }
            

                 if($value['id_leaves_format'] == 2){ // half_leave
                    $form_leave .='รูปแบบ<br>';
                    $form_leave .= '<div class="form-group">';
                            $form_leave .= '<div class="col-sm-9">';
                                    $form_leave .= '<label class="group-display">';
                                            $form_leave .= '<input type="radio" name="format_leaves" id="half" value="'.$leaves_format[1]['id_leaves_format'].'" checked class="flat-red half"> ลาครึ่งวัน';
                                    $form_leave .= '</label>&nbsp&nbsp';                       
                            $form_leave .='</div>';
                    $form_leave .='</div><br>';

                         $form_leave .= '<div class="half_morning_leave">';
                            $form_leave .= '<div class="col-md-6">';
                            $form_leave .='วันที่';
                            $form_leave .= '<div class="input-group col-md-12">';
                                    $form_leave .= '<div class="input-group-addon">';
                                            $form_leave .= '<i class="fa fa-calendar"></i>';
                                    $form_leave .='</div>';
                                    $form_leave .= '<input type="text" readonly value="'.$value['start_leave'].'" id="input-form_datetime2" readonly class="form-control">';
                            $form_leave .='</div>';
                            $form_leave .='</div><br>';

                                if($value['start_time'] == '09:00:00' ){

                                    $form_leave .= '<div class="col-md-3">';
                                            $form_leave .= '<input type="radio" checked name="format_leave" id="" value="1" class="flat-red half_morning"> ช่วงเช้า';
                                            $form_leave .= '<input type="hidden" name="" id="" value="'.$company_info->working_time->work_in_morning->start.'-'.$company_info->working_time->work_in_morning->end.'">';
                                    $form_leave .='</div>';
                                }

                                if($value['start_time'] == '13:00:00' ){
                                     $form_leave .= '<div class="col-md-3">';
                                            $form_leave .= '<input type="radio" checked name="format_leave" id="" value="2" class="flat-red half_afternoon"> ช่วงบ่าย';
                                              $form_leave .= '<input type="hidden" name="" id="" value="'.$company_info->working_time->work_in_afternoon->start.'-'.$company_info->working_time->work_in_afternoon->end.'">';
                                        $form_leave .='</div>';
                                } 

                            $form_leave .='</div>';
                        }

                        if($value['id_leaves_format'] == 3){ // hour_leave
                            $form_leave .='รูปแบบ<br>';
                            $form_leave .= '<div class="form-group">';
                                $form_leave .= '<div class="col-sm-9">';
                                        $form_leave .= '<label class="group-display">';
                                                $form_leave .= '<input type="radio" checked name="format_leaves" id="hour" value="'.$leaves_format[2]['id_leaves_format'].'" class="flat-red hour"> ลารายชั่วโมง';
                                        $form_leave .= '</label>&nbsp&nbsp';
                                $form_leave .='</div>';
                            $form_leave .='</div><br>';

                                $form_leave .= '<div class="half_afternoon_leave">';
                                $form_leave .= '<div class="col-md-6">';
                                $form_leave .='วันที่';
                                $form_leave .= '<div class="input-group col-md-12">';
                                        $form_leave .= '<div class="input-group-addon">';
                                                $form_leave .= '<i class="fa fa-calendar"></i>';
                                        $form_leave .='</div>';
                                        $form_leave .= '<input type="text" readonly value="'.$value['start_leave'].'" id="input-form_datetime3" readonly class="form-control">';
                                $form_leave .='</div><br>';
                                $form_leave .='</div>';
                                $form_leave .= '<div class="col-md-6">';
                                $form_leave .='เวลาเริ่ม';
                                $form_leave .= '<div class="input-group col-md-12">';
                                        $form_leave .= '<div class="input-group-addon">';
                                                $form_leave .= '<i class="fa fa-clock-o"></i>';
                                        $form_leave .='</div>';
                                        $form_leave .= '<input id="start_time_h_a" type="text" value="'.$value['start_time'].'" readonly class="form-control">';
                                $form_leave .='</div><br>';
                                  $form_leave .='เวลาสิ้นสุด';
                                $form_leave .= '<div class="input-group col-md-12">';
                                        $form_leave .= '<div class="input-group-addon">';
                                                $form_leave .= '<i class="fa fa-clock-o"></i>';
                                        $form_leave .='</div>';
                                        $form_leave .= '<input id="end_time_h_a" type="text" value="'.$value['end_time'].'" readonly class="form-control">';
                                $form_leave .='</div>';
                            $form_leave .='</div>';
                        }

            $form_leave .='</div><br>';
            $form_leave .='เหตุผลการลา<br>';
            $form_leave .='<textarea class="form-control textarea g-disable-input" readonly placeholder="type..." rows="5" id="edit-input-reason-leave-reason">'.$value['reason'].'</textarea>';
                    }
        return $form_leave;
    }
}