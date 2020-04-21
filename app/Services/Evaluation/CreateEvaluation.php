<?php

namespace App\Services\Evaluation;

use Illuminate\Database\Eloquent\Model;

class CreateEvaluation extends Model
{
    protected $table = 'create_evaluation';
    protected $primaryKey = 'id_topic';

    //protected $fillable = ['id_employee', 'first_name', 'last_name', 'id_position', 'id_department', 'id_Evaluation', 'gender', 'age', 'address', 'email', 'tel', 'reason', 'status', 'approvers', 'reason_approvers'];

    public function parts()
    {
        return $this->hasMany("App\Services\Evaluation\Part", 'id_topic', 'id_topic');
    }

    public function employee()
    {
        return $this->belongsTo("App\Services\Employee\Employee", 'id_employee', 'id_employee');
    }

    public function evaluation()
    {
        return $this->hasMany("App\Services\Evaluation\Evaluation", 'id_topic', 'id_topic');
        // OnetoMany ไปยังตาราง evaluation
    }

    public function answerformat()
    {
        return $this->hasOne("App\Services\Evaluation\AnswerFormat", 'id_answer_format', 'id_answer_format');
    }
}
