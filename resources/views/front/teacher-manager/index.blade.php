@extends('front.layouts.teacher-manager-master')
@section('title', 'Hồ Sơ ' . (Auth::guard('teacher')->user()->name ?? 'Cá Nhân'))
@section('head')
@endsection
@section('content')
<div class="mainbox mt-0">
    <div class="w-100 d-flex">
        <div class="col-3">
            Ảnh đại diện
        </div>
    </div>
</div>

<div class="mainbox">
    <div>
        Cac lop dang ky
    </div>
</div>


@endsection
