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
