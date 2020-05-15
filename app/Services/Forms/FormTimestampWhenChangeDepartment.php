<?php
namespace App\Services\Forms;

use App\Services\Employee\EmployeeObject;
class FormTimestampWhenChangeDepartment
{
	public static function getFormTimestampWhenChangeDepartment($emp_timestamp){
        //sd($emp_timestamp->toArray());
        $form  = '';
        $form .= '<table id="myTable" class="table table-hover">';
            $form .=  '<thead>';
                $form .=  '<tr>';
                    $form .=  '<th>Name</th>';
                        $form .=  '<th>Department</th>';
                        $form .=  '<th>Position</th>';
                        $form .=  '<th>Date</th>';
                        $form .=  '<th>Time-In</th>';
                        $form .=  '<th>Break-Out</th>';
                        $form .=  '<th>Break-In</th>';
                        $form .=  '<th>Time-Out</th>';
                        $form .=  '<th>Total(hr)</th>';
                    $form .=  '</tr>';
            $form .=  '</thead>';
        $count_emp = $emp_timestamp->count(); // พนักงานใน timestamp
        for($i=0; $i<$count_emp; $i++){
            if(!empty($emp_timestamp[$i]->employee->department)){
                $form .='<tr>';
                    $form .='<td style="color: blue; text-align: left; padding-left: 30px;">'.$emp_timestamp[$i]->employee->first_name." ".$emp_timestamp[$i]->employee->last_name.'</td>';
                    $form .='<td>'.$emp_timestamp[$i]->employee->department->name.'</td>';
                    $form .='<td>'.$emp_timestamp[$i]->employee->position->name.'</td>';
                    $form .='<td>'.$emp_timestamp[$i]->date.'</td>';
                    $form .='<td>'.(!empty($emp_timestamp[$i]->time_in) ? $emp_timestamp[$i]->time_in : '-').'</td>';
                    $form .='<td>'.(!empty($emp_timestamp[$i]->break_out) ? $emp_timestamp[$i]->break_out : '-').'</td>';
                    $form .='<td>'.(!empty($emp_timestamp[$i]->break_in) ? $emp_timestamp[$i]->break_in : '-').'</td>';
                    $form .='<td>'.(!empty($emp_timestamp[$i]->time_out) ? $emp_timestamp[$i]->time_out : '-').'</td>';
                    $start  = strtotime($emp_timestamp[$i]->time_in);
                    $end    = strtotime($emp_timestamp[$i]->time_out);
                    if(!empty($start) && !empty($end)){
                        $total_hour = intval(($end - $start)/3600);
                        $mins = (int)(($end - $start) / 60);
                        $form .='<td style="color: red">'.$total_hour.'</td>';
                    }else{
                        $form .='<td style="color: red">-</td>';
                    }
                $form .='</tr>';
            }
        }
        $form .='</table>';
        return ['form' => $form];
        //$count_t = $employees->timestamp->count();
        //sd($count_t);
        //sd($count);

        //sd($employee->toArray());
        /*$form ='';
        foreach ($employees as $value) {
            sd($value->toArray());
            //echo $value->timestamp;
            //echo "<br>";
            if(!empty($value->timestamp_hasone)){
                echo "55";
                echo "<br>";
            $form .='<tr>';
                $form .='<td style="color: blue">'.$value->first_name.'</td>';
                $form .='<td>'.$value->department->name.'</td>';
                $form .='<td></td>';
                $form .='<td>'.$value->date.'</td>';
                $form .='<td>'.(!empty($value->$value->time_in) ? $value->$value->time_in : '-').'</td>';
                $form .='<td>'.(!empty($value->break_out) ? $value->break_out : '-').'</td>';
                $form .='<td>'.(!empty($value->break_in) ? $value->break_in : '-').'</td>';
                $form .='<td>'.(!empty($value->time_out) ? $value->time_out : '-').'</td>';
                $start  = strtotime($value->time_in);
                $end    = strtotime($value->time_out);
                if(!empty($end)){
                    $total_hour = intval(($end - $start)/3600);
                    $mins = (int)(($end - $start) / 60);
                }
                $form .='<td style="color: red">'.(!empty($total_hour) ? $total_hour : '-').'</td>';
                $form .='</div>';
                $form .='<div class="box-footer no-padding">';
                $form .='<ul class="nav nav-stacked">';
                $form .='<li class="manage-employee" data-form_id="'.$value["id_employee"].'" data-form_position="'.$value["id_position"].'" data-form_department="'.$value["id_department"].'">';
            $form .='</tr>';
            }
        }
       return $form;*/
    }
}