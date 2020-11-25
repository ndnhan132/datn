
    <div class="coursedetail-box mt-0">
        <div class="w-100">
            <table class="w-100 p-4">
                <tbody>
                    <tr>
                        <td class="text-nowrap"><span>Môn dạy:</span></td>
                        <td><span class="text-capitalize">{{ $course->getDisplaySubject() }}</span></td>
                    </tr>
                    <tr>
                        <td class="text-nowrap"><span>Lớp dạy:</span></td>
                        <td><span class="text-capitalize">{{ $course->getDisplayCourseLevel() }}</span></td>
                    </tr>
                    <tr>
                        <td class="text-nowrap">Địa chỉ:</td>
                        <td>{{ $course->address }}</td>
                    </tr>
                    <tr>
                        <td class="text-nowrap"><span>Người gửi:</span></td>
                        <td><span>{{ $course->fullname }}</span></td>
                    </tr>
                    <tr>
                        <td class="text-nowrap"><span>Số lượng học sinh</span></td>
                        <td><span>{{ $course->num_of_student }}</span></td>
                    </tr>
                    <tr>
                        <td class="text-nowrap"><span>Thời gian</span></td>
                        <td><span>{{ $course->getDisplayTimeAll() }}</span></td>
                    </tr>
                    <tr>
                        <td class="text-nowrap"><span>Lương tháng</span></td>
                        <td><span>{{ $course->getDisplayTution() }} VND</span></td>
                    </tr>
                    <tr>
                        <td class="text-nowrap"><span>Yêu cầu giáo viên:</span></td>
                        <td><span>{{ $course->getDisplayTeacherLevelAndGender() }}</span></td>
                    </tr>
                    <tr>
                        <td class="text-nowrap"><span>Yêu cầu khác:</span></td>
                        <td><span>{{ $course->other_requirement ?? '' }}</span></td>
                    </tr>

                </tbody>
            </table>
        </div>
        <div class="w-100">
            @if ($course->flag_is_confirmed)
            <div class="col-12 p-0" id="teacher-course-registration-box"
                data-course-id="{{ $course->id }}">
                @if ($course->received())
                <span class="text-nowrap">Trạng thái: </span>Lớp đã có người nhận
                @else
                @include('front.teacher-course-registration.registration-box',
                ['courseId'=> $course->id])
                @endif
            </div>
            @else
            <div class="text-secondary mt-3">
                <span class="text-nowrap">Trạng thái: </span>Lớp chưa xét duyệt
            </div>
            @endif
        </div>
    </div>











    @if ($course->flag_is_confirmed)
    <div class="mainbox">
        <h3 class="w-100 text-center">DANH SÁCH GIA SƯ ĐÃ ĐĂNG KÝ</h3>
        <div class="table-responsive">
            @php
            $registrations = $course->teacherCourseRegistrations->sortByDesc('id')->all();
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
                        <td><img src="{{ asset($teacher->getAvatarSrc()) }}"
                                alt="Hình ảnh đại diện" width="50" height="70">
                        </td>
                        <td class="text-capitalize">
                            <span>{{ $teacher->name }}</span></td>
                        <td class="text-capitalize">
                            <span>{{ $teacher->getGenderAndLevel() }}</span>
                        </td>
                        <td class="text-center">
                            @if ($record->isReceived())
                            <span class="text-success">Đã nhận</span>
                            @elseif ($record->isPendding())
                            <span class="text-warning">Chưa Kiểm tra</span>
                            @elseif ($record->isEligible())
                            <span class="text-info">Đủ điều kiên</span>
                            @else
                            <span class="text-secondary">Không đủ điều
                                kiên</span>
                            @endif
                        </td>
                    </tr>
                    @endforeach
                </tbody>
            </table>
        </div>
    </div>
    @endif
