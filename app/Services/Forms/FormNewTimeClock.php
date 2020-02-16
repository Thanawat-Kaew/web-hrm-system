<?php
namespace App\Services\Forms;

use App\Services\Employee\EmployeeObject;
class FormNewTimeClock
{
	 public static function getFormNewTimeClock($header){
         $form_new_time_clock = '<h4>วันที่ขอลงเวลา</h4>';
            $form_new_time_clock .= '<div class="input-group col-md-12">';
                $form_new_time_clock .= '<div class="input-group-addon">';
                    $form_new_time_clock .= '<i class="fa fa-calendar"></i>';
                $form_new_time_clock .= '</div>';
                $form_new_time_clock .= '<input type="text"  value=""  placeholder="เลือกวันที่..."  class="form-control datepicker required" id="input-request_timestamp" name="request_timestamp">';
            $form_new_time_clock .= '</div>';
            $form_new_time_clock .= '<label class="text-error" id="input-request_timestamp-text-error"></label><br>';


            $form_new_time_clock .= '<h4>รูปแบบการลงเวลา</h4>';
            $form_new_time_clock .= '<div class="form-group">';
                $form_new_time_clock .= '<div class="col-md-12">';
                    $form_new_time_clock .= '<div class="col-md-6">';
                        $form_new_time_clock .= '<label class="group-display">';
                            $form_new_time_clock .= '<input type="checkbox" name="time_set[]" value="stamp_in_out" class="flat-red" id="t_in_out"> ';
                            $form_new_time_clock .= 'ลงเวลาเข้า-ออก งาน';
                        $form_new_time_clock .= '</label>';
                        $form_new_time_clock .= '<div class="col-md-12">';
                          $form_new_time_clock .= '<label class="group-display">';
                            $form_new_time_clock .= '<input type="checkbox" name="time_set[]" value="stamp_in" class="flat-red hide" id="t_in" disabled> ';
                            $form_new_time_clock .= 'ลงเวลาเข้างาน';
                        $form_new_time_clock .= '</label>';
                        $form_new_time_clock .= '<br>';
                        $form_new_time_clock .= '<label class="text-error" id="t_in-text-error">';
                        $form_new_time_clock .= '</label>';
                        $form_new_time_clock .= '<label class="group-display">';
                            $form_new_time_clock .= '<input type="checkbox" name="time_set[]" value="stamp_out" class="flat-red hide" id="t_out" disabled> ';
                            $form_new_time_clock .= 'ลงเวลาออกงาน';
                        $form_new_time_clock .= '</label>';
                        $form_new_time_clock .= '<br>';
                          $form_new_time_clock .= '<label class="text-error" id="t_out-text-error">';
                        $form_new_time_clock .= '</label>';
                        $form_new_time_clock .= '</div>';
                        $form_new_time_clock .= '<br>';
                    $form_new_time_clock .= '</div>';


                    $form_new_time_clock .= '<div class="col-md-6">';
                        $form_new_time_clock .= '<label class="group-display">';
                            $form_new_time_clock .= '<input type="checkbox" name="time_set[]" value="stamp_break_in_out" class="flat-red" id="br_in_out"> ';
                            $form_new_time_clock .= 'ลงเวลาพัก';
                        $form_new_time_clock .= '</label>';
                        $form_new_time_clock .= '<div class="col-md-12">';
                         $form_new_time_clock .= '<label class="group-display">';
                            $form_new_time_clock .= '<input type="checkbox" name="time_set[]" value="stamp_break_in" class="flat-red" id="br_in" disabled> ';
                            $form_new_time_clock .= 'พักกลางวัน';
                        $form_new_time_clock .= '</label>';
                        $form_new_time_clock .= '<br>';
                        $form_new_time_clock .= '<label class="group-display">';
                            $form_new_time_clock .= '<input type="checkbox" name="time_set[]" value="stamp_break_out" class="flat-red" id="br_out" disabled> ';
                            $form_new_time_clock .= 'เข้าทำงานช่วงบ่าย';
                        $form_new_time_clock .= '</label>';
                        $form_new_time_clock .= '<br>';
                        $form_new_time_clock .= '</div>';
                        $form_new_time_clock .= '<br>';
                    $form_new_time_clock .= '</div>';
                $form_new_time_clock .= '</div>';
            $form_new_time_clock .= '</div>';


            $form_new_time_clock .= '<div class="form-group input-t_in hide">';
                $form_new_time_clock .= 'เวลาเข้างาน';
                $form_new_time_clock .= '<div class="input-group">';
                    $form_new_time_clock .= '<div class="input-group-addon">';
                        $form_new_time_clock .= '<i class="fa fa-clock-o"></i>';
                    $form_new_time_clock .= '</div>';
                    $form_new_time_clock .= '<input type="text" name="time_in" id="input-time_in" class="form-control">';
                $form_new_time_clock .= '</div>';
            $form_new_time_clock .= '</div>';
            $form_new_time_clock .= '<label class="text-error" id="input-time_in-text-error">';
            $form_new_time_clock .= '</label>';

            $form_new_time_clock .= '<div class="form-group input-t_out hide">';
                $form_new_time_clock .= 'เวลาออกงาน';
                $form_new_time_clock .= '<div class="input-group time_out">';
                    $form_new_time_clock .= '<div class="input-group-addon">';
                        $form_new_time_clock .= '<i class="fa fa-clock-o"></i>';
                    $form_new_time_clock .= '</div>';
                    $form_new_time_clock .= '<input type="text" name="time_out" id="input-time_out" class="form-control" id="time_out">';
                $form_new_time_clock .= '</div>';
            $form_new_time_clock .= '</div>';
            $form_new_time_clock .= '<label class="text-error" id="input-time_out-text-error">';
            $form_new_time_clock .= '</label>';


            $form_new_time_clock .= '<div class="form-group input-b_in hide">';
                $form_new_time_clock .= 'พักกลางวัน';
                $form_new_time_clock .= '<div class="input-group">';
                    $form_new_time_clock .= '<div class="input-group-addon">';
                        $form_new_time_clock .= '<i class="fa fa-clock-o"></i>';
                    $form_new_time_clock .= '</div>';
                    $form_new_time_clock .= '<input type="text" name="break_in" id="input-break_in" class="form-control">';
                $form_new_time_clock .= '</div>';
            $form_new_time_clock .= '</div>';
            $form_new_time_clock .= '<label class="text-error" id="input-break_in-text-error">';
            $form_new_time_clock .= '</label>';
            $form_new_time_clock .= '<div class="form-group input-b_out hide">';
                $form_new_time_clock .= 'เข้าทำงานช่วงบ่าย';
                $form_new_time_clock .= '<div class="input-group">';
                    $form_new_time_clock .= '<div class="input-group-addon">';
                        $form_new_time_clock .= '<i class="fa fa-clock-o"></i>';
                    $form_new_time_clock .= '</div>';
                    $form_new_time_clock .= '<input type="text" name="break_out" id="input-break_out" class="form-control">';
                $form_new_time_clock .= '</div>';
            $form_new_time_clock .= '</div>';
            $form_new_time_clock .= '<label class="text-error" id="input-break_out-text-error">';
            $form_new_time_clock .= '</label>';

            /*$form_new_time_clock .= '<input type="text" value="" class="form-control error_check required" id="input-error_check" name="error_check" disabled>';*/
            $form_new_time_clock .= '<label class="text-error" id="input-error_check-text-error">';
            $form_new_time_clock .= '</label>';

            $form_new_time_clock .= '<br>';
            $form_new_time_clock .= '<h4>เหตุผล</h4>';
            $form_new_time_clock .= '<textarea type="text" class="form-control textarea g-disable-input required reason_request"  placeholder="Type..." rows="5" id="input-reason" name="reason">';
            $form_new_time_clock .= '</textarea>';
            $form_new_time_clock .= '<label class="text-error" id="input-reason-text-error">';
            $form_new_time_clock .= '</label>';
            $form_new_time_clock .= '<br>';

            $form_new_time_clock .= '<h4>ผู้อนุมัติ</h4>';
            $form_new_time_clock .= '<div class="input-group col-md-12 approved">';
                $form_new_time_clock .= '<div class="input-group-addon">';
                    $form_new_time_clock .= '<i class="fa fa-user"></i>';
                $form_new_time_clock .= '</div>';
                $form_new_time_clock .= '<input type="text" value="'.$header->first_name.' '.$header->last_name.'" readonly class="form-control" id="approved">';
                $form_new_time_clock .= '<input type="hidden" value="'.$header->id_employee.'" readonly class="form-control" id="approved-id">';
            $form_new_time_clock .= '</div>';

        return $form_new_time_clock;
    }

}