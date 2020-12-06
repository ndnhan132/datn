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
			<span type="button" class="btn-table-reload px-3 d-none"><i
					class="fa fa-refresh"></i></span>
		</h1>
	</div>
</div>
<div class="row teacher-course-registration" id="content-table">
	@include('admin.layouts.blank')
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
