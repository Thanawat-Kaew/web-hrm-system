<?php

namespace App\Services\Admin;

use Illuminate\Database\Eloquent\Model;

class RecoveryStatusEmployee extends Model
{
    protected $table = 'recovery_status_employee';

    public function employee()
    {
        return $this->belongsTo("App\Services\Employee\Employee", 'id_employee', 'id_employee');
    }

    public function status()
    {
        return $this->belongsTo("App\Services\Request\Status", 'id_status', 'id');
    }

    public function admin()
    {
        return $this->belongsTo("App\Services\Admin\Admin", 'id_admin', 'id_admin');
    }

}
