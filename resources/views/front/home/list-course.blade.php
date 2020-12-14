<div id="list-course" class="mainbox">
    <div>
        @include('front.home.header-title', ['title' => 'Danh sách lớp mới'])
        <div class="table-responsive">
        <table class="table table-striped table-bordered">
            <thead class="bg-primary text-white">
                <tr class="text-nowrap">
                    <th>Môn học</th>
                    <th>Thời gian</th>
                    <th>Địa chỉ</th>
                    <th>Học phí</th>
                    <th>Yêu cầu</th>
                    <th>Tình trạng</th>
                </tr>
            </thead>
            <tbody>
            @foreach ($courses as $course)
                <tr>
                    <td class="text-capitalize">{{ $course->subject->display_name }}</td>
                    <td>{{ $course->time_working }}</td>
                    <td>{{ $course->address }}</td>
                    <td>{{ $course->tuition_per_session . ' đ/tháng' }}</td>
                <td>
                <span title="{{ $course->other_requirement }}">{{ (strlen($course->other_requirement) > 50) ? (substr($course->other_requirement, 0, 50). '...') : ($course->other_requirement) }}</span>
            </td>
                <td>{{ 'Chưa nhận' }}</td>
                </tr>
            @endforeach
            </tbody>
        </table>
        </div>
    </div>
    <div class="w-100 d-flex">
        <a href="{{ route('front.getNotReceivedClassPage') }}" class="btn btn-sm btn-primary rounded-pill text-uppercase px-4 ml-auto">Xem thêm</a>
    </div>
</div>
