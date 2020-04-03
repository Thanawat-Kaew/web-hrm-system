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

    public function timestamp()
    {
        return $this->hasMany("App\Services\TimeStamp\TimeStamp", 'id_employee', 'id_employee'); // many to many

    }

    public function timestamp_hasone()
    {
        return $this->hasOne("App\Services\TimeStamp\TimeStamp", 'id_employee', 'id_employee'); // one to many

    }

    public function requesttimestamp()
    {
        return $this->hasMany("App\Services\Request\RequestTimeStamp", 'id_employee', 'id_employee');
    }

    public function leaves()
    {
        return $this->hasMany("App\Services\leaves\leaves", 'id_employee', 'id_employee'); // one to many

    }

    public function company()
    {
        return $this->hasOne("App\Services\Company\Company", 'id_company', 'id_company'); // one to many

    }

    public function createevaluation()
    {
        return $this->hasOne("App\Services\Evaluation\CreateEvaluation", 'id_employee', 'id_employee'); // one to many

    }

    public function createevaluation_hasmany()
    {
        return $this->hasMany("App\Services\Evaluation\CreateEvaluation", 'id_employee', 'id_employee'); // one to many

    }

    public function evaluation()
    {
        //return $this->hasOne("App\Services\Evaluation\Evaluation", 'id_employee', 'id_assessor', 'id_employee', 'iid_assessment_person'); // one to many
        return $this->hasOne("App\Services\Evaluation\Evaluation", 'id_employee', 'id_assessor'); // one to many
        /*ถ้าตอน Query เอา table ไหนเป็นหลัก ตรง model ก็เอา pk ของ table นั้นขึ้นทีหลัง*/
        //return $this->hasMany("App\Services\Evaluation\Evaluation", 'id_assessor', 'id_employee'); // one to many
    }

    public function evaluation_hasmany()
    {
        return $this->hasMany("App\Services\Evaluation\Evaluation", 'id_assessor', 'id_employee');
    }

    public function statusemployee()
    {
        return $this->belongsTo("App\Services\Employee\StatusEmployee", 'id_status', 'id_status');
    }

    public function recoverystatusemployee()
    {
        return $this->hasMany("App\Services\Admin\RecoveryStatusEmployee", 'id_employee', 'id_employee');
    }
}
