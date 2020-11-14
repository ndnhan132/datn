@extends('front.layouts.app')
@section('title', $course->title)
@section('head')
@endsection
@section('content')
<div class="container mt-3">
    <div class="d-flex">
        <div class="col-3 pl-md-0">
            @include('front.layouts.asidebar')
        </div>
        <div class="col-9 pr-md-0" id="teacher-register-course-content">
            @include('front.teacher-course-registration.teacher-register-course-content', ['course' => $course])
        </div>
    </div>
</div>
@endsection
