<?php
namespace App\Services\Forms;

use App\Services\Employee\EmployeeObject;
class FormRequestTimeStamp
{
	public static function getRequestTimeStamp($header) // ลืมลงเวลา
    {
                $form = '<div class="form-group">';
                    $form .= '<label>วันที่</label>';
                    $form .= '<div class="input-group">';
                        $form .= '<div class="input-group-addon">';
                            $form .= '<i class="fa fa-calendar"></i>';
                        $form .= '</div>';
                        $form .= '<input type="text" class="form-control datepicker required" value=""  id="date-request-forget-to-time">';
                    $form .= '</div>';
                $form .= '<label class="text-error" id="date-request-forget-to-time-text-error"></label>';
                $form .= '</div>';
                $form .= '<div class="form-group ">';
                    $form .= '<label>รูปแบบ</label>';
                    $form .= '<select class="form-control select2" style="width: 100%;" id="type-time-request-forget-to-time">';
                        $form .= '<option value="time_in" id="time_in">ลงเวลาเข้า  (Time In)</option>';
                        $form .= '<option value="time_out" id="time_out">ลงเวลาออก  (Time Out)</option>';
                        $form .= '<option value="break_out" id="break_out">ออกพักกลางวัน  (Break Out)</option>';
                        $form .= '<option value="break_in" id="break_in">เข้าพักกลางวัน  (Break In)</option>';
                    $form .= '</select>';
                $form .= '</div>';
                $form .= '<div class="form-group">';
                    $form .= '<label>เวลา</label>';
                    $form .= '<div class="input-group">';
                        $form .= '<div class="input-group-addon">';
                            $form .= '<i class="fa fa-clock-o"></i>';
                        $form .= '</div>';
                        $form .= '<input type="text" class="form-control timepicker" id="time-request-forget-to-time">';
                    $form .= '</div>';
                $form .= '</div>';
                $form .= '<div class="form-group">';
                    $form .= '<label>เหตุผล</label>';
                    $form .= '<textarea type="text" rows="5" class="form-control required" placeholder="ลืมลงเวลาออก" id="reason-request-forget-to-time" value=""></textarea>';
                $form .= '<label class="text-error" id="reason-request-forget-to-time-text-error"></label>';
                $form .= '</div>';
                $form .= '<div class="form-group">';
                    $form .= '<label>ผู้ที่จะอนุมัติ</label>';
                    $form .= '<div class="input-group">';
                        $form .= '<div class="input-group-addon">';
                            $form .= '<i class="fa fa-user"></i>';
                        $form .= '</div>';
                        $form .= '<input type="text" readonly class="form-control" value="'.$header['first_name'].' '.$header['last_name'].'">';
                    $form .= '</div>';
                $form .= '</div>';

        return $form;
    }

}