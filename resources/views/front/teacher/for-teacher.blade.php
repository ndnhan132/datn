@extends('front.layouts.app')
@section('title', 'Dành cho gia sư')
@section('head')
@endsection
@section('content')
    @php
        $arr = array();
        $arr[] = array(
            'title' => 'Đăng ký làm gia sư',
            'url'   => route('front.getTeacherRegisterPage'),
        );
        $arr[] = array(
            'title' => 'Lớp mới cần gia sư',
            'url'   => route('front.getTeacherRegisterPage'),
        );
        $arr[] = array(
            'title' => 'Tìm kiếm lớp mới',
            'url'   => route('front.getTeacherRegisterPage'),
        );
        $arr[] = array(
            'title' => 'Hướng dẫn đăng ký làm gia sư',
            'url'   => route('front.getTeacherRegisterPage'),
        );
        $arr[] = array(
            'title' => 'Hướng dẫn nhận lớp',
            'url'   => route('front.getTeacherRegisterPage'),
        );
        $arr[] = array(
            'title' => 'Hợp đồng gia sư',
            'url'   => route('front.getTeacherRegisterPage'),
        );
        $arr[] = array(
            'title' => 'Gia sư cần biết',
            'url'   => route('front.getTeacherRegisterPage'),
        );
    @endphp
    <div class="mainbox mt-0 p-5">
        <div class="list-type5">
            <ol>
                @foreach ($arr as $item)
                <li><a href="{{ $item['url'] }}">{{ $item['title'] }}</a></li>
                @endforeach
            </ol>
        </div>
    </div>
@endsection
