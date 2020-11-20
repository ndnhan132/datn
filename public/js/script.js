$(function () {

    //! start header scroll
    /* #region   */
    var navbarCollapse = function () {
        if ($('#mainNav').length) {
            if ($("#mainNav").offset().top > 68) {
                $("#mainNav").addClass("navbar-shrink");
            } else {
                $("#mainNav").removeClass("navbar-shrink");
            }
        }
    };
    // Smooth scrolling using jQuery easing
    $('a.js-scroll-trigger[href*="#"]:not([href="#"])').click(function () {
        if (
            location.pathname.replace(/^\//, "") ==
            this.pathname.replace(/^\//, "") &&
            location.hostname == this.hostname
        ) {
            var target = $(this.hash);
            target = target.length
                ? target
                : $("[name=" + this.hash.slice(1) + "]");
            if (target.length) {
                $("html, body").animate(
                    {
                        scrollTop: target.offset().top - $('#mainNav').outerHeight() + 2,
                        // 68 = $('#mainNav').outerHeight()
                        // = nav height when coslapse
                    },
                    1000,
                    "easeInOutExpo"
                );
                return false;
            }
        }
    });
    // Closes responsive menu when a scroll trigger link is clicked
    $(".js-scroll-trigger").click(function () {
        $(".navbar-collapse").collapse("hide");
    });
    // Activate scrollspy to add active class to navbar items on scroll
    $("body").scrollspy({
        target: "#mainNav",
        offset: 74,
    });
    // Collapse now if page is not at top
    navbarCollapse();
    // Collapse the navbar when page is scrolled
    $(window).scroll(navbarCollapse);

    /* #endregion */
    //! end header scroll

    //! load aside data
    var asidebarInterval = setInterval(loadAsidebarBoxContent, 100);

    $(document).on('click', '.btn-teacher-show-login', function (event) {
        event.preventDefault();
        $('.form-box').slideToggle();
    });

    $(document).on('click', '.btn-teacher-login', function (event) {
        /* #region   */
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
        /* #endregion */
    });
    $(document).on('click', '.btn-teacher-logout', function (event) {
        /* #region   */
        event.preventDefault();
        $.ajax({
            url: '/ajax/teacher-logout',
            type: 'GET',
        })
            .done(function (data) {
                console.log(data);
                if (data.success) {
                    loadTeacherLoginBox();
                    var myInterval = setInterval(function () {
                        if ($(document).find('#teacher-login-box .form-box').length) {
                            $(document).find('#teacher-login-box .form-box').css('display', 'block');
                        }
                    }, 100);
                }
            });
        /* #endregion */
    });
    $(document).on('click', '.btn-teacher-register-course', function (event) {
        /* #region   */
        event.preventDefault();
        var courseId = $(document).find('#teacher-course-registration-box').data('course-id');
        if (!courseId) {
            alert('Error');
            return;
        }
        $.ajax({
            url: '/ajax/teacher-register-course',
            type: 'POST',
            dataType: 'json',
            data: { courseId: courseId },
        })
            .done(function (data) {
                console.log(data);
                if (data.success) {
                    reloadRegisterPageContent();
                }
            });
        /* #endregion */
    });

    // $(document).on('hv', '')

    var pageNum = 1;
    $(document).on('click', '.pagination-item', function () {
        pageNum = $(this).data('pagenum') ? $(this).data('pagenum') : 1;
        reloadListCourse();
    });

    //! teacher manager
    $('.teacher-manager form#general-form .btn-submit').on('click', function (event) {
        event.preventDefault();
        var _url = '/ajax/teacher-manager/update/general';
        var _formData = $('.teacher-manager form#general-form').serialize();
        console.log(_formData);
        ajaxTeacherManagerUpdate(_url, _formData);
    });
    $('.teacher-manager form#password-form .btn-submit').on('click', function (event) {
        event.preventDefault();
        var _url = '/ajax/teacher-manager/update/password';
        var _formData = $('.teacher-manager form#password-form').serialize();
        console.log(_formData);
        ajaxTeacherManagerUpdate(_url, _formData);
    });
    $('.teacher-manager form#education-form .btn-submit').on('click', function (event) {
        event.preventDefault();
        var _url = '/ajax/teacher-manager/update/education';
        var _formData = $('.teacher-manager form#education-form').serialize();
        console.log(_formData);
        ajaxTeacherManagerUpdate(_url, _formData);
    });
    $('.teacher-manager form#avatar-form .btn-submit').on('click', function (event) {
        event.preventDefault();
        var _url = '/ajax/teacher-manager/update/avatar';
        var _formData = $('.teacher-manager form#avatar-form').serialize();
        console.log(_formData);
        ajaxTeacherManagerUpdate(_url, _formData);
    });

    // !#function
    function loadTeacherLoginBox() {
        /* #region   */
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
        /* #endregion */
    }

    function reloadRegisterPageContent() {
        var _url = '/ajax/nhan-lop/' + 'eveniet-similique-incidunt-nam-cumque-dolorem-quas-debitis.html';
        $(document).find('#teacher-register-course-content').load(_url);
    }

    function loadAsidebarBoxContent() {
        /* #region   */
        var _asideBar = $(document).find('#asidebar');
        if (_asideBar.length) {
            console.log('aside loading...');
            clearInterval(asidebarInterval);
            var _type = _asideBar.data('type');
            $.ajax({
                url: '/ajax/load-aside-data',
                type: 'POST',
                dataType: 'json',
                data: { type: _type },
            })
                .done(function (data) {
                    if (data.success) {
                        if (data.html.teacherByCourseLevel.length) {
                            $(document).find('#asidebar-teacher-by-courselevel .asidebar-box-body')
                                .empty()
                                .append(data.html.teacherByCourseLevel);
                        }
                        if (data.html.teacherBySubject.length) {
                            $(document).find('#asidebar-teacher-by-subject .asidebar-box-body')
                                .empty()
                                .append(data.html.teacherBySubject);
                        }
                        if (data.html.support.length) {
                            $(document).find('#asidebar-support .asidebar-box-body')
                                .empty()
                                .append(data.html.support);
                        }
                    }
                });
        }
        /* #endregion */
    }

    function reloadListCourse() {
        /* #region   */
        var _contentTable = $('#list-class-page');
        $url = '/ajax/get-list-class?page=' + pageNum + '&type=' + _contentTable.data('type');
        console.log('reload ' + $url);
        // document.getElementById('list-class-page').firstElementChild.style.opacity = '0';
        _contentTable.find('.list-class-page').css('opacity', '0');
        _contentTable.load($url, function () {
            console.log('load Index');
            //scroll top
            scroll2Top();
            // document.getElementById('list-class-page').firstElementChild.style.opacity = '1';
            _contentTable.find('.list-class-page').css('opacity', '1');
        });
        /* #endregion */
    }

    function scroll2Top() {
        /* #region   */
        // document.body.scrollTop = 0;
        // document.documentElement.scrollTop = 0;
        $("#mainNav").removeClass("navbar-shrink");
        $("html, body").animate(
            {
                scrollTop: 0 - $('#mainNav').outerHeight() * 3,
            },
            1000,
            "easeInOutExpo"
        );
        /* #endregion */
    }

    function ajaxTeacherManagerUpdate(url, formData) {
        scroll2Top();
        $.ajax({
            url: url,
            type: 'POST',
            dataType: 'json',
            data: formData,
        })
            .done(function (data) {
                console.log(data);
                var _message;
                if (data.message) _message = data.message;
                showSettingAlert(data.success, _message);
            })
            .fail(function (jqXHR, textStatus, errorThrown) {
                console.log("error");
                showSettingAlert(false);
            });
    }

    function showSettingAlert($status, $message = null) {
        if ($status) {
            if ($message) {
                if (typeof $message == "string") {
                    $htm = `<div class="alert alert-success" style="display:none">
                    <i class="fas fa-check"></i>&nbsp;` + $message + `
                </div>`;
                }
                if (typeof $message == "object") {
                    $htm = `<div class="alert alert-success" style="display:none">`;
                    $.each($message, function (key, value) {
                        $htm += `<i class="fas fa-check"></i>&nbsp;` + value + `!<br>`;
                    });
                    $htm += `</div>`;
                }
            }
            else {
                $htm = `<div class="alert alert-success" style="display:none">
                    <i class="fas fa-check"></i>&nbsp;Cập nhật thành công!
                </div>`;
            }
        }
        else {
            if ($message) {
                if (typeof $message == "string") {
                    $htm = `<div class="alert alert-danger" style="display:none">
                    <i class="fas fa-info"></i>&nbsp;` + $message + `
                </div>`;
                }
                if (typeof $message == "object") {
                    $htm = `<div class="alert alert-danger" style="display:none">`;
                    $.each($message, function (key, value) {
                        $htm += `<i class="fas fa-info"></i>&nbsp;` + value + `!<br>`;
                    });
                    $htm += `</div>`;
                }
            }
            else {
                $htm = `<div class="alert alert-danger" style="display:none">
                    <i class="fas fa-info"></i>&nbsp;Cập nhật thât bại!
                </div>`;
            }
        }
        var _alert = $(document).find('.teacher-manager .setting-alert');
        _alert.empty().append($htm);
        // var _myIntervalShow = setInterval(function () {
            _alert.find('.alert').slideDown();
            // clearInterval(_myIntervalShow);
        // }, 999);
        var _myIntervalHide = setInterval(function () {
            _alert.find('.alert').slideUp('slow');
            clearInterval(_myIntervalHide);
        }, 4000);
    }
});
