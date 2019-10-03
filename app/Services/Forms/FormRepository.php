<?php
namespace App\Services\Forms;

class FormRepository
{
	public static function getFormEmployee($department, $position){
		$form = '<div class="row">
        <div class="col-md-8 col-md-offset-2" >
        <div class="box-body">
        <div class="profile-picture">
        <div class="form-group">
        <label for="exampleInputFile">Profile Picture</label>
        <input type="file" id="exampleInputFile">
        </div>
        </div>
        รหัสพนักงาน
        <div class="input-group id_employee">
        <div class="input-group-addon">
        <i class="fa fa-key"></i>
        </div>
        <input class="form-control" type="text" value="" readonly placeholder="Auto Generate" id="id_employee">
        </div>
        <label class="text-error" id="text-error"></label>
        ชื่อ
        <div class="input-group fname_employee">
        <div class="input-group-addon">
        <i class="fa fa-user-secret"></i>
        </div>
        <input class="form-control required " type="text" value="" placeholder="สมหมาย" id="fname">
        </div>
        <label class="text-error" id="fname-text-error"></label>
        นามสกุล
        <div class="input-group lname_employee">
        <div class="input-group-addon">
        <i class="fa fa-user-secret"></i>
        </div>
        <input class="form-control required" type="text" value="" placeholder="แสนดี" id="lname">
        </div>
        <label class="text-error" id="lname-text-error"></label>
        ตำแหน่ง
        <div class="input-group position_employee">
        <div class="input-group-addon">
        <i class="fa fa-briefcase"></i>
        </div>
        <select class="form-control required select2" style="width: 100%;" id="position">
        <option selected="selected" value="">เลือกตำแหน่ง...</option>';
        foreach ($position as $value) {
            $form .='<option value="'.$value->id_position.'">'.$value->name.'</option>';
        }
        $form .='</select>
        </div>
        <label class="text-error" id="position-text-error"></label>
        แผนก
        <div class="input-group department_employee">
        <div class="input-group-addon">
        <i class="fa fa-sitemap"></i>
        </div>
        <select class="form-control required select2" style="width: 100%;" id="department">

        <option selected="selected" value="">เลือกแผนก...</option>';
        foreach ($department as $value) {
            $form .='<option value="'.$value->id_department.'">'.$value->name.'</option>';
        }
        $form .='
        </select>
        </div>
        <label class="text-error" id="department-text-error"></label>
        อัตราเงินเดือน
        <div class="input-group salary_employee">
        <div class="input-group-addon">
        <i class="fa fa-money"></i>
        </div>
        <input class="form-control required" type="number" value="" placeholder="15,000..." id="salary">
        </div>
        <label class="text-error" id="salary-text-error"></label>
        การศึกษา
        <div class="input-group education_employee">
        <div class="input-group-addon">
        <i class="fa fa-graduation-cap"></i>
        </div>
        <select class="form-control required select2" style="width: 100%;" id="education">
        <option selected="selected" value="">เลือกระดับการศึกษา</option>
        <option value="มัธยมต้น">มัธยมต้น</option>
        <option value="มัธยมปลาย">มัธยมปลาย</option>
        <option value="ประกาศนียบัตรวิชาชีพ (ปวช)">ประกาศนียบัตรวิชาชีพ (ปวช)</option>
        <option value="ประกาศนียบัตรวิชาชีพชั้นสูง (ปวส)">ประกาศนียบัตรวิชาชีพชั้นสูง (ปวส)</option>
        <option value="ปริญญาตรี">ปริญญาตรี</option>
        <option value="ปริญญาโท">ปริญญาโท</option>
        <option value="ปริญญาเอก">ปริญญาเอก</option>
        </select>
        </div>
        <label class="text-error" id="education-text-error"></label>
        เพศ
        <div class="input-group gender_employee">
        <div class="input-group-addon">
        <i class="fa fa-venus-mars"></i>
        </div>
        <select class="form-control required select2" style="width: 100%;" id="gender">
        <option selected="selected" value="">เลือกเพศ...</option>
        <option value="หญิง">หญิง</option>
        <option value="ชาย">ชาย</option>
        </select>
        </div>
        <label class="text-error" id="gender-text-error"></label>
        อายุ
        <div class="input-group old_employee">
        <div class="input-group-addon">
        <i class="fa  fa-circle-o"></i>
        </div>
        <input class="form-control required" type="number" value="" placeholder="25..." id="age">
        </div>
        <label class="text-error" id="age-text-error"></label>
        ที่อยู่
        <div class="input-group address_employee">
        <div class="input-group-addon">
        <i class="fa fa-map-marker"></i>
        </div>
        <input class="form-control required" type="text" value="" placeholder="ยานนาวา สาทร กรุงเทพฯ" id="address">
        </div>
        <label class="text-error" id="address-text-error"></label>
        อีเมล์
        <div class="input-group email_employee">
        <div class="input-group-addon">
        <i class="fa fa-envelope"></i>
        </div>
        <input class="form-control required" type="text" value="" placeholder="email@example.com" id="email">
        </div>
        <label class="text-error" id="email-text-error"></label>
        เบอร์โทรศัพท์
        <div class="input-group tel_employee">
        <div class="input-group-addon">
        <i class="fa  fa-phone"></i>
        </div>
        <input class="form-control required" type="number" value="" placeholder="023456789..." id="tel">
        </div>
        <label class="text-error" id="tel-text-error"></label>
        ตั้งรหัสผ่านเข้าสู่ระบบ
        <div class="input-group password_employee">
        <div class="input-group-addon">
        <i class="fa fa-lock"></i>
        </div>
        <input class="form-control required"  type="text" value="" placeholder="Password..." id="password">
        </div>
        <label class="text-error" id="password-text-error"></label>
        ยืนยันรหัสผ่านอีกครั้ง
        <div class="input-group confirm_password">
        <div class="input-group-addon">
        <i class="fa fa-lock"></i>
        </div>
        <input class="form-control "  type="text" value="" id="confirm_password" placeholder="Confirm Password...">
        </div><br>
        <label class="text-error" id="confirm_password-text-error"></label>
        </div>
        </div>
        </div>';

        return $form;
    }

    public static function getFormLeave(){
        $form_leave = '<div class="box-body">
        ประเภท
        <div class="input-group name_user">
        <div class="input-group-addon">
        <i class="fa fa-navicon"></i>
        </div>
        <select class="form-control select2" style="width: 100%;">
        <option selected="selected">เลือกประเภท...</option>
        <option>ลากิจส่วนตัว</option>
        <option>ลาป่วย</option>
        <option>ลาคลอดบุตร</option>
        <option>ลาไปช่วยเหลือภริยาหลังคลอด</option>
        <option>ลาพักผ่อน</option>
        <option>ลาอุปสมบท</option>
        <option>ลาไปประกอบพิธีฮัจญ์</option>
        <option>ลาเกี่ยวกับราชการทหาร</option>
        <option>ลาติดตามคู่สมรส</option>
        <option>การไปถือศีลปฏิบัติธรรม</option>
        </select>
        </div><br>
        รูปแบบ<br>
        <div class="form-group">
        <div class="col-sm-9">
        <label class="group-display">
        <input type="radio" name="repeatday[]" value="sunday" class="flat-red"> ลาเต็มวัน
        </label>&nbsp&nbsp
        <label class="group-display">
        <input type="radio" name="repeatday[]" value="monday" class="flat-red"> ลาครึ่งเช้า
        </label>&nbsp&nbsp
        <label class="group-display">
        <input type="radio" name="repeatday[]" value="tuesday" class="flat-red"> ลาครึ่งบ่าย
        </label>&nbsp&nbsp
        </div>
        </div><br>
        เริ่มวันที่
        <div class="input-group col-md-12">
        <div class="input-group-addon">
        <i class="fa fa-calendar"></i>
        </div>
        <input type="text" value="" readonly class="form_datetime form-control">
        </div><br>
        ถึงวันที่
        <div class="input-group col-md-12">
        <div class="input-group-addon">
        <i class="fa fa-calendar"></i>
        </div>
        <input type="text" value="" readonly class="form_datetime form-control">
        </div>
        รวมจำนวน <i style="font-size: 30px; color: red"> 3 </i> วัน<br><hr>
        เหตุผลการลา<br>
        <textarea class="form-control textarea g-disable-input" name="live-preview" placeholder="Type..." rows="5"></textarea>';

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
        เหตุผลการลา<br>
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
                         $form .= '<button class="btn btn-success pull-right add-more btn-sm" type="button"><i class="glyphicon glyphicon-plus"></i> เพิ่ม</button>';

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
                         $form .= '<div class="col-md-6">';
                             $form .= '<label>เลือกรูปแบบคำตอบ</label>';
                             $form .= '<select class="form-control" style="width: 100%;">';
                                 $form .= '<option selected="selected">เลือกรูปแบบ...</option>';
                                 $form .= '<option>รูปแบบ 1</option>';
                                 $form .= '<option>รูปแบบ 2</option>';
                                 $form .= '<option>รูปแบบ 3</option>';
                             $form .= '</select>';
                             $form .= '<br>';
                         $form .= '</div>';
                         $form .= '<div class="col-md-6">';
                             $form .= '<label>เปอร์เซนต์ (%)</label>';
                             $form .= '<input type="number" name="percen" class="form-control" placeholder="30">';
                         $form .= '</div>';
                     $form .= '</div>';
                 $form .= '</div>';
             $form .= '</div>';

        return $form;
    }
}