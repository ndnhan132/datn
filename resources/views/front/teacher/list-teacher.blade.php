@extends('front.layouts.app')
@section('title', 'Dành cho gia sư')
@section('head')
@endsection
@section('content')
@include('front.home.header-title', ['title' => 'Danh sách gia sư'])

<div id="list-teachers">
<div class="d-flex flex-wrap">
    @foreach ($teachers as $teacher)
    <article class="teacher-item col-sm-6">
        <div class="w-100 d-flex bg-white p-3">
            <div class="teacher-img col-lg-4 col-md-4 col-sm-4 col-xs-12">
                <a href="">
                    <img src="{{ $teacher->getAvatarSrc() }}" alt="@">
                </a>
            </div>
            <div class="col-lg-8 col-md-8 col-sm-8 col-xs-12">
                <a href="" class="teacher-name">
                    <h2 class="text-truncate">{{ $teacher->name }}</h2>
                </a>
                <div class="date">
                    Trình độ -&nbsp;&nbsp;Giảng viên đại học
                </div>
                <div class="date">
                    @if ($teacher->getAge())
                    Tuổi&nbsp;&nbsp;{{ $teacher->getAge()}}
                    @else
                    Tuổi&nbsp;&nbsp; Chưa cập nhật
                    @endif
                </div>
            </div>
        </div>
    </article>
    @endforeach
</div>
{{-- {{ dd($max)}} --}}
@isset($max)
@if($max > 1)
<div class="pagination-wrapper mt-3">
    <ul class="pagination pagination-sm flex-wrap justify-content-center">
        @for($i = 1; $i <= $max; $i++) <li
            class="page-item {{ $i == $page ? 'active' : '' }}"><button
                class="page-link pagination-item"
                data-pagenum="{{ $i }}">{{ $i }}</button></li>
            @endfor
    </ul>
</div>
@endif
@endisset
</div>
@endsection
