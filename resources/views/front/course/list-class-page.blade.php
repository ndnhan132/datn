@extends('front.layouts.app')
@if ($type == 'NOT_RECEIVED')
    @section('title', 'Lớp chưa giao')
@else
    @section('title', 'Danh sách lớp')
@endif
@section('head')
@endsection
@section('content')
<div class="list-teacher-page">
    <div class="d-flex align-items-center title mb-3">
        <div class="title-icon">
        <img src="{{ asset_public_env('images/icon/graduation-cap-solid.svg') }}" alt="al">
        </div>
        <h3>Danh sách lớp</h3>
    </div>
    <form method="GET" class="col-12 p-3 filter" id="course-search-form">
        <input type="hidden" value="1" name="page">
        <div class="row d-flex flex-wrap">
            {{-- @isset($teacherLevels)
            <div class="form-group col-sm-4 px-0">
                <label class="col-sm-12">Trình độ giáo viên</label>
                <div class="col-sm-12">
                    <select name="teacher_level" class="form-control input-onchange">
                        <option value="">Toàn bộ</option>
                        @foreach ($teacherLevels as $teacherLevel)
                        <option value="{{$teacherLevel->id}}">{{$teacherLevel->display_name}}</option>
                        @endforeach
                    </select>
                </div>
            </div>
            @endisset --}}
            {{-- <div class="form-group col-sm-6 px-0">
                <label class="col-sm-12">Trình độ học sinh</label>
                <div class="col-sm-12">
                    <select name="gender" class="form-control input-onchange">
                        <option value="">Toàn bộ</option>
                        <option value="MALE">Nam</option>
                        <option value="FEMALE">Nữ</option>
                    </select>
                </div>
            </div> --}}
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
    {{-- <div class="body" id="list-teachers">
        @include('front.teacher.list-teacher-content')
    </div> --}}
    <div class="body" id="list-class-page" data-type="{{ $type ?? 'ALL'}}">
        @include('front.course.list-class-table');
    </div>
</div>

@endsection
