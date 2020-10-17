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

    // dk tim gia su
    Route::get('/khoa-hoc', 'CourseController@index')->name('course.index');
    Route::get('/khoa-hoc/ajax/index', 'CourseController@ajaxGetTableContent');
});
