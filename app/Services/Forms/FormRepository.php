<?php
namespace App\Services\Forms;

use App\Services\Employee\EmployeeObject;
class FormRepository
{
	public static function getFormEmployee($department, $position, $education, $employee=''){
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
                         $form .= '<input class="form-control required " type="text" value="'.((!empty($employee) ? $employee["first_name"] : '' )).'" placeholder="สมหมาย" id="fname">';
                     $form .= '</div>';
                    $form .= '<label class="text-error" id="fname-text-error"></label>';
                     $form .= 'นามสกุล';
                    $form .= '<div class="input-group lname_employee">';
                        $form .= '<div class="input-group-addon">';
                             $form .= '<i class="fa fa-user-secret"></i>';
                         $form .= '</div>';
                         $form .= '<input class="form-control required" type="text" value="'.((!empty($employee) ? $employee["last_name"] : '' )).'" placeholder="แสนดี" id="lname">';
                     $form .= '</div>';
                    $form .= '<label class="text-error" id="lname-text-error"></label>';
                     $form .= 'ตำแหน่ง';
                    $form .= '<div class="input-group position_employee">';
                        $form .= '<div class="input-group-addon">';
                             $form .= '<i class="fa fa-briefcase"></i>';
                         $form .= '</div>';
                         $form .= '<select class="form-control required select2" style="width: 100%;" id="position">';
                            if(!empty($employee)){ //แก้ไข
                                foreach($position as $value){
                                    $form .= '<option value="'.$employee->position['id_position'].'" '.(($value['id_position'] == $employee->position['id_position']) ? 'selected' : '').'>'.$value['name'].'</option>';
                                }
                            }else{ // เพิ่มพนักงาน
                                $form .= '<option value="">'.'เลือกตำแหน่ง...'.'</option>';
                                foreach($position as $value) {
                                    $form .= '<option value="'.$value['id_position'].'">'.$value['name'].'</option>';
                                }
                            }
                     $form .= '</select>';
                 $form .= '</div>';
                $form .= '<label class="text-error" id="position-text-error"></label>';
                $form .= 'แผนก';
            $form .= '<div class="input-group department_employee">';
                $form .= '<div class="input-group-addon">';
                     $form .= '<i class="fa fa-graduation-cap"></i>';
                $form .= '</div>';
                $form .= '<select class="form-control required select2" style="width: 100%;" id="add-emp-department">';
                     if(!empty($employee)){ //แก้ไข
                        foreach($department as $value){
                             $form .= '<option value="'.$employee->department['id_department'].'" '.(($value['id_department'] == $employee->department['id_department']) ? 'selected' : '').'>'.$value['name'].'</option>';
                        }
                    }else{ // เพิ่มพนักงาน
                        $form .= '<option value="">'.'เลือกแผนก...'.'</option>';
                        foreach($department as $value) {
                            $form .= '<option value="'.$value['id_department'].'">'.$value['name'].'</option>';
                        }
                    }
                $form .= '</select>';
            $form .= '</div>';
            $form .= '<label class="text-error" id="add-emp-department-text-error"></label>';
             $form .= 'อัตราเงินเดือน';
            $form .= '<div class="input-group salary_employee">';
                $form .= '<div class="input-group-addon">';
                     $form .= '<i class="fa fa-money"></i>';
                 $form .= '</div>';
                 $form .= '<input class="form-control required" type="number" value="'.((!empty($employee) ? $employee["salary"] : '' )).'" placeholder="15,000..." id="salary">';
             $form .= '</div>';
            $form .= '<label class="text-error" id="salary-text-error"></label>';
             $form .= 'การศึกษา';
            $form .= '<div class="input-group education_employee">';
                $form .= '<div class="input-group-addon">';
                     $form .= '<i class="fa fa-graduation-cap"></i>';
                 $form .= '</div>';
                 $form .= '<select class="form-control required select2" style="width: 100%;" id="education">';
                     if(!empty($employee)){ //แก้ไข
                                foreach($education as $value){
                                    $form .= '<option value="'.$employee->education['id_education'].'" '.(($value['id_education'] == $employee->education['id_education']) ? 'selected' : '').'>'.$value['name'].'</option>';
                                }
                            }else{ // เพิ่มพนักงาน
                                $form .= '<option value="">'.'เลือกระดับการศึกษา...'.'</option>';
                                foreach($education as $value) {
                                    $form .= '<option value="'.$value['id_education'].'">'.$value['name'].'</option>';
                                }
                            }
                 $form .= '</select>';
             $form .= '</div>';
            $form .= '<label class="text-error" id="education-text-error"></label>';
             $form .= 'เพศ';
            $form .= '<div class="input-group gender_employee">';
                $form .= '<div class="input-group-addon">';
                     $form .= '<i class="fa fa-venus-mars"></i>';
                 $form .= '</div>';
                 $form .= '<select class="form-control required select2" style="width: 100%;" id="gender">';
                     $form .= '<option selected="selected" value="'.((!empty($employee) ? $employee['gender'] : '' )).'">'.((!empty($employee) ? $employee['gender'] : 'เลือกเพศ...' )).'</option>';
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
                 $form .= '<input class="form-control required" type="number" value="'.((!empty($employee) ? $employee["age"] : '' )).'" placeholder="25..." id="age">';
             $form .= '</div>';
            $form .= '<label class="text-error" id="age-text-error"></label>';
             $form .= 'ที่อยู่';
            $form .= '<div class="input-group address_employee">';
                $form .= '<div class="input-group-addon">';
                     $form .= '<i class="fa fa-map-marker"></i>';
                 $form .= '</div>';
                 $form .= '<input class="form-control required" type="text" value="'.((!empty($employee) ? $employee["address"] : '' )).'" placeholder="ยานนาวา สาทร กรุงเทพฯ" id="address">';
             $form .= '</div>';
            $form .= '<label class="text-error" id="address-text-error"></label>';
             $form .= 'อีเมล์';
            $form .= '<div class="input-group email_employee">';
                $form .= '<div class="input-group-addon">';
                     $form .= '<i class="fa fa-envelope"></i>';
                 $form .= '</div>';
                 $form .= '<input class="form-control required" type="text" value="'.((!empty($employee) ? $employee["email"] : '' )).'" placeholder="email@example.com" id="email">';
             $form .= '</div>';
            $form .= '<label class="text-error" id="email-text-error"></label>';
            $form .= 'เบอร์โทรศัพท์';
            $form .= '<div class="input-group tel_employee">';
                $form .= '<div class="input-group-addon">';
                     $form .= '<i class="fa  fa-phone"></i>';
                 $form .= '</div>';
                 $form .= '<input class="form-control required" type="number" value="'.((!empty($employee) ? $employee["tel"] : '' )).'" placeholder="023456789..." id="tel">';
             $form .= '</div>';
            $form .= '<label class="text-error" id="tel-text-error"></label>';
             $form .= 'ตั้งรหัสผ่านเข้าสู่ระบบ';
            $form .= '<div class="input-group password_employee">';
                $form .= '<div class="input-group-addon">';
                     $form .= '<i class="fa fa-lock"></i>';
                 $form .= '</div>';
                 $form .= '<input class="form-control required"  type="text" value="'.((!empty($employee) ? $employee["password"] : '' )).'" placeholder="Password..." id="password">';
             $form .= '</div>';
            $form .= '<label class="text-error" id="password-text-error"></label>';
             $form .= 'ยืนยันรหัสผ่านอีกครั้ง';
            $form .= '<div class="input-group confirm_password">';
                $form .= '<div class="input-group-addon">';
                     $form .= '<i class="fa fa-lock"></i>';
                 $form .= '</div>';
                 $form .= '<input class="form-control "  type="text" value="'.((!empty($employee) ? $employee["password"] : '' )).'" id="confirm_password" placeholder="Confirm Password...">';
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

    public static function getFormNewTimeClock($header){
         $form_new_time_clock = '<h4>วันที่ขอลงเวลา</h4>';
            $form_new_time_clock .= '<div class="input-group col-md-12">';
                $form_new_time_clock .= '<div class="input-group-addon">';
                    $form_new_time_clock .= '<i class="fa fa-calendar"></i>';
                $form_new_time_clock .= '</div>';
                $form_new_time_clock .= '<input type="text"  value=""  placeholder="เลือกวันที่..."  class="form-control datepicker required" id="date-request-timestamp">';
            $form_new_time_clock .= '</div>';
            $form_new_time_clock .= '<label class="text-error" id="date-request-timestamp-text-error"></label><br>';


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
                    $form_new_time_clock .= '<input type="text" name="time_in" id="input-t_in" class="form-control">';
                $form_new_time_clock .= '</div>';
            $form_new_time_clock .= '</div>';
            $form_new_time_clock .= '<label class="text-error" id="input-t_in-text-error">';
            $form_new_time_clock .= '</label>';

            $form_new_time_clock .= '<div class="form-group input-t_out hide">';
                $form_new_time_clock .= 'เวลาออกงาน';
                $form_new_time_clock .= '<div class="input-group time_out">';
                    $form_new_time_clock .= '<div class="input-group-addon">';
                        $form_new_time_clock .= '<i class="fa fa-clock-o"></i>';
                    $form_new_time_clock .= '</div>';
                    $form_new_time_clock .= '<input type="text" name="t_out" id="input-t_out" class="form-control" id="time_out">';
                $form_new_time_clock .= '</div>';
            $form_new_time_clock .= '</div>';
            $form_new_time_clock .= '<label class="text-error" id="input-t_out-text-error">';
            $form_new_time_clock .= '</label>';


            $form_new_time_clock .= '<div class="form-group input-b_in hide">';
                $form_new_time_clock .= 'พักกลางวัน';
                $form_new_time_clock .= '<div class="input-group">';
                    $form_new_time_clock .= '<div class="input-group-addon">';
                        $form_new_time_clock .= '<i class="fa fa-clock-o"></i>';
                    $form_new_time_clock .= '</div>';
                    $form_new_time_clock .= '<input type="text" name="break_in" id="input-b_in" class="form-control">';
                $form_new_time_clock .= '</div>';
            $form_new_time_clock .= '</div>';
            $form_new_time_clock .= '<label class="text-error" id="input-b_in-text-error">';
            $form_new_time_clock .= '</label>';
            $form_new_time_clock .= '<div class="form-group input-b_out hide">';
                $form_new_time_clock .= 'เข้าทำงานช่วงบ่าย';
                $form_new_time_clock .= '<div class="input-group">';
                    $form_new_time_clock .= '<div class="input-group-addon">';
                        $form_new_time_clock .= '<i class="fa fa-clock-o"></i>';
                    $form_new_time_clock .= '</div>';
                    $form_new_time_clock .= '<input type="text" name="break_out" id="input-b_out" class="form-control">';
                $form_new_time_clock .= '</div>';
            $form_new_time_clock .= '</div>';
            $form_new_time_clock .= '<label class="text-error" id="input-b_out-text-error">';
            $form_new_time_clock .= '</label>';


            $form_new_time_clock .= '<br>';
            $form_new_time_clock .= '<h4>เหตุผล</h4>';
            $form_new_time_clock .= '<textarea type="text" class="form-control textarea g-disable-input required reason_request"  placeholder="Type..." rows="5" id="reason-request-time-stamp">';
            $form_new_time_clock .= '</textarea>';
            $form_new_time_clock .= '<label class="text-error" id="reason-request-time-stamp-text-error">';
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


    public static function getFormChangeDepartment($employee){
      $form_head ='';
      $form_emp ='';

            foreach ($employee as $key => $value) {
               if($value['id_position'] == 2) {
                $form_head .='<div class="col-md-2 col-sm-2 ">';
                $form_head .='<div class="box box-widget widget-user-2">';
                $form_head .='<div class="widget-user-header">';
                $form_head .='<!-- /.widget-user-image -->';
                $form_head .='<div class="group-image" align="center" valign="center">';
                $form_head .='<img src="/resources/assets/theme/adminlte/dist/img/user8-128x128.jpg">';
                $form_head .='</div>';
                $form_head .='<div class="about-employee" id="header">';
                $form_head .='<p id="header_id">รหัส  : <span>'.$value["id_employee"].'</span></p>';
                $form_head .='<p id="header_name">ชื่อ : <span>'.$value["first_name"].' '.$value["last_name"].'</span></p>';
                $form_head .='</div>';
                $form_head .='</div>';
                $form_head .='<div class="box-footer no-padding">';
                $form_head .='<ul class="nav nav-stacked">';
                $form_head .='<li class="manage-employee" data-form_id="'.$value["id_employee"].'" data-form_position="'.$value["id_position"].'" data-form_department="'.$value["id_department"].'">';
                $form_head .='<a style="margin: 5px border: 1px; color : #F76608;">';
                $form_head .='<center>';
                $form_head .='<i class="fa fa-cog"></i> Manage Data';
                $form_head .='</center>';
                $form_head .='</a>';
                $form_head .='</li>';
                $form_head .='</ul>';
                $form_head .='</div>';
                $form_head .='</div>';
                $form_head .='</div>';
            }
        }

         foreach($employee as $key => $value) {
            if($value['id_position'] == 1) {
                $form_emp .='<div class="col-md-2 col-sm-2 ">';
                $form_emp .='<div class="box box-widget widget-user-2">';
                $form_emp .='<div class="widget-user-header">';
                $form_emp .='<!-- /.widget-user-image -->';
                $form_emp .='<div class="group-image" align="center" valign="center">';
                $form_emp .='<img src="/resources/assets/theme/adminlte/dist/img/user2-160x160.jpg">';
                $form_emp .='</div>';
                $form_emp .='<div class="about-employee" id="employee">';
                $form_emp .='<p>รหัส  : <span>'.$value['id_employee'].'</span></p>';
                $form_emp .='<p>ชื่อ   : <span>'.$value['first_name']." ".$value['last_name'].'</span></p>';
                $form_emp .='</div>';
                $form_emp .='</div>';
                $form_emp .='<div class="box-footer no-padding">';
                $form_emp .='<ul class="nav nav-stacked">';
                $form_emp .='<li class="manage-employee" data-form_id="'.$value["id_employee"].'" data-form_position="'.$value["id_position"].'" data-form_department="'.$value["id_department"].'">';
                $form_emp .='<a style="margin: 5px border: 1px; color : #F76608;">';
                $form_emp .='<center>';
                $form_emp .='<i class="fa fa-cog"></i> Manage Data';
                $form_emp .='</center>';
                $form_emp .='</a>';
                $form_emp .='</li>';
                $form_emp .='</ul>';
                $form_emp .='</div>';
                $form_emp .='</div>';
                $form_emp .='</div>';
            }
        }

         return ['form_head' => $form_head, 'form_emp' => $form_emp];
    }

    public static function getManageData($get_data_employee){
        if(!empty($get_data_employee)){
            $department_employee    = $get_data_employee->department->id_department;
            $position_employee      = $get_data_employee->position->id_position;

            $current_employee       = new EmployeeObject;
            $current_position       = $current_employee->getIdPosition();
            $current_department     = $current_employee->getIdDepartment();

                $form = '<div class="view-menu" style="padding:0 15%; text-align: center; font-size : 18px;">';
                    $form .= '<div class="form-group">';
                        $form .= '<button class="btn btn-block btn-info btn-outline-primary view_data" href="#">';
                            $form .= '<center>';
                                $form .= '<i class="fa fa-search"></i> ดูข้อมูลส่วนตัว';
                            $form .= '</center>';
                        $form .= '</button>';

                        if($current_department == 'hr0001' &&  ($position_employee == $current_position || $current_position == 2) ){
                            $form .= '<button class="btn btn-block btn-warning btn-outline-success edit_data" href="#">';
                                $form .= '<center>';
                                    $form .= '<i class="fa fa-cog"></i> แก้ไขข้อมูล';
                                $form .= '</center>';
                            $form .= '</button>';
                        }

                        if($current_department == 'hr0001' &&  $current_position == 2){
                            $form .= '<button class="btn btn-block btn-danger btn-outline-success  delete_data" href="#" data-href="'.route('data_manage.delete_employee.post',$get_data_employee['id_employee']).'" >';
                                $form .= '<center>';
                                    $form .= '<i class="fa fa-trash-o"></i> ลบข้อมูล';
                                $form .= '</center>';
                            $form .= '</button>';
                        }
                $form .= '</div>';
            return $form;
        }
    }

    public static function getFormAmendment($department, $position , $employee, $education){
                $form = '<div class="row">';
            $form .= '<div class="col-md-8 col-md-offset-2" >';
                $form .= '<div class="box-body">';
                $form .= '<input type="hidden" value="'.$employee['id_employee'].'" id="id_employee">';
                     $form .= 'ชื่อ';
                    $form .= '<div class="input-group fname_employee">';
                        $form .= '<div class="input-group-addon">';
                             $form .= '<i class="fa fa-user-secret"></i>';
                         $form .= '</div>';
                         $form .= '<input class="form-control required " type="text" value="'.$employee["first_name"].'" id="fname">';
                     $form .= '</div>';
                     $form .= '<label class="text-error" id="fname-text-error"></label>';
                     $form .= 'นามสกุล';
                    $form .= '<div class="input-group lname_employee">';
                        $form .= '<div class="input-group-addon">';
                             $form .= '<i class="fa fa-user-secret"></i>';
                         $form .= '</div>';
                         $form .= '<input class="form-control required" type="text" value="'.$employee["last_name"].'" id="lname">';
                     $form .= '</div>';
                     $form .= '<label class="text-error" id="lname-text-error"></label>';
                     $form .= 'ตำแหน่ง';
                    $form .= '<div class="input-group position_employee">';
                        $form .= '<div class="input-group-addon">';
                             $form .= '<i class="fa fa-briefcase"></i>';
                         $form .= '</div>';
                         $form .= '<select class="form-control required select2" style="width: 100%;" id="position">';
                            foreach ($position as $value) {
                            $form .= '<option value="'.$value["id_position"].'" '.(($value["id_position"] == $employee['id_position']) ? 'selected' : '').'>'.$value["name"].'</option>';
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
                        foreach ($department as $value) {
                        $form .= '<option value="'.$value["id_department"].'" '.(($value["id_department"] == $employee['id_department']) ? 'selected' : '').'>'.$value["name"].'</option>';
                    }
                    $form .='</select>';
             $form .= '</div>';
             $form .= '<label class="text-error" id="department-text-error"></label>';
             $form .= 'การศึกษา';
            $form .= '<div class="input-group education_employee">';
                $form .= '<div class="input-group-addon">';
                     $form .= '<i class="fa fa-graduation-cap"></i>';
                 $form .= '</div>';
                 $form .= '<select class="form-control required select2" style="width: 100%;" id="education">';
                 foreach ($education as $value) {
                        $form .= '<option value="'.$value["id_education"].'" '.(($value["id_education"] == $employee['id_education']) ? 'selected' : '').'>'.$value["name"].'</option>';
                    }
                 $form .= '</select>';
             $form .= '</div>';
             $form .= '<label class="text-error" id="education-text-error"></label>';
             $form .= 'เพศ';
            $form .= '<div class="input-group gender_employee">';
                $form .= '<div class="input-group-addon">';
                     $form .= '<i class="fa fa-venus-mars"></i>';
                 $form .= '</div>';
                 $form .= '<select class="form-control required select2" style="width: 100%;" id="gender">';
                     $form .= '<option value="หญิง" '.(($employee['gender'] == "หญิง") ? 'selected' : '').'>หญิง</option>';
                     $form .= '<option value="ชาย"'.(($employee['gender'] == "ชาย") ? 'selected' : '').'>ชาย</option>';
                 $form .= '</select>';
             $form .= '</div>';
             $form .= '<label class="text-error" id="gender-text-error"></label>';
             $form .= 'อายุ';
            $form .= '<div class="input-group old_employee">';
                $form .= '<div class="input-group-addon">';
                     $form .= '<i class="fa  fa-circle-o"></i>';
                 $form .= '</div>';
                 $form .= '<input class="form-control required" type="number" value="'.$employee["age"].'" id="age">';
             $form .= '</div>';
             $form .= 'ที่อยู่';
            $form .= '<div class="input-group address_employee">';
                $form .= '<div class="input-group-addon">';
                     $form .= '<i class="fa fa-map-marker"></i>';
                 $form .= '</div>';
                 $form .= '<input class="form-control required" type="text" value="'.$employee["address"].'" id="address">';
             $form .= '</div>';
             $form .= '<label class="text-error" id="address-text-error"></label>';
             $form .= 'อีเมล์';
            $form .= '<div class="input-group email_employee">';
                $form .= '<div class="input-group-addon">';
                     $form .= '<i class="fa fa-envelope"></i>';
                 $form .= '</div>';
                 $form .= '<input class="form-control required" type="email" value="'.$employee["email"].'"  id="email">';
             $form .= '</div>';
             $form .= '<label class="text-error" id="email-text-error"></label>';
            $form .= 'เบอร์โทรศัพท์';
            $form .= '<div class="input-group tel_employee">';
                $form .= '<div class="input-group-addon">';
                     $form .= '<i class="fa  fa-phone"></i>';
                 $form .= '</div>';
                 $form .= '<input class="form-control required" type="number" value="'.$employee["tel"].'"  id="tel">';
             $form .= '</div>';
             $form .= '<label class="text-error" id="tel-text-error"></label>';
               $form .= 'เหตุผลที่แก้ไข';
            $form .= '<div class="input-group reason">';
                $form .= '<div class="input-group-addon">';
                     $form .= '<i class="fa fa-commenting"></i>';
                 $form .= '</div>';
                 $form .= '<input class="form-control required" type="text" value="" placeholder="เหตุผล..." id="reason">';
             $form .= '</div>';
             $form .= '<label class="text-error" id="reason-text-error"></label>';
             $form .= '<br>';
         $form .= '</div>';
         $form .= '</div>';
         $form .= '</div>';

        return $form;
    }

    public static function getDataPersonal($employee){
        $form = '<div class="box-body" style="text-center">';
            $form .= '<div class="text-center">';
                $form .= '<img src="/resources/assets/theme/adminlte/dist/img/user2-160x160.jpg" class="user-image img-circle" alt="User Image">';
            $form .= '</div>';
            $form .= '<div class="personal-data">';
            $form .= '<h4>รหัสพนักงาน :  '.$employee['id_employee'].' </h4>';
            $form .= '<h4>ชื่อ - สกุล :   '.$employee['first_name'].' '. $employee['last_name'].'</h4>';
            $form .= '<h4>ตำแหน่ง :    '.  $employee->position["name"].'</h4>';
            $form .= '<h4>แผนก :  '.  $employee->department['name'].'</h4>';
            if($employee['$id_position'] == 2 ){
            $form .= '<h4>อัตราเงินเดือน : '. $employee['salary'].' </h4>';
            }
            $form .= '<h4>การศึกษา :  '. $employee->education['name'].' </h4>';
            $form .= '<h4>เพศ :  '. $employee['gender'].' </h4>';
            $form .= '<h4>อายุ :  '. $employee['age'].' </h4>';
            $form .= '<h4>ที่อยู่ :  '. $employee['address'].' </h4>';
            $form .= '<h4>อีเมล์ :  '. $employee['email'].' </h4>';
            $form .= '<h4>เบอร์โทรศัพท์ : '. $employee['tel'].' </h4>';
        $form .= '</div>';
        $form .= '</div>';

    return $form;
    }

    public static function getHistoryChangeData($emp_department, $emp_position ,$employee, $emp_education){
                $form = '<div class="row">';
            $form .= '<div class="col-md-8 col-md-offset-2" >';
                $form .= '<div class="box-body">';
                $form .= '<input type="hidden" value="'.$employee['id_employee'].'" id="id_employee">';
                     $form .= 'ชื่อ';
                    $form .= '<div class="input-group fname_employee">';
                        $form .= '<div class="input-group-addon">';
                             $form .= '<i class="fa fa-user-secret"></i>';
                         $form .= '</div>';
                         $form .= '<input class="form-control required " readonly type="text" value="'.$employee["first_name"].'" id="fname">';
                     $form .= '</div>';
                     $form .= '<label class="text-error" id="fname-text-error"></label>';
                     $form .= 'นามสกุล';
                    $form .= '<div class="input-group lname_employee">';
                        $form .= '<div class="input-group-addon">';
                             $form .= '<i class="fa fa-user-secret"></i>';
                         $form .= '</div>';
                         $form .= '<input class="form-control required" readonly type="text" value="'.$employee["last_name"].'" id="lname">';
                     $form .= '</div>';
                     $form .= '<label class="text-error" id="lname-text-error"></label>';
                     $form .= 'ตำแหน่ง';
                    $form .= '<div class="input-group position_employee">';
                        $form .= '<div class="input-group-addon">';
                             $form .= '<i class="fa fa-briefcase"></i>';
                         $form .= '</div>';
                         $form .= '<input class="form-control required select2" readonly style="width: 100%;" id="position" value="'.$emp_position['name'].'">';
                 $form .= '</div>';
                 $form .= '<label class="text-error" id="position-text-error"></label>';
                 $form .= 'แผนก';
                $form .= '<div class="input-group department_employee">';
                    $form .= '<div class="input-group-addon">';
                         $form .= '<i class="fa fa-sitemap"></i>';
                     $form .= '</div>';
                     $form .= '<input class="form-control required select2" readonly style="width: 100%;" id="department" value="'.$emp_department['name'].'">';
             $form .= '</div>';
             $form .= '<label class="text-error" id="department-text-error"></label>';
             $form .= 'การศึกษา';
            $form .= '<div class="input-group education_employee">';
                $form .= '<div class="input-group-addon">';
                     $form .= '<i class="fa fa-graduation-cap"></i>';
                 $form .= '</div>';
                 $form .= '<input class="form-control required select2" readonly style="width: 100%;" id="education" value="'.$emp_education['name'].'">';
             $form .= '</div>';
             $form .= '<label class="text-error" id="education-text-error"></label>';
             $form .= 'เพศ';
            $form .= '<div class="input-group gender_employee">';
                $form .= '<div class="input-group-addon">';
                     $form .= '<i class="fa fa-venus-mars"></i>';
                 $form .= '</div>';
                 $form .= '<input class="form-control required select2" readonly style="width: 100%;" id="education" value="'.$employee['gender'].'">';
             $form .= '</div>';
             $form .= '<label class="text-error" id="gender-text-error"></label>';
             $form .= 'อายุ';
            $form .= '<div class="input-group old_employee">';
                $form .= '<div class="input-group-addon">';
                     $form .= '<i class="fa  fa-circle-o"></i>';
                 $form .= '</div>';
                 $form .= '<input class="form-control required" readonly type="number" value="'.$employee["age"].'" id="age">';
             $form .= '</div>';
             $form .= 'ที่อยู่';
            $form .= '<div class="input-group address_employee">';
                $form .= '<div class="input-group-addon">';
                     $form .= '<i class="fa fa-map-marker"></i>';
                 $form .= '</div>';
                 $form .= '<input class="form-control required" readonly type="text" value="'.$employee["address"].'" id="address">';
             $form .= '</div>';
             $form .= '<label class="text-error" id="address-text-error"></label>';
             $form .= 'อีเมล์';
            $form .= '<div class="input-group email_employee">';
                $form .= '<div class="input-group-addon">';
                     $form .= '<i class="fa fa-envelope"></i>';
                 $form .= '</div>';
                 $form .= '<input class="form-control required" readonly type="email" value="'.$employee["email"].'"  id="email">';
             $form .= '</div>';
             $form .= '<label class="text-error" id="email-text-error"></label>';
            $form .= 'เบอร์โทรศัพท์';
            $form .= '<div class="input-group tel_employee">';
                $form .= '<div class="input-group-addon">';
                     $form .= '<i class="fa  fa-phone"></i>';
                 $form .= '</div>';
                 $form .= '<input class="form-control required" readonly type="number" value="'.$employee["tel"].'"  id="tel">';
             $form .= '</div>';
             $form .= '<label class="text-error" id="tel-text-error"></label>';
               $form .= 'เหตุผลที่แก้ไข';
            $form .= '<div class="input-group reason">';
                $form .= '<div class="input-group-addon">';
                     $form .= '<i class="fa fa-commenting"></i>';
                 $form .= '</div>';
                 $form .= '<input class="form-control required" readonly type="text" value="'.$employee['reason'].'" placeholder="เหตุผล..." id="reason">';
             $form .= '</div>';
             $form .= '<label class="text-error" id="reason-text-error"></label>';
            $form .= 'เหตุผลที่อนุมัติ/ไม่อนุมัติ';
            $form .= '<div class="input-group reason">';
                $form .= '<div class="input-group-addon">';
                     $form .= '<i class="fa fa-commenting"></i>';
                 $form .= '</div>';
                 $form .= '<input class="form-control" readonly type="text" value="'.$employee['reason_approvers'].'" placeholder="...." id="reason">';
             $form .= '</div>';
             $form .= '<label class="text-error" id="reason_approvers-text-error"></label>';
             $form .= '<br>';
         $form .= '</div>';
         $form .= '</div>';
         $form .= '</div>';
        return $form;
    }

    public static function getEditAgain($emp_department, $emp_position ,$employee, $position, $department, $emp_education, $education){
                $form = '<div class="row">';
            $form .= '<div class="col-md-8 col-md-offset-2" >';
                $form .= '<div class="box-body">';
                $form .= '<input type="hidden" value="'.$employee['id_employee'].'" id="id_employee">';
                $form .= '<input type="hidden" value="'.$employee['id'].'" id="id">'; // id ของ table request_change_data
                     $form .= 'ชื่อ';
                    $form .= '<div class="input-group fname_employee">';
                        $form .= '<div class="input-group-addon">';
                             $form .= '<i class="fa fa-user-secret"></i>';
                         $form .= '</div>';
                         $form .= '<input class="form-control required "  type="text" value="'.$employee["first_name"].'" id="fname">';
                     $form .= '</div>';
                     $form .= '<label class="text-error" id="fname-text-error"></label>';
                     $form .= 'นามสกุล';
                    $form .= '<div class="input-group lname_employee">';
                        $form .= '<div class="input-group-addon">';
                             $form .= '<i class="fa fa-user-secret"></i>';
                         $form .= '</div>';
                         $form .= '<input class="form-control required"  type="text" value="'.$employee["last_name"].'" id="lname">';
                     $form .= '</div>';
                     $form .= '<label class="text-error" id="lname-text-error"></label>';
                     $form .= 'ตำแหน่ง';
                    $form .= '<div class="input-group position_employee">';
                        $form .= '<div class="input-group-addon">';
                             $form .= '<i class="fa fa-briefcase"></i>';
                         $form .= '</div>';
                         $form .= '<select class="form-control required select2"  style="width: 100%;" id="position">';
                            foreach ($position as $value) {
                            $form .= '<option value="'.$value["id_position"].'" '.(($value["id_position"] == $emp_position['id_position']) ? 'selected' : '').'>'.$value["name"].'</option>';
                     }
                     $form .= '</select>';
                 $form .= '</div>';
                 $form .= '<label class="text-error" id="position-text-error"></label>';
                 $form .= 'แผนก';
                $form .= '<div class="input-group department_employee">';
                    $form .= '<div class="input-group-addon">';
                         $form .= '<i class="fa fa-sitemap"></i>';
                     $form .= '</div>';
                     $form .= '<select class="form-control required select2"  style="width: 100%;" id="department">';
                         foreach ($department as $value) {
                            $form .= '<option value="'.$value["id_department"].'" '.(($value["id_department"] == $emp_department['id_department']) ? 'selected' : '').'>'.$value["name"].'</option>';
                     }
                    $form .='</select>';
             $form .= '</div>';
             $form .= '<label class="text-error" id="department-text-error"></label>';
             $form .= 'การศึกษา';
            $form .= '<div class="input-group education_employee">';
                $form .= '<div class="input-group-addon">';
                     $form .= '<i class="fa fa-graduation-cap"></i>';
                 $form .= '</div>';
                 $form .= '<select class="form-control required select2"  style="width: 100%;" id="education">';
                     foreach ($education as $value) {
                            $form .= '<option value="'.$value["id_education"].'" '.(($value["id_education"] == $emp_education['id_education']) ? 'selected' : '').'>'.$value["name"].'</option>';
                     }
                 $form .= '</select>';
             $form .= '</div>';
             $form .= '<label class="text-error" id="education-text-error"></label>';
             $form .= 'เพศ';
            $form .= '<div class="input-group gender_employee">';
                $form .= '<div class="input-group-addon">';
                     $form .= '<i class="fa fa-venus-mars"></i>';
                 $form .= '</div>';
                  $form .= '<select class="form-control required select2" style="width: 100%;" id="gender">';
                     $form .= '<option value="หญิง" '.(($employee['gender'] == "หญิง") ? 'selected' : '').'>หญิง</option>';
                     $form .= '<option value="ชาย"'.(($employee['gender'] == "ชาย") ? 'selected' : '').'>ชาย</option>';
                 $form .= '</select>';
             $form .= '</div>';
             $form .= '<label class="text-error" id="gender-text-error"></label>';
             $form .= 'อายุ';
            $form .= '<div class="input-group old_employee">';
                $form .= '<div class="input-group-addon">';
                     $form .= '<i class="fa  fa-circle-o"></i>';
                 $form .= '</div>';
                 $form .= '<input class="form-control required"  type="number" value="'.$employee["age"].'" id="age">';
             $form .= '</div>';
             $form .= 'ที่อยู่';
            $form .= '<div class="input-group address_employee">';
                $form .= '<div class="input-group-addon">';
                     $form .= '<i class="fa fa-map-marker"></i>';
                 $form .= '</div>';
                 $form .= '<input class="form-control required"  type="text" value="'.$employee["address"].'" id="address">';
             $form .= '</div>';
             $form .= '<label class="text-error" id="address-text-error"></label>';
             $form .= 'อีเมล์';
            $form .= '<div class="input-group email_employee">';
                $form .= '<div class="input-group-addon">';
                     $form .= '<i class="fa fa-envelope"></i>';
                 $form .= '</div>';
                 $form .= '<input class="form-control required"  type="email" value="'.$employee["email"].'"  id="email">';
             $form .= '</div>';
             $form .= '<label class="text-error" id="email-text-error"></label>';
            $form .= 'เบอร์โทรศัพท์';
            $form .= '<div class="input-group tel_employee">';
                $form .= '<div class="input-group-addon">';
                     $form .= '<i class="fa  fa-phone"></i>';
                 $form .= '</div>';
                 $form .= '<input class="form-control required"  type="number" value="'.$employee["tel"].'"  id="tel">';
             $form .= '</div>';
             $form .= '<label class="text-error" id="tel-text-error"></label>';
               $form .= 'เหตุผลที่แก้ไข';
            $form .= '<div class="input-group reason">';
                $form .= '<div class="input-group-addon">';
                     $form .= '<i class="fa fa-commenting"></i>';
                 $form .= '</div>';
                 $form .= '<input class="form-control required"  type="text" value="'.$employee['reason'].'" placeholder="เหตุผล..." id="reason">';
             $form .= '</div>';
             $form .= '<label class="text-error" id="reason-text-error"></label>';
             $form .= '<br>';
         $form .= '</div>';
         $form .= '</div>';
         $form .= '</div>';
        return $form;
    }

    public static function getViewDataRequest($employee, $emp_department, $emp_position, $emp_education){
                $form = '<div class="row">';
            $form .= '<div class="col-md-8 col-md-offset-2" >';
                $form .= '<div class="box-body">';
                $form .= '<input type="hidden" value="'.$employee['id_employee'].'" id="id_employee">';
                     $form .= 'ชื่อ';
                    $form .= '<div class="input-group fname_employee">';
                        $form .= '<div class="input-group-addon">';
                             $form .= '<i class="fa fa-user-secret"></i>';
                         $form .= '</div>';
                         $form .= '<input class="form-control required " readonly type="text" value="'.$employee["first_name"].'" id="fname">';
                     $form .= '</div>';
                     $form .= '<label class="text-error" id="fname-text-error"></label>';
                     $form .= 'นามสกุล';
                    $form .= '<div class="input-group lname_employee">';
                        $form .= '<div class="input-group-addon">';
                             $form .= '<i class="fa fa-user-secret"></i>';
                         $form .= '</div>';
                         $form .= '<input class="form-control required" readonly type="text" value="'.$employee["last_name"].'" id="lname">';
                     $form .= '</div>';
                     $form .= '<label class="text-error" id="lname-text-error"></label>';
                     $form .= 'ตำแหน่ง';
                    $form .= '<div class="input-group position_employee">';
                        $form .= '<div class="input-group-addon">';
                             $form .= '<i class="fa fa-briefcase"></i>';
                         $form .= '</div>';
                         $form .= '<input class="form-control required select2" readonly style="width: 100%;" id="position" value="'.$emp_position['name'].'">';
                 $form .= '</div>';
                 $form .= '<label class="text-error" id="position-text-error"></label>';
                 $form .= 'แผนก';
                $form .= '<div class="input-group department_employee">';
                    $form .= '<div class="input-group-addon">';
                         $form .= '<i class="fa fa-sitemap"></i>';
                     $form .= '</div>';
                     $form .= '<input class="form-control required select2" readonly style="width: 100%;" id="department" value="'.$emp_department['name'].'">';
             $form .= '</div>';
             $form .= '<label class="text-error" id="department-text-error"></label>';
             $form .= 'การศึกษา';
            $form .= '<div class="input-group education_employee">';
                $form .= '<div class="input-group-addon">';
                     $form .= '<i class="fa fa-graduation-cap"></i>';
                 $form .= '</div>';
                 $form .= '<input class="form-control required select2" readonly style="width: 100%;" id="education" value="'.$emp_education['name'].'">';
             $form .= '</div>';
             $form .= '<label class="text-error" id="education-text-error"></label>';
             $form .= 'เพศ';
            $form .= '<div class="input-group gender_employee">';
                $form .= '<div class="input-group-addon">';
                     $form .= '<i class="fa fa-venus-mars"></i>';
                 $form .= '</div>';
                 $form .= '<input class="form-control required select2" readonly style="width: 100%;" id="education" value="'.$employee['gender'].'">';
             $form .= '</div>';
             $form .= '<label class="text-error" id="gender-text-error"></label>';
             $form .= 'อายุ';
            $form .= '<div class="input-group old_employee">';
                $form .= '<div class="input-group-addon">';
                     $form .= '<i class="fa  fa-circle-o"></i>';
                 $form .= '</div>';
                 $form .= '<input class="form-control required" readonly type="number" value="'.$employee["age"].'" id="age">';
             $form .= '</div>';
             $form .= 'ที่อยู่';
            $form .= '<div class="input-group address_employee">';
                $form .= '<div class="input-group-addon">';
                     $form .= '<i class="fa fa-map-marker"></i>';
                 $form .= '</div>';
                 $form .= '<input class="form-control required" readonly type="text" value="'.$employee["address"].'" id="address">';
             $form .= '</div>';
             $form .= '<label class="text-error" id="address-text-error"></label>';
             $form .= 'อีเมล์';
            $form .= '<div class="input-group email_employee">';
                $form .= '<div class="input-group-addon">';
                     $form .= '<i class="fa fa-envelope"></i>';
                 $form .= '</div>';
                 $form .= '<input class="form-control required" readonly type="email" value="'.$employee["email"].'"  id="email">';
             $form .= '</div>';
             $form .= '<label class="text-error" id="email-text-error"></label>';
            $form .= 'เบอร์โทรศัพท์';
            $form .= '<div class="input-group tel_employee">';
                $form .= '<div class="input-group-addon">';
                     $form .= '<i class="fa  fa-phone"></i>';
                 $form .= '</div>';
                 $form .= '<input class="form-control required" readonly type="number" value="'.$employee["tel"].'"  id="tel">';
             $form .= '</div>';
             $form .= '<label class="text-error" id="tel-text-error"></label>';
               $form .= 'เหตุผลที่แก้ไข';
            $form .= '<div class="input-group reason">';
                $form .= '<div class="input-group-addon">';
                     $form .= '<i class="fa fa-commenting"></i>';
                 $form .= '</div>';
                 $form .= '<input class="form-control required" readonly type="text" value="'.$employee['reason'].'" placeholder="เหตุผล..." id="reason">';
             $form .= '</div>';
             $form .= '<label class="text-error" id="reason-text-error"></label>';
             $form .= '<br>';
         $form .= '</div>';
         $form .= '</div>';
         $form .= '</div>';
        return $form;
    }

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

        $form .='</div>';
        return $form;
    }

    public static function getViewRequestTimeStamp($data){ // request_history.php //ดูข้อมูลตัวเอง
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

            $form .='เหตุผลที่ขอลงเวลาย้อนหลัง';
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

        $form .='</div>';
        return $form;
    }

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

               /* $form_new_time_clock .= '<div class="col-md-12">';
                    $form_new_time_clock .= '<div class="col-md-6">';*/

                        /*$form_new_time_clock .= '<label class="group-display">';
                            $form_new_time_clock .= '<input type="checkbox" name="time_set[]" value="stamp_in_out" class="flat-red"'. ($data['request_type'] == "time_in" or $data['request_type'] == "time_out" ? 'checked' : '').' id="edit-t_in_out">';
                            $form_new_time_clock .= 'ลงเวลาเข้า-ออก งาน';
                        $form_new_time_clock .= '</label>';*/

                        // $form_new_time_clock .= '<div class="col-md-12">';

                        if($data['request_type'] == "time_in"){
                        $form_new_time_clock .= '<label class="group-display">';
                            $form_new_time_clock .= '<input type="checkbox" name="time_set[]" value="stamp_in" class="flat-red hide" id="edit-t_in"  '.($data['request_type'] == "time_in" ? 'checked' : '').'>';
                            $form_new_time_clock .= ' ลงเวลาเข้างาน';
                        $form_new_time_clock .= '</label>';
                        $form_new_time_clock .= '<br>';
                        $form_new_time_clock .= '<label class="text-error" id="edit-t_in-text-error">';
                        $form_new_time_clock .= '</label>';
                        }else if($data['request_type'] == "time_out"){
                        $form_new_time_clock .= '<label class="group-display">';
                            $form_new_time_clock .= '<input type="checkbox" name="time_set[]" value="stamp_out" class="flat-red hide" id="edit-t_out"  '.($data['request_type'] == "time_out" ? 'checked' : '').'>';
                            $form_new_time_clock .= ' ลงเวลาออกงาน';
                        $form_new_time_clock .= '</label>';
                        $form_new_time_clock .= '<br>';
                          $form_new_time_clock .= '<label class="text-error" id="edit-t_out-text-error">';
                        $form_new_time_clock .= '</label>';
                        }
                        /*$form_new_time_clock .= '</div>';*/

                        /*$form_new_time_clock .= '<br>';
                    $form_new_time_clock .= '</div>';*/


                    /*$form_new_time_clock .= '<div class="col-md-6">';
*/
                        /*$form_new_time_clock .= '<label class="group-display">';
                            $form_new_time_clock .= '<input type="checkbox" name="time_set[]" value="stamp_break_in_out" class="flat-red" id="edit-br_in_out" '.($data['request_type'] == "break_out" or $data['request_type'] == "break_in" ? 'checked' : '').'> ';
                            $form_new_time_clock .= 'ลงเวลาพัก';
                        $form_new_time_clock .= '</label>';*/

                        $form_new_time_clock .= '<div class="col-md-12">';
                        else if($data['request_type'] == "break_out"){
                         $form_new_time_clock .= '<label class="group-display">';
                            $form_new_time_clock .= '<input type="checkbox" name="time_set[]" value="stamp_break_in" class="flat-red"  id="edit-br_in"  '.($data['request_type'] == "break_out" ? 'checked' : '').'> ';
                            $form_new_time_clock .= ' พักกลางวัน';
                        $form_new_time_clock .= '</label>';
                        $form_new_time_clock .= '<br>';
                        }else if($data['request_type'] == "break_in"){
                        $form_new_time_clock .= '<label class="group-display">';
                            $form_new_time_clock .= '<input type="checkbox" name="time_set[]" value="stamp_break_out" class="flat-red" id="edit-br_out"  '.($data['request_type'] == "break_in" ? 'checked' : '').'> ';
                            $form_new_time_clock .= ' เข้าทำงานช่วงบ่าย';
                        $form_new_time_clock .= '</label>';
                        $form_new_time_clock .= '<br>';
                        }
                        /*$form_new_time_clock .= '</div>';*/

                        /*$form_new_time_clock .= '<br>';
                    $form_new_time_clock .= '</div>';

                $form_new_time_clock .= '</div>';

            $form_new_time_clock .= '</div>';*/


            $form_new_time_clock .= '<div class="form-group input-t_in '.($data['request_type'] == "time_in" ? '' : 'hide' ).'">';
                $form_new_time_clock .= 'เวลาเข้างาน';
                $form_new_time_clock .= '<div class="input-group">';
                    $form_new_time_clock .= '<div class="input-group-addon">';
                        $form_new_time_clock .= '<i class="fa fa-clock-o"></i>';
                    $form_new_time_clock .= '</div>';
                    $form_new_time_clock .= '<input type="text" name="time_in" id="edit-input-t_in" class="form-control" value="'.($data['request_type'] == "time_in" ? $data['request_time'] : '' ).'">';
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
                    $form_new_time_clock .= '<input type="text" name="t_out" id="edit-input-t_out" class="form-control" id="time_out" value="'.($data['request_type'] == "time_out" ? $data['request_time'] : '' ).'">';
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
                    $form_new_time_clock .= '<input type="text" name="break_in" id="edit-input-b_in" class="form-control" value="'.($data['request_type'] == "break_out" ? $data['request_time'] : '' ).'">';
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
                    $form_new_time_clock .= '<input type="text" name="break_out" id="edit-input-b_out" class="form-control" value="'.($data['request_type'] == "break_in" ? $data['request_time'] : '' ).'">';
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