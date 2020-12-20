showSpinner();
var myInterval = setInterval(hideSpinner, 2000);
function showSpinner() {
    $('#spinner').css('display', 'block');
    $(document).find('body').addClass('hover_cursor_progress');
    var myInterval = setInterval(hideSpinner, 5000);
}
function hideSpinner() {
    $('#spinner').css('display', 'none');
    $(document).find('body').removeClass('hover_cursor_progress');
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

function msgErrors(msg = null) {
    if (!msg) {
        msg = "Có lỗi xảy ra !"
    }

    Swal.fire({
        icon: 'error',
        // title: 'Oops...',
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
        title: 'Dữ liệu khồng hợp lệ!',
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
    $(document).on('click', '.btn-table-reset-reload', function () {
        showSpinner();
        if(document.getElementById("page-control-form")){
            document.getElementById("page-control-form").reset();
        }
        if(document.getElementById("form-search")){
            document.getElementById("form-search").reset();
        }
        $("#page-control-form input[type=hidden]").val('');
        $('#page-control-form option').attr('selected', false);
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
                case 'parentregister':
                    var parentRegisterId = ($(this).data('parentregister-id')) ? $(this).data('parentregister-id') : '';
                    url = '/quan-ly/phu-huynh-dang-ky/ajax/show/' + parentRegisterId;
                    break;
        }

        showDetailModal(url);
    });


    // ! post
    $(document).on('click', '.post-manager .btn-delete', function () {
        var _confirm = confirm('Xóa sẽ không khôi phục được. Chắc chắn xóa!');
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
                    msgSuccess('Xóa thành công.');
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
        event.preventDefault();
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
                if(typeof data == "string"){
                    data = JSON.parse(data);
                }
                console.log(data.message);
                console.log(data);
                if (data.success) {
                    msgSuccess('Cập nhật thành công');
                    reloadMainTable();
                } else {
                    if(data.message){
                        showAjaxErrors(data.message);
                    }else{
                        msgErrors();
                    }
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
        event.preventDefault();
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
                    reloadMainTable();
                } else {
                    if(data.message){
                        showAjaxErrors(data.message);
                    }else{
                        msgErrors();
                    }
                }
                hideSpinner();
            })
            .fail(function (jqXHR, textStatus, errorThrown) {
                msgErrors();
                hideSpinner();
                console.log(errorThrown);
            });
    });
    $(document).on('change', 'select.select_category', function (event) {
        event.preventDefault();
        showSpinner();
        console.log($(this).val());
        var _input_select_category = $(document).find('#page-control-form input[name=select_category]');
        if (_input_select_category) {
            _input_select_category.val($(this).val());
        }
        setPageNum(1);
        reloadMainTable();
    });
    // !end  post

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


    //! Teacher
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
    // ! end Teacher

    // ! course
    $(document).on('change', 'select.is_received', function (event) {
        event.preventDefault();
        showSpinner();
        console.log($(this).val());
        var _inputIsReceived = $(document).find('#page-control-form input[name=is_received]');
        if (_inputIsReceived) {
            _inputIsReceived.val($(this).val());
        }
        setPageNum(1);
        reloadMainTable();
    });

    $(document).on('change', 'select.course_status', function (event) {
        event.preventDefault();
        showSpinner();
        console.log($(this).val());
        var _inputCourseStatus = $(document).find('#page-control-form input[name=course_status]');
        if (_inputCourseStatus) {
            _inputCourseStatus.val($(this).val());
        }
        setPageNum(1);
        reloadMainTable();
    });
    $(document).on('change', 'select.select_subject', function (event) {
        event.preventDefault();
        showSpinner();
        console.log($(this).val());
        var _inputSelectSubject = $(document).find('#page-control-form input[name=select_subject]');
        if (_inputSelectSubject) {
            _inputSelectSubject.val($(this).val());
        }
        setPageNum(1);
        reloadMainTable();
    });
    $(document).on('change', 'select.select_course_level', function (event) {
        event.preventDefault();
        showSpinner();
        console.log($(this).val());
        var _inputSelectCourseLevel = $(document).find('#page-control-form input[name=select_course_level]');
        if (_inputSelectCourseLevel) {
            _inputSelectCourseLevel.val($(this).val());
        }
        setPageNum(1);
        reloadMainTable();
    });

    $(document).on('click', '.btn-course-create', function (event) {
        event.preventDefault();
        var _modal = $(document).find('.modal-create-course');
        if (_modal.length) {
            _modal.find('select[name="course_level"').val('');
            _modal.find('input[name="course_id"').val('');
            _modal.find('select[name="subject"').val('');
            _modal.find('input[name="tuition_per_session"').val('');
            _modal.find('.coursealert').text('');
            _modal.modal('show');
        }
    });
    $(document).on('click', '.btn-course-edit', function (event) {
        event.preventDefault();
        var courseId = $(this).data('id');
        $.ajax({
            type: 'GET',
            url: '/quan-ly/khoa-hoc/ajax/get-course-by-id?courseid=' +  courseId,
        })
            .done(function (data) {
                console.log(data);
                if (data.success && data.data) {
                    $('.new-course-form input[name=course_id]').val(data.data.id);
                    $('.new-course-form select[name=course_level]').val(data.data.course_level_id);
                    $('.new-course-form select[name=subject]').val(data.data.subject_id);
                    $('.new-course-form input[name=tuition_per_session]').val(data.data.tuition_per_session);
                    $('.new-course-form .coursealert').text('* Lớp đã tồn tại : chỉnh sửa');
                    var _modal = $(document).find('.modal-create-course');
                    if (_modal.length) {
                        _modal.modal('show');
                    }
                }
            hideSpinner();
        })
        .fail(function (jqXHR, textStatus, errorThrown) {
            //    msgErrors(errorThrown);
            msgErrors();
            hideSpinner();
        });


    });

    $(document).on('change', '.new-course-form select.selectOnChange', function (event) {
        event.preventDefault();
        var _course_level = $('.new-course-form select[name=course_level]').val();
        var _subject = $('.new-course-form select[name=subject]').val();
        console.log(_course_level, _subject);
        if(_course_level && _subject) {
            showSpinner();
            $.ajax({
                type: 'GET',
                url: '/quan-ly/khoa-hoc/ajax/get-course-by-courselevel-and-subject?courselevel=' +  _course_level + '&subject=' + _subject,
            })
                .done(function (data) {
                    console.log(data);
                    if (data.success && data.data) {
                        $('.new-course-form input[name=course_id]').val(data.data.id);
                        $('.new-course-form input[name=tuition_per_session]').val(data.data.tuition_per_session);
                        $('.new-course-form select[name="session_per_week"]').empty().append('<option value="' + data.data.session_per_week + '">' + data.data.session_per_week + '</option>');
                        $('.new-course-form .coursealert').text('* Lớp đã tồn tại : chỉnh sửa');
                    }else{
                        // msgErrors();
                        $('.new-course-form input[name=course_id]').val();
                        $('.new-course-form input[name=tuition_per_session]').val('');
                        $('.new-course-form .coursealert').text('* Lớp chưa tồn tại: tạo mới');
                    }
                hideSpinner();
            })
            .fail(function (jqXHR, textStatus, errorThrown) {
                //    msgErrors(errorThrown);
                msgErrors();
                hideSpinner();
            });
        }
    });

    $(document).on('click', '.new-course-form button[type="submit"]', function (event) {
        event.preventDefault();
        var _course_level = $('.new-course-form select[name=course_level]').val();
        var _subject = $('.new-course-form select[name=subject]').val();
        var _course_id = $('.new-course-form select[name=course_id]').val();
        console.log(_course_level, _subject, _course_id);
        if(_course_level && _subject) {
            showSpinner();
            var formData = $('.new-course-form').serialize();
            $.ajax({
                type: 'POST',
                url: '/quan-ly/khoa-hoc/ajax/update-course',
                type: 'POST',
                dataType: 'json',
                data: formData,
            })
                .done(function (data) {
                    console.log(data);
                    if (data.success) {
                        msgSuccess('Lưu thành công')
                    }else{
                            msgErrors();
                    }
                    reloadMainTable();
                    hideSpinner();
                    $(document).find('.modal-create-course').modal('hide');
            })
            .fail(function (jqXHR, textStatus, errorThrown) {
                //    msgErrors(errorThrown);
                $(document).find('.modal-create-course').modal('hide');
                msgErrors();
                hideSpinner();
            });
        }
    });

    // ! end course
    // ! enquiry
    $(document).on('change', 'select.enquiry_status', function (event) {
        event.preventDefault();
        showSpinner();
        console.log($(this).val());
        var _inputEnquiryStatus = $(document).find('#page-control-form input[name=enquiry_status]');
        if (_inputEnquiryStatus) {
            _inputEnquiryStatus.val($(this).val());
        }
        setPageNum(1);
        reloadMainTable();
    });
    $(document).on('click', '.btn-enquiry-detail', function (event) {
        event.preventDefault();
        showSpinner();
        var _enquiry = $(this).data('enquiry');
        if (_enquiry) {
            var _modal = $(document).find('.modal-enquiry-detail');
            _modal.find('.field-val').empty();
            $.ajax({
                type: 'GET',
                url: '/quan-ly/lien-he/ajax/show/'+ _enquiry,
            })
                .done(function (data) {
                    if (data.success && data.data) {
                        $('.field-val-name').text(data.data.name);
                        $('.field-val-phone').text(data.data.phone);
                        $('.field-val-email').text(data.data.email);
                        $('.field-val-content').text(data.data.content);
                        if (data.data.flag_is_checked) {
                        $('.field-val-status').text("Đã xử lý");
                        } else {
                        $('.field-val-status').text("Chưa xử lý");
                        }
                    _modal.modal('show');
                }else{
                        msgErrors();
                }

            hideSpinner();
        })
        .fail(function (jqXHR, textStatus, errorThrown) {
            //    msgErrors(errorThrown);
            msgErrors();
            hideSpinner();
        });
    }
    });

    $(document).on('click', '.btn-change-post-status', function (event) {
        event.preventDefault();
        var _recordId = $(this).data('record-id');
        if(!isNaN(_recordId) && _recordId > 0) {
            Swal.fire({
                title: 'Thay đổi trạng thái?',
                showDenyButton: true,
                // showCancelButton: true,
                confirmButtonText: 'Đã xử lý',
                denyButtonText: 'Chưa xử lý',
            }).then((result) => {
                if (result.isConfirmed) {
                    changePostStatus(_recordId, 'YES');
                } else if (result.isDenied) {
                    changePostStatus(_recordId, 'NO');
                }
            });
        }
    });

    // ! end enquiry

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
            // _btnSearch.hide();
            $(document).find('#page-control-form input[name=is_search]').val(0);
        } else {
            // _btnSearch.show();
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


    // ! teacher course registration
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
            Swal.fire({
                title: 'Chắc chắn thay đổi trạng thái.',
                showDenyButton: true,
                confirmButtonText: `Chắc chắn`,
                denyButtonText: 'Huỷ',
            }).then((result) => {
                if (result.isConfirmed) {
                    confirmStatus(registrationStatus,  registrationId, courseId);
                }
            });
        }
    });

    $(document).on('change', 'select.select_registration_status', function (event) {
        event.preventDefault();
        showSpinner();
        console.log($(this).val());
        var _inputregistration_status = $(document).find('#page-control-form input[name=select_registration_status]');
        if (_inputregistration_status) {
            _inputregistration_status.val($(this).val());
        }
        setPageNum(1);
        reloadMainTable();
    });

    // ! end teacher course registration

    // ! delete record
    $(document).on('click', '.btn-delete-record', function (event) {
        Swal.fire({
            title: 'Chắc chắn xóa.',
            showDenyButton: true,
            confirmButtonText: `Chắc chắn`,
            denyButtonText: 'Huỷ',
        }).then((result) => {
            if (result.isConfirmed) {
                var _recordId = $(this).data('record-id');
                console.log(isNaN(_recordId));
                if (!isNaN(_recordId) && _recordId > 0) {
                    deleteRecord(_recordId);
                }
            }
        });
    });







    // !# function

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
                    msgSuccess('Thay đổi trạng thái thành công.');
                    reloadMainTable();
                } else {
                    msgErrors(data.message);
                }
                $(document).find('.btn-modal-dismiss').click();
                hideSpinner();
            })
            .fail(function (jqXHR, textStatus, errorThrown) {
                msgErrors();
            })
        .always(function() {
        });
    }

    function deleteRecord(recordId) {
        $url = pathName + '/ajax/delete';
        console.log('delete ' + $url);
        showSpinner();

        $.ajax({
            url: $url,
            type: 'POST',
            dataType: 'json',
            data: { recordId: recordId },
        })
            .done(function (data) {
                console.log(data);
                if (data.success) {
                    msgSuccess('Xóa thành công.');
                } else {
                    msgErrors((data.message ? data.message : ''));
                }
            })
            .fail(function (jqXHR, textStatus, errorThrown) {
                msgErrors();
            }).always(function () {
                reloadMainTable();
                hideSpinner();
            });
    }

    function changePostStatus(_recordId, _newStatus)
    {
        showSpinner();
        $.ajax({
            type: 'POST',
            url: '/quan-ly/lien-he/ajax/change-status',
            dataType: 'json',
            data: {
                recordId: _recordId,
                isChecked: _newStatus,
            },
        })
            .done(function (data) {
                if(data.success){
                    msgSuccess('Thay đổi thành công.');
                } else if(data.message){
                    msgErrors(data.message ? data.message : '');
                }
            })
            .fail(function (jqXHR, textStatus, errorThrown) {
                msgErrors();
            })
            .always(function () {
                hideSpinner();
                reloadMainTable();
            });
    }
});
