<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use Illuminate\Foundation\Auth\AuthenticatesUsers;
use Illuminate\Http\Request;
use DB;
use App\Services\Auth\Employee;
use Symfony\Component\HttpFoundation\Session\Session;



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
        //return view('main');
        if(($checkLogin['id_position'] == 1) && ($checkLogin['id_department'] == 'en0001')){
            echo $checkLogin['id_position']." and ".$checkLogin['id_department'];
            /*return view('main')->with('employee', 'พนักงาน');*/
        }else if(($checkLogin['id_position'] == 1) && ($checkLogin['id_department'] == 'fa0001')){
            echo $checkLogin['id_position']." and ".$checkLogin['id_department'];
            /*return view('main')->with('employee', 'พนักงาน');*/
        }else if(($checkLogin['id_position'] == 1) && ($checkLogin['id_department'] == 'pm0001')){
            echo $checkLogin['id_position']." and ".$checkLogin['id_department'];
            /*return view('main')->with('employee', 'พนักงาน');*/
        }else if(($checkLogin['id_position'] == 1) && ($checkLogin['id_department'] == 'ss0001')){
            echo $checkLogin['id_position']." and ".$checkLogin['id_department'];
            /*return view('main')->with('employee', 'พนักงาน');*/
        }elseif(($checkLogin['id_position'] == 2) && ($checkLogin['id_department'] == 'en0001')){
            echo $checkLogin['id_position']." and ".$checkLogin['id_department'];
            /*return view('main')->with('header', 'หัวหน้า');*/
        }else if(($checkLogin['id_position'] == 2) && ($checkLogin['id_department'] == 'fa0001')){
            echo $checkLogin['id_position']." and ".$checkLogin['id_department'];
            /*return view('main')->with('header', 'หัวหน้า');*/
        }else if(($checkLogin['id_position'] == 2) && ($checkLogin['id_department'] == 'pm0001')){
            echo $checkLogin['id_position']." and ".$checkLogin['id_department'];
            /*return view('main')->with('header', 'หัวหน้า');*/
        }else if(($checkLogin['id_position'] == 2) && ($checkLogin['id_department'] == 'ss0001')){
            echo $checkLogin['id_position']." and ".$checkLogin['id_department'];
            /*return view('main')->with('header', 'หัวหน้า');*/
        }else if(($checkLogin['id_position'] == 1) && ($checkLogin['id_department'] == 'hr0001')){
            echo $checkLogin['id_position']." and ".$checkLogin['id_department'];
            /*return view('main')->with('work_hr', 'พนักงานบุคคล');*/
        }else if(($checkLogin['id_position'] == 2) && ($checkLogin['id_department'] == 'hr0001')){
            echo $checkLogin['id_position']." and ".$checkLogin['id_department'];
            /*return view('main')->with('header_hr', 'หัวหน้าฝ่ายบุคคล');*/
        }

        if($checkLogin['id_position'] == 1){
            //return redirect('main')->with('employee', 'หนักงาน');

            //Session::put('employee', Input::get('employee'));
            //return redirect('main')->with('employee', 'Anda telah login!');

            $req->session()->put('employee');
            return view('main')->with('employee', $req->$req->session()->get('employee'));
        }else if($checkLogin['id_position'] == 2){
            //return redirect('main')->with('header', 'หัวหน้า');

            //Session::put('header', Input::get('header'));
            //return redirect('main')->with('header', 'Anda telah login!');


        }

        //if($attempt) {
    //Session::put('usersess', Input::get('username'));
    //return Redirect::to('index')->with('message', 'Anda telah login!' . $attempt);
        //}
    }
}


