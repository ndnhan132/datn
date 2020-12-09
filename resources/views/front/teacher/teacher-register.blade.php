@extends('front.layouts.app')
@section('title', 'Trang chủ')
@section('head')
@endsection
@section('content')
<div class="form-wrap mb-4 p-3">
    @if (Auth::guard('teacher')->check())
    <div class="form-alert">
        <div class="alert alert-danger">
            <i class="fas fa-info"></i>&nbsp; Đã có tài khoản gia sư đăng
            nhập!<br>
            <i class="fas fa-info"></i>&nbsp; Bạn cần đăng xuất để thực hiện
            chức năng này!<br>
        </div>
    </div>
    <div class="w-100 d-flex py-4">
        <a href="{{ route('front.teacherLogout') }}"
            class="btn btn-outline-warning rounded-pill px-5 mx-auto btn-logout">Đăng
            xuất</a>
    </div>
    @else
    <form id="teacher-register-form" method="post" class="position-relative py-4" >
        @csrf
        <div class="form-alert">
        </div>
        <div class="row">
            <div class="form-group col-sm-12 d-flex flex-wrap">
                <div class="form-group col-sm-12 row">
                    <label class="col-sm-3">Email<span
                            class="text-danger">(*)</span></label>
                    <div class="col-sm-6">
                        <input type="text" class="form-control" name="email"
                            value="user{{ time() }}@gmail.com">
                        <div class="form-control-feedback">(Sử dụng để đăng
                            nhập)
                        </div>
                    </div>
                </div>
                <div class="form-group col-sm-12 row">
                    <label class="col-sm-3">Họ tên</label>
                    <div class="col-sm-6">
                        <input type="text" class="form-control" name="name" value="user {{ time() }}">
                    </div>
                </div>
                <div class="form-group col-sm-12 row">
                    <label class="col-sm-3">Mật khẩu <span
                            class="text-danger">(*)</span></label>
                    <div class="col-sm-6">
                        <input type="password" class="form-control"
                            name="password" value="111111">
                    </div>
                </div>
                <div class="form-group col-sm-12 row">
                    <label class="col-sm-3">Nhập lại mật khẩu <span
                            class="text-danger">(*)</span></label>
                    <div class="col-sm-6">
                        <input type="password" class="form-control"
                            name="password_confirmation" value="111111">
                    </div>
                </div>
            </div>
        </div>
        <div class="w-100 d-flex py-4">
            <a href="#"
            class="btn btn-outline-info rounded-pill px-5 mx-auto btn-submit">Gửi
            đăng ký</a>
        </div>
    </form>
    @endif
</div>

@endsection
@section('javascript')
<script type="text/javascript">



$(document).on('click', 'form#teacher-register-form .btn-submit', function(
    event) {
    event.preventDefault();
    var formData = $('#teacher-register-form').serialize()
    var _registerBox = $(document).find('#teacher-register-form');

    var _width = _registerBox.outerWidth();
    var _height = _registerBox.outerHeight();
    _registerBox.css({width: _width, height: _height});
    var _loadingStyle = `style="
    width: ${_width}px;
    height: ${_height}px;
    background: transition;
    position: absolute;
    top: 0;
    left:0;
    z-index: 9999;
    "`;
    var loadingHtml = `<div class="d-flex justify-content-center my-auto border-0 loading-spinner" ${_loadingStyle}>
        <div class="spinner-border my-auto" role="status" style="color: teal; ">
            <span class="sr-only">Loading...</span>
        </div>
    </div>`;
    // _registerBox.append(loadingHtml);
    $(document).find('body').addClass('hover_cursor_progress');
    $.ajax({
            url: '/front/ajax/teacher/store',
            type: 'POST',
            dataType: 'json',
            data: formData,
        })
        .done(function(data) {
            // alert(data)
            console.log(data);
            if (data.success) {
                console.log('Đăng ký thành công');
                Swal.fire({
                    title: 'Đăng ký thành công',
                    icon: 'success',
                    showConfirmButton: false,
                    timer: 1500
                });
            }
            else {
                if(data.message && typeof data.message == 'string')
                {
                    console.log(data.message);
                    msg = data.message ? data.message : "Có lỗi xảy ra!";
                    Swal.fire({
                        icon: 'error',
                        text: msg,
                    });
                }
            }
            _registerBox.find('.loading-spinner').remove();
            _registerBox.empty();
            _registerBox.append(data.html);
            $(document).find('body').removeClass('hover_cursor_progress');
        })
        .fail(function(jqXHR, textStatus, errorThrown) {
            console.log("error+ " + errorThrown);
            Swal.fire({
                icon: 'error',
                text: 'Có lỗi xảy ra!',
            });
            $(document).find('body').removeClass('hover_cursor_progress');
        });
});
</script>
@endsection
