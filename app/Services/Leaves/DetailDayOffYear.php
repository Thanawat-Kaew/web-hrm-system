<?php

namespace App\Services\Leaves;
use Illuminate\Database\Eloquent\Model;

class DetailDayOffYear extends Model
{
    protected $table = 'detail_day_off_year';
    protected $primaryKey = 'id';

    public function day_off_year()
    {
    	return $this->hasMany("App\Services\Leaves\DayOffYears",'id','id_day_off_year');
    }
}