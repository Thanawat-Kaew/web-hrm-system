<?php

namespace App\Services\Employee;

use Illuminate\Database\Eloquent\Model;

class Employee extends Model
{
    protected $table = 'employee';
    protected $primaryKey = 'id_employee';

    public function position()
    {
    	return $this->belongsTo("App\Services\Position\Position", 'id_position', 'id_position');
    }

    public function department()
    {
    	return $this->belongsTo("App\Services\Department\Department", 'id_department', 'id_department');
    }

    public function employeemenu()
    {
    	return $this->hasMany("App\Services\Employee\EmployeeMenu", 'id_employee', 'id_employee');
    }

    public function requestchangedata()
    {
        return $this->hasMany("App\Services\Request\RequestChangeData", 'id_employee', 'id_employee');
    }

    public function education()
    {
        return $this->belongsTo("App\Services\Education\Education", 'id_education', 'id_education');
    }
}
