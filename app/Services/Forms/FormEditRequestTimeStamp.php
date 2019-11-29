<?php
namespace App\Services\Forms;

use App\Services\Employee\EmployeeObject;
class FormEditRequestTimeStamp
{
	 public static function getEditRequestTimeStamp($header, $data){ // request_history.php // แก้ไขข้อมูลที่ร้องขอมา
        $form_new_time_clock = '<h4>วันที่ขอลงเวลา</h4>';
            $form_new_time_clock .= '<div class="input-group col-md-12">';
                $form_new_time_clock .= '<div class="input-group-addon">';
                    $form_new_time_clock .= '<i class="fa fa-calendar"></i>';
                $form_new_time_clock .= '</div>';
                $form_new_time_clock .= '<input type="hidden" id="id-edit-request-timestamp" value="'.(!empty($data) ? $data['id'] : '').'" >';
                $form_new_time_clock .= '<input type="text"  value="'.$data['request_date'].'"  placeholder="เลือกวันที่..."  class="form-control datepicker required" id="edit-date-request-timestamp">';
            $form_new_time_clock .= '</div>';
            $form_new_time_clock .= '<label class="text-error" id="edit-date-request-timestamp-text-error"></label><br>';

            $form_new_time_clock .= '<h4>รูปแบบการลงเวลา</h4>';
            $form_new_time_clock .= '<div class="form-group">';
            $form_new_time_clock .= '<div class="form-group input-t_in '.($data['request_type'] == "time_in" ? '' : 'hide' ).'">';
                $form_new_time_clock .= 'เวลาเข้างาน';
                $form_new_time_clock .= '<div class="input-group">';
                    $form_new_time_clock .= '<div class="input-group-addon">';
                        $form_new_time_clock .= '<i class="fa fa-clock-o"></i>';
                    $form_new_time_clock .= '</div>';
                    $form_new_time_clock .= '<input type="text" name="time_in" id="edit-input-t_in" class="form-control '.($data['request_type'] == "time_in" ? 'required' : '' ).'" value="'.($data['request_type'] == "time_in" ? $data['request_time'] : '' ).'">';
                $form_new_time_clock .= '</div>';
            $form_new_time_clock .= '</div>';
            $form_new_time_clock .= '<label class="text-error" id="edit-input-t_in-text-error">';
            $form_new_time_clock .= '</label>';

            $form_new_time_clock .= '<div class="form-group input-t_out '.($data['request_type'] == "time_out" ? '' : 'hide' ).' ">';
                $form_new_time_clock .= 'เวลาออกงาน';
                $form_new_time_clock .= '<div class="input-group time_out">';
                    $form_new_time_clock .= '<div class="input-group-addon">';
                        $form_new_time_clock .= '<i class="fa fa-clock-o"></i>';
                    $form_new_time_clock .= '</div>';
                    $form_new_time_clock .= '<input type="text" name="t_out" id="edit-input-t_out" class="form-control '.($data['request_type'] == "time_out" ? 'required' : '' ).'" id="time_out" value="'.($data['request_type'] == "time_out" ? $data['request_time'] : '' ).'">';
                $form_new_time_clock .= '</div>';
            $form_new_time_clock .= '</div>';
            $form_new_time_clock .= '<label class="text-error" id="edit-input-t_out-text-error">';
            $form_new_time_clock .= '</label>';


            $form_new_time_clock .= '<div class="form-group input-b_in '.($data['request_type'] == "break_out" ? '' : 'hide' ).'">';
                $form_new_time_clock .= 'พักกลางวัน';
                $form_new_time_clock .= '<div class="input-group">';
                    $form_new_time_clock .= '<div class="input-group-addon">';
                        $form_new_time_clock .= '<i class="fa fa-clock-o"></i>';
                    $form_new_time_clock .= '</div>';
                    $form_new_time_clock .= '<input type="text" name="break_in" id="edit-input-b_in" class="form-control '.($data['request_type'] == "break_out" ? 'required' : '' ).'" value="'.($data['request_type'] == "break_out" ? $data['request_time'] : '' ).'">';
                $form_new_time_clock .= '</div>';
            $form_new_time_clock .= '</div>';
            $form_new_time_clock .= '<label class="text-error" id="edit-input-b_in-text-error">';
            $form_new_time_clock .= '</label>';
            $form_new_time_clock .= '<div class="form-group input-b_out '.($data['request_type'] == "break_in" ? '' : 'hide' ).'">';
                $form_new_time_clock .= 'เข้าทำงานช่วงบ่าย';
                $form_new_time_clock .= '<div class="input-group">';
                    $form_new_time_clock .= '<div class="input-group-addon">';
                        $form_new_time_clock .= '<i class="fa fa-clock-o"></i>';
                    $form_new_time_clock .= '</div>';
                    $form_new_time_clock .= '<input type="text" name="break_out" id="edit-input-b_out" class="form-control '.($data['request_type'] == "break_in" ? 'required' : '' ).'" value="'.($data['request_type'] == "break_in" ? $data['request_time'] : '' ).'">';
                $form_new_time_clock .= '</div>';
            $form_new_time_clock .= '</div>';
            $form_new_time_clock .= '<label class="text-error" id="edit-input-b_out-text-error">';
            $form_new_time_clock .= '</label>';


            $form_new_time_clock .= '<br>';
            $form_new_time_clock .= '<h4>เหตุผล</h4>';
            $form_new_time_clock .= '<textarea type="text" class="form-control textarea g-disable-input required reason_request"  placeholder="Type..." rows="5" id="edit-reason-request-time-stamp">'.$data['reason'];
            $form_new_time_clock .= '</textarea>';
            $form_new_time_clock .= '<label class="text-error" id="edit-reason-request-time-stamp-text-error">';
            $form_new_time_clock .= '</label>';
            $form_new_time_clock .= '<br>';

            $form_new_time_clock .= '<h4>ผู้อนุมัติ</h4>';
            $form_new_time_clock .= '<div class="input-group col-md-12 approved">';
                $form_new_time_clock .= '<div class="input-group-addon">';
                    $form_new_time_clock .= '<i class="fa fa-user"></i>';
                $form_new_time_clock .= '</div>';
                $form_new_time_clock .= '<input type="text" value="'.$header['first_name'].' '.$header['last_name'].'" readonly class="form-control" id="approved-id">';
                $form_new_time_clock .= '<input type="hidden" value="'.$header['id_employee'].'" readonly class="form-control" id="approved-id-edit">';
            $form_new_time_clock .= '</div>';

        return $form_new_time_clock;

    }
}