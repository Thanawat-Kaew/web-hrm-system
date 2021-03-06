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

    public function requesttimestamp()
    {
    	return $this->hasOne("App\Services\Request\RequestTimeStamp", 'id', 'status');
    }

    public function requestleaves()
    {
        return $this->hasOne("App\Services\Request\RequestLeaves", 'status_leave', 'status');
    }

    public function recoverystatusemployee()
    {
        return $this->hasOne("App\Services\Admin\RecoveryStatusEmployee", 'id', 'id_status');
    }

}
