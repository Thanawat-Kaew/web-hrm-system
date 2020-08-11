<?php

namespace App\Services\Request;

use Illuminate\Database\Eloquent\Model;

class RequestLeaves extends Model
{
    protected $table = 'leaves';

    public function employee()
    {
        return $this->belongsTo("App\Services\Employee\Employee", 'id_employee', 'id_employee');
    }

    public function status()
    {
        return $this->belongsTo("App\Services\Request\Status", 'status', 'status_leave');
    }

}