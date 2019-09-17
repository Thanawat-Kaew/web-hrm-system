<?php

namespace App\Http\Controllers\DataManagement;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

class DataManageController extends Controller
{
	public function index()
	{
		return $this->useTemplate('data_management.index');
	}
    //
}
