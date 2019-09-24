<?php

namespace App\Services\Auth;

use Illuminate\Database\Eloquent\Model;

class Department extends Model
{
    protected $table = 'department';

    public function employee()
    {
    	return $this->hasMany(Employee::class);  // onetoMany ไปยังตาราง Employee
    }
}
