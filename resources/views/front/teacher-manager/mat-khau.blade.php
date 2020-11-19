@extends('front.layouts.teacher-manager-master')
@section('title', 'Thay đổi mật khẩu')
@section('head')
@endsection
@section('content')
<div class="content mb-5">
    <form action="" method="post" id="password-form">
        <div class="setting-alert">
        </div>
        <div class="row d-flex flex-wrap border-bottom pb-4">
            <div class="form-group col-12">
                <label class="col-sm-12">Mật khẩu hiện tại</label>
                <div class="col-sm-12">
                    <input type="password" class="form-control" value="" name="current_password">
                </div>
            </div>
            <div class="form-group col-12">
                <label class="col-sm-12">Mật khẩu mới</label>
                <div class="col-sm-12">
                    <input type="password" class="form-control" value="" name="password">
                </div>
            </div>
            <div class="form-group col-12">
                <label class="col-sm-12">Xác nhận mật khẩu mới</label>
                <div class="col-sm-12">
                    <input type="password" class="form-control" value="" name="password_confirmation">
                </div>
            </div>
        </div>
        <div class="w-100 d-flex py-4">
            <a href="#" class="btn btn-info rounded-pill text-uppercase px-5 mx-auto btn-submit">Lưu</a>
        </div>
    </form>
</div>
@endsection
