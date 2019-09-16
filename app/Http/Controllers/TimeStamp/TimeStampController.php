<?php

namespace App\Http\Controllers\TimeStamp;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

class TimeStampController extends Controller
{
	public function index()
    {
        return $this->useTemplate('time_stamp.index');
    }

    public function time_stamp()
    {
        return view('time_stamp.time_stamp');
    }

}
