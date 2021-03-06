@if (Auth::guard('teacher')->check())
@php
$teacher = Auth::guard('teacher')->user();
@endphp

    @if ($teacher->isRegisteredThisCourse($courseId))
    <div class=" w-100 pt-3">
        <span class="text-danger font-weight-bold">* Bạn đã đăng ký lớp học này</span>
    </div>
    @else
    <div class=" w-100 pt-3">
        <a href="#" class="btn btn-sm btn-outline-primary btn-teacher-register-course">Nhận lớp ngay</a>
    </div>
    @endif

@else
<div class=" w-100 pt-3">
    <span class="text-danger font-weight-bold">* Gia sư cần đăng nhập để đăng ký nhận dạy lớp học này</span>
</div>
@endif
