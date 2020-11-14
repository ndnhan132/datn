@include('front.home.header-title', ['title' => 'Danh sách lớp mới'])
<div class="d-flex flex-wrap">
    @foreach ($courses as $course)
    <div class="col-lg-3 pl-3 pr-0">
        <div class="card mainbox">
            <div class="card-header">
                {{ $course->subject->display_name }}
            </div>
            <div class="card-body-">
                {{-- <h5 class="card-title">{{ $course->subject->display_name }}</h5> --}}
                {{-- <p class="card-text">{{ $course->time_working }}</p>
                <p class="card-text">{{ $course->address }}</p>
                <p class="card-text">{{ $course->tuition_per_month }}</p> --}}

                <p class="card-text">flg confirm {{ $course->flag_is_confirmed }}</p>
                <p class="card-text">id {{ $course->id }}</p>
                <p class="card-text">status: {{ ($course->received()) ? 'received' : 'not received' }}</p>


                {{-- <p class="card-text">
                    {{ $course->getRequiredGenderAndLevel() }}</p>
                <a href="{{ route('front.teacherRegisterCourse', $course->slug) }}"
                    class="btn btn-primary">Đăng ký ngay</a> --}}
            </div>
        </div>
    </div>
    @endforeach
</div>
{{-- {{ dd($max)}} --}}
@isset($max)
@if($max > 1)
<div class="pagination-wrapper">
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
