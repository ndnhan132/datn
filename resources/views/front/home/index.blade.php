@extends('front.layouts.app')
@section('title', 'Trang chủ')
@section('head')
@endsection
@section('content')
<div class="container">
    <div class="d-flex bg-light">
        <div class="col-3">
        sdsf
    </div>
    <div class="col-9">
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
