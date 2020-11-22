@extends('front.layouts.app')
@section('title', 'Trang chủ')
@section('head')
@endsection
@section('content')
<div class="form-wrap mb-4">
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
    <form id="teacher-register-form" method="post">
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
                            value="test{{ time() }}@gmail.com">
                        <div class="form-control-feedback">(Sử dụng để đăng
                            nhập)
                        </div>
                    </div>
                </div>
                <div class="form-group col-sm-12 row">
                    <label class="col-sm-3">Họ tên</label>
                    <div class="col-sm-6">
                        <input type="text" class="form-control" name="name" value="test {{ time() }}">
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
                alert('Đăng ký thành công');
                if (data.redirect) {
                    window.location.replace(data.redirect)
                } else {
                    window.location.replace(window.location.hostname + '/lop-can-gia-su.html');
                }
            }
            else {
                if(data.message && typeof data.message == 'string')
                {
                    alert(data.message);
                }
            }
        })
        .fail(function(jqXHR, textStatus, errorThrown) {
            console.log("error");
            alert(errorThrown);
        });
});
</script>
@endsection
