<?php

namespace App\Services\Company;

use Illuminate\Database\Eloquent\Model;

class Company extends Model
{
    protected $table = 'company';

    public function employee()
    {
    	return $this->hasMany("App\Services\Employee\Employee", 'id_company', 'id_company'); 
    }
}
