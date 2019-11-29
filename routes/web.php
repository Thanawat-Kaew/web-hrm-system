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
Route::get('/logout', 'Auth\LoginController@logout')->name('logout.index.post');

// Route::post('/login', 'Auth\LoginController@login')->name('login');
// Route::get('/main', 'Main\MainController@main')->name('main');
Route::get('/index', 'TimeStamp\TimeStampController@index')->name('time_stamp.index.get');

Route::get('/index/timestamp', 'TimeStamp\TimeStampController@time_stamp')->name('time_stamp.get');
Route::get('/index/request_history', 'TimeStamp\TimeStampController@request_history')->name('time_stamp.request_history.get');

Route::get('/index/timestamp/request', 'TimeStamp\TimeStampController@time_stamp_request')->name('time_stamp.time_stamp_request.get');

Route::get('/index/timestamp/list_request', 'TimeStamp\TimeStampController@time_stamp_list_request')->name('time_stamp.list_request.get');

Route::get('/index/timestamp/change_time_stamp_request', 'TimeStamp\TimeStampController@change_time_stamp_request')->name('time_stamp.change_time_stamp_request.get');

Route::post('/timestamp/add_timestamp', 'TimeStamp\TimeStampController@addTimeStamp')->name('time_stamp.add_timestamp.post');

Route::post('/time_stamp/add_time_stamp', 'TimeStamp\TimeStampController@add_time_stamp')->name('time_stamp.add_time_stamp.post');
Route::post('/time_stamp/add_request_time_stamp', 'TimeStamp\TimeStampController@addRequestTimeStamp')->name('time_stamp.add_request_time_stamp.post'); //add-request-timestamp
Route::post('/time_stamp/edit_request_time_stamp', 'TimeStamp\TimeStampController@editRequestTimeStamp')->name('request_history.edit_request_time_stamp.post'); //edit-request-timestamp
Route::post('/time_stamp/view_request_timestamp', 'TimeStamp\TimeStampController@ajaxCenter')->name('request_history.ajax_center.post');



Route::get('/leave', 'Leave\LeaveController@leave')->name('leave.leave.get');

Route::get('/leave/history', 'Leave\LeaveController@leave_history')->name('leave.leave_history.get');

Route::get('/personal_info', 'Employee\EmployeeController@personal_info')->name('personal_info.personal_info.get');
Route::post('/personal_info/amendment', 'Employee\EmployeeController@ajaxCenter')->name('personal_info.ajax_center.post');

Route::post('/personal_info/edit_data_employee', 'Employee\EmployeeController@editDataEmployee')->name('personal_info.edit_data_employee.post');
Route::post('/personal_info/update_edit_data_employee', 'Employee\EmployeeController@updateEditDataEmployee')->name('personal_info.update_edit_data_employee.post');

Route::get('/data_manage/employee', 'DataManagement\DataManageController@index')->name('data_management.index.get');

Route::post('/data_manage/ajax_center', 'DataManagement\DataManageController@ajaxCenter')->name('data_manage.ajax_center.post');

Route::post('/data_manage/add_employee', 'DataManagement\DataManageController@addEmployee')->name('data_manage.add_employee.post');
Route::post('/data_manage/change_department', 'DataManagement\DataManageController@changeDepartment')->name('data_manage.change_department.post');
Route::post('/data_manage/confirm', 'DataManagement\DataManageController@confirmDataRequest')->name('data_manage.confirm_data_request.post');
Route::post('/data_manage/cancel', 'DataManagement\DataManageController@cancelDataRequest')->name('data_manage.cancel_data_request.post');

Route::post('/leave/ajax_center', 'Leave\LeaveController@ajaxCenter')->name('leave.ajax_center.post');

Route::post('/time_stamp/ajax_center', 'TimeStamp\TimeStampController@ajaxCenter')->name('time_stamp.ajax_center.post');
Route::post('/time_stamp/confirm', 'TimeStamp\TimeStampController@confirmDataRequestTimeStamp')->name('time_stamp.confirm-data-request-time-stamp.post'); // confirm-request-time-stamp
Route::post('/time_stamp/cancel', 'TimeStamp\TimeStampController@cancelDataRequestTimeStamp')->name('time_stamp.cancel-data-request-time-stamp.post'); // cancel-request-time-stamp



Route::get('/evaluation/create_evaluations', 'Evaluation\EvaluationController@create_evaluations')->name('evaluation.create_evaluations.get');
Route::get('/evaluation/human_assessment/assessment', 'Evaluation\EvaluationController@assessment')->name('evaluation.assessment.get');
Route::get('/evaluation/human_assessment', 'Evaluation\EvaluationController@human_assessment')->name('evaluation.human_assessment.get');

Route::post('/evaluation/ajax_center', 'Evaluation\EvaluationController@ajaxCenter')->name('evaluation.ajax_center.post');

Route::get('/evaluation', 'Evaluation\EvaluationController@index')->name('evaluation.index.get');

Route::get('/report', 'Report\ReportController@index')->name('report.index.get');
Route::get('/report/report_time_stamp', 'Report\ReportController@reportTimeStamp')->name('report.report_time_stamp.get');
Route::get('/report/report_leave', 'Report\ReportController@reportLeave')->name('report.report_leave.get');
Route::get('/report/report_evaluation', 'Report\ReportController@reportEvaluation')->name('report.report_evaluations.get');
Route::get('/report/report_overview', 'Report\ReportController@reportOverview')->name('report.report_overview.get');
Route::get('/data_manage/request', 'DataManagement\DataManageController@notificationRequest')->name('data_management.notification_request.get');

Route::post('personal_info/dalete/{id}','Employee\EmployeeController@postDeleteRequestChangeData')->name('personal_info.delete_employee.post');

Route::post('/data_manage/delete/{id_employee}','DataManagement\DataManageController@postDeleteData')->name('data_manage.delete_employee.post');

Route::post('/request_history/delete/{id}','TimeStamp\TimeStampController@postDeleteRequestHistory')->name('timestamp.delete_request_history.post');


Auth::routes();

// Route::get('/home', 'HomeController@index')->name('home');
Route::get('/main', 'Main\MainController@main')->name('main.get');


