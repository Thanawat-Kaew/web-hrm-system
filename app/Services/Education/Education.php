<?php

namespace App\Services\Education;

use Illuminate\Database\Eloquent\Model;

class Education extends Model
{
    protected $table = 'education';

    //protected $fillable = ['id_employee', 'first_name', 'last_name', 'id_position', 'id_department', 'id_education', 'gender', 'age', 'address', 'email', 'tel', 'reason', 'status', 'approvers', 'reason_approvers'];

    public function employee()
    {
    	return $this->hasOne("App\Services\Employee\Employee", 'id_education', 'id_education');  // onetoMany ไปยังตาราง Employee
    }
}
