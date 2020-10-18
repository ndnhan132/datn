$(function () {
    $(document).on('click', '.course-btn-detail', function() {
        var courseId = ($(this).data('course-id')) ? $(this).data('course-id') : '';
        var $_modal = $('#js-modal-course-detail');
        $_modal.find('.modal-body').empty();
        $.ajax({
            type: 'GET',
            url: '/quan-ly/khoa-hoc/ajax/show/' + courseId,
        })
        .done(function (data) {
            $_modal.find('.modal-body').append(data.html)
            $_modal.modal('show');
        })
        .fail(function (jqXHR, textStatus, errorThrown) {
             //    msgErrors(errorThrown);
            })
        .always(function () {
            // hideSpinner();
        });
    });

});

// $.ajax({
// type: 'GET',
// url: '/',
// })
// .done(function(data) {
// })
// .(function (jqXHR, textStatus, errorThrown) {
// msgErrors(errorThrown);
// }).always(function () {
// hideSpinner();
// });
