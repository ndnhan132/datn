@extends('front.layouts.app')
@section('title', 'Trang chủ')
@section('head')
@endsection
@section('content')
    @include('front.course.register-form');
@endsection
@section('javascript')
    <script type="text/javascript">
    $(document).on('click', 'form#course-register-form .submit', function(event) {
        event.preventDefault();
        var formData = $('#course-register-form').serialize()
        $.ajax({
            url: '/front/ajax/course/store',
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
