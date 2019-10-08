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

    public function reportTimeStamp()
    {
    	return $this->useTemplate('report.report_time_stamp');
    }

    public function reportLeave()
    {
    	return $this->useTemplate('report.report_leave');
    }

    public function reportEvaluation()
    {
    	return $this->useTemplate('report.report_evaluations');
    }

    public function reportOverview()
    {
    	return $this->useTemplate('report.report_overview');
    }

}