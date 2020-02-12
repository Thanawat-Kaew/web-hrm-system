<?php

namespace App\Services\Leaves;
use Illuminate\Database\Eloquent\Model;

class LeavesRequirements extends Model
{
    protected $table = 'leave_requirements';

    public function leaves_type()
    {
    	return $this->belongsTo("App\Services\leaves\LeavesType", 'id_leaves_type', 'id_leaves_type');
    }
}