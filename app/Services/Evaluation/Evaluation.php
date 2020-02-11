<?php

namespace App\Services\Evaluation;

use Illuminate\Database\Eloquent\Model;

class Evaluation extends Model
{
    protected $table      = 'evaluation';
    protected $primaryKey = 'id_evaluation';


    public function employee()
    {
        //return $this->belongsTo("App\Services\Employee\Employee", 'id_assessor', 'id_employee', 'id_assessment_person', 'id_employee');
        //return $this->belongsTo("App\Services\Employee\Employee", 'id_assessor', 'id_employee');
        return $this->belongsTo("App\Services\Employee\Employee", 'id_employee', 'id_assessor');
    }

    public function resultevaluation()
    {
        return $this->hasOne("App\Services\Evaluation\Evaluation", 'id_evaluation', 'id_evaluation');
    }
}