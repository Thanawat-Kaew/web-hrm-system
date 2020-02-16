<?php

namespace App\Services\Leaves;
use Illuminate\Database\Eloquent\Model;

class Leaves extends Model
{
    protected $table = 'leaves';
    protected $primaryKey = 'id_leave';

    public function employee()
    {
    	return $this->belongsTo("App\Services\Employee\Employee", 'id_employee', 'id_employee');
    }

    public function leaves_type()
    {
    	return $this->belongsTo("App\Services\leaves\LeavesType", 'id_leaves_type', 'id_leaves_type');
    }

    public function leaves_format()
    {
    	return $this->belongsTo("App\Services\leaves\LeavesFormat", 'id_leaves_format', 'id_leaves_format');
    } 

    public function leaves_status()
    {
        return $this->belongsTo("App\Services\Request\Status", 'status_leave', 'id');
    } 
}