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
        <div id="carouselExampleSlidesOnly" class="carousel slide"
            data-ride="carousel">
            <div class="carousel-inner">
                <div class="carousel-item active">
                    <img src="{{ asset('image/slider-1.png') }}" class="d-block w-100" alt="...">
                </div>
                <div class="carousel-item">
                    <img src="{{ asset('image/slider-1.png') }}" class="d-block w-100" alt="...">
                </div>
                <div class="carousel-item">
                    <img src="{{ asset('image/slider-1.png') }}" class="d-block w-100" alt="...">
                </div>
            </div>
        </div>
    </div>
    </div>
</div>
@endsection
@section('javascript')
@endsection
