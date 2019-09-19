<?php

namespace App\Http\Controllers\Main;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
//use Illuminate\Support\Facades\Session;

class MainController extends Controller
{
	public function main()
    {	
        return view('main');
    }
}

