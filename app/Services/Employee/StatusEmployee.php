<?php

namespace App\Services\Employee;

use Illuminate\Database\Eloquent\Model;

class StatusEmployee extends Model
{
    protected $table = 'status_employee';

    public function employee()
    {
        return $this->hasOne("App\Services\Employee\Employee", 'id_status', 'id_status');
    }


}
