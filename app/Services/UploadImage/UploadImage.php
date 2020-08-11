<?php

namespace App\Services\UploadImage;

use Illuminate\Database\Eloquent\Model;

class UploadImage extends Model
{
    protected $table = 'upload_image';

    public function employee()
    {
    	return $this->belongsTo("App\Services\Employee\Employee", 'id_employee', 'id_employee');
    }

}