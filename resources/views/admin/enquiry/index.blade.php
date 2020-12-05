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
			<i class="fa fa-th-list"></i>
			&nbsp;&nbsp;Liên hệ
			<span type="button" class="btn-table-reload px-3"><i
					class="fa fa-refresh"></i></span>

		</h1>
	</div>
	<ul class="app-breadcrumb breadcrumb">
		<li class="breadcrumb-item"><i class="fa fa-home fa-lg"></i></li>
		<li class="breadcrumb-item">Tables</li>
		<li class="breadcrumb-item active"><a href="#"></a></li>
	</ul>
</div>
<div class="row" id="content-table">
	@include('admin.layouts.blank')
</div>

@endsection
@section('javascript')
@endsection
