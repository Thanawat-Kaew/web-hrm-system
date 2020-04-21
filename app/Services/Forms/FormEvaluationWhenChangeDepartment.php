<?php
namespace App\Services\Forms;

use App\Services\Employee\EmployeeObject;
class FormEvaluationWhenChangeDepartment
{
	public static function getFormEvaluationWhenChangeDepartment($emp_evaluation, $count_first_name, $count_last_name, $count_name_evaluation){
        $form  = '';
        $form .= '<table class="table table-hover">';
            $form .= '<tr>';
                $form .= '<th>รหัสพนักงาน</th>';
                $form .= '<th>ชื่อ-นามสกุล</th>';
                $form .= '<th>แผนก</th>';
                $form .= '<th>ต่ำแหน่ง</th>';
                $form .= '<th>วันที่ประเมิน</th>';
                $form .= '<th>ผู้ประเมิน</th>';
                $form .= '<th>หัวข้อการประเมิน</th>';
                $form .= '<th>id_topic</th>';
                $form .= '<th>คะแนนการประเมิน</th>';
                $form .= '<th>จากคะแนนเต็ม</th>';
                $form .= '<th>คิดเป็นร้อยละ (%)</th>';
            $form .= '</tr>';
                $no = 0;
                $count_assessor = $emp_evaluation->count();
                //sd($count_assessor);
            for ($i=0; $i < $count_assessor; $i++) {
                if(!empty($emp_evaluation[$i]->employee->department)){
            $form .= '<tr>';
                $form .= '<td style="color: blue">'.$emp_evaluation[$i]->employee->id_employee.'</td>';
                $form .= '<td style="color: blue">'.$emp_evaluation[$i]->employee->first_name.' '.$emp_evaluation[$i]->employee->last_name.'</td>';
                $form .= '<td>'.$emp_evaluation[$i]->employee->department->name.'</td>';
                $form .= '<td>'.$emp_evaluation[$i]->employee->position->name.'</td>';
                $form .= '<td>'.$emp_evaluation[$i]->date.'</td>';
                $form .= '<td>'.$count_first_name[$no].' '.$count_last_name[$no].'</td>';
                $form .= '<td>'.$count_name_evaluation[$no].'</td>';
                $form .= '<td>'.$emp_evaluation[$i]->id_topic.'</td>';
                $form .= '<td>'.$emp_evaluation[$i]->result_evaluation.'</td>';
                $form .= '<td>'.$emp_evaluation[$i]->from_the_full_score.'</td>';
                $form .= '<td>'.$emp_evaluation[$i]->percent.'%</td>';
            $form .= '</tr>';
                $no++;
                }
            }
        $form .= '</table>';
        return ['form' => $form];
    }
}