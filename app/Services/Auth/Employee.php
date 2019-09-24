<?php

namespace App\Services\Auth;

use Illuminate\Database\Eloquent\Model;

class Employee extends Model
{
    protected $table = 'employee';

    public function position()
    {
    	return $this->belongsTo(Position::class, 'id_position', 'id_position');
    }

    public function department()
    {
    	return $this->belongsTo(Department::class, 'id_department', 'id_department');
    }
}
