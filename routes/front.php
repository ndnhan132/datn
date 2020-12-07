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
Route::post('/ajax/get-list-class', 'CourseController@ajaxGetListClass');


Route::get('/nhan-lop/{slug}.html', 'TeacherCourseRegistrationController@getRegisterPage')->name('front.teacherRegisterCourse');
Route::get('/ajax/nhan-lop/{slug}.html', 'TeacherCourseRegistrationController@ajaxReloadRegisterPage');

Route::post('/ajax/teacher-login', 'TeacherController@ajaxLogin')->name('front.teacherLogin');
Route::get('/ajax/teacher-logout', 'TeacherController@ajaxLogout');
Route::get('/dang-xuat.html', 'TeacherController@logout')->name('front.teacherLogout');
Route::get('/ajax/load-teacher-login-box', 'TeacherController@ajaxLoadTeacherLoginBox');
Route::get('/ajax/load-teacher-course-registration-box/{courseId}', 'TeacherCourseRegistrationController@ajaxLoadTeacherCourseRegistrationBox');
Route::post('/ajax/teacher-register-course', 'TeacherCourseRegistrationController@ajaxTeacherRegisterCourse');
Route::post('/ajax/load-aside-data', 'PageController@ajaxLoadAsideData');


Route::get('/giao-vien.html', 'PageController@getForTeacherPage')->name('front.forTeacher');

Route::get('/phu-huynh.html', 'PageController@getForParentPage')->name('front.forParent');

Route::get('/danh-sach-gia-su.html', 'TeacherController@getAllTeachersPage')->name('front.getAllTeachersPage');
Route::get('/gia-su/{slug}.html', 'TeacherController@getDetailTeacherPage')->name('front.getDetailTeacherPage');
Route::post('/ajax/get-list-teacher', 'TeacherController@ajaxGetListTeacher');
Route::get('/ajax/get-teacher-by-id/{teacherId}', 'TeacherController@ajaxGetTeacherById');












Route::get('/tin-tuc.html', 'PageController@getListNews')->name('front.getListNews');
Route::get('/tin-tuc/{slug}.html', 'PageController@readPost')->name('front.readNews');
Route::get('/trang/{slug}.html', 'PageController@readPost')->name('front.readPage');



// group quan ly giao vien
Route::name('front.teacherManager.')->prefix('/ho-so')->middleware(['CheckTeacher'])->group(function () {
    Route::get('/thong-tin.html', 'TeacherManagerController@index')->name('index');
    Route::get('/lop-dang-ky.html', 'TeacherManagerController@getRegistrationCourse')->name('registrationCourse');
    Route::get('/cai-dat-{settingType}.html', 'TeacherManagerController@getManager')->name('getManager');
});
Route::prefix('/ajax/')->middleware(['CheckTeacher'])->group(function() {
    Route::post('teacher-manager/update/general', 'TeacherManagerController@ajaxUpdateGeneral');
    Route::post('teacher-manager/update/password', 'TeacherManagerController@ajaxUpdatePassword');
    Route::post('teacher-manager/update/education', 'TeacherManagerController@ajaxUpdateEducation');
    Route::post('teacher-manager/update/avatar', 'TeacherManagerController@ajaxUpdateAvatar');
    Route::post('teacher-manager/update/image', 'TeacherManagerController@ajaxUpdateImage');
    Route::post('teacher-manager/update/delete-image', 'TeacherManagerController@ajaxUpdateDeleteImage');

    Route::get('get-course-by-id/{courseId}', 'TeacherManagerController@ajaxGetCourseById');
    Route::post('delete-registration', 'TeacherManagerController@ajaxDeleteCourse');

    Route::get('get-teacher-level', 'TeacherManagerController@ajaxGetTeacherLevel');
    Route::get('teacher-manager/send-request-confirmation', 'TeacherManagerController@ajaxSendRequestConfirmation');
});

Route::post('/ajax/enquiry-store', 'EnquiryController@ajaxStore');
Route::get('/account/verify-email', 'TeacherController@verifyTeacherEmail')->name('front.verifyTeacherEmail');
