<?php

namespace App\Http\Controllers\Leave;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

class LeaveController extends Controller
{
	public function leave()
    {
        return $this->useTemplate('leave.leave');
    }
    
}
