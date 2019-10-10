<?php

namespace App\Services\Request;

use Illuminate\Database\Eloquent\Model;

class Status extends Model
{
    protected $table = 'status';

    public function requestchangedata()
    {
    	return $this->hasOne("App\Services\Request\RequestChangeData", 'id', 'status');
    }
}
