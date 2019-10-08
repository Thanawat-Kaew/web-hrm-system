<?php
namespace App\Services\Forms;

class FormRepository
{
	public static function getFormEmployee($department, $position){
                $form = '<div class="row">';
            $form .= '<div class="col-md-8 col-md-offset-2" >';
                $form .= '<div class="box-body">';
                    $form .= '<div class="profile-picture">';
                        $form .= '<div class="form-group">';
                            $form .= '<label for="exampleInputFile">Profile Picture</label>';
                             $form .= '<input type="file" id="exampleInputFile">';
                         $form .= '</div>';
                     $form .= '</div>';
                     $form .= 'รหัสพนักงาน';
                    $form .= '<div class="input-group id_employee">';
                        $form .= '<div class="input-group-addon">';
                             $form .= '<i class="fa fa-key"></i>';
                         $form .= '</div>';
                         $form .= '<input class="form-control" type="text" value="" readonly placeholder="Auto Generate" id="id_employee">';
                     $form .= '</div>';
                    $form .= '<label class="text-error" id="text-error"></label>';
                     $form .= 'ชื่อ';
                    $form .= '<div class="input-group fname_employee">';
                        $form .= '<div class="input-group-addon">';
                             $form .= '<i class="fa fa-user-secret"></i>';
                         $form .= '</div>';
                         $form .= '<input class="form-control required " type="text" value="" placeholder="สมหมาย" id="fname">';
                     $form .= '</div>';
                    $form .= '<label class="text-error" id="fname-text-error"></label>';
                     $form .= 'นามสกุล';
                    $form .= '<div class="input-group lname_employee">';
                        $form .= '<div class="input-group-addon">';
                             $form .= '<i class="fa fa-user-secret"></i>';
                         $form .= '</div>';
                         $form .= '<input class="form-control required" type="text" value="" placeholder="แสนดี" id="lname">';
                     $form .= '</div>';
                    $form .= '<label class="text-error" id="lname-text-error"></label>';
                     $form .= 'ตำแหน่ง';
                    $form .= '<div class="input-group position_employee">';
                        $form .= '<div class="input-group-addon">';
                             $form .= '<i class="fa fa-briefcase"></i>';
                         $form .= '</div>';
                         $form .= '<select class="form-control required select2" style="width: 100%;" id="position">';
                             $form .= '<option selected="selected" value="">เลือกตำแหน่ง...</option>';
                            foreach ($position as $value) {
                             $form .= '<option value="'.$value->id_position.'">'.$value->name.'</option>';
                     }
                     $form .= '</select>';
                 $form .= '</div>';
                $form .= '<label class="text-error" id="position-text-error"></label>';
                 $form .= 'แผนก';
                $form .= '<div class="input-group department_employee">';
                    $form .= '<div class="input-group-addon">';
                         $form .= '<i class="fa fa-sitemap"></i>';
                     $form .= '</div>';
                     $form .= '<select class="form-control required select2" style="width: 100%;" id="department">';
                         $form .= '<option selected="selected" value="">เลือกแผนก...</option>';
                        foreach ($department as $value) {
                         $form .='<option value="'.$value->id_department.'">'.$value->name.'</option>';
                    }
                    $form .='</select>';
             $form .= '</div>';
            $form .= '<label class="text-error" id="department-text-error"></label>';
             $form .= 'อัตราเงินเดือน';
            $form .= '<div class="input-group salary_employee">';
                $form .= '<div class="input-group-addon">';
                     $form .= '<i class="fa fa-money"></i>';
                 $form .= '</div>';
                 $form .= '<input class="form-control required" type="number" value="" placeholder="15,000..." id="salary">';
             $form .= '</div>';
            $form .= '<label class="text-error" id="salary-text-error"></label>';
             $form .= 'การศึกษา';
            $form .= '<div class="input-group education_employee">';
                $form .= '<div class="input-group-addon">';
                     $form .= '<i class="fa fa-graduation-cap"></i>';
                 $form .= '</div>';
                 $form .= '<select class="form-control required select2" style="width: 100%;" id="education">';
                     $form .= '<option selected="selected" value="">เลือกระดับการศึกษา</option>';
                     $form .= '<option value="มัธยมต้น">มัธยมต้น</option>';
                     $form .= '<option value="มัธยมปลาย">มัธยมปลาย</option>';
                     $form .= '<option value="ประกาศนียบัตรวิชาชีพ (ปวช)">ประกาศนียบัตรวิชาชีพ (ปวช)</option>';
                     $form .= '<option value="ประกาศนียบัตรวิชาชีพชั้นสูง (ปวส)">ประกาศนียบัตรวิชาชีพชั้นสูง (ปวส)</option>';
                     $form .= '<option value="ปริญญาตรี">ปริญญาตรี</option>';
                     $form .= '<option value="ปริญญาโท">ปริญญาโท</option>';
                     $form .= '<option value="ปริญญาเอก">ปริญญาเอก</option>';
                 $form .= '</select>';
             $form .= '</div>';
            $form .= '<label class="text-error" id="education-text-error"></label>';
             $form .= 'เพศ';
            $form .= '<div class="input-group gender_employee">';
                $form .= '<div class="input-group-addon">';
                     $form .= '<i class="fa fa-venus-mars"></i>';
                 $form .= '</div>';
                 $form .= '<select class="form-control required select2" style="width: 100%;" id="gender">';
                     $form .= '<option selected="selected" value="">เลือกเพศ...</option>';
                     $form .= '<option value="หญิง">หญิง</option>';
                     $form .= '<option value="ชาย">ชาย</option>';
                 $form .= '</select>';
             $form .= '</div>';
            $form .= '<label class="text-error" id="gender-text-error"></label>';
             $form .= 'อายุ';
            $form .= '<div class="input-group old_employee">';
                $form .= '<div class="input-group-addon">';
                     $form .= '<i class="fa  fa-circle-o"></i>';
                 $form .= '</div>';
                 $form .= '<input class="form-control required" type="number" value="" placeholder="25..." id="age">';
             $form .= '</div>';
            $form .= '<label class="text-error" id="age-text-error"></label>';
             $form .= 'ที่อยู่';
            $form .= '<div class="input-group address_employee">';
                $form .= '<div class="input-group-addon">';
                     $form .= '<i class="fa fa-map-marker"></i>';
                 $form .= '</div>';
                 $form .= '<input class="form-control required" type="text" value="" placeholder="ยานนาวา สาทร กรุงเทพฯ" id="address">';
             $form .= '</div>';
            $form .= '<label class="text-error" id="address-text-error"></label>';
             $form .= 'อีเมล์';
            $form .= '<div class="input-group email_employee">';
                $form .= '<div class="input-group-addon">';
                     $form .= '<i class="fa fa-envelope"></i>';
                 $form .= '</div>';
                 $form .= '<input class="form-control required" type="text" value="" placeholder="email@example.com" id="email">';
             $form .= '</div>';
            $form .= '<label class="text-error" id="email-text-error"></label>';
            $form .= 'เบอร์โทรศัพท์';
            $form .= '<div class="input-group tel_employee">';
                $form .= '<div class="input-group-addon">';
                     $form .= '<i class="fa  fa-phone"></i>';
                 $form .= '</div>';
                 $form .= '<input class="form-control required" type="number" value="" placeholder="023456789..." id="tel">';
             $form .= '</div>';
            $form .= '<label class="text-error" id="tel-text-error"></label>';
             $form .= 'ตั้งรหัสผ่านเข้าสู่ระบบ';
            $form .= '<div class="input-group password_employee">';
                $form .= '<div class="input-group-addon">';
                     $form .= '<i class="fa fa-lock"></i>';
                 $form .= '</div>';
                 $form .= '<input class="form-control required"  type="text" value="" placeholder="Password..." id="password">';
             $form .= '</div>';
            $form .= '<label class="text-error" id="password-text-error"></label>';
             $form .= 'ยืนยันรหัสผ่านอีกครั้ง';
            $form .= '<div class="input-group confirm_password">';
                $form .= '<div class="input-group-addon">';
                     $form .= '<i class="fa fa-lock"></i>';
                 $form .= '</div>';
                 $form .= '<input class="form-control "  type="text" value="" id="confirm_password" placeholder="Confirm Password...">';
             $form .= '</div><br>';
            $form .= '<label class="text-error" id="confirm_password-text-error"></label>';
         $form .= '</div>';
         $form .= '</div>';
         $form .= '</div>';

        return $form;
    }

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
                $form_leave .= '<input type="text" value="" readonly class="form_datetime form-control">';
        $form_leave .='</div>';
        $form_leave .= 'รวมจำนวน <i style="font-size: 30px; color: red"> 3 </i> วัน<br><hr>';
          $form_leave .='เหตุผลการลา<br>';
          $form_leave .='<textarea class="form-control textarea g-disable-input" name="live-preview" placeholder="Type..." rows="5"></textarea>';

        return $form_leave;
    }

    public static function getFormNewTimeClock(){
        $form_new_time_clock = '<div class="box-body">
        วันที่ขอลงเวลาย้อนหลัง
        <div class="input-group col-md-12">
        <div class="input-group-addon">
        <i class="fa fa-calendar"></i>
        </div>
        <input readonly value="" placeholder="เลือกวันที่..."  class="form-control datepicker" id="date-history">
        </div><br>
        เวลาเข้างาน
        <div class="input-group col-md-12">
        <div class="input-group-addon">
        <i class="fa fa-clock-o"></i>
        </div>
        <input readonly value="" class="form-control timepicker" id="time-in-history">
        </div><br>
        เวลาออก(พัก)กลางวัน
        <div class="input-group col-md-12">
        <div class="input-group-addon">
        <i class="fa fa-clock-o"></i>
        </div>
        <input readonly value="" class="form-control timepicker" id="break-out-history">
        </div><br>
        เวลาเข้า(พัก)กลางวัน
        <div class="input-group col-md-12">
        <div class="input-group-addon">
        <i class="fa fa-clock-o"></i>
        </div>
        <input readonly value="" class="form-control timepicker" id="break-in-history">
        </div><br>
        เวลาเลิกงาน
        <div class="input-group col-md-12">
        <div class="input-group-addon">
        <i class="fa fa-clock-o"></i>
        </div>
        <input readonly value="" class="form-control timepicker" id="time-out-history">
        </div><br>
        เหตุผล<br>
        <textarea class="form-control textarea g-disable-input" placeholder="Type..." rows="5" id="reason"></textarea><br>
        ผู้อนุมัติ
        <div class="input-group col-md-12">
        <div class="input-group-addon">
        <i class="fa fa-user"></i>
        </div>
        <input value="" readonly class="form-control" id="approved">
        </div><br>
        </div>';
        return $form_new_time_clock;
    }

    public static function getFormEvaluation(){
        $form = '<div class="col-md-12 new-part">';
                 $form .= '<div class="panel panel-default">';
                     $form .= '<div class="panel-body">';
                        
                         $form .= '<label>ชื่อตอน </label>';
                         $form .= '<input type="text" name="add-name" class="form-control" placeholder="ชื่อตอน..."><br>';
                         $form .= '<label>คำถาม</label>';
                         $form .= '<button class="btn btn-success pull-right add-more" style="width: 63px;" type="button"><i class="glyphicon glyphicon-plus"></i> เพิ่ม</button>';

                         $form .= '<div class="control-group input-group" style="margin-top:10px">';
                             $form .= '<input type="text" name="addmore[]" class="form-control" placeholder="คำถาม">';
                             $form .= '<div class="input-group-btn"> ';
                                 $form .= '<button class="btn btn-warning remove" type="button"><i class="glyphicon glyphicon-remove"></i> ลบ</button>';
                             $form .= '</div>';
                         $form .= '</div>';
                         $form .= '<div class="selected-question"></div>';

                         $form .= '<div class="copy hide">';
                             $form .= '<div class="control-group input-group" style="margin-top:10px">';
                                 $form .= '<input type="text" name="addmore[]" class="form-control" placeholder="คำถาม">';
                                 $form .= '<div class="input-group-btn"> ';
                                     $form .= '<button class="btn btn-warning remove" type="button"><i class="glyphicon glyphicon-remove"></i> ลบ</button>';
                                 $form .= '</div>';
                             $form .= '</div>';
                         $form .= '</div><br>';
                             $form .= '<label>เลือกรูปแบบคำตอบ</label>';
                             $form .= '<select class="form-control" style="width: 100%;">';
                                 $form .= '<option selected="selected">เลือกรูปแบบ...</option>';
                                 $form .= '<option>รูปแบบ 1</option>';
                                 $form .= '<option>รูปแบบ 2</option>';
                             $form .= '</select>';
                             $form .= '<br>';
                             $form .= '<label>เปอร์เซนต์คะแนน (%)</label>';
                             $form .= '<input type="number" name="percen" class="form-control" placeholder="30">';
                     $form .= '</div>';
                 $form .= '</div>';
             $form .= '</div>';

        return $form;
    }
}