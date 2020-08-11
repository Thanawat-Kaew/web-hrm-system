<?php

namespace App\Services\Position;

use Illuminate\Database\Eloquent\Model;

class Position extends Model
{
    protected $table = 'position';

    public function employee()
    {
    	return $this->hasMany("App\Services\Employee\Employee", 'id_position', 'id_position'); // onetoMany ไปยังตาราง Employee
    }
}
