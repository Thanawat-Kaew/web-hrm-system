<?php
namespace App\Services\Forms;

use App\Services\Employee\EmployeeObject;
class FormDataPersonal
{
	 public static function getDataPersonal($employee, $age){
                 $form = '<div class="box-body">';
                 $form .= '<div class="text-center">';
                     $form .= '<img src="/resources/assets/theme/adminlte/dist/img/user2-160x160.jpg" class="user-image img-circle" alt="User Image" style="width : 80px; height : 80px;">';
                 $form .= '</div>';
                 $form .= '<div class="box-body">';
                     $form .= '<table class="table table-bordered">';
                         $form .= '<tbody>';
                             $form .= '<tr>';
                                 $form .= '<td>รหัสพนักงาน</td>';
                                 $form .= '<td>'.$employee['id_employee'].'</td>';
                             $form .= '</tr>';
                             $form .= '<tr>';
                                 $form .= '<td>ชื่อ - สกุล</td>';
                                 $form .= '<td>'.$employee['first_name'].' '. $employee['last_name'].'</td>';
                             $form .= '</tr>';
                             $form .= '<tr>';
                                 $form .= '<td>ตำแหน่ง</td>';
                                 $form .= '<td>'.  $employee->position["name"].'</td>';
                             $form .= '</tr>';
                             $form .= '<tr>';
                                 $form .= '<td>แผนก</td>';
                                 $form .= '<td>'.  $employee->department['name'].'</td>';
                             $form .= '</tr>';
                                    if($employee['$id_position'] == 2 ){
                             $form .= '<tr>';
                                 $form .= '<td>อัตราเงินเดือน</td>';
                                         $form .= '<td>'. $employee['salary'].'</td>';
                             $form .= '</tr>';
                                    }
                             $form .= '<tr>';
                                 $form .= '<td>การศึกษา</td>';
                                 $form .= '<td>'. $employee->education['name'].'</td>';
                             $form .= '</tr>';
                             $form .= '<tr>';
                                 $form .= '<td>เพศ</td>';
                                 $form .= '<td>'. $employee['gender'].'</td>';
                             $form .= '</tr>';
                             $form .= '<tr>';
                                 $form .= '<td>อายุ</td>';
                                 $form .= '<td>'.$age.' ปี</td>';
                             $form .= '</tr>';
                             $form .= '<tr>';
                                 $form .= '<td>ที่อยู่</td>';
                                 $form .= '<td>'. $employee['address'].'</td>';
                             $form .= '</tr>';
                             $form .= '<tr>';
                                 $form .= '<td>อีเมล์</td>';
                                 $form .= '<td>'. $employee['email'].'</td>';
                             $form .= '</tr>';
                             $form .= '<tr>';
                                 $form .= '<td>เบอร์โทรศัพท์</td>';
                                 $form .= '<td>'. $employee['tel'].'</td>';
                             $form .= '</tr>';
                         $form .= '</tbody></table>';
                     $form .= '</div>';
             $form .= '</div>';

    return $form;
    }
}