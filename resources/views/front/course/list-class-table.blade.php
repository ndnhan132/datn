@isset($total)
<div class="w-100 opacity_transition_effect">
    <div class="col-12 px-0">
        <div class="total-results">
            <span>{{ $total }} Kết quả tìm thấy</span>
        </div>
    </div>
</div>
@endisset
<div class="d-flex flex-wrap  opacity_transition_effect">
    @foreach ($courses as $course)
    <div class="col-12 col-sm-6 col-md-4 col-lg-4 col-xl-4 px-0 px-sm-2 pr-0">
        <div class="list-class-item">
            <div class="border-bottom item-header">
                <h6 class="text-left text-uppercase">
                    {{'#' . $course->id}} {{ $course->getSubjectAndLevel() }}
                </h6>
            </div>
            <div class="item-body">
                <ul class="list-unstyled">
                    <li>
                        <span class="font-weight-bold--">Môn học: </span><span class="text-capitalize bold text-info">{{ $course->subject->display_name ?? 'Chưa rõ' }}</span>
                    </li>
                    <li>
                        <span class="font-weight-bold--">Khối lớp: </span><span class="text-capitalize bold text-info">{{ $course->courseLevel->display_name ?? 'Chưa rõ' }}</span>
                    </li>
                    <li>
                        <span class="font-weight-bold--">Học phí: </span><span class="text-capitalize bold text-danger">{{ $course->getDisplayTution() . ' VNĐ' }}</span>
                    </li>
                    <li>
                        <span class="font-weight-bold--">Số buổi: </span><span class="bold">{{ $course->session_per_week . ' Buổi/Tuần'}}</span>
                    </li>
                </ul>
                <div class="w-100 d-flex mt-0">
                    @if (Auth::guard('teacher')->check() && Auth::guard('teacher')->user()->isRegisteredThisCourse($course->id))
                    <a href="{{ route('front.teacherRegisterCourse', $course->slug) }}" class="btn btn-sm rounded-pill- rounded-0 text-uppercase px-2 py-1 ml-auto text-white" style="background: orange;">Xem chi tiết</a>
                    @else
                    <a href="{{ route('front.teacherRegisterCourse', $course->slug) }}" class="btn btn-sm btn-primary rounded-pill- rounded-0 text-uppercase px-2 py-1 ml-auto">Đăng ký ngay</a>
                    @endif
                </div>
            </div>
        </div>
    </div>
    @endforeach
</div>
@isset($max)
@if($max > 1)
<div class="pagination-wrapper mt-3  opacity_transition_effect">
    <ul class="pagination pagination-sm flex-wrap justify-content-center">
        @for($i = 1; $i <= $max; $i++) <li
            class="page-item {{ $i == $page ? 'active' : '' }}"><button
                class="page-link pagination-item"
                data-pagenum="{{ $i }}">{{ $i }}</button></li>
            @endfor
    </ul>
</div>
@endif
@endisset
