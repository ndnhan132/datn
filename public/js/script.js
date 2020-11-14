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
    }
});
