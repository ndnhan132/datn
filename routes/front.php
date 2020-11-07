<?php
use Illuminate\Support\Facades\Route;

Route::get('/', 'HomeController@index')->name('front.home');

Route::get('/dang-ky-tim-gia-su.html', 'CourseController@getCourseRegisterPage')->name('front.getCourseRegisterPage');
Route::post('/front/ajax/course/store', 'CourseController@ajaxStore');

Route::get('/dang-ky-lam-gia-su.html', 'TeacherController@getTeacherRegisterPage')->name('front.getTeacherRegisterPage');
Route::post('/front/ajax/teacher/store', 'TeacherController@ajaxStore');

Route::get('/lop-can-gia-su.html', 'CourseController@getNewClassPage')->name('front.getNewClassPage');

Route::get('/nhan-lop/{slug}', 'TeacherCourseRegistrationController@getRegisterPage')->name('front.teacherRegisterCourse');
Route::get('/ajax/nhan-lop/{slug}', 'TeacherCourseRegistrationController@ajaxReloadRegisterPage');

Route::post('/ajax/teacher-login', 'TeacherController@ajaxLogin')->name('front.teacherLogin');
Route::get('/ajax/teacher-logout', 'TeacherController@logout')->name('front.teacherLogout');
Route::get('/ajax/load-teacher-login-box', 'TeacherController@ajaxLoadTeacherLoginBox');
Route::get('/ajax/load-teacher-course-registration-box/{courseId}', 'TeacherCourseRegistrationController@ajaxLoadTeacherCourseRegistrationBox');
Route::post('/ajax/teacher-register-course', 'TeacherCourseRegistrationController@ajaxTeacherRegisterCourse');
