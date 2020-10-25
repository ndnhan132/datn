showSpinner();
var myInterval = setInterval(hideSpinner, 2000);
function showSpinner() {
    $('#spinner').css('display', 'block');
    var myInterval = setInterval(hideSpinner, 5000);
}
function hideSpinner() {
    $('#spinner').css('display', 'none');
    clearInterval(myInterval);
}
function fadeInContentTable()
{
    document.getElementById('content-table').firstElementChild.style.opacity = '1';
}
function fadeOutContentTable()
{
    document.getElementById('content-table').firstElementChild.style.opacity = '0';
}

$(document).ready(function () {
    $.ajaxSetup({
        headers: {
            'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
        }
    });
});

$(function () {
    var pageNum = 1;
    var pathName = window.location.pathname;
    reloadMainTable();
    $(document).on('click', '.btn-table-reload', function () {
        showSpinner();
        reloadMainTable();
    });


    $(document).on('click', '.pagination-item', function () {
        showSpinner();
        setPageNum($(this).data('pagenum'));
        reloadMainTable();
    });

    $(document).on('click', '.btn-detail', function () {
        var type = ($(this).data('type')) ? $(this).data('type') : '';
        var url = '';
        switch (type) {
            case 'course':
                var courseId = ($(this).data('course-id')) ? $(this).data('course-id') : '';
                var canConfirm = ($(this).data('can-confirm') == 'yes') ? 'yes' : 'no';
                url = '/quan-ly/khoa-hoc/ajax/show/' + courseId + '?can-confirm=' + canConfirm;
                break;
        }

        showDetailModal(url);
    });

    // # function

    function reloadMainTable() {
        $url = pathName + '/ajax/index?page=' + pageNum;
        console.log('reload ' + $url);
        var _contentTable = $('#content-table');
        fadeOutContentTable();
        _contentTable.load($url, function () {
            console.log('load Index');
            hideSpinner();
            fadeInContentTable();
        });
    }
    function setPageNum(num) {
        pageNum = num;
    }
    function showDetailModal(url) {
        showSpinner();
        var _modal = $('#js-modal-detail');
        _modal.find('.modal-body').empty();
        $.ajax({
            type: 'GET',
            url: url,
        })
        .done(function (data) {
            _modal.find('.modal-body').append(data.html)
            _modal.modal('show');
            hideSpinner();
        })
        .fail(function (jqXHR, textStatus, errorThrown) {
             //    msgErrors(errorThrown);
            });
    }
});

// $.ajax({
//   url: '/',
//   type: 'POST',
//   dataType: 'json',
//   data: {param1: 'value1'},
// })
// .done(function(data) {
//   console.log("success");
// })
// .fail(function(jqXHR, textStatus, errorThrown) {
//   console.log("error");
// })
// .always(function(data|jqXHR, textStatus, jqXHR|errorThrown ) {
//   console.log("complete");
// });
