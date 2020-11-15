@extends('front.layouts.app')
@if ($type == 'NOT_RECEIVED')
    @section('title', 'Lớp chưa giao')
@else
    @section('title', 'Danh sách lớp')
@endif
@section('head')
@endsection
@section('content')
<div id="list-class-page" data-type="{{ $type ?? 'ALL'}}">
    @include('front.course.list-class-table');
</div>
@endsection
