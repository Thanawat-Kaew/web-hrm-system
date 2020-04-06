<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use Illuminate\Foundation\Auth\AuthenticatesUsers;
use Illuminate\Http\Request;
use DB;
use App\Services\Employee\Employee;
use App\Services\Employee\EmployeeObject;
use Illuminate\Support\Facades\Session;
use App\Services\Admin\Admin;
use App\Services\Admin\AdminObject;




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
        //sd($email);

        $checkLogin   = Employee::where('email',$email)->where('password',$password)->where('id_status', 1)->first(); // first() เป็นการ get ข้อมูลrecord เดียว

        if(!empty($checkLogin)){
            $employee_object = new EmployeeObject;
            $employee_object->setUp($checkLogin);
            $employee_object->setupMenu($checkLogin->id_employee);
            return redirect()->route('main.get');
            // return redirect()->route('dashboard.dashboard.get');
        }else{
            return view('auth.login'/*, compact('success' ,'กรุณากรอกข้อมูลใหม่')*/);
        }
    }

    public function logout(){
            // \Session::flush();
            \Session::forget(['current_employee','current_menu']);
            \Session::forget('current_menu');
            return view('auth.login');
    }

    public function admin_login_(Request $req){
        $username    = $req->input('username');
        $password    = $req->input('password');

        $checkLogin   = Admin::where('user_admin',$username)->where('pass_admin',$password)->first();
        if(!empty($checkLogin)){
            $admin_object = new AdminObject;
            $admin_object->setUp($checkLogin);
            return redirect()->route('admin.admin_main.get');
        }else{

            return view('auth.admin_login');
        }

    }
    
    public function logout_admin(){
        // \Session::flush();
        \Session::forget('current_admin');
        return view('auth.admin_login');
    }
}