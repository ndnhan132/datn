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
                    &nbsp;&nbsp;Quản lý giáo viên
                    <span type="button" class="btn-table-reload px-3"><i
                            class="fa fa-refresh"></i></span>
                            <span type="button" class="btn-post-create px-3"><i
                                class="fa fa-plus-circle"></i></span>
                </h1>
            </div>
            <ul class="app-breadcrumb breadcrumb">
                <li class="breadcrumb-item"><i class="fa fa-file-text-o fa-lg"></i></li>
                <li class="breadcrumb-item">Tables</li>
                <li class="breadcrumb-item active"><a href="#"></a></li>
            </ul>
        </div>

        <div class="row post-manager" id="content-table">
            @include('admin.layouts.blank')
        </div>


    </section>
@endsection
@section('javascript')
<script src="https://cdn.ckeditor.com/4.14.0/full-all/ckeditor.js"></script>
@endsection
