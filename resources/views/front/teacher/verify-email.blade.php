@extends('front.layouts.app')
@section('title', 'Trang chủ')
@section('head')
@endsection
@section('content')
<div class="form-wrap mb-4 p-5">
    @if (!$success)
    <div class="form-alert">
        <div class="alert alert-danger">
            <i class="fas fa-info"></i>&nbsp; Kích hoạt email thất bại!<br>
            <i class="fas fa-info"></i>&nbsp; Lỗi: {{ $error}}!<br>
        </div>
    </div>
    <div class="w-100 d-flex py-4">
        <a href=""
            class="btn btn-outline-info rounded-pill px-5 mx-auto"> Trang chủ</a>
    </div>
    @else
    <form id="teacher-register-form" method="post" class="position-relative py-4" >
        @csrf
        <div class="form-alert">
            <div class="alert alert-success">
                <i class="fas fa-check"></i>&nbsp; Kích hoạt email thành công!<br>
            </div>
        </div>
        <div class="row">
        </div>
        <div class="w-100 d-flex py-4">
            <a href="{{ route('front.teacherManager.index') }}" class="btn btn-outline-info rounded-pill px-5 mx-auto">Quản lý tài khoản</a>
        </div>
    </form>
    @endif
</div>

@endsection
