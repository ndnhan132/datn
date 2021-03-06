<?php
use Illuminate\Support\Facades\Route;

Route::get('/is', function(){
    echo 'xxxx';
});
Route::name('admin.')->middleware(['CheckAdminLogin'])->group(function(){
    Route::get('/', 'DashboardController@index')->name('dashboard.index');
    Route::get('/dashboard', 'DashboardController@index');
    Route::get('/index', 'DashboardController@index');
    Route::get('/ajax/get-dashboard-count', 'DashboardController@ajaxGetDashboardCount');

    // Danh sách gia sư
    Route::get('/giao-vien', 'TeacherController@index')->name('teacher.index');
    Route::get('/giao-vien/ajax/index', 'TeacherController@ajaxGetTableContent');
    Route::get('/giao-vien/ajax/show/{teacherId}', 'TeacherController@ajaxShow');
    Route::post('/giao-vien/ajax/confirm', 'TeacherController@ajaxConfirm');
    Route::post('/giao-vien/ajax/delete', 'TeacherController@ajaxDelete');

    //dang ky nhan lop
    Route::prefix('/dang-ky-nhan-lop')->name('teacherCourseRegistration.')->group(function() {
        Route::get('/', 'TeacherCourseRegistrationController@index')->name('index');
        Route::prefix('/ajax')->group(function(){
            Route::get('/index', 'TeacherCourseRegistrationController@ajaxGetTableContent');
            Route::get('/get-teacher-registration/{courseId}', 'TeacherCourseRegistrationController@ajaxGetTeacherRegistration');
            Route::get('/compare/{registrationId}', 'TeacherCourseRegistrationController@ajaxGetCompare');
            Route::post('/confirm-status', 'TeacherCourseRegistrationController@ajaxConfirmStatus');
            Route::post('/delete', 'TeacherCourseRegistrationController@ajaxDelete');
        });
    });
    // dk tim gia su
    Route::get('/khoa-hoc', 'CourseController@index')->name('course.index');
    Route::get('/khoa-hoc/ajax/index', 'CourseController@ajaxGetTableContent');
    Route::get('/khoa-hoc/ajax/show/{courseId}', 'CourseController@ajaxShow');
    Route::post('/khoa-hoc/ajax/confirm', 'CourseController@ajaxConfirm');
    Route::post('/khoa-hoc/ajax/delete', 'CourseController@ajaxDelete');
    Route::get('/khoa-hoc/ajax/get-course-by-courselevel-and-subject', 'CourseController@ajaxGetCourseByCourselevelAndSubject');
    Route::post('/khoa-hoc/ajax/update-course', 'CourseController@ajaxUpdateCourse');
    Route::get('/khoa-hoc/ajax/get-course-by-id', 'CourseController@ajaxGetCourseById');

    // Phụ huynh đăng ký lớp
    Route::get('/phu-huynh-dang-ky', 'ParentRegisterController@index')->name('parentRegister.index');
    Route::get('/phu-huynh-dang-ky/ajax/index', 'ParentRegisterController@ajaxGetTableContent');
    Route::get('/phu-huynh-dang-ky/ajax/show/{parentRegisterId}', 'ParentRegisterController@ajaxShow');
    Route::post('/phu-huynh-dang-ky/ajax/confirm', 'ParentRegisterController@ajaxConfirm');
    Route::post('/phu-huynh-dang-ky/ajax/delete', 'ParentRegisterController@ajaxDelete');



    Route::get('/bai-viet', 'PostController@index')->name('post.index');
    Route::get('/bai-viet/ajax/index', 'PostController@ajaxGetTableContent');
    Route::post('/bai-viet/ajax/delete', 'PostController@ajaxDelete');
    Route::post('/bai-viet/ajax/get-update', 'PostController@ajaxGetUpdate');
    Route::post('/bai-viet/ajax/post-update', 'PostController@ajaxPostUpdate');
    Route::get('/bai-viet/ajax/get-create', 'PostController@ajaxGetCreate');
    Route::post('/bai-viet/ajax/post-store', 'PostController@ajaxPostStore');


    Route::get('/lien-he', 'EnquiryController@index')->name('enquiry.index');
    Route::get('/lien-he/ajax/index', 'EnquiryController@ajaxGetTableContent');
    Route::get('/lien-he/ajax/show/{enquiryId}', 'EnquiryController@ajaxShow');
    Route::post('/lien-he/ajax/delete', 'EnquiryController@ajaxDelete');
    Route::post('/lien-he/ajax/change-status', 'EnquiryController@ajaxChangeStatus');

    Route::post('ckeditor/upload', 'PageController@upload')->name('ckeditor.upload');

});
Route::get('dang-nhap', 'PageController@getLogin')->name('admin.getLogin');
Route::post('dang-nhap', 'PageController@postLogin')->name('admin.postLogin');
Route::post('ajax/users/login', 'PageController@ajaxPostLogin');
Route::get('dang-xuat', 'PageController@logout')->name('admin.logout');
