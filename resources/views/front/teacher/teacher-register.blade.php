@extends('front.layouts.app')
@section('title', 'Trang chủ')
@section('head')
@endsection
@section('content')
<div class="container mt-3">
    <div class="d-flex">
        <div class="col-3 pl-md-0">
            @include('front.home.asidebar')
        </div>
        <div class="col-9 pr-md-0">
            @include('front.teacher.register-form');
        </div>
    </div>
</div>
@endsection
@section('javascript')
    <script type="text/javascript">
    $(document).on('click', 'form#teacher-register-form .submit', function(event) {
        event.preventDefault();
        var formData = $('#teacher-register-form').serialize()
        $.ajax({
            url: '/front/ajax/teacher/store',
            type: 'POST',
            dataType: 'json',
            data: formData,
        })
        .done(function(data) {
          alert(data);
        })
        .fail(function(jqXHR, textStatus, errorThrown) {
          console.log("error");
        })
        .always(function(data, textStatus,errorThrown ) {
            console.log("complete");
        });
    });

    </script>
@endsection
