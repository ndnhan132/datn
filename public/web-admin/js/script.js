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

    // ! pagination
    $(document).on('change', '.footer-control select.record_per_page', function (event) {
        event.preventDefault();
        showSpinner();
        console.log($(this).val());
        var _inputRecordPerPage = $(document).find('#page-control-form input[name=record_per_page]');
        if (_inputRecordPerPage) {
            _inputRecordPerPage.val($(this).val());
        }
        setPageNum(1);
        reloadMainTable();
    });
    $(document).on('change', 'select.teacher_account_status', function (event) {
        event.preventDefault();
        showSpinner();
        console.log($(this).val());
        var _inputTeacherAccountStatus = $(document).find('#page-control-form input[name=teacher_account_status]');
        if (_inputTeacherAccountStatus) {
            _inputTeacherAccountStatus.val($(this).val());
        }
        setPageNum(1);
        reloadMainTable();
    });
    $(document).on('change', 'select.teacher_level', function (event) {
        event.preventDefault();
        showSpinner();
        console.log($(this).val());
        var _inputTeacherLevel = $(document).find('#page-control-form input[name=teacher_level]');
        if (_inputTeacherLevel) {
            _inputTeacherLevel.val($(this).val());
        }
        setPageNum(1);
        reloadMainTable();
    });
    // ! end pagination
    $(document).on('keypress', '#form-search', function (e) {
        if (e.keyCode == 13) {
            e.preventDefault();
            return false;
          }
    });
    $(document).on('change', '#form-search select[name=search_criterion]', function (event) {
        event.preventDefault();
        var _btnSearch = $(document).find('#form-search .btn-submit');
        if ($(this).val() == '') {
            _btnSearch.hide();
            $(document).find('#page-control-form input[name=is_search]').val(0);
        } else {
            _btnSearch.show();
            $(document).find('#page-control-form input[name=is_search]').val(1);
        }
    });
    $(document).on('click', '#form-search .btn-submit', function (event) {
        event.preventDefault();
        showSpinner();
        setPageNum(1);
        reloadMainTable();
    });
    // ! teacher account manager
    $(document).on('click', '.footer-control .pag-link', function (event) {
        event.preventDefault();
        showSpinner();
        setPageNum($(this).data('pagenum'));
        reloadMainTable();
    });
    // ! end teacher account manager

    // # function

    function reloadMainTable() {
        $url = pathName + '/ajax/index';
        var queryString = $('#page-control-form').serialize();
        if (queryString.length) {
            $url += '?' + queryString;
        }
        if ($('#page-control-form').find('input[name=is_search]').length) {
            var isSearch = $('#page-control-form').find('input[name=is_search]').val();
            if(isSearch){
                var searchString = $('#form-search').serialize();
                if (queryString.length) {
                    $url += '&' + searchString;
                }
            }
        }
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
        var _inputPageNum = $(document).find('input[name=page]');
        if (_inputPageNum) {
            _inputPageNum.val(num);
        }
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
