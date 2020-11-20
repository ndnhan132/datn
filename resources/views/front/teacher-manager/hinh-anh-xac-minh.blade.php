@extends('front.layouts.teacher-manager-master')
@section('title', 'Cài đặt chung')
@section('head')
@endsection
@section('content')
@php
    $teacher = Auth::guard('teacher')->user();
@endphp
<div class="content mb-5">
    <form action="" method="post" id="education-form">
        <div class="setting-alert">
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
                <label class="col-sm-12">Học phí tham khảo <small class="text-danger">(theo tháng)</small></label>
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
    });
});
</script>
@endsection
