$(function () {
    var courseTableHtml = '';

    $(document).on('click', '.teacher-course-registration .btn-display-teacher', function () {
        setCourseTableHtml();
        if ($(this).data('course-id')) {
            loadTeacherRegistrationTable($(this).data('course-id'));
        }
    });

    $(document).on('click', '.teacher-course-registration .btn-back-to-main-table', function () {
        // $('.teacher-course-registration#content-table').empty().append(courseTableHtml); // clone html
        $(document).find('.btn-table-reload').click(); // ajax reload table
    });

    $(document).on('click', '.teacher-course-registration .registration-btn-compare', function(){
        var registrationId = ($(this).data('registration-id')) ? $(this).data('registration-id') : '';
        if(registrationId != '') {
            registrationCompareTeacherVsCourse(registrationId);
        }
    });

    $(document).on('click', '#js-teacher-course-registration-compare .btn-confirm', function () {
        var registrationStatus = $(this).data('status');
        var registrationId = $(this).data('registration-id');
        var courseId = $(this).data('course-id');
        if (registrationStatus && registrationId) {
            confirmStatus(registrationStatus,  registrationId, courseId);
        }
    });


    //* #function

    function setCourseTableHtml() {
        courseTableHtml = $('.teacher-course-registration#content-table').html();
        // courseTableHtml = $('#js-teacher-course-registration-table').parent().html();
    }

    function getCourseTableHtml() {
        $('.teacher-course-registration#content-table').empty().append(courseTableHtml);
    }

    function loadTeacherRegistrationTable(courseId) {
        showSpinner();
        fadeOutContentTable();
        $url = '/quan-ly/dang-ky-nhan-lop/ajax/get-teacher-registration/' + courseId;
        $('#content-table').load($url, function () {
            console.log('registration table');
            hideSpinner();
            fadeInContentTable();
        });
    }

    function registrationCompareTeacherVsCourse(registrationId) {
        showSpinner();
        var _modal = $(document).find('#js-modal-course-registration-compare');
        _modal.find('.modal-body').empty();
        $.ajax({
            url: '/quan-ly/dang-ky-nhan-lop/ajax/compare/' + registrationId,
            type: 'GET',
        })
        .done(function(data) {
            _modal.find('.modal-body').append(data.html)
            _modal.modal('show');
            // $(document).find('.btn-modal-dismiss').click();
            // $(document).find('.btn-table-reload').click();
            hideSpinner();
        })
        .fail(function(jqXHR, textStatus, errorThrown) {
            console.log("error");
        })
        .always(function() {
        });
    }

    function confirmStatus(registrationStatus, registrationId, courseId) {
        showSpinner();
        $.ajax({
            url: '/quan-ly/dang-ky-nhan-lop/ajax/confirm-status',
            type: 'POST',
            dataType: 'json',
                data: {
                    registrationStatus: registrationStatus,
                    registrationId: registrationId,
                },
        })
            .done(function (data) {
                console.log(data);
                if (data.success) {
                    loadTeacherRegistrationTable(courseId);
                } else {
                    alert(data.message);
                }
                $(document).find('.btn-modal-dismiss').click();
                showSpinner();
        })
        .fail(function(jqXHR, textStatus, errorThrown) {
            console.log("error");
        })
        .always(function() {
        });
    }
});
