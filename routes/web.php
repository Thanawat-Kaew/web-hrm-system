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

/*****************************************************Timestamp***************************************************************/
Route::get('/index', 'TimeStamp\TimeStampController@index')->name('time_stamp.index.get'); //ขึ้นข้อมูลวันที่ลงเวลาหน้า index

Route::get('/index/timestamp', 'TimeStamp\TimeStampController@time_stamp')->name('time_stamp.get'); //ขึ้นข้อมูลเมื่อลงเวลาหน้า new window
Route::post('/timestamp/add_timestamp', 'TimeStamp\TimeStampController@addTimeStamp')->name('time_stamp.add_timestamp.post'); // ลงเวลาเข้าออกงาน

Route::get('/index/request_history', 'TimeStamp\TimeStampController@request_history')->name('time_stamp.request_history.get'); //ดูประวัติการร้องขอ
Route::post('/time_stamp/add_request_time_stamp', 'TimeStamp\TimeStampController@addRequestTimeStamp')->name('time_stamp.add_request_time_stamp.post'); //add-request-timestamp
Route::post('/time_stamp/edit_request_time_stamp', 'TimeStamp\TimeStampController@editRequestTimeStamp')->name('request_history.edit_request_time_stamp.post'); //edit-request-timestamp
Route::post('/request_history/delete/{id}','TimeStamp\TimeStampController@postDeleteRequestHistory')->name('timestamp.delete_request_history.post'); // delete-history-request-timestamp

Route::get('/index/timestamp/request', 'TimeStamp\TimeStampController@time_stamp_request')->name('time_stamp.time_stamp_request.get'); // หน้า confirm/cancel การลงวลาย้อนหลัง
Route::post('/time_stamp/confirm', 'TimeStamp\TimeStampController@confirmDataRequestTimeStamp')->name('time_stamp.confirm-data-request-time-stamp.post'); // confirm-request-time-stamp
Route::post('/time_stamp/cancel', 'TimeStamp\TimeStampController@cancelDataRequestTimeStamp')->name('time_stamp.cancel-data-request-time-stamp.post'); // cancel-request-time-stamp

Route::post('/time_stamp/ajax_center', 'TimeStamp\TimeStampController@ajaxCenter')->name('time_stamp.ajax_center.post'); // ajaxcenter
/**************************************************End Timestamp**************************************************************/



/**************************************************Personalinfo***************************************************************/
Route::get('/personal_info', 'Employee\EmployeeController@personal_info')->name('personal_info.personal_info.get'); //หน้าแสดงข้อมูลส่วนตัว
Route::post('/personal_info/amendment', 'Employee\EmployeeController@ajaxCenter')->name('personal_info.ajax_center.post'); // ajaxcenter
Route::post('/personal_info/edit_data_employee', 'Employee\EmployeeController@editDataEmployee')->name('personal_info.edit_data_employee.post'); // edit-request-cahnge-data // ร้องขอการแก้ไขข้อมูล (แก้ไขครั้งที่1)
Route::post('/personal_info/update_edit_data_employee', 'Employee\EmployeeController@updateEditDataEmployee')->name('personal_info.update_edit_data_employee.post'); // update-request-cahnge-data //แก้ไขการร้องขอการแก้ไขข้อมูล (แก้ไขครั้งที่2)
Route::post('personal_info/dalete/{id}','Employee\EmployeeController@postDeleteRequestChangeData')->name('personal_info.delete_employee.post'); // delete-request-change-data
/************************************************End Personalinfo***********************************************************/


/************************************************DataManagement**************************************************************/
Route::get('/data_manage/employee', 'DataManagement\DataManageController@index')->name('data_management.index.get');

Route::post('/data_manage/ajax_center', 'DataManagement\DataManageController@ajaxCenter')->name('data_manage.ajax_center.post');

Route::post('/data_manage/add_employee', 'DataManagement\DataManageController@addEmployee')->name('data_manage.add_employee.post');// เพิ่มหนักงาน
Route::post('/data_manage/confirm', 'DataManagement\DataManageController@confirmDataRequest')->name('data_manage.confirm_data_request.post'); //confirm-request-change-data
Route::post('/data_manage/cancel', 'DataManagement\DataManageController@cancelDataRequest')->name('data_manage.cancel_data_request.post'); // cancel-request-change-data
Route::post('/data_manage/delete/{id_employee}','DataManagement\DataManageController@postDeleteData')->name('data_manage.delete_employee.post'); // delete-request-change-data
Route::post('/data_manage/edit_employee', 'DataManagement\DataManageController@editEmployee')->name('data_manage.edit_employee.post');// แก้ไขข้อมูลพนักงาน
Route::get('/data_manage/request', 'DataManagement\DataManageController@notificationRequest')->name('data_management.notification_request.get'); // notification
/***********************************************EndDataManagement***************************************************************/


/****************************************************Leave*********************************************************************/
Route::post('/leave/ajax_center', 'Leave\LeaveController@ajaxCenter')->name('leave.ajax_center.post');
Route::get('/leave', 'Leave\LeaveController@leave')->name('leave.leave.get');
Route::get('/leave/history', 'Leave\LeaveController@leave_history')->name('leave.leave_history.get');
Route::get('/leave/request', 'Leave\LeaveController@leave_request')->name('leave.leave_request.get');
Route::get('/leave/set_holiday', 'Leave\LeaveController@leave_set_holiday')->name('leave.set_holiday.get');
Route::post('/leave/add_request_leave', 'Leave\LeaveController@addRequestLeave')->name('leave.add_request_leave.post');
Route::post('/leave/request/confirm', 'Leave\LeaveController@confirmDataRequestLeave')->name('leaves.confirm-data-request-leave.post');
Route::post('/leave/request/cancel', 'Leave\LeaveController@cancelDataRequestLeave')->name('leaves.cancel-data-request-leave.post');
Route::post('/leaves_history/delete/{id}','Leave\LeaveController@postDeleteLeaveHistory')->name('leaves.delete_leave_history.post');
Route::post('/leave/edit_request_leave', 'Leave\LeaveController@editRequestLeave')->name('request_history.edit_request_leave.post');
Route::post('/leave/add_set_holiday', 'Leave\LeaveController@addSetHoliday')->name('leave.add_set_holiday.post');
Route::post('/leaves/delete_set_holiday/{id}','Leave\LeaveController@postDeleteSetHoliday')->name('leaves.delete_set_holiday.post');
/**************************************************EndLeave********************************************************************/


/**************************************************Evaluation*******************************************************************/
Route::get('/evaluation/create_evaluations', 'Evaluation\EvaluationController@create_evaluations')->name('evaluation.create_evaluations.get');
Route::get('/evaluation/human_assessment/assessment/{id}/topic/{id_topic}', 'Evaluation\EvaluationController@assessment')->name('evaluation.assessment.get'); // ข้อมูลผู้ถูกประเมิน
Route::get('/evaluation/human_assessment/{id}', 'Evaluation\EvaluationController@human_assessment')->name('evaluation.human_assessment.get'); // หน้ารายชื่อผู้ถูกประเมิน
Route::post('/evaluation/ajax_center', 'Evaluation\EvaluationController@ajaxCenter')->name('evaluation.ajax_center.post');
Route::post('/evaluation/post_add', 'Evaluation\EvaluationController@postAddEvaluations')->name('evaluation.post_add.post');
Route::get('/evaluation/view_create_evaluation/{id}', 'Evaluation\EvaluationController@viewCreateEvaluation')->name('evaluation.view_create_evaluations.get'); // view-create-evaluation
Route::get('/evaluation/view_create_evaluation_index/{id}', 'Evaluation\EvaluationController@viewCreateEvaluation_2')->name('evaluation.view_create_evaluations_for_index.get'); // view-create-evaluation
Route::get('/evaluation/edit_evaluation/{id}', 'Evaluation\EvaluationController@editEvaluation')->name('evaluation.edit_evaluations.get'); // edit-evaluation //page
Route::post('/evaluation/post_edit', 'Evaluation\EvaluationController@postEditEvaluations')->name('evaluation.post_edit.post'); // edit to database

Route::get('/evaluation/confirm-send-create-evaluation/{id}', 'Evaluation\EvaluationController@postConfirmSendCreateEvaluations')->name('evaluation.confirm_send_create_evaluation.get'); // confirm send create evaluation to database

Route::post('/evaluation/post_record_evaluation', 'Evaluation\EvaluationController@postRecordEvaluation')->name('evaluation.post_record_evaluation.post'); // evaluation // บันทึกแบบประเมิน
Route::get('/evaluation', 'Evaluation\EvaluationController@index')->name('evaluation.index.get');

Route::post('/evaluation/delete/{id}','Evaluation\EvaluationController@postDeleteCreateEvaluation')->name('evaluation.index.post');
Route::get('/evaluation/request_created_evaluation', 'Evaluation\EvaluationController@viewCreateEvaluationRequest')->name('evaluation.create_evaluations_request.get');//หน้าอนุมัติ กรณีมีพนักงานสร้างแบบประเมิน
Route::get('/evaluation/history_request_created_evaluation', 'Evaluation\EvaluationController@viewHistoryCreateEvaluation')->name('evaluation.history_create_evaluations.get');//หน้าประวัติการสร้างแบบประเมิน กรณีพนักงานและ HR
Route::post('/evaluation/request_created_evaluation/confirm', 'Evaluation\EvaluationController@confirmCreateEvaluation')->name('evaluation.confirm-create-evaluation.post'); // confrim create evaluation
Route::post('/evaluation/request_created_evaluation/cancel', 'Evaluation\EvaluationController@cancelCreateEvaluation')->name('evaluation.cancel-create-evaluation.post'); // cancel create evaluation
/************************************************End Evaluation******************************************************************/

/******************************************************Report*********************************************************************/
Route::get('/report', 'Report\ReportController@index')->name('report.index.get');
Route::get('/report/report_time_stamp', 'Report\ReportController@reportTimeStamp')->name('report.report_time_stamp.get');
Route::get('/report/report_leave', 'Report\ReportController@reportLeave')->name('report.report_leave.get');
Route::get('/report/report_evaluation', 'Report\ReportController@reportEvaluation')->name('report.report_evaluations.get');
Route::get('/report/report_overview', 'Report\ReportController@reportOverview')->name('report.report_overview.get');
/***************************************************End Report********************************************************************/

Auth::routes();

// Route::get('/home', 'HomeController@index')->name('home');
Route::get('/main', 'Main\MainController@main')->name('main.get');


