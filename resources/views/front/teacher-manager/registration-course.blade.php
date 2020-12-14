@extends('front.layouts.teacher-manager-master')
@section('title', 'Danh sách lớp đẵ đăng ký')
@section('head')
@endsection
@section('content')
@php
    $teacher = Auth::guard('teacher')->user();
    $registrations = $teacher->teacherCourseRegistrations->sortByDesc('id')->all();
    $myReceived = $teacher->getMyReceivedRegistration();
@endphp
<div class="form-wrap- mb-5" id="profile">
    <div>
        <div class="row d-flex flex-wrap pb-4">
            <div class="form-group col-sm-12">
                <div class="col-sm-12">
                    <div class="profile-box d-flex flex-wrap">
                        <div class="col-12" id="all-courses">
                            @include('front.teacher-manager.all-course')
                        </div>
                    </div>
                </div>
            </div>

            <div class="form-group col-sm-12">
                <div class="col-sm-12">
                    <div class="profile-box d-flex flex-wrap">
                        <div class="col-12">
                            <div class="d-flex flex-column">
                                <h5 class="text-capitalize name">Lớp đã nhận</h5>
                                @if ($myReceived)
                                @include('front.teacher-manager.registed-course')
                                @else
                                <span>Chưa Nhận lớp nào</span>
                                @endif
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
<script>
    $(function() {
        $(document).on('click', '.btn-del-registration', function() {
            Swal.fire({
            title: 'Bạn chắc chắn xoá đăng ký lớp này!',
            showDenyButton: true,
            // showCancelButton: true,
            confirmButtonText: 'Xoá',
            denyButtonText: 'Không',
        }).then((result) => {
            if (result.isConfirmed) {

                $.ajax({
                    url: '/ajax/delete-registration',
                    type: 'POST',
                    dataType: 'json',
                    data : {courseId: $(this).data('course')},
                })
                .done(function(data) {
                    console.log(data);
                    if(data.success){
                        $(document).find('#all-courses').empty().append(data.html);
                        Swal.fire({
                            title: 'Đã xoá',
                            icon: 'success',
                            showConfirmButton: false,
                            timer: 1500
                        });
                    }
                });
            }
        });


        });
    });
</script>
@endsection
