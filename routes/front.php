<?php
use Illuminate\Support\Facades\Route;

Route::get('/', 'PageController@index')->name('front.home');

Route::get('/dang-ky-tim-gia-su.html', 'CourseController@getCourseRegisterPage')->name('front.getCourseRegisterPage');
Route::post('/front/ajax/course/store', 'CourseController@ajaxStore');

Route::get('/dang-ky-lam-gia-su.html', 'TeacherController@getTeacherRegisterPage')->name('front.getTeacherRegisterPage');
Route::post('/front/ajax/teacher/store', 'TeacherController@ajaxStore');

// lop moi chua giao
Route::get('/lop-can-gia-su.html', 'CourseController@getNotReceivedClassPage')->name('front.getNotReceivedClassPage');
// tat ca cac lop
Route::get('/danh-sach-lop.html', 'CourseController@getAllClassPage')->name('front.getAllClassPage');
Route::get('/ajax/get-list-class', 'CourseController@ajaxGetListClass');

Route::get('/nhan-lop/{slug}', 'TeacherCourseRegistrationController@getRegisterPage')->name('front.teacherRegisterCourse');
Route::get('/ajax/nhan-lop/{slug}', 'TeacherCourseRegistrationController@ajaxReloadRegisterPage');

Route::post('/ajax/teacher-login', 'TeacherController@ajaxLogin')->name('front.teacherLogin');
Route::get('/ajax/teacher-logout', 'TeacherController@logout')->name('front.teacherLogout');
Route::get('/ajax/load-teacher-login-box', 'TeacherController@ajaxLoadTeacherLoginBox');
Route::get('/ajax/load-teacher-course-registration-box/{courseId}', 'TeacherCourseRegistrationController@ajaxLoadTeacherCourseRegistrationBox');
Route::post('/ajax/teacher-register-course', 'TeacherCourseRegistrationController@ajaxTeacherRegisterCourse');
Route::post('/ajax/load-aside-data', 'PageController@ajaxLoadAsideData');


Route::get('/giao-vien', 'TeacherController@getForTeacherPage')->name('front.forTeacher');

// group quan ly giao vien
Route::name('front.teacherManager.')->prefix('/ho-so')->group(function () {
    Route::get('/', 'TeacherManagerController@index')->name('index');
    Route::get('/cai-dat-{settingType}.html', 'TeacherManagerController@getManager')->name('getManager');
});

Route::post('/ajax/teacher-manager/update/general', 'TeacherManagerController@ajaxUpdateGeneral');
Route::post('/ajax/teacher-manager/update/password', 'TeacherManagerController@ajaxUpdatePassword');
Route::post('/ajax/teacher-manager/update/education', 'TeacherManagerController@ajaxUpdateEducation');
Route::post('/ajax/teacher-manager/update/avatar', 'TeacherManagerController@ajaxUpdateAvatar');

Route::get('/ajax/get-teacher-level', 'TeacherManagerController@ajaxGetTeacherLevel');
