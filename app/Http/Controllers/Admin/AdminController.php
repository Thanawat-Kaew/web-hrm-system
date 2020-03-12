<?php

namespace App\Http\Controllers\Admin;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
//use Illuminate\Support\Facades\Session;

class AdminController extends Controller
{
    public function admin_add_header_emp()
    {
        return view('admin.add_header_emp');
    }

    public function admin_add_department()
    {
        return view('admin.add_department');
    }

    public function admin_log()
    {
        return view('admin.log');
    }
}

