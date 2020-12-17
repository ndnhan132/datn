<div id="list-course" class="mainbox">
    <div>
        @include('front.home.header-title', ['title' => 'Danh sách lớp mới'])
        <div class="table-responsive">
        <table class="table table-striped table-bordered">
            <thead class="bg-primary text-white">
                <tr class="text-nowrap">
                    <th>Môn học</th>
                    <th>Khối lớp</th>
                    <th>Học phí</th>
                    <th>Số buổi</th>
                    <th>Giáo viên đăng ký</th>
                    {{-- <th>Tình trạng</th> --}}
                </tr>
            </thead>
            <tbody>
            @foreach ($courses as $course)
                <tr>
                    <td class="text-capitalize">{{ $course->subject->display_name ?? '' }}</td>
                    <td class="text-capitalize">{{ $course->courseLevel->display_name ?? '' }}</td>
                    <td>{{ $course->tuition_per_session . ' đ/buổi' }}</td>
                    <td>{{ $course->session_per_week ?? '' }}</td>
                <td>{{ count($course->teacherCourseRegistrations->where('registration_status_id', \App\Models\RegistrationStatus::ELIGIBLE_ID)) }}</td>
                </tr>
            @endforeach
            </tbody>
        </table>
        </div>
    </div>
    <div class="w-100 d-flex">
        <a href="{{ route('front.getAllClassPage') }}" class="btn btn-sm btn-primary rounded-pill text-uppercase px-4 ml-auto">Xem thêm</a>
    </div>
</div>
