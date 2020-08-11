<?php

namespace App\Services\Department;

use Illuminate\Database\Eloquent\Model;

class Department extends Model
{
    protected $table = 'department';
    // protected $primaryKey   = 'id_department';

    public function employee()
    {
    	return $this->hasOne("App\Services\Employee\Employee", 'id_department', 'id_department');  // onetoMany ไปยังตาราง Employee
    }
}
