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
Route::get('/index', 'TimeStamp\TimeStampController@index')->name('time_stamp.index.get');

Route::get('/index/timestamp', 'TimeStamp\TimeStampController@time_stamp')->name('time_stamp.get');

Route::get('/leave', 'Leave\LeaveController@leave')->name('leave.leave.get');
Route::get('/personal_info/{id}', 'Employee\EmployeeController@personal_info')->name('personal_info.personal_info.get');
Route::get('/data_manage/index', 'DataManagement\DataManageController@index')->name('data_management.index.get');
Route::get('/evaluation/index', 'Evaluation\EvaluationController@evaluation')->name('evaluation.index.get');
Route::get('/evaluation/create_evaluations', 'Evaluation\EvaluationController@create_evaluations')->name('evaluation.create_evaluations.get');

Route::post('/data_manage/ajax_center', 'DataManagement\DataManageController@ajaxCenter')->name('data_manage.ajax_center.post');
Route::post('/data_manage/add_employee', 'DataManagement\DataManageController@addEmployee')->name('data_manage.add_employee.post');
Route::post('/leave/ajax_center', 'Leave\LeaveController@ajaxCenter')->name('leave.ajax_center.post');
Route::post('/time_stamp/ajax_center', 'TimeStamp\TimeStampController@ajaxCenter')->name('time_stamp.ajax_center.post');
Route::post('/evaluation/index', 'Evaluation\EvaluationController@ajaxCenter')->name('evaluation.ajax_center.post');

Auth::routes();

// Route::get('/home', 'HomeController@index')->name('home');
Route::get('/main', 'Main\MainController@main')->name('main.get');


