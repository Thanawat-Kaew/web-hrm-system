<?php

namespace App\Http\Controllers\Leave;

use Illuminate\Http\Request;
use App\Http\Requests;
use App\Http\Controllers\Controller;
use App\Services\Forms\FormRepository;

class LeaveController extends Controller
{
	public function leave()
    {
        return $this->useTemplate('leave.leave');
    }

    public function leave_history()
    {
        return $this->useTemplate('leave.leave_history');
    }

     public function ajaxCenter(Request $request)
    {
    	$method = $request->get('method');
        switch ($method) {
            case 'getFormLeave':
               	$form_repo = new FormRepository;
				$form_leave = $form_repo->getFormLeave();
                return response()->json(['status'=> 'success','data'=> $form_leave]);
                break;
            
            default:
                # code...
                break;
        }
       
    }
    
}
