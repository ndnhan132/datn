$(function () {
    var courseTableHtml = '';

    $(document).on('click', '.teacher-course-registration .btn-display-teacher', function () {
        setCourseTableHtml();
        if ($(this).data('course-id')) {
            loadTeacherRegistrationTable($(this).data('course-id'));
        }
    });

    $(document).on('click', '.teacher-course-registration .btn-back-to-main-table', function () {
        $('.teacher-course-registration#content-table').empty().append(courseTableHtml);
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
        $url = '/quan-ly/dang-ky-nhan-lop/ajax/get-teacher-registration/' + courseId;
        $('#content-table').load($url, function () {
            console.log('registration table');
        });
    }
});
