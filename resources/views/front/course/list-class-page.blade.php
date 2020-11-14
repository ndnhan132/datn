@extends('front.layouts.app')
@section('title', 'Trang chủ')
@section('head')
@endsection
@section('content')
{{-- {{ dd($courses) }} --}}
<div id="list-class-page" data-type="{{ $type ?? 'ALL'}}">
    @include('front.course.list-class-table');
</div>
@endsection
