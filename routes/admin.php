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

    //dang ky nhan lop
    Route::prefix('/dang-ky-nhan-lop')->name('teacherCourseRegistration.')->group(function() {
        Route::get('/', 'TeacherCourseRegistrationController@index')->name('index');
        Route::prefix('/ajax')->group(function(){
            Route::get('/index', 'TeacherCourseRegistrationController@ajaxGetTableContent');
            Route::get('/get-teacher-registration/{courseId}', 'TeacherCourseRegistrationController@ajaxGetTeacherRegistration');
        });
    });
    // dk tim gia su
    Route::get('/khoa-hoc', 'CourseController@index')->name('course.index');
    Route::get('/khoa-hoc/ajax/index', 'CourseController@ajaxGetTableContent');
    Route::get('/khoa-hoc/ajax/show/{courseId}', 'CourseController@ajaxShow');
    Route::post('/khoa-hoc/ajax/confirm', 'CourseController@ajaxConfirm');
});
