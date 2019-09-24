<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use Illuminate\Foundation\Auth\AuthenticatesUsers;
use Illuminate\Http\Request;
use DB;
use App\Services\Auth\Employee;
use Illuminate\Support\Facades\Session;




class LoginController extends Controller
{
    /*
    |--------------------------------------------------------------------------
    | Login Controller
    |--------------------------------------------------------------------------
    |
    | This controller handles authenticating users for the application and
    | redirecting them to your home screen. The controller uses a trait
    | to conveniently provide its functionality to your applications.
    |
    */

    use AuthenticatesUsers;

    /**
     * Where to redirect users after login.
     *
     * @var string
     */
    protected $redirectTo = '/home';

    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('guest')->except('logout');
    }

    public function login(Request $req)
    {
        $email    = $req->input('email');
        $password = $req->input('password');

        $checkLogin   = Employee::where('email',$email)->where('password',$password)->first(); // first() เป็นการ get ข้อมูลrecord เดียว
        $id = $checkLogin['id_employee'];
        if($checkLogin['id_role'] == 1){
            \Session::put('employee_general', $id);  

            \Session::forget('header_general');   
            \Session::forget('employee_hr');   
            \Session::forget('header_hr');   
            return redirect()->route('main');
        }else if($checkLogin['id_role'] == 2){
            \Session::put('header_general', $id);

            \Session::forget('employee_general');
            \Session::forget('employee_hr');
            \Session::forget('header_hr');
            return redirect()->route('main');          
        }else if($checkLogin['id_role'] == 3){
            \Session::put('employee_hr', $id);

            \Session::forget('employee_general');
            \Session::forget('header_general');
            \Session::forget('header_hr');
            return redirect()->route('main');
        }else if($checkLogin['id_role'] == 4){
            \Session::put('header_hr', $id);

            \Session::forget('employee_general');
            \Session::forget('header_general');
            \Session::forget('employee_hr');
            return redirect()->route('main');
        }
        
    }
}