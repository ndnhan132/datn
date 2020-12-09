@extends('admin.layouts.app')
@section('title', 'Danh sách lớp')
@section('head')
<style>

</style>
@endsection
@section('content')
<div class="app-title">
	<div>
		<h1>
			<i class="fa fa-file-text-o"></i>
			&nbsp;&nbsp;Danh sách Lớp
			<span type="button" class="btn-table-reload px-3 d-none"><i
					class="fa fa-refresh"></i></span>

		</h1>
	</div>
</div>
<div class="row" id="content-table">
	@include('admin.layouts.blank')
</div>

@endsection
@section('javascript')
<script src="{{asset('/web-admin/js/onepage/course.js') . '?' . time() }}"
	type="text/javascript"></script>
@endsection
