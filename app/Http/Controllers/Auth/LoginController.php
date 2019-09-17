<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use Illuminate\Foundation\Auth\AuthenticatesUsers;
use Illuminate\Http\Request;
use DB;

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

        $checkLogin = DB::table('employee')->where(['email'=>$email, 'password'=>$password])->get();
        if(count($checkLogin) > 0){
            if($checkLogin->where(['id_position'] == 1) && ['id_department'] == 'en0001'||'fa0001'||'pm0001'||'ss0001'){
                echo "1 en";
                //return redirect()->route('main');
            }
            else if($checkLogin->where(['id_position'] == 2) && ['id_department'] == 'en0001'||'fa0001'||'pm0001'||'ss0001'){
                echo "2 en";
            }else if($checkLogin->where(['id_position'] == 1) && ['id_department'] == 'hr0001'){
                echo "1 hr";
            }else if($checkLogin->where(['id_position'] == 2) && ['id_department'] == 'hr0001'){
                echo "2 hr";
            }
        }else{
            return redirect()->route('login');
        }
    }
}


