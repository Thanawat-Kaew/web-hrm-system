<?php

namespace App\Services\TimeStamp;

use Illuminate\Database\Eloquent\Model;

class TimeStamp extends Model
{
    protected $table = 'time_stamp';

    public function employee()
    {
    	return $this->belongsTo("App\Services\Employee\Employee", 'id_employee', 'id_employee');
    }

    public function requesttimestamp()
    {
    	return $this->hasMany("App\Services\Request\RequestTimeStamp", 'request_date', 'date');
    }


}
