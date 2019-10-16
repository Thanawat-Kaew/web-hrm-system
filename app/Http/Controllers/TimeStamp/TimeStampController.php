<?php

namespace App\Http\Controllers\TimeStamp;

use Illuminate\Http\Request;
use App\Http\Requests;
use App\Http\Controllers\Controller;
use App\Services\Forms\FormRepository;
use App\Services\TimeStamp\TimeStamp;

class TimeStampController extends Controller
{
	public function index()
    {
        return $this->useTemplate('time_stamp.index');
    }

    public function time_stamp()
    {
        return $this->useTemplate('time_stamp.time_stamp');
    }

    public function time_stamp_request()
    {
        return $this->useTemplate('time_stamp.time_stamp_request');
    }


    public function ajaxCenter(Request $request)
    {
    	$method = $request->get('method');
        switch ($method) {
            case 'getFormNewTimeClock':
               	$form_repo = new FormRepository;
				$form_new_time_clock = $form_repo->getFormNewTimeClock();
                return response()->json(['status'=> 'success','data'=> $form_new_time_clock]);
                break;
            
            default:
                # code...
                break;
        }
       
    }
    
    

}
