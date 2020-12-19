@extends('admin.layouts.app')
@section('title', 'Dashboard')
@section('head')
@endsection
@section('content')
<div class="app-title">
    <div>
        <h1><i class="fa fa-dashboard"></i> Dashboard</h1>
        <p>Trung tâm gia sư Đà Nẵng</p>
    </div>
</div>

<div class="row">
    <div class="col-md-6 col-lg-3">
      <div class="widget-small primary coloured-icon"><i class="icon fa fa-graduation-cap fa-3x"></i>
        <div class="info">
          <h4>Gia sư</h4>
          <p><b class="count_teacher">00</b></p>
        </div>
      </div>
    </div>
    <div class="col-md-6 col-lg-3">
      <div class="widget-small info coloured-icon"><i class="icon fa fa-file-text-o fa-3x"></i>
        <div class="info">
          <h4>Lớp</h4>
          <p><b class="count_course">00</b></p>
        </div>
      </div>
    </div>
    <div class="col-md-6 col-lg-3">
      <div class="widget-small warning coloured-icon"><i class="icon fa fa-registered fa-3x"></i>
        <div class="info">
          <h4>Gia sư đk lớp</h4>
          <p><b class="count_teacher_reg">00</b></p>
        </div>
      </div>
    </div>
    <div class="col-md-6 col-lg-3">
      <div class="widget-small danger coloured-icon"><i class="icon fa fa-file-text fa-3x"></i>
        <div class="info">
          <h4>Phụ huynh đk lớp</h4>
          <p><b class="count_parent_reg">00</b></p>
        </div>
      </div>
    </div>
  </div>
@endsection
@section('javascript')
{{-- <script type="text/javascript" src="/web-admin/template/js/plugins/chart.js">
</script> --}}

<script>
    $(function() {
        $('.info .count_teacher').text('--');
        $('.info .count_course').text('--');
        $('.info .count_parent_reg').text('--');
        $('.info .count_teacher_reg').text('--');
        $.ajax({
            url: '/quan-ly/ajax/get-dashboard-count',
            type: 'GET',
        })
        .done(function(data) {
            console.log(data);
            if(data.success){
                $('.info .count_teacher').text('').text(data.count.teachers);
                $('.info .count_course').text('').text(data.count.courses);
                $('.info .count_parent_reg').text('').text(data.count.parent_reg);
                $('.info .count_teacher_reg').text('').text(data.count.teacher_reg);
            }
        });
    });

    </script>
@endsection
