<?php
use Illuminate\Support\Facades\Route;

Route::get('/is', function(){
    echo 'xxxx';
});
Route::name('admin.')->group(function(){
    Route::get('/', 'DashboardController@index')->name('dashboard.index');
    Route::get('/dashboard', 'DashboardController@index');
    Route::get('/index', 'DashboardController@index');

    // Danh sách gia sư
    Route::get('/giao-vien', 'TeacherController@index')->name('teacher.index');
    Route::get('/giao-vien/ajax/index', 'TeacherController@ajaxGetTableContent');
    Route::get('/giao-vien/ajax/show/{teacherId}', 'TeacherController@ajaxShow');
    Route::post('/giao-vien/ajax/confirm', 'TeacherController@ajaxConfirm');

    //dang ky nhan lop
    Route::prefix('/dang-ky-nhan-lop')->name('teacherCourseRegistration.')->group(function() {
        Route::get('/', 'TeacherCourseRegistrationController@index')->name('index');
        Route::prefix('/ajax')->group(function(){
            Route::get('/index', 'TeacherCourseRegistrationController@ajaxGetTableContent');
            Route::get('/get-teacher-registration/{courseId}', 'TeacherCourseRegistrationController@ajaxGetTeacherRegistration');
            Route::get('/compare/{registrationId}', 'TeacherCourseRegistrationController@ajaxGetCompare');
            Route::post('/confirm-status', 'TeacherCourseRegistrationController@ajaxConfirmStatus');
        });
    });
    // dk tim gia su
    Route::get('/khoa-hoc', 'CourseController@index')->name('course.index');
    Route::get('/khoa-hoc/ajax/index', 'CourseController@ajaxGetTableContent');
    Route::get('/khoa-hoc/ajax/show/{courseId}', 'CourseController@ajaxShow');
    Route::post('/khoa-hoc/ajax/confirm', 'CourseController@ajaxConfirm');

    Route::view('/binh-luan', 'admin.comment.index')->name('comment.index');
});
