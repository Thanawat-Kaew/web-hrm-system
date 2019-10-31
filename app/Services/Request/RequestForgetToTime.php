<?php

namespace App\Services\Request;

use Illuminate\Database\Eloquent\Model;

class RequestForgetToTime extends Model
{
    protected $table = 'request_forget_to_time';

    public function employee()
    {
    	return $this->belongsTo("App\Services\Employee\Employee", 'id_employee', 'id_employee');
    }

    public function status()
    {
    	return $this->belongsTo("App\Services\Request\Status", 'status', 'id');
    }

    public function timestamp()
    {
    	return $this->belongsTo("App\Services\TimeStamp\TimeStamp", 'id_employee', 'id_employee');
    }
}