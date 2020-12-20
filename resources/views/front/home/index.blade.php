@extends('front.layouts.app')
@section('title', 'Gia Sư Đà Nằng')
@section('head')
@endsection
@section('content')
    @include('front.home.slider')
    @include('front.home.introduce')
    @include('front.home.list-course')
    @include('front.home.reference-tuition')
    @include('front.home.list-teacher')
@endsection
@section('javascript')
@endsection
