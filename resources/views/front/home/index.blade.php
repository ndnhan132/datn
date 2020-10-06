@extends('front.layouts.app')
@section('title', 'Trang chủ')
@section('head')
@endsection
@section('content')
<div class="container mt-3">
    <div class="d-flex">
        <div class="col-3 pl-md-0">
            @include('front.home.asidebar')
        </div>
        <div class="col-9 pr-md-0">
            @include('front.home.slider')
            @include('front.home.introduce')
            @include('front.home.list-course')
            @include('front.home.list-teacher')
        </div>
    </div>
</div>
@endsection
@section('javascript')
@endsection
