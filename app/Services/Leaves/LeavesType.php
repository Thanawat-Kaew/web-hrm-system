<?php

namespace App\Services\Leaves;
use Illuminate\Database\Eloquent\Model;

class LeavesType extends Model
{
    protected $table = 'leaves_type';

    public function leaves()
    {
    	return $this->belongsTo("App\Services\Leaves\Leaves", 'id_leaves_type', 'id_leaves_type');
    }
}