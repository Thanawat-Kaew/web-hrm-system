<?php
namespace App\Services\Forms;

use App\Services\Employee\EmployeeObject;
class FormLeavesWhenChangeDepartment
{
	public static function getFormLeavesWhenChangeDepartment($emp_leaves){
       
        $form ='<table class="table table-hover">';
                        $form .='<thead>';
                            $form .='<tr>';
                                $form .='<th>Name</th>';
                                $form .='<th>Department</th>';
                                $form .='<th>Position</th>';
                                $form .='<th>ประเภทการลา</th>';
                                $form .='<th>เริ่มวันที่</th>';
                                $form .='<th>สิ้นสุดวันที่</th>';
                                $form .='<th>จำนวน</th>';
                            $form .='</tr>';
                        $form .='</thead>';
                        $count_emp = $emp_leaves->count();
                            for ($i=0; $i < $count_emp ; $i++) { 
                                if(!empty($emp_leaves[$i]->employee->department)){
                                    $d=1;
                                    $e=2;
                                    $u=3;
                                $form .='<tr>';
                                    $form .='<td style="color: blue; text-align: left; padding-left: 30px;">'.$emp_leaves[$i]->employee->first_name.''.$emp_leaves[$i]->employee->last_name.'</td>';
                                    $form .='<td>'.$emp_leaves[$i]->employee->department->name.'</td>';
                                    $form .='<td>'.$emp_leaves[$i]->employee->Position->name.'</td>';
                                    $form .='<td>'.$emp_leaves[$i]->leaves_type->leaves_name.'</td>';
                                    $form .='<td>'.$emp_leaves[$i]->start_leave.'</td>';
                                    $form .='<td>'.$emp_leaves[$i]->end_leave.'</td>';
                                    if($emp_leaves[$i]->leaves_format->id_leaves_format == $d) {
                                        $form .='<td style="color: red;">'.($emp_leaves[$i]->total_leave/8).' วัน</td>';
                                    }
                                    if($emp_leaves[$i]->leaves_format->id_leaves_format == $e) {
                                        $form .='<td style="color: orange;"> ครึ่งวัน</td>';
                                    }
                                    if($emp_leaves[$i]->leaves_format->id_leaves_format == $u) {
                                        $form .='<td style="color: green;">'.$emp_leaves[$i]->total_leave.' ชั่วโมง</td>';
                                    }
                                $form .='</tr>';
                            }
                            }
                    $form .='</table>';
        return $form;
    }
}