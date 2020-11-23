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

function msgErrors(msg) {
    if (!msg) {
        msg = "Có lỗi xảy ra !"
    }

    Swal.fire({
        icon: 'error',
        title: 'Oops...',
        text: msg,
    });
    hideSpinner();
}
function msgSuccess(msg = null) {
    if(!msg) msg = 'Thành công.'
    Swal.fire({
        title: msg,
        icon: 'success',
        showConfirmButton: false,
        timer: 1500
    });
    hideSpinner();
}
function showAjaxErrors(errors) {
    var alertHtml = "<div>";
    $.each(errors, function (key, value) {
        alertHtml += '<div class = "alert alert-danger py-2 px-2" style = "float: left;width: calc(100% - 0px);margin-left: 0px;">' +
            '- ' + value + '<button type="extutton" class="close d-none" data-dismiss="alert">×</button >' +
            '</div>';
    });
    alertHtml += '</div>'
    Swal.fire({
        title: 'Invalid Data',
        html: alertHtml,
        focusConfirm: false,
    })
    hideSpinner();
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
            case 'teacher':
                var teacherId = ($(this).data('teacher-id')) ? $(this).data('teacher-id') : '';
                url = '/quan-ly/giao-vien/ajax/show/' + teacherId;
                break;
        }

        showDetailModal(url);
    });

    $(document).on('click', '.post-manager .btn-delete', function () {
        var _confirm = confirm('Xoá sẽ không khôi phục được. Chắc chắn xoá!');
        if (_confirm) {
            showSpinner();
            $.ajax({
                type: 'POST',
                url: '/quan-ly/bai-viet/ajax/delete',
                datatype: 'json',
                data: { id: $(this).data('id')}
            })
            .done(function (data) {
                console.log(data);
                if (data.success) {
                    msgSuccess('Xoá thành công.');
                    reloadMainTable();
                }
                hideSpinner();
            })
            .fail(function (jqXHR, textStatus, errorThrown) {
                msgErrors(errorThrown);
                hideSpinner();
               });
        }
    });

    $(document).on('click', '.post-manager .btn-edit', function () {
        var _postId = $(this).data('id');
        if (_postId) {
            var _contentTable = $('#content-table');
            fadeOutContentTable();
            showSpinner();
            $.ajax({
                type: 'POST',
                url: '/quan-ly/bai-viet/ajax/get-update',
                datatype: 'json',
                data: { id: _postId }
            })
            .done(function (data) {
                console.log(data);
                if (data.success) {
                    _contentTable.empty().append(data.html);
                    hideSpinner();
                    fadeInContentTable();
                }
                hideSpinner();
            })
            .fail(function (jqXHR, textStatus, errorThrown) {
                msgErrors(errorThrown);
                hideSpinner();
               });
        }
    });

    $(document).on('click', '.post-manager #js-form-update .btn-submit', function (event) {
        var form = document.getElementById('js-form-update');
        var content = CKEDITOR.instances['input-content'].getData();
        var formData = new FormData(form);
        formData.append('content' , content);
        $.ajax({
            type: "POST",
            url: "/quan-ly/bai-viet/ajax/post-update",
            data: formData,
            dataType: "text",
            contentType: false,
            processData: false,
        })
            .done(function (data) {
                data = JSON.parse(data);
                if (data.success) {
                    msgSuccess('Cập nhật thành công');
                    loadPageTable();
                } else {
                    msgErrors();
                }
                hideSpinner();
            })
            .fail(function (jqXHR, textStatus, errorThrown) {
                msgErrors();
                hideSpinner();
                console.log(errorThrown);
            });
    });

    $(document).on('click', '.btn-post-create', function () {
        var _contentTable = $('#content-table');
        fadeOutContentTable();
        showSpinner();
        $.ajax({
            type: 'GET',
            url: '/quan-ly/bai-viet/ajax/get-create',
        })
        .done(function (data) {
            console.log(data);
            if (data.success) {
                _contentTable.empty().append(data.html);
                hideSpinner();
                fadeInContentTable();
            }
            hideSpinner();
        })
        .fail(function (jqXHR, textStatus, errorThrown) {
            msgErrors(errorThrown);
            hideSpinner();
           });
    });

    $(document).on('click', '.post-manager #js-form-create .btn-submit', function (event) {
        var form = document.getElementById('js-form-create');
        var content = CKEDITOR.instances['input-content'].getData();
        var formData = new FormData(form);
        formData.append('content' , content);
        $.ajax({
            type: "POST",
            url: "/quan-ly/bai-viet/ajax/post-store",
            data: formData,
            dataType: "text",
            contentType: false,
            processData: false,
        })
            .done(function (data) {
                data = JSON.parse(data);
                if (data.success) {
                    msgSuccess('Tạo thành công');
                    loadPageTable();
                } else {
                    msgErrors();
                }
                hideSpinner();
            })
            .fail(function (jqXHR, textStatus, errorThrown) {
                msgErrors();
                hideSpinner();
                console.log(errorThrown);
            });
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
