@extends('admin.layouts.app')
@section('title', 'Đăng ký nhận lớp')
@section('head')
<style>

</style>
@endsection
@section('content')
<div class="app-title">
	<div>
		<h1>
			<i class="fa fa-th-list"></i>
			&nbsp;&nbsp;Đăng ký nhận lớp
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
<div class="row teacher-course-registration" id="content-table">
	<div class="alert alert-warning w-100 h-100" role="alert">
		A simple warning alert—check it out!
	  </div>
</div>

<div class="modal fade modal-custom" id="js-modal-course-registration-compare" tabindex="-1"
	role="dialog">
	<div class="modal-dialog modal-lg" role="document">
		<div class="modal-content rounded-0">
			<div class="modal-header py-2 border-bottom-0 bg-primary rounded-0">
				<h5 class="modal-title text-white" id="exampleModalLabel"><i class="fa fa-info-circle"></i> Chi tiết</h5>
				<button type="button" class="close" data-dismiss="modal"
					aria-label="Close">
					<span aria-hidden="true">&times;</span>
				</button>
			</div>
			<div class="modal-body py-0 my-3">

			</div>
		</div>
	</div>
</div>

@endsection
@section('javascript')
<script src="{{asset('/web-admin/js/onepage/teacher-course-registration.js') . '?' . time() }}"
	type="text/javascript"></script>
@endsection
