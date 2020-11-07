<div class="row">
    <table>
        <tbody>
            <tr>
                <td class="font-weight-bold">Môn dạy:</td>
                <td>{{ $course->subject->display_name }}</td>
            </tr>
            <tr>
                <td class="font-weight-bold">Lớp dạy:</td>
                <td>{{ $course->courseLevel->display_name }}</td>
            </tr>
            <tr>
                <td class="font-weight-bold">Địa chỉ:</td>
                <td>{{ $course->address }}</td>
            </tr>
        </tbody>
    </table>
</div>
<div class="row">
    <div class="col-12 p-0" id="teacher-course-registration-box" data-course-id="{{ $course->id }}">
        @if ($course->received())
            Lớp đã  có người nhận
        @else
        @include('front.teacher-course-registration.registration-box', ['courseId'=> $course->id])
        @endif
    </div>
</div>
<div class="row">
    <h3 class="w-100 text-center">Danh sách gia sư đã đăng ký</h3>
    <div  class="table-responsive">
        @php
            $registrations = $course->teacherCourseRegistrations;
        @endphp
        <table class="table table-striped table-bordered">
            <thead class="bg-success text-white">
                <tr class="text-nowrap">
                    <th>Ảnh</th>
                    <th>Họ tên</th>
                    <th>Thông tin</th>
                    <th class="text-center">Trạng thái</th>
                </tr>
            </thead>
            <tbody>
            @foreach ($registrations as $record)
                @php
                    $teacher = $record->teacher;
                @endphp
                <tr>
                    <td><img src="{{ asset($teacher->getAvatarSrc()) }}" alt="Hình ảnh đại diện" width="50" height="70"></td>
                    <td class="text-capitalize"><span>{{ $teacher->name }}</span></td>
                    <td class="text-capitalize"><span>{{ $teacher->getGenderAndLevel() }}</span></td>
                    <td class="text-center">
                        @if ($record->isReceived())
                        <span class="text-success">Đã nhận</span>
                        @elseif ($record->isPendding())
                        <span class="text-warning">Chưa Kiểm tra</span>
                        @elseif ($record->isEligible())
                        <span class="text-info">Đủ điều kiên</span>
                        @else
                        <span class="text-secondary">Không đủ điều kiên</span>
                        @endif
                    </td>
                </tr>
            @endforeach
            </tbody>
        </table>
    </div>
</div>
