<?php

namespace App\Services\Leaves;
use Illuminate\Database\Eloquent\Model;

class LeavesFormat extends Model
{
    protected $table = 'leaves_format';

    public function leaves()
    {
    	return $this->belongsTo("App\Services\Leaves\Leaves", 'id_leaves_format', 'id_leaves_format');
    }
}