<?php
namespace App\Services\Forms;

use App\Services\Employee\EmployeeObject;
class FormTimestampWhenChangeDepartment
{
	public static function getFormTimestampWhenChangeDepartment($employees){
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
        $count_emp = $employees->count();
        for($i=0; $i<$count_emp; $i++){
            //echo "count_emp".$i."<br>";
            $count_ts = $employees[$i]->timestamp->count();
            for($j=0; $j<$count_ts; $j++){
                //echo "count_emp".$j."<br>";
                $form .='<tr>';
                    $form .='<td style="color: blue">'.$employees[$i]->first_name." ".$employees[$i]->last_name.'</td>';
                    $form .='<td>'.$employees[$i]->department->name.'</td>';
                    $form .='<td>'.$employees[$i]->position->name.'</td>';
                    $form .='<td>'.$employees[$i]->timestamp[$j]->date.'</td>';
                    $form .='<td>'.(!empty($employees[$i]->timestamp[$j]->time_in) ? $employees[$i]->timestamp[$j]->time_in : '-').'</td>';
                    $form .='<td>'.(!empty($employees[$i]->timestamp[$j]->break_out) ? $employees[$i]->timestamp[$j]->break_out : '-').'</td>';
                    $form .='<td>'.(!empty($employees[$i]->timestamp[$j]->break_in) ? $employees[$i]->timestamp[$j]->break_in : '-').'</td>';
                    $form .='<td>'.(!empty($employees[$i]->timestamp[$j]->time_out) ? $employees[$i]->timestamp[$j]->time_out : '-').'</td>';
                    $start  = strtotime($employees[$i]->timestamp[$j]->time_in);
                    $end    = strtotime($employees[$i]->timestamp[$j]->time_out);
                    if(!empty($end)){
                        $total_hour = intval(($end - $start)/3600);
                        $mins = (int)(($end - $start) / 60);
                    }
                    $form .='<td style="color: red">'.(!empty($total_hour) ? $total_hour : '-').'</td>';
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