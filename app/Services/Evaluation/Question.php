<?php

namespace App\Services\Evaluation;

use Illuminate\Database\Eloquent\Model;

class Question extends Model
{
    protected $table      = 'question';
    protected $primaryKey = 'id_question';

    public function parts()
    {
    	return $this->belongsTo("App\Services\Evaluation\Part", 'id_part', 'id_part');
    }
}