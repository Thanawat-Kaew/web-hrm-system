<?php

namespace App\Services\Evaluation;

use Illuminate\Database\Eloquent\Model;

class AnswerDetails extends Model
{
    protected $table        = 'answer_details';
    protected $primaryKey   = 'id_answer_details';

     public function answerformat()
    {
        return $this->belongsTo("App\Services\Evaluation\AnswerFormat", 'id_answer_format', 'id_answer_format'); // OnetoOne ไปยังตาราง answer_format
    }


}