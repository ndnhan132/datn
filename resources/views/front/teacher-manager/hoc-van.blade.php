@extends('front.layouts.teacher-manager-master')
@section('title', 'Học vấn')
@section('head')
@endsection
@section('content')
@php
    $teacher = Auth::guard('teacher')->user();
@endphp
<div class="form-wrap mb-5">
    <form action="" method="post" id="education-form">
        <div class="form-alert">
        </div>
        <div class="row d-flex flex-wrap border-bottom pb-4">
            <div class="form-group col-sm-6">
                <label class="col-sm-12">Đại học <small class="text-danger">(Nếu có)</small></label>
                <div class="col-sm-12">
                    <input type="text" class="form-control" value="{{ $teacher->university }}" name="university">
                </div>
            </div>
            <div class="form-group col-sm-6">
                <label class="col-sm-12">Chuyên ngành <small class="text-danger">(Nếu có)</small></label>
                <div class="col-sm-12">
                    <input type="text" class="form-control" value="{{ $teacher->speciality }}" name="speciality">
                </div>
            </div>
            <div class="form-group col-sm-6">
                <label class="col-sm-12">Trình độ hiện tại</label>
                <div class="col-sm-12">
                    {{-- <input type="text" class="form-control" value="{{ $teacher->teacherLevel->display_name }}" name="teacher_level"> --}}
                    <select name="teacher_level_id" class="form-control" data-teacher_level="{{ $teacher->teacher_level_id ?? '' }}">
                    </select>
                </div>
            </div>
            <div class="form-group col-sm-6">
                <label class="col-sm-12">Học phí tham khảo <small class="text-danger">(một buổi)</small></label>
                <div class="col-sm-12">
                    <input type="text" class="form-control" value="{{ $teacher->reference_tuition }}" name="reference_tuition">
                </div>
            </div>
            <div class="form-group col-sm-6">
                <label class="col-sm-12">Nhân dạy lớp</label>
                <div class="col-sm-12">
                    {{-- <input type="text" class="form-control" value="{{ $teacher->reference_tuition }}" name="reference_tuition"> --}}
                    <div class="d-flex flex-wrap">
                        @php
                            $myLv = $teacher->getMyCourseLevelId();
                        @endphp
                        @foreach ($courseLevels as $item)
                        {{-- <div class="form-check"> --}}
                            <div class="form-check form-check-inline">
                                <input class="form-check-input" type="checkbox" name="course_level[]" id="1_inlineCheckbox{{$item->id }}" value="{{$item->id }}"  style="height: 20px!important" {{ in_array($item->id, $myLv) ? 'checked="checked"' : '' }}>
                                <label class="form-check-label text-capitalize" for="1_inlineCheckbox{{$item->id }}">{{ $item->display_name }}</label>
                              </div>
                        {{-- </div> --}}
                        @endforeach
                    </div>
                </div>
            </div>
            <div class="form-group col-sm-6">
                <label class="col-sm-12">Nhân dạy môn</label>
                <div class="col-sm-12">
                    {{-- <input type="text" class="form-control" value="{{ $teacher->reference_tuition }}" name="reference_tuition"> --}}
                    <div class="d-flex flex-wrap">
                        @php
                            $myLv = $teacher->getMySubjectId();
                        @endphp
                        @foreach ($subjects as $item)
                        {{-- <div class="form-check"> --}}
                            <div class="form-check form-check-inline">
                                <input class="form-check-input" type="checkbox" name="subject[]" id="2_inlineCheckbox{{$item->id }}" value="{{$item->id }}"  style="height: 20px!important" {{ in_array($item->id, $myLv) ? 'checked="checked"' : '' }}>
                                <label class="form-check-label text-capitalize" for="2_inlineCheckbox{{$item->id }}">{{ $item->display_name }}</label>
                              </div>
                        {{-- </div> --}}
                        @endforeach
                    </div>
                </div>
            </div>
        </div>
        <div class="w-100 d-flex py-4">
            <a href="#" class="btn btn-info rounded-pill text-uppercase px-5 mx-auto btn-submit">Lưu</a>
        </div>
    </form>
</div>
<script>
$(function() {
    $.ajax({
        url: '/ajax/get-teacher-level',
        type: 'GET',
    })
    .done(function(data) {
        console.log(data);
        if(data.success){
            var _select = $(document).find('.teacher-manager form#education-form select[name=teacher_level_id]');
            var _options = '';
            var _currentLevel = _select.data('teacher_level');
            if(!_currentLevel){
                _options = '<option value=""></option>';
            }
            $.each(data.data, function(key, value){
                var _selected = '';
                if(value.id == _currentLevel) _selected = "selected";
                _options += '<option value="' + value.id + '" ' + _selected + '>' + value.display_name + '</option>';
            });
            _select.append(_options);
        }
    });
});

</script>
@endsection
