@extends('front.layouts.app')
@section('title', 'Dành cho giáo viên')
@section('head')
@endsection
@section('content')
    @php
        $arr = array();
        $arr[] = array(
            'title' => 'Đăng ký tìm gia sư',
            'url'   => route('front.getCourseRegisterPage'),
        );
        $arr[] = array(
            'title' => 'Bảng giá tham khảo',
            'url'   => route('front.getTeacherRegisterPage'),
        );
        $arr[] = array(
            'title' => 'Phụ huynh cần biết',
            'url'   => route('front.getTeacherRegisterPage'),
        );
        $arr[] = array(
            'title' => 'Gia sư tiêu biểu',
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
