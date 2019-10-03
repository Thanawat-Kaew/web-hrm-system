<?php

namespace App\Http\Controllers\Evaluation;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Services\Forms\FormRepository;

class EvaluationController extends Controller
{
	public function evaluation()
    {
        return $this->useTemplate('evaluation.index');
    }

    public function create_evaluations()
    {
        return $this->useTemplate('evaluation.create_evaluations');
    }

     public function ajaxCenter(Request $request)
    {
    	$method = $request->get('method');
        switch ($method) {
            case 'getFormEvaluation':
               	$form_repo = new FormRepository;
				$form_evaluation = $form_repo->getFormEvaluation();
                return response()->json(['status'=> 'success','data'=> $form_evaluation]);
                break;
            
            default:
                # code...
                break;
        }
       
    }
}
