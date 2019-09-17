<?php

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/

Route::get('/', function () {
    // return view('auth.login');
    // return view('layouts.template');
    return view('main');
});



Route::get('/main', 'Main\MainController@main')->name('main');

Route::get('/index', 'TimeStamp\TimeStampController@index')->name('index');
Route::get('/index/timestamp', 'TimeStamp\TimeStampController@time_stamp')->name('time_stamp');

Route::get('/leave', 'Leave\LeaveController@leave')->name('leave');

Route::get('/personal_info', 'Employee\EmployeeController@personal_info')->name('personal_info');

Route::post('/login', 'Auth\LoginController@login')->name('login');


Auth::routes();

// Route::get('/home', 'HomeController@index')->name('home');
Route::get('/main', 'Main\MainController@main')->name('main');


