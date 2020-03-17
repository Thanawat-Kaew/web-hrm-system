<?php

namespace App\Services\Admin;

use Illuminate\Database\Eloquent\Model;

class Admin extends Model
{
    protected $table = 'admin';
    protected $primaryKey = 'id_admin';

    public function recoverystatusemployee()
    {
        return $this->hasOne("App\Services\Admin\RecoveryStatusEmployee", 'id_admin', 'id_admin');
    }

}
