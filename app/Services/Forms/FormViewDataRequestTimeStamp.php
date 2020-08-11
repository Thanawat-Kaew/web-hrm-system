<?php
namespace App\Services\Forms;

use App\Services\Employee\EmployeeObject;
class FormViewDataRequestTimeStamp
{
	 public static function getViewDataRequestTimeStamp($data){  // time_stmap_request.php // ดูของคนที่ร้องขอมา
        $form  = '<div class="box-body">';

            $form .= 'วันที่ขอลงเวลาย้อนหลัง <span style="color : black">ปี/เดือน/วัน</span>';
            $form .= '<div class="input-group col-md-12">';
                $form .='<div class="input-group-addon">';
                    $form .='<i class="fa fa-calendar"></i>';
                $form .='</div>';
                $form .='<input  value="'.$data["request_date"].'" readonly  class="form-control datepicker required" id="date-history">';
            $form .='</div>';
            $form .='<label class="text-error" id="date-history-text-error"></label>';
            $form .='<br>';

            if($data["request_type"] == "time_in"){
            $form .='เวลาเข้างาน';
            $form .='<div class="input-group col-md-12">';
                $form .='<div class="input-group-addon">';
                    $form .='<i class="fa fa-clock-o"></i>';
                $form .='</div>';
                $form .='<input value="'.$data["request_time"].'"  readonly class="form-control timepicker required" id="time-in-history">';
            $form .='</div>';
            $form .='<label class="text-error" id="time-in-history-text-error"></label>';
            $form .='<br>';
            }

            if($data["request_type"] == "break_out"){
            $form .='เวลาออก(พัก)กลางวัน';
            $form .='<div class="input-group col-md-12">';
                $form .='<div class="input-group-addon">';
                    $form .='<i class="fa fa-clock-o"></i>';
                $form .='</div>';
                $form .='<input value="'.$data["request_time"].'"  readonly class="form-control timepicker required" id="break-out-history">';
            $form .='</div>';
            $form .='<label class="text-error" id="break-out-history-text-error"></label>';
            $form .='<br>';
            }

            if($data["request_type"] == "break_in"){
            $form .='เวลาเข้า(พัก)กลางวัน';
            $form .='<div class="input-group col-md-12">';
                $form .='<div class="input-group-addon">';
                    $form .='<i class="fa fa-clock-o"></i>';
                $form .='</div>';
                $form .='<input value="'.$data["request_time"].'"  readonly class="form-control timepicker required" id="break-in-history">';
            $form .='</div>';
            $form .='<label class="text-error" id="break-in-history-text-error"></label>';
            $form .='<br>';
            }

            if($data["request_type"] == "time_out"){
            $form .='เวลาเลิกงาน';
            $form .='<div class="input-group col-md-12">';
                $form .='<div class="input-group-addon">';
                    $form .='<i class="fa fa-clock-o"></i>';
                $form .='</div>';
                $form .='<input value="'.$data["request_time"].'" readonly class="form-control timepicker required" id="time-out-history" >';
            $form .='</div>';
            $form .='<label class="text-error" id="time-out-history-text-error"></label>';
            $form .='<br>';
            }

            $form .='เหตุผล';
            $form .='<br>';
            $form .='<textarea class="form-control textarea g-disable-input required"  readonly rows="5" id="reason-request-time-stamp" >'.$data["reason"].'</textarea>';
            $form .='<label class="text-error" id="reason-request-time-stamp-text-error"></label>';
            $form .='<br>';
              if(!empty($data["reason_approvers"])){
            $form .='เหตุผลที่ไม่อนุมัติ';
            $form .='<br>';            
            $form .='<textarea class="form-control textarea g-disable-input required"  readonly rows="5" id="reason-request-time-stamp" >'.$data["reason_approvers"].'</textarea>';
            $form .='<label class="text-error" id="reason-request-time-stamp-text-error"></label>';
            $form .='<br>';
            }


            if(!empty($data["reason_approvers"])){
            $form .='เหตุผลที่ไม่อนุมัติ';
            $form .='<br>';
            $form .='<textarea class="form-control textarea g-disable-input required"  readonly rows="5" id="reason-request-time-stamp" >'.$data["reason_approvers"].'</textarea>';
            $form .='<label class="text-error" id="reason-request-time-stamp-text-error"></label>';
            $form .='<br>';
            }

        $form .='</div>';
        return $form;
    }

}