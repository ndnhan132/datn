<div id="list-course">
    <div>
        @include('front.home.header-title', ['title' => 'Danh sách lớp mới', 'icon' => 'fas fa-star-of-life'])
    <div class="d-flex flex-wrap">

            @foreach ($courses as $course)
                <div class="col-lg-6">
                    <div class="card">
                        <div class="card-header">
                            {{ $course->subject->display_name }}
                        </div>
                        <div class="card-body">
                          <h5 class="card-title">{{ $course->subject->display_name }}</h5>
                          <p class="card-text">{{ $course->time_working }}</p>
                          <p class="card-text">{{ $course->address }}</p>
                          <p class="card-text">{{ $course->tuition_per_month }}</p>
                          <p class="card-text">{{ $course->getRequiredGenderAndLevel() }}</p>
                          <a href="{{ route('front.teacherRegisterCourse', $course->slug) }}" class="btn btn-primary">Đăng ký ngay</a>
                        </div>
                      </div>
                </div>
            @endforeach

    </div>
    </div>
</div>
