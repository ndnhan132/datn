<div class="d-flex flex-wrap  opacity_transition_effect">
    @foreach ($courses as $course)
    <div class="col-12 col-sm-12 col-md-6 col-lg-6 col-xl-4 pl-3 pr-0">
        <div class="list-class-item {{ ($course->received()) ? 'received' : '' }}">
            <div class="border-bottom item-header">
                <h6 class="text-left text-uppercase">
                    {{'#' . $course->id}} {{ ($course->received()) ? 'Lớp đã có người nhận' : 'Lớp cần  gia sư' }}
                </h6>
            </div>
            <div class="item-body">
                <ul class="list-unstyled">
                    <li>
                        <span class="font-weight-bold--">Môn dạy: </span><span class="text-capitalize bold text-info">{{ $course->getSubjectAndLevel() }}</span>
                    </li>
                    <li class="address">
                        <span class="font-weight-bold--">Địa chỉ: </span><span class="text-capitalize bold text-dark">{{ $course->address }}</span>
                    </li>
                    <li>
                        <span class="font-weight-bold--">Mức lương: </span><span class="text-capitalize bold text-danger">{{ $course->getDisplayTution() . ' VNĐ' }}</span>
                    </li>
                    <li>
                        <span class="font-weight-bold--">Thời gian dạy: </span><span class="bold">{{ $course->time_working }}</span>
                    </li>
                    <li>
                        <span class="font-weight-bold--">Số buổi: </span><span class="bold">{{ $course->session_per_week . ' Buổi/Tuần - ' . $course->time_per_session . ' Phút/Buổi'}}</span>
                    </li>
                    <li>
                        <span class="font-weight-bold--">Yêu cầu: </span><span class="bold">{{ $course->getDisplayTeacherLevelAndGender() }}</span>
                    </li>

                {{-- <p class="card-text">flg confirm {{ $course->flag_is_confirmed }}</p>
                <p class="card-text">id {{ $course->id }}</p>
                <p class="card-text">status: {{ ($course->received()) ? 'received' : 'not received' }}</p> --}}
                </ul>

                {{-- <p class="card-text">{{ $course->getDisplayTeacherLevelAndGender() }}</p> --}}
                <div class="w-100 d-flex mt-0">
                    @if ($course->received())
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
