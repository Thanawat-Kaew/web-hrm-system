<?php

namespace App\Services\Request;

use Illuminate\Database\Eloquent\Model;

class RequestChangeData extends Model
{
    protected $table = 'request_change_data';

    public function employee()
    {
    	return $this->belongsTo("App\Services\Employee\Employee", 'id_employee', 'id_employee');
    }
}
