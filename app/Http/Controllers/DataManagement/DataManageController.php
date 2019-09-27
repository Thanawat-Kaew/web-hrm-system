<?php

namespace App\Http\Controllers\DataManagement;

use Illuminate\Http\Request;
use App\Http\Requests;
use App\Http\Controllers\Controller;
use App\Services\Forms\FormRepository;
use App\Services\Auth\Department;
use App\Services\Auth\Position;

class DataManageController extends Controller
{
	public function index()
	{
		
		return $this->useTemplate('data_management.index'/*,compact('form_add_emp')*/);
	}  

	 public function ajaxCenter(Request $request)
    {

    	$method = $request->get('method');
        switch ($method) {
            case 'getFormAddEmpolyee':
                $department = Department::all();
                $position = Position::all();
               	$form_repo = new FormRepository;
				$form_add_emp = $form_repo->getFormEmployee($department,$position);
                return response()->json(['status'=> 'success','data'=> $form_add_emp]);
                break;
            
            default:
                # code...
                break;
        }
       
    }
}
