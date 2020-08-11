<?php

namespace App\Services\Evaluation;

use Illuminate\Database\Eloquent\Model;

class Part extends Model
{
    protected $table = 'part';
    protected $primaryKey = 'id_part';

    public function createevalucation()
    {
    	return $this->belongsTo("App\Services\Evaluation\CreateEvaluation", 'id_topic', 'id_topic');  // ManytoOne ไปยังตาราง CreateEvaluation
    }

    public function question()
    {
    	return $this->hasMany("App\Services\Evaluation\Question", 'id_part', 'id_part'); // ManytoOne ไปยังตาราง question
    }

    /*public function answerformat()
    {
        return $this->hasOne("App\Services\Evaluation\AnswerFormat", 'id_answer_format', 'id_answer_format'); // OnetoOne ไปยังตาราง answer_format
    }*/

}