<div id="list-course" class="mainbox">
    <div>
        @include('front.home.header-title', ['title' => 'Danh sách lớp mới'])
        <div class="table-responsive- w-100">
        <table class="table table-striped table-bordered w-100"  style="table-layout:fixed">
            <thead class="bg-primary text-white">
                <tr class="text-nowrap">
                    <th class="text-center">Môn học</th>
                    <th class="text-center">Khối lớp</th>
                    <th class="text-center">Học phí</th>
                    <th class="text-center">Số buổi</th>
                    <th class="text-center">Giáo viên đăng ký</th>
                    {{-- <th>Tình trạng</th> --}}
                </tr>
            </thead>
            <tbody>
            @foreach ($courses as $course)
                <tr>
                    <td class="text-capitalize text-center">{{ $course->subject->display_name ?? '' }}</td>
                    <td class="text-capitalize text-center">{{ $course->courseLevel->display_name ?? '' }}</td>
                    <td class="text-center">{{ $course->tuition_per_session . ' đ/buổi' }}</td>
                    <td class="text-center">{{ $course->session_per_week ?? '' }}</td>
                    <td class="text-center">{{ count($course->teacherCourseRegistrations->where('registration_status_id', \App\Models\RegistrationStatus::ELIGIBLE_ID)) }}</td>
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
