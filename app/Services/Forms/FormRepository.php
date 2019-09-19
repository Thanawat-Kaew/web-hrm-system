<?php 
namespace App\Services\Forms;

class FormRepository 
{
	public static function getFormEmployee(){

		$form_add_emp = '<div class="row">
        <div class="col-md-8 col-md-offset-2" >
        <div class="box-body">
       <div class="profile-picture">
        <div class="form-group">
        <label for="exampleInputFile">Profile Picture</label>
        <input type="file" id="exampleInputFile">
        </div>
        </div>
        รหัสพนักงาน
        <div class="input-group name_user">
        <div class="input-group-addon">
        <i class="fa fa-key"></i>
        </div>
        <input class="form-control" type="text" value="" readonly placeholder="Auto Generate">
        </div>
        ชื่อ
        <div class="input-group name_user">
        <div class="input-group-addon">
        <i class="fa fa-user-secret"></i>
        </div>
        <input class="form-control" type="text" value="" placeholder="สมหมาย">
        </div>
        นามสกุล
        <div class="input-group name_user">
        <div class="input-group-addon">
        <i class="fa fa-user-secret"></i>
        </div>
        <input class="form-control" type="text" value="" placeholder="แสนดี">
        </div>
        ตำแหน่ง
        <div class="input-group name_user">
        <div class="input-group-addon">
        <i class="fa fa-briefcase"></i>
        </div>
        <select class="form-control select2" style="width: 100%;">
        <option selected="selected">เลือกตำแหน่ง...</option>
        <option>ตำแหน่ง 1</option>
        <option>ตำแหน่ง 2</option>
        <option>ตำแหน่ง 3</option>
        </select>
        </div>
        แผนก
        <div class="input-group name_user">
        <div class="input-group-addon">
        <i class="fa fa-sitemap"></i>
        </div>
        <select class="form-control select2" style="width: 100%;">
        <option selected="selected">เลือกแผนก...</option>
        <option>แผนก 1</option>
        <option>แผนก 2</option>
        <option>แผนก 3</option>
        </select>
        </div>
        อัตราเงินเดือน
        <div class="input-group name_user">
        <div class="input-group-addon">
        <i class="fa fa-money"></i>
        </div>
        <input class="form-control" type="text" value="" placeholder="15,000...">
        </div>
        การศึกษา
        <div class="input-group name_user">
        <div class="input-group-addon">
        <i class="fa fa-graduation-cap"></i>
        </div>
        <input class="form-control" type="text" value="" placeholder=" ปริญญาตรี...">
        </div>
        อายุ
        <div class="input-group name_user">
        <div class="input-group-addon">
        <i class="fa  fa-circle-o"></i>
        </div>
        <input class="form-control" type="text" value="" placeholder="25...">
        </div>
        ที่อยู่
        <div class="input-group name_user">
        <div class="input-group-addon">
        <i class="fa fa-map-marker"></i>
        </div>
        <input class="form-control" type="text" value="" placeholder="ยานนาวา สาทร กรุงเทพฯ">
        </div>
        อีเมล์
        <div class="input-group name_user">
        <div class="input-group-addon">
        <i class="fa fa-envelope"></i>
        </div>
        <input class="form-control" type="text" value="" placeholder="email@example.com">
        </div>
        ตั้งรหัสผ่านเข้าสู่ระบบ
        <div class="input-group name_user">
        <div class="input-group-addon">
        <i class="fa fa-lock"></i>
        </div>
        <input class="form-control" style="border-color: red;" type="text" value="" placeholder="Password...">
        </div>
        ยืนยันรหัสผ่านอีกครั้ง
        <div class="input-group name_user">
        <div class="input-group-addon">
        <i class="fa fa-lock"></i>
        </div>
        <input class="form-control" style="border-color: red;" type="text" value="" placeholder="Confirm Password...">
        </div><br>
        </div>
        </div>
        </div>';

        return $form_add_emp;
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
        <input type="checkbox" name="repeatday[]" value="sunday" class="flat-red"> ลาเต็มวัน
        </label>&nbsp&nbsp
        <label class="group-display">
        <input type="checkbox" name="repeatday[]" value="monday" class="flat-red"> ลาครึ่งเช้า
        </label>&nbsp&nbsp
        <label class="group-display"> 
        <input type="checkbox" name="repeatday[]" value="tuesday" class="flat-red"> ลาครึ่งบ่าย
        </label>&nbsp&nbsp
        </div>
        </div><br>
        ว/ด/ป
        <div class="form-group"> 
        <div class="input-group">
        <div class="input-group-addon">
        <i class="fa fa-calendar"></i>
        </div>
        <input type="text" name="daterangepicker" class="form-control pull-right" id="daterangepicker">
        </div>
        </div><br>
        รวมจำนวน <i style="font-size: 30px; color: red"> 3 </i> วัน<br><hr>
        เหตุผลการลา<br>
        <textarea class="form-control textarea g-disable-input" name="live-preview" placeholder="Type..." rows="5"></textarea>';

        return $form_leave;
    }

}