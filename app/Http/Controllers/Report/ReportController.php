<?php

namespace App\Http\Controllers\Report;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Services\Employee\Employee;
use App\Services\Position\Position;
use App\Services\Department\Department;

class ReportController extends Controller
{
	public function index()
    {
    	return $this->useTemplate('report.index');
    }

}