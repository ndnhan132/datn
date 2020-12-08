@extends('front.layouts.app')
@section('title', 'Dành cho gia sư')
@section('head')
@endsection
@section('content')
{{-- @include('front.home.header-title', ['title' => 'Danh sách gia sư']) --}}

<div class="list-teacher-page">
        <div class="d-flex align-items-center title">
            <div class="title-icon">
            <img src="{{ asset('images/icon/graduation-cap-solid.svg') }}" alt="al">
            </div>
            <h3>Danh sách gia sư</h3>
        </div>
        <form method="GET" class="col-12 p-3 filter" id="teacher-search-form">
            <input type="hidden" value="1" name="page">
            <div class="row d-flex flex-wrap">
                @isset($teacherLevels)
                <div class="form-group col-sm-6 px-0">
                    <label class="col-sm-12">Trình độ hiện tại</label>
                    <div class="col-sm-12">
                        <select name="teacher_level" class="form-control input-onchange">
                            <option value="">Toàn bộ</option>
                            @foreach ($teacherLevels as $teacherLevel)
                            <option value="{{$teacherLevel->id}}">{{$teacherLevel->display_name}}</option>
                            @endforeach
                        </select>
                    </div>
                </div>
                @endisset
                <div class="form-group col-sm-6 px-0">
                    <label class="col-sm-12">Giới tính</label>
                    <div class="col-sm-12">
                        <select name="gender" class="form-control input-onchange">
                            <option value="BOTH">Cả hai</option>
                            <option value="MALE">Nam</option>
                            <option value="FEMALE">Nữ</option>
                        </select>
                    </div>
                </div>
                <div class="form-group col-sm-6 px-0">
                    <label class="col-sm-12">Lớp dạy</label>
                    <div class="col-sm-12">
                        <select name="course_level" class="form-control input-onchange text-capitalize">
                            <option value="">Toàn bộ</option>
                            @foreach ($courseLevels as $courseLevel)
                            <option value="{{$courseLevel->id}}">{{$courseLevel->display_name}}</option>
                            @endforeach
                        </select>
                    </div>
                </div>
                <div class="form-group col-sm-6 px-0">
                    <label class="col-sm-12">Môn dạy</label>
                    <div class="col-sm-12">
                        <select name="subject" class="form-control input-onchange text-capitalize">
                            <option value="">Toàn bộ</option>
                            @foreach ($subjects as $subject)
                            <option value="{{$subject->id}}">{{$subject->display_name}}</option>
                            @endforeach
                        </select>
                    </div>
                </div>
            </div>
        </form>
        <div class="body" id="list-teachers">
            @include('front.teacher.list-teacher-content')
        </div>
</div>




<div class="modal fade" id="view-teacher-modal" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
    <div class="modal-dialog">
      <div class="modal-content">
        <div class="modal-header">
          <h5 class="modal-title teacher-val" id="exampleModalLabel">Thông tin gia sư</h5>
          <button type="button" class="close" data-dismiss="modal" aria-label="Close">
            <span aria-hidden="true">&times;</span>
          </button>
        </div>
        <div class="modal-body">
        </div>
      </div>
    </div>
  </div>
@endsection
@section('javascript')
<script>
    $(document).on('click', '.btn-view-teacher-modal', function(event) {
        event.preventDefault();
        var _teacher = $(this).data('teacher');
        var _modal = $(document).find('#view-teacher-modal');
        $(document).find('body').addClass('hover_cursor_progress');
        _modal.find('.modal-body').empty();
        $.ajax({
                url: '/ajax/get-teacher-by-id/' + _teacher,
                type: 'GET',
            })
            .done(function(data) {
                console.log(data);
                if(data.success){
                    _modal.find('.modal-body').append(data.html);
                    _modal.modal('show');
                }
                $(document).find('body').removeClass('hover_cursor_progress');
            })
            .fail(function (jqXHR, textStatus, errorThrown) {
                console.log("error");
                alert(errorThrown);
                $(document).find('body').removeClass('hover_cursor_progress');
            });
    });
</script>
@endsection
