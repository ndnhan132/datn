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
                    <legend class="col-sm-12 label-title">Thông tin liên hệ</legend>
                    <div class="form-group col-sm-12 row">
                        <label class="col-sm-3">Họ tên <span class="text-danger">(*)</span></label>
                        <div class="col-sm-6">
                        <input type="text" class="form-control" name="fullname" value="test value">
                        </div>
                    </div>
                    <div class="form-group col-sm-12 row">
                        <label class="col-sm-3">Số điện thoại <span class="text-danger">(*)</span></label>
                        <div class="col-sm-6">
                            <input type="text" class="form-control" name="phone" value="test value">
                        </div>
                    </div>
                    <div class="form-group col-sm-12 row">
                        <label class="col-sm-3">Email <span class="text-danger">(*)</span></label>
                        <div class="col-sm-6">
                            <input type="text" class="form-control" name="email" value="test value">
                        </div>
                    </div>
                    <div class="form-group col-sm-12 row">
                        <label class="col-sm-3">Địa chỉ <span class="text-danger">(*)</span></label>
                        <div class="col-sm-6">
                            <input type="text" class="form-control" name="address" value="test value">
                        </div>
                    </div>
                </fieldset>
            </div>

            <div class="form-group col-sm-12 d-flex flex-wrap">
                <fieldset class="w-100">
                    <legend class="col-sm-12 label-title">Thông tin lớp học</legend>
                    <div class="form-group col-sm-12 row">
                        <label class="col-sm-3">Khối lớp</label>
                        <div class="col-sm-6">
                            <select name="course_level" class="form-control">
                                @foreach ($courseLevels as $item)
                                    <option value="{{$item->id}}">{{$item->display_name}}</option>
                                @endforeach
                            </select>
                        </div>
                    </div>
                    <div class="form-group col-sm-12 row">
                        <label class="col-sm-3">Khối lớp khác <small class="text-muted font-weight-bold">(nếu có)</small></label>
                        <div class="col-sm-6">
                            <input type="text" class="form-control" name="other_course_level" value="test value">
                        </div>
                    </div>
                    <div class="form-group col-sm-12 row">
                        <label class="col-sm-3">Môn học</label>
                        <div class="col-sm-6">
                            <select name="subject" class="form-control">
                                @foreach ($subjects as $item)
                                    <option value="{{$item->id}}">{{$item->display_name}}</option>
                                @endforeach
                            </select>
                        </div>
                    </div>
                    <div class="form-group col-sm-12 row">
                        <label class="col-sm-3">Môn học khác <small class="text-muted font-weight-bold">(nếu có)</small></label>
                        <div class="col-sm-6">
                            <input type="text" class="form-control" name="other_subject" value="test value">
                        </div>
                    </div>
                    <div class="form-group col-sm-12 row">
                        <label class="col-sm-3">Số lượng học sinh</label>
                        <div class="col-sm-6">
                            <select class="form-control" name="num_of_student">
                                @for ($i = 1; $i < 8; $i++)
                                <option value="{{$i}}">{{ $i . ' học sinh' }}</option>
                                @endfor
                            </select>
                        </div>
                    </div>
                    <div class="form-group col-sm-12 row">
                        <label class="col-sm-3">Lương tháng</label>
                        <div class="col-sm-6">
                            <input type="text" class="form-control" name="tuition_per_month" value="12345">
                        </div>
                    </div>
                    <div class="form-group col-sm-12 row">
                        <label class="col-sm-3">Số buổi</label>
                        <div class="col-sm-6">
                            <select class="form-control" name="session_per_week">
                                @for ($i = 1; $i < 11; $i++)
                                <option value="{{$i}}">{{ $i . ' buổi' }}</option>
                                @endfor
                            </select>
                        </div>
                    </div>
                    <div class="form-group col-sm-12 row">
                        <label class="col-sm-3">Thời gian 1 buổi</label>
                        <div class="col-sm-6">
                            <input type="text" class="form-control" name="time_per_session" value="120">
                        </div>
                    </div>
                    <div class="form-group col-sm-12 row">
                        <label class="col-sm-3">Thời gian dạy</label>
                        <div class="col-sm-6">
                            <input type="text" class="form-control" name="time_working" value="test value">
                            <span class="text-muted">*(VD: Tối T2-T7)</span>
                        </div>
                    </div>
                </fieldset>
            </div>

            <div class="form-group col-sm-12 d-flex flex-wrap">
                <fieldset class="w-100">
                    <legend class="col-sm-12 label-title">Yêu cầu gia sư</legend>
                    <div class="form-group col-sm-12 row">
                        <label class="col-sm-3">Trình độ giáo viên</label>
                        <div class="col-sm-6">
                            <select name="teacher_level" class="form-control">
                                @foreach ($teacherLevels as $item)
                                    <option value="{{$item->id}}">{{$item->display_name}}</option>
                                @endforeach
                            </select>
                        </div>
                    </div>
                    <div class="form-group col-sm-12 row">
                        <label class="col-sm-3">Giới tính</label>
                        <div class="col-sm-6">
                            <select name="teacher_gender" class="form-control">
                                <option value="BOTH">Không yêu cầu</option>
                                <option value="MALE">Gia sư nam</option>
                                <option value="FEMALE">Gia sư nữ</option>
                            </select>
                        </div>
                    </div>
                    <div class="form-group col-sm-12 row">
                        <label class="col-sm-3">Trình độ khác <small class="text-muted font-weight-bold">(nếu có)</small></label>
                        <div class="col-sm-6">
                            <input type="text" class="form-control" name="other_teacher_level" value="test value">
                        </div>
                    </div>
                    <div class="form-group col-sm-12 row">
                        <label class="col-sm-3">Yêu cầu khác <small class="text-muted font-weight-bold">(nếu có)</small></label>
                        <div class="col-sm-6">
                            <textarea type="text" class="form-control" name="other_requirement" rows="4">value="test value"</textarea>
                        </div>
                    </div>
                </fieldset>
            </div>

        </div>

        <div class="w-100 d-flex py-4">
            <a href="#" class="btn btn-info rounded-pill text-uppercase px-5 mx-auto btn-submit">Gửi đăng ký</a>
        </div>
    </form>
</div>
@endsection

@section('javascript')
<script type="text/javascript">
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

</script>
@endsection
