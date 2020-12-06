@extends('admin.layouts.app')
@section('title', 'Danh sách bài viết')
@section('head')
@endsection
@section('content')
    <section id="post-content">
        <div class="app-title">
            <div>
                <h1>
                    <i class="fa fa-file-text-o"></i>
                    &nbsp;&nbsp;Quản lý bài viết
                    <span type="button" class="btn-table-reload px-3 d-none"><i
                            class="fa fa-refresh"></i></span>
                </h1>
            </div>
        </div>

        <div class="row post-manager" id="content-table">
            @include('admin.layouts.blank')
        </div>


    </section>
@endsection
@section('javascript')
<script src="https://cdn.ckeditor.com/4.14.0/full-all/ckeditor.js"></script>
@endsection
