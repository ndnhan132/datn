<div id="list-course" class="mainbox">
    <div>
        @include('front.home.header-title', ['title' => 'Danh sách lớp mới'])
        <div class="table-responsive">
        <table class="table table-striped table-bordered">
            <thead class="bg-primary text-white">
                <tr class="text-nowrap">
                    <th>Mã số</th>
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
                    <td>{{ $course->code }}</td>
                    <td class="text-capitalize">{{ $course->subject->display_name }}</td>
                    <td>{{ $course->time_working }}</td>
                    <td>{{ $course->address }}</td>
                    <td>{{ $course->tuition_per_month . ' đ/tháng' }}</td>
                <td>{{ $course->other_requirement }}</td>
                <td>{{ 'Chưa nhận' }}</td>
                </tr>
            @endforeach
            </tbody>
        </table>
        </div>
    </div>
    <div class="w-100 d-flex">
        <a href="./" class="btn btn-sm btn-primary rounded-pill text-uppercase px-4 ml-auto">Xem thêm</a>
    </div>
</div>
