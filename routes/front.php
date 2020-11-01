<?php
use Illuminate\Support\Facades\Route;

Route::get('/', 'HomeController@index')->name('front.home');

Route::get('/dang-ky-tim-gia-su.html', 'CourseController@getCourseRegisterPage')->name('front.getCourseRegisterPage');
Route::post('/front/ajax/course/store', 'CourseController@ajaxStore');

Route::get('/dang-ky-lam-gia-su.html', 'TeacherController@getTeacherRegisterPage')->name('front.getTeacherRegisterPage');
Route::post('/front/ajax/teacher/store', 'TeacherController@ajaxStore');

Route::get('/lop-can-gia-su.html', 'CourseController@getNewClassPage')->name('front.getNewClassPage');

Route::get('/nhan-lop/{slug}', 'TeacherCourseRegistrationController@getRegisterPage')->name('front.teacherRegisterCourse');
