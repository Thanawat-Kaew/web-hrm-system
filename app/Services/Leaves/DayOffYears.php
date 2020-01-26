<?php

namespace App\Services\Leaves;
use Illuminate\Database\Eloquent\Model;

class DayOffYears extends Model
{
    protected $table = 'day_off_year';
    // protected $primaryKey = 'id';

    public function detail_day_off_year()
    {
    	return $this->belongsTo("App\Services\Leaves\DetailDayOffYear",'id_day_off_year','id');
    }
}