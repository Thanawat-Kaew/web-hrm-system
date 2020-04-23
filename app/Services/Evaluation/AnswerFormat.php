<?php

namespace App\Services\Evaluation;

use Illuminate\Database\Eloquent\Model;

class AnswerFormat extends Model
{
    protected $table        = 'answer_format';
    protected $primaryKey   = 'id_answer_format';


    /*public function parts()
    {
    	return $this->belongsTo("App\Services\Evaluation\Part", 'id_answer_format', 'id_answer_format');  // OnetoOne ไปยังตาราง Part
    }*/

    public function answerdetails()
    {
    	return $this->hasMany("App\Services\Evaluation\AnswerDetails", 'id_answer_format', 'id_answer_format');  // OnetoOne ไปยังตาราง answerdetails
    }

    public function createevaluation()
    {
        return $this->belongsTo("App\Services\Evaluation\Part", 'id_answer_format', 'id_answer_format');  // OnetoOne ไปยังตาราง Part
    }


}