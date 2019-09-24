<?php

namespace App\Services\Auth;

use Illuminate\Database\Eloquent\Model;

class Position extends Model
{
    protected $table = 'position';

    public function employee()
    {
    	return $this->hasMany(Employee::class); // onetoMany ไปยังตาราง Employee
    }
}
