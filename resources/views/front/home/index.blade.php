@extends('front.layouts.app')
@section('title', 'Trang chủ')
@section('head')
@endsection
@section('content')
    @include('front.home.slider')
    @include('front.home.introduce')
    @include('front.home.list-course')
    @include('front.home.list-teacher')
@endsection
@section('javascript')
@endsection
