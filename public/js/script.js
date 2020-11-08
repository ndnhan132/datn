$(function () {
    $(document).on('click', '.btn-teacher-show-login', function (event) {
        event.preventDefault();
        $('.form-box').slideToggle();
    });

    $(document).on('click', '.btn-teacher-login', function(event) {
        event.preventDefault();
        $.ajax({
            url: '/ajax/teacher-login',
            type: 'POST',
            dataType: 'json',
            data: $('form#teacher-login-form').serialize(),
        })
            .done(function (data) {
                console.log(data);
                if (data.success) {
                    loadTeacherLoginBox();
                }
            });
    });
    $(document).on('click', '.btn-teacher-logout', function(event) {
        event.preventDefault();
        $.ajax({
            url: '/ajax/teacher-logout',
            type: 'GET',
        })
            .done(function (data) {
                console.log(data);
                if (data.success) {
                    loadTeacherLoginBox();
                }
            });
    });
    $(document).on('click', '.btn-teacher-register-course', function(event){
        event.preventDefault();
        var courseId = $(document).find('#teacher-course-registration-box').data('course-id');
        if(!courseId) {
            alert('Error');
            return;
        }
        $.ajax({
            url: '/ajax/teacher-register-course',
            type: 'POST',
            dataType: 'json',
            data: {courseId : courseId},
        })
            .done(function (data) {
                console.log(data);
                if (data.success) {
                    reloadRegisterPageContent();
                }
            });
    });

    // !#function
    function loadTeacherLoginBox() {
        var _loginBox = $(document).find('#teacher-login-box');
        // var _width = _loginBox.outerWidth();
        // var _height = _loginBox.outerHeight();

        var _width = _loginBox.width();
        var _height = _loginBox.height();

        var _loadingStyle = `style="
            width: ${_width}px;
            height: ${_height}px;
            background: #FFFCEC;
        "`;
        console.log(_loadingStyle);
        _loginBox.empty();
        var loadingHtml = `<div class="d-flex justify-content-center my-auto border" ${_loadingStyle}>
                <div class="spinner-border my-auto" role="status" style="color: #cdcdcd; ">
                    <span class="sr-only">Loading...</span>
                </div>
            </div>`;
        _loginBox.append(loadingHtml);
        _loginBox.load('/ajax/load-teacher-login-box');
        var _registrationBox = $(document).find('#teacher-course-registration-box');
        if (_registrationBox) {
            _registrationBox.empty();
            // _registrationBox.fadeOut();
            _registrationBox.append(loadingHtml);
            _registrationBox.load('/ajax/load-teacher-course-registration-box/' + $(document).find('#teacher-course-registration-box').data('course-id'));
            // _registrationBox.fadeIn();
        }
    }

    function reloadRegisterPageContent(){
        var _url = '/ajax/nhan-lop/' + 'eveniet-similique-incidunt-nam-cumque-dolorem-quas-debitis.html';
        $(document).find('#teacher-register-course-content').load(_url);
    }
});
