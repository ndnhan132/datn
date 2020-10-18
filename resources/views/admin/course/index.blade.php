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
			&nbsp;&nbsp;Quản lý giáo viên
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
	<div class="alert alert-warning w-100 h-100" role="alert">
		A simple warning alert—check it out!
	  </div>
</div>

<div class="modal fade modal-custom" id="js-modal-course-detail" tabindex="-1"
	role="dialog">
	<div class="modal-dialog" role="document">
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
			{{-- <div class="modal-footer py-2">
                  <button class="btn btn-sm btn-primary submit px-3">
                      lưu
                  </button>
                  &nbsp;&nbsp;&nbsp;
                  <button class="btn btn-sm btn-secondary px-3"  data-dismiss="modal">
                     Huỷ
                  </button>
              </div> --}}
		</div>
	</div>
</div>

@endsection
@section('javascript')
<script src="{{asset('/web-admin/js/onepage/course.js') . '?' . time() }}"
	type="text/javascript"></script>
@endsection
