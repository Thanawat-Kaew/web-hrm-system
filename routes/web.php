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
    return view('auth.login');
    // return view('layouts.template');
    // return view('main');
});



// Route::post('/login', 'Auth\LoginController@login')->name('login');
// Route::get('/main', 'Main\MainController@main')->name('main');
Route::get('/index', 'TimeStamp\TimeStampController@index')->name('time_stamp.index');

Route::get('/index/timestamp', 'TimeStamp\TimeStampController@time_stamp')->name('time_stamp');

Route::get('/leave', 'Leave\LeaveController@leave')->name('leave.leave');
Route::get('/personal_info/{id}', 'Employee\EmployeeController@personal_info')->name('personal_info.personal_info');
Route::get('/data_manage/index', 'DataManagement\DataManageController@index')->name('data_management.index');

Route::post('/data_manage/ajax_center', 'DataManagement\DataManageController@ajaxCenter')->name('data_manage.ajax_center');
Route::post('/leave/ajax_center', 'Leave\LeaveController@ajaxCenter')->name('leave.ajax_center');
Route::post('/time_stamp/ajax_center', 'TimeStamp\TimeStampController@ajaxCenter')->name('time_stamp.ajax_center');

Auth::routes();

// Route::get('/home', 'HomeController@index')->name('home');
Route::get('/main', 'Main\MainController@main')->name('main');


