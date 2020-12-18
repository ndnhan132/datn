@extends('front.layouts.app')
@section('title', 'Trang chủ')
@section('head')
@endsection
@section('content')
<div class="form-wrap mb-4">
    <form id="course-register-form" method="post">
        @csrf
        <div class="form-alert">
        </div>
        <div class="row d-flex flex-wrap">

            <div class="form-group col-sm-12 d-flex flex-wrap">
                <fieldset class="w-100">
                    <legend class="col-sm-12 label-title text_georgia">Thông tin liên hệ</legend>
                    <div class="form-group col-sm-12 row">
                        <label class="text-nowrap col-sm-4 col-md-3">Họ tên <span class="text-danger">(*)</span></label>
                        <div class="col-sm-8 col-sm-8 col-lg-7">
                        <input type="text" class="form-control" name="fullname" value="">
                        </div>
                    </div>
                    <div class="form-group col-sm-12 row">
                        <label class="text-nowrap col-sm-4 col-md-3">Số điện thoại <span class="text-danger">(*)</span></label>
                        <div class="col-sm-8 col-sm-8 col-lg-7">
                            <input type="text" class="form-control" name="phone" value="">
                        </div>
                    </div>
                    <div class="form-group col-sm-12 row">
                        <label class="text-nowrap col-sm-4 col-md-3">Email <span class="text-danger">(*)</span></label>
                        <div class="col-sm-8 col-sm-8 col-lg-7">
                            <input type="text" class="form-control" name="email" value="">
                        </div>
                    </div>
                    <div class="form-group col-sm-12 row">
                        <label class="text-nowrap col-sm-4 col-md-3">Địa chỉ <span class="text-danger">(*)</span></label>
                        <div class="col-sm-8 col-sm-8 col-lg-7">
                            <input type="text" class="form-control" name="address" value="">
                        </div>
                    </div>
                </fieldset>
            </div>

            <div class="form-group col-sm-12 d-flex flex-wrap">
                <fieldset class="w-100">
                    <legend class="col-sm-12 label-title text_georgia">Thông tin lớp học</legend>
                    <div class="form-group col-sm-12 row">
                        <label class="text-nowrap col-sm-4 col-md-3">Khối lớp</label>
                        <div class="col-sm-8 col-sm-8 col-lg-7">
                            <select name="course_level" class="form-control">
                                <option value="">Lựa chọn</option>
                                @foreach ($courseLevels as $item)
                                    <option value="{{$item->id}}">{{$item->display_name}}</option>
                                @endforeach
                            </select>
                        </div>
                    </div>
                    <div class="form-group col-sm-12 row">
                        <label class="text-nowrap col-sm-4 col-md-3">Môn học</label>
                        <div class="col-sm-8 col-sm-8 col-lg-7">
                            <select name="subject" class="form-control">
                            </select>
                        </div>
                    </div>
                    <div class="form-group col-sm-12 row">
                        <label class="text-nowrap col-sm-4 col-md-3">Học phí/buổi</label>
                        <div class="col-sm-8 col-sm-8 col-lg-7">
                            <input type="text" class="form-control" name="tuition_per_session" value="" readonly>
                        </div>
                    </div>
                    <div class="form-group col-sm-12 row">
                        <label class="text-nowrap col-sm-4 col-md-3">Số buổi/Tuần</label>
                        <div class="col-sm-8 col-sm-8 col-lg-7">
                            <input type="text" class="form-control" name="session_per_week" value="" readonly>
                        </div>
                    </div>
                    <div class="form-group col-sm-12 row">
                        <label class="text-nowrap col-sm-4 col-md-3">Thời gian dạy <span class="text-danger">(*)</span></label>
                        <div class="col-sm-8 col-sm-8 col-lg-7">
                            <input type="text" class="form-control" name="time_working" value="">
                            <span class="text-muted">*(VD: Tối T2-T7)</span>
                        </div>
                    </div>
                    <input type="hidden" name="select_course">
                    <input type="hidden" name="select_teacher">

                </fieldset>
            </div>

            <div  id="teacher_table" style="display: none" class="w-100">
            <div class="form-group col-sm-12 d-flex flex-wrap">
                <fieldset class="w-100">
                    <legend class="col-sm-12 label-title text_georgia">Đề cử gia sư</legend>
                    <div class="form-group col-sm-12 row">
                        <div class="table-responsive">
                            <table class="table table-striped table-bordered">
                                <thead class="bg-primary text-white">
                                    <tr class="text-nowrap">
                                        <th>Ảnh</th>
                                        <th>Họ tên</th>
                                        <th>Thông tin</th>
                                        <th class="text-center">Trạng thái</th>
                                    </tr>
                                </thead>
                                <tbody>
                                </tbody>
                            </table>
                        </div>
                    </div>
                </fieldset>
            </div>
        </div>

        </div>
        {{-- <input id="prarent_register_class_course_id" type="hidden" value="" name="course">
        <input id="prarent_register_class_teacher_id" type="hidden" value="" name="teacher"> --}}
        {{-- <div class="w-100 d-flex py-4">
            <a href="#" class="btn btn-info rounded-pill text-uppercase px-5 mx-auto btn-submit">Gửi đăng ký</a>
        </div> --}}
    </form>
</div>
<div class="modal fade modal-custom" id="js-modal-detail-teacher" tabindex="-1"
	role="dialog">
	<div class="modal-dialog" role="document">
		<div class="modal-content rounded-0">
			<div class="modal-header py-2 border-bottom-0 bg-primary rounded-0">
				<h5 class="modal-title text-white" id="exampleModalLabel"><i class="fa fa-info-circle"></i> Chi tiết giáo viên</h5>
				<button type="button" class="close" data-dismiss="modal"
					aria-label="Close">
					<span aria-hidden="true">&times;</span>
				</button>
			</div>
			<div class="modal-body py-0 my-3">

			</div>
		</div>
	</div>
</div>
@endsection

@section('javascript')
<script type="text/javascript">
    $(document).on('change', 'select[name="course_level"]', function() {
        var _course_level = $(this).val();
        $(document).find('select[name=subject]').empty();
        $(document).find('input[name=tuition_per_session]').val('');
        $(document).find('input[name=session_per_week]').val('');
        $(document).find('input[name=select_course]').val('');
        $(document).find('body').addClass('hover_cursor_progress');
        $(document).find('#teacher_table tbody').empty();
        $(document).find('#teacher_table').slideUp();
        if(_course_level){
            $.ajax({
                url: '/front/ajax/course/get-subject-by-courselevel?courselevel=' + _course_level,
                type: 'GET',
            })
            .done(function (data) {
                console.log(data);
                if(data.success){
                    if(data.data.length){
                        $(document).find('select[name=subject]').append('<option value=""></option>');
                        data.data.forEach(function(item, index, array) {
                            $(document).find('select[name=subject]').append('<option value="' + item.subject_id + '">' +  item.subject_name + '</option>');
                        });
                    }else{
                        Swal.fire({
                            icon: 'error',
                            text: 'Hiện chưa có lớp này',
                        });
                    }
                }else{
                    Swal.fire({
                            icon: 'error',
                            text: 'Có lỗi xảy ra',
                        });
                }
            $(document).find('body').removeClass('hover_cursor_progress');
            }).fail(function (jqXHR, textStatus, errorThrown) {
                console.log("error");
                alert(errorThrown);
                $(document).find('body').removeClass('hover_cursor_progress');
                Swal.fire({
                            icon: 'error',
                            text: 'Có lỗi xảy ra',
                        });
            })
            .always(function (data, textStatus, errorThrown) {
                console.log("complete");
                $(document).find('body').removeClass('hover_cursor_progress');
            });
        }
    });

    $(document).on('change', 'select[name="subject"]', function() {
        var _subject = $(this).val();
        var _course_level = $(document).find('select[name=course_level]').val();
        console.log(_course_level, _subject);
        $(document).find('input[name=tuition_per_session]').val('');
        $(document).find('input[name=session_per_week]').val('');
        $(document).find('input[name=select_course]').val('');
        $(document).find('body').addClass('hover_cursor_progress');
        $(document).find('#teacher_table tbody').empty();
        $(document).find('#teacher_table').slideUp();
        if(_course_level && _subject){
            $.ajax({
                url: '/front/ajax/course/get-course-by-courselevel-and-subject?courselevel=' + _course_level + '&subject=' + _subject,
                type: 'GET',
            })
            .done(function (data) {
                console.log(data);
                if(data.success){
                    console.log(data.data);
                    if(data.data){
                        $(document).find('input[name=tuition_per_session]').val(data.data.tuition_per_session);
                        $(document).find('input[name=session_per_week]').val(data.data.session_per_week);
                        $(document).find('input[name=select_course]').val(data.data.id);
                        console.log(data.teacher.length);
                        if(data.teacher.length){
                            $(document).find('#teacher_table').slideDown();
                            data.teacher.forEach(function(item, index, array) {
                                var row = `
                                <tr>
                                        <td class="p-1"><img src="` + item.teacher_avatar + `" alt="Hình ảnh đại diện" width="50" height="70">
                                    </td>
                                    <td class="text-capitalize align-middle p-1 text-nowrap">
                                        <span>` + item.teacher_name + `</span>
                                    </td>
                                    <td class="text-capitalize align-middle p-1 text-nowrap">
                                        <span>` + item.teacher_level + `</span>
                                    </td>
                                    <td class="text-center align-middle p-1 text-nowrap">
                                        <span data-teacher="` + item.teacher_id + `" class="btn btn-teacher-detail label-status bg-warning">xem</span>
                                    </td>
                                </tr>
                                `;
                                $(document).find('#teacher_table tbody').append(row);
                            });
                        }else{
                            // $(document).find('#teacher_table').slideUp();
                            $(document).find('#teacher_table').slideDown();
                            var row = `
                                <tr>
                                    <td class="text-capitalize align-middle" colspan="4">
                                        <span>Không có gia sư nhận dạy lớp này.</span>
                                    </td>
                                </tr>
                                `;
                                $(document).find('#teacher_table tbody').append(row);
                        }

                    }else{
                        Swal.fire({
                            icon: 'error',
                            text: 'Hiện chưa có lớp này',
                        });
                    }
                }else{
                    if(data.message){
                        Swal.fire({
                            icon: 'error',
                            text: data.message,
                        });
                    }else{
                        Swal.fire({
                            icon: 'error',
                            text: 'Có lỗi xảy ra',
                        });
                    }
                }
            $(document).find('body').removeClass('hover_cursor_progress');
            }).fail(function (jqXHR, textStatus, errorThrown) {
                console.log("error");
                alert(errorThrown);
                $(document).find('body').removeClass('hover_cursor_progress');
                Swal.fire({
                            icon: 'error',
                            text: 'Có lỗi xảy ra',
                        });
            })
            .always(function (data, textStatus, errorThrown) {
                console.log("complete");
                $(document).find('body').removeClass('hover_cursor_progress');
            });
        }
    });


    $(document).on('click','.btn-teacher-detail', function(event){
        event.preventDefault();
        var teacherId = $(this).data('teacher');
        var url = '/front/ajax/parent-register/show-teacher-preview/' + teacherId;
        var _modal = $('#js-modal-detail-teacher');
        _modal.find('.modal-body').empty();
        $(document).find('body').addClass('hover_cursor_progress');
        $.ajax({
            type: 'GET',
            url: url,
        })
        .done(function (data) {
            _modal.find('.modal-body').append(data.html)
            _modal.modal('show');
            $(document).find('body').removeClass('hover_cursor_progress');
        })
        .fail(function (jqXHR, textStatus, errorThrown) {
             //    msgErrors(errorThrown);
             $(document).find('body').removeClass('hover_cursor_progress');
            });
    });

    $(document).on('click', 'form#course-register-form .btn-submit', function (event) {
        event.preventDefault();
        var formData = $('#course-register-form').serialize()
        $.ajax({
                url: '/front/ajax/course/store',
                type: 'POST',
                dataType: 'json',
                data: formData,
            })
            .done(function (data) {
                console.log(data);
                if(data.success){
                    alert('Đăng ký thành công');
                    if(data.redirect){
                        window.location.replace(data.redirect)
                    }else{
                        window.location.replace(window.location.hostname + '/lop-can-gia-su.html');
                    }
                }
            })
            .fail(function (jqXHR, textStatus, errorThrown) {
                console.log("error");
                alert(errorThrown);
            })
            .always(function (data, textStatus, errorThrown) {
                console.log("complete");
            });
    });

    $(document).on('click', '.btn-parent-register-submit', function (event) {
        event.preventDefault();
        $(document).find('#course-register-form input[name="select_teacher"').val("");
        $(document).find('#course-register-form input[name="select_teacher"').val($(this).data('teacher-id'));
        var formData = $('#course-register-form').serialize()
        $(document).find('body').addClass('hover_cursor_progress');
        $.ajax({
                url: '/front/ajax/parent-register/store',
                type: 'POST',
                dataType: 'json',
                data: formData,
            })
            .done(function (data) {
                console.log(data);
                if(data.success){
                    Swal.fire({
                        title: 'Đăng ký thành công.',
                        icon: 'success',
                        showConfirmButton: false,
                        timer: 1500
                    });
                $(document).find('.modal').modal('hide');
                } else{
                    Swal.fire({
                        icon: 'error',
                        text: 'Đăng ký thất bại!',
                    });
                    $(document).find('.modal').modal('hide');
                    showErrorAlert(data.message);
                }
                $(document).find('body').removeClass('hover_cursor_progress');
            })
            .fail(function (jqXHR, textStatus, errorThrown) {
                console.log("error");
                Swal.fire({
                            icon: 'error',
                            text: 'Có lỗi xảy ra!',
                        });
                $(document).find('.modal').modal('hide');
                $(document).find('body').removeClass('hover_cursor_progress');
            })
            .always(function (data, textStatus, errorThrown) {
                console.log("complete");
                $(document).find('.modal').modal('hide');
                $(document).find('body').removeClass('hover_cursor_progress');
            });
    });
    function showErrorAlert(errors)
    {
        if(typeof errors == "object") {
            var alertHtml = "<div>";
            $.each(errors, function (key, value) {
                alertHtml += '<div class = "alert alert-danger py-2 px-2" style = "float: left;width: calc(100% - 0px);margin-left: 0px;">' +
                    '- ' + value + '<button type="extutton" class="close d-none" data-dismiss="alert">×</button >' +
                    '</div>';
            });
            alertHtml += '</div>'
            Swal.fire({
                title: 'Dữ liệu không hợp lệ',
                html: alertHtml,
                focusConfirm: false,
            })
        }
    }
</script>
@endsection
