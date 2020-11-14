@extends('front.layouts.app')
@section('title', 'Trang chủ')
@section('head')
@endsection
@section('content')
<div class="container mt-3">
    <div class="d-flex">
        <div class="col-3 pl-md-0">
            @include('front.layouts.asidebar')
        </div>
        <div class="col-9 pr-md-0">
        </div>
    </div>
</div>
@endsection
