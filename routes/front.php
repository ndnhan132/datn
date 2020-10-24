<?php
use Illuminate\Support\Facades\Route;

Route::get('/', 'HomeController@index');

Route::get('/dang-ky-tim-gia-su.html', 'CourseController@getCourseRegisterPage')->name('front.getCourseRegisterPage');
Route::post('/front/ajax/course/store', 'CourseController@ajaxStore');

Route::get('/dang-ky-lam-gia-su.html', 'TeacherController@getTeacherRegisterPage')->name('front.getTeacherRegisterPage');
Route::post('/front/ajax/teacher/store', 'TeacherController@ajaxStore');
