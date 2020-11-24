@extends('front.layouts.app')
@section('title', 'Tin tức')
@section('head')
@endsection
@section('content')
<div class="mainbox mt-0 mb-4 rounded-0">
    <div class="w-100">
        <div class="col-12">
            <div class="breadcrumbs text-uppercase">
                <span>{{ $post->title }}</span>
            </div>
        </div>
    </div>
    <div class="col-12 my-3">
        <div class="w-100 border p-3" style="box-shadow: 0 1px 3px rgba(0, 0, 0, 0.2)">
            <section id="list-news">
                {!! $post->content ?? 'Chưa có nội dung' !!}
            </section>
        </div>
    </div>
</div>
@endsection
