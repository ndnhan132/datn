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
<div class="modal fade modal-create-course" tabindex="-1"
	role="dialog">
	<div class="modal-dialog" role="document">
		<div class="modal-content rounded-0">
			<div class="modal-header py-2 border-bottom-0 bg-primary rounded-0">
				<h5 class="modal-title text-white" id="exampleModalLabel"><i class="fa fa-info-circle"></i> Lớp học mới</h5>
				<button type="button" class="close" data-dismiss="modal"
					aria-label="Close">
					<span aria-hidden="true">&times;</span>
				</button>
			</div>
			<div class="modal-body py-0 my-3">
				<form class="new-course-form">
					<div class="form-group">
					  <label for="">Môn dạy</label>
					  <select class="form-control selectOnChange" name="subject">
						  <option value=""></option>
						@foreach ($subjects as $item)
						<option value="{{$item->id}}">{{ $item->display_name}}</option>
						@endforeach
					  </select>

					</div>
					<div class="form-group">
					  <label for="">Khối lớp</label>
					  <select class="form-control selectOnChange" name="course_level">
						  <option value=""></option>
						@foreach ($courseLevels as $item)
						<option value="{{$item->id}}" >{{ $item->display_name}}</option>
						@endforeach
					  </select>
					</div>
					<div class="form-group">
						<label for="">Số buổi học mỗi tuần</label>
						<select class="form-control" name="session_per_week" readonly>
							<option value="3">3</option>
						</select>
					  </div>
					  <div class="form-group">
						<label>Học phí (vnd)</label>
						<input type="text" class="form-control" name="tuition_per_session">
					  </div>
					<div class="form-group d-flex">
						<span class="coursealert">

						</span>
						<input type="hidden" name="course_id">
						<button type="submit" class="btn btn-primary ml-auto">Lưu</button>
					</div>
				  </form>
			</div>
		</div>
	</div>
</div>
@endsection
@section('javascript')
<script>

</script>
@endsection
