@extends('front.layouts.app')
@section('title', $course->title)
@section('head')
@endsection
@section('content')
<div id='teacher-register-course-page-content'>
    @include('front.teacher-course-registration.teacher-register-course-content', ['course' => $course])
</div>
@endsection
