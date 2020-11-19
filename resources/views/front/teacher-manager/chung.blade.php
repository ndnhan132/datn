@extends('front.layouts.teacher-manager-master')
@section('title', 'Cài đặt chung')
@section('head')
@endsection
@section('content')
@php
    $teacher = Auth::guard('teacher')->user();
@endphp
<div class="content mb-5">
    <form action="" method="post" id="general-form">
        <div class="setting-alert">
        </div>
        <div class="row d-flex flex-wrap border-bottom pb-4">
            <div class="form-group col-sm-6">
                <label class="col-sm-12">Email</label>
                <div class="col-sm-12">
                    <input type="text" class="form-control" value="{{ $teacher->email }}" readonly>
                </div>
            </div>
            <div class="form-group col-sm-6">
                <label class="col-sm-12">Họ tên</label>
                <div class="col-sm-12">
                    <input type="text" class="form-control" value="{{ $teacher->name }}" name="name">
                </div>
            </div>
            <div class="form-group col-sm-6">
                <label class="col-sm-12">Địa chỉ</label>
                <div class="col-sm-12">
                    <input type="text" class="form-control" value="{{ $teacher->address }}" name="address">
                </div>
            </div>
            <div class="form-group col-sm-6">
                <label class="col-sm-12">Điện thoại</label>
                <div class="col-sm-12">
                    <input type="text" class="form-control" value="{{ $teacher->phone }}" name="phone">
                </div>
            </div>
            <div class="form-group col-sm-6">
                <div class="form-group col-sm-12">
                    <label class="col-sm-12">Số chứng minh nhân dân</label>
                    <div class="col-sm-12">
                        <input type="text" class="form-control" value="{{ $teacher->identity_card }}" name="identity_card">
                    </div>
                </div>
                <div class="form-group col-sm-12">
                    <label class="col-sm-12">Giới tính</label>
                    <div class="col-sm-12">
                        <select name="is_male" class="form-control">
                            <option value="1" {{ ($teacher->is_male == 1) ? 'selected' : '' }}>Nam</option>
                            <option value="0" {{ ($teacher->is_male == 0) ? 'selected' : '' }}>Nữ</option>
                        </select>
                    </div>
                </div>
            </div>
            <div class="form-group col-sm-6">
                <label class="col-sm-12">Mô tả</label>
                <div class="col-sm-12">
                    <textarea name="description" cols="30" rows="7" class="form-control">{{ $teacher->description }}</textarea>
                </div>
            </div>
        </div>
        <div class="w-100 d-flex py-4">
            <a href="#" class="btn btn-info rounded-pill text-uppercase px-5 mx-auto btn-submit">Lưu</a>
        </div>
    </form>
</div>
@endsection
