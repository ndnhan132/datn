@extends('admin.layouts.app')
@section('title', 'Danh sách gia sư')
@section('head')
<style>

</style>
@endsection
@section('content')
<div class="app-title">
	<div>
		<h1>
			<i class="fa fa-envelope"></i>
			&nbsp;&nbsp;Liên hệ
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
@endsection
