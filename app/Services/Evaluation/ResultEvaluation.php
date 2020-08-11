<?php

namespace App\Services\Evaluation;

use Illuminate\Database\Eloquent\Model;

class ResultEvaluation extends Model
{
    protected $table      = 'result_evaluation';
    protected $primaryKey = 'id_result_evaluation';


    public function evaluation()
    {
        return $this->belongsTo("App\Services\Evaluation\Evaluation", 'id_evaluation', 'id_evaluation');
    }
}