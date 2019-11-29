<?php
namespace App\Services\Forms;

use App\Services\Employee\EmployeeObject;
class FormLeave
{
	public static function getFormLeave(){
        $form_leave  = '<div class="box-body">';
        $form_leave .='ประเภท';
        $form_leave .= '<div class="input-group name_user">';
                $form_leave .= '<div class="input-group-addon">';
                        $form_leave .= '<i class="fa fa-navicon"></i>';
                $form_leave .='</div>';
                $form_leave .= '<select class="form-control select2" style="width: 100%;">';
                        $form_leave .= '<option selected="selected">เลือกประเภท...</option>';
                        $form_leave .= '<option>ลากิจส่วนตัว</option>';
                        $form_leave .= '<option>ลาป่วย</option>';
                        $form_leave .= '<option>ลาคลอดบุตร</option>';
                        $form_leave .= '<option>ลาไปช่วยเหลือภริยาหลังคลอด</option>';
                        $form_leave .= '<option>ลาพักผ่อน</option>';
                        $form_leave .= '<option>ลาอุปสมบท</option>';
                        $form_leave .= '<option>ลาไปประกอบพิธีฮัจญ์</option>';
                        $form_leave .= '<option>ลาเกี่ยวกับราชการทหาร</option>';
                        $form_leave .= '<option>ลาติดตามคู่สมรส</option>';
                        $form_leave .= '<option>การไปถือศีลปฏิบัติธรรม</option>';
                $form_leave .= '</select>';
        $form_leave .='</div><br>';
        $form_leave .='รูปแบบ<br>';
        $form_leave .= '<div class="form-group">';
                $form_leave .= '<div class="col-sm-9">';
                        $form_leave .= '<label class="group-display">';
                                $form_leave .= '<input type="radio" name="repeatday[]" value="sunday" class="flat-red"> ลาเต็มวัน';
                        $form_leave .= '</label>&nbsp&nbsp';
                        $form_leave .= '<label class="group-display">';
                                $form_leave .= '<input type="radio" name="repeatday[]" value="monday" class="flat-red"> ลาครึ่งเช้า';
                        $form_leave .= '</label>&nbsp&nbsp';
                        $form_leave .= '<label class="group-display">';
                                $form_leave .= '<input type="radio" name="repeatday[]" value="tuesday" class="flat-red"> ลาครึ่งบ่าย';
                        $form_leave .= '</label>&nbsp&nbsp';
                $form_leave .='</div>';
        $form_leave .='</div><br>';
        $form_leave .='เริ่มวันที่';
        $form_leave .= '<div class="input-group col-md-12">';
                $form_leave .= '<div class="input-group-addon">';
                        $form_leave .= '<i class="fa fa-calendar"></i>';
                $form_leave .='</div>';
                $form_leave .= '<input type="text" value="" readonly class="form_datetime form-control">';
        $form_leave .='</div><br>';
        $form_leave .='ถึงวันที่';
        $form_leave .= '<div class="input-group col-md-12">';
                $form_leave .= '<div class="input-group-addon">';
                        $form_leave .= '<i class="fa fa-calendar"></i>';
                $form_leave .='</div>';
                $form_leave .= '<input type="text" value="" readonly class="form_datetime1 form-control">';
        $form_leave .='</div>';
        $form_leave .= 'รวมจำนวน <i style="font-size: 30px; color: red" class="result" value=""> 0 </i> วัน<br><hr>';
          $form_leave .='เหตุผลการลา<br>';
          $form_leave .='<textarea class="form-control textarea g-disable-input" name="live-preview" placeholder="Type..." rows="5"></textarea>';

        return $form_leave;
    }

}