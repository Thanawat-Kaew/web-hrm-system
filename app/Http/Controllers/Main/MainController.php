<?php

namespace App\Http\Controllers\Main;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

class MainController extends Controller
{
	public function main()
    {
        return view('main');
    }

    public function main_head()
    {
        return view('main_head');
    }

    public function main_head_hr()
    {
        return view('main_head_hr');
    }

    public function main_worker()
    {
        return view('main_worker');
    }

    public function main_worker_hr()
    {
        return view('main_worker_hr');
    }
    
    
}

