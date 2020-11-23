@extends('front.layouts.app')
@section('title', 'Tin tức')
@section('head')
@endsection
@section('content')
<div class="mainbox mt-0">
    <div class="w-100">
        <div class="col-12">
            <div class="breadcrumbs">
                <span>Danh sách bài viết</span>
            </div>
        </div>
    </div>
    <section id="list-news">
        @include('front.articles.lists')
    </section>
</div>
@endsection
