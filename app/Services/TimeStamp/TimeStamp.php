<?php

namespace App\Services\TimeStamp;

use Illuminate\Database\Eloquent\Model;

class TimeStamp extends Model
{
    protected $table = 'time_stamp';

    public function employee()
    {
    	return $this->hasMany("App\Services\Employee\Employee", 'id_employee', 'id_employee'); // onetoMany ไปยังตาราง Employee
    }

    public function requestforgettotime()
    {
    	return $this->hasOne("App\Services\Request\RequestForgetToTime", 'id_employee', 'id_employee'); // onetoMany ไปยังตาราง request_forget_to_time
    }
}
