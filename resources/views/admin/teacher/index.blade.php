@extends('admin.layouts.app')
@section('title', 'Danh sách gia sư')
@section('head')
@endsection
@section('content')
    <div class="app-title">
      <div>
        <h1><i class="fa fa-th-list"></i>&nbsp;&nbsp;Quản lý giáo viên</h1>
      </div>
      <ul class="app-breadcrumb breadcrumb">
        <li class="breadcrumb-item"><i class="fa fa-home fa-lg"></i></li>
                <li class="breadcrumb-item">Tables</li>
        <li class="breadcrumb-item active"><a href="#"></a></li>
      </ul>
    </div>

    <div class="row">
      <div class="col-md-12 px-0">
        <div class="tile">
          {{-- <h3 class="tile-title">
            <i class="fa fa-table pr-2"></i>&nbsp;Danh sách gia sư
          </h3> --}}
          <div class="table-responsive">
            <table class="table table-bordered table-hover">
              <thead>
                <tr>
                  <th>Ảnh</th>
                  <th>Họ & tên</th>
                  <th>Email</th>
                  <th>Địa chỉ</th>
                  <th>Trình độ</th>
                  <th>Trình độ</th>
                </tr>
              </thead>
              <tbody>
               @foreach ($teachers as $teacher)
               {{ \Debugbar::debug($teacher) }}
               <tr>
                 <td><img src="{{ asset('web-admin/images/user.png') }}" alt="" width="50" height="50"></td>
               <td>{{ $teacher->name }}</td>
               <td>{{ $teacher->email }}</td>
               <td>{{ $teacher->address }}</td>
               <td>{{ $teacher->level }}</td>
               <td>{{ $teacher->speciality }}</td>
              </tr>
               @endforeach
              </tbody>
            </table>
          </div>
        </div>
      </div>
    </div>
@endsection
@section('javascript')
@endsection
