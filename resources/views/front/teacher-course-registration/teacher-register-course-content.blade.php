
    <div class="coursedetail-box mt-0">
        <div class="w-100">
            <table class="w-100 p-4">
                <tbody>
                    <tr>
                        <td class="text-nowrap"><span>Môn dạy:</span></td>
                        <td><span class="text-capitalize">{{ $course->subject->display_name ?? 'Chưa rõ' }}</span></td>
                    {{-- </tr>
                    <tr> --}}
                        <td class="text-nowrap"><span>Lớp dạy:</span></td>
                        <td><span class="text-capitalize">{{ $course->courseLevel->display_name ?? 'Chưa rõ' }}</span></td>
                    </tr>
                    <tr>
                        <td class="text-nowrap"><span>Thời gian</span></td>
                        <td><span>{{ $course->session_per_week . 'Buổi/ tuần' }}</span></td>
                    {{-- </tr>
                    <tr> --}}
                        <td class="text-nowrap"><span>Học phí</span></td>
                        <td><span>{{ $course->getDisplayTution() }} vnd</span></td>
                    </tr>

                </tbody>
            </table>
        </div>
        <div class="w-100">
            <div class="col-12 p-0" id="teacher-course-registration-box"
                data-course-id="{{ $course->id }}">
                @include('front.teacher-course-registration.registration-box',
                ['courseId'=> $course->id])
            </div>
        </div>
    </div>










    <div class="mainbox">
        <h3 class="w-100 text-center">DANH SÁCH GIA SƯ ĐÃ ĐĂNG KÝ</h3>
        <div class="table-responsive">
            @php
            $registrations = $course->teacherCourseRegistrations->sortByDesc('id')->all();
            @endphp
            <table class="table table-striped table-bordered">
                <thead class="bg-primary text-white">
                    <tr class="text-nowrap">
                        <th>Ảnh</th>
                        <th>Họ tên</th>
                        <th>Trình độ</th>
                        <th class="text-center">Trạng thái</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach ($registrations as $record)
                    @php
                    $teacher = $record->teacher;
                    @endphp
                    <tr>
                        <td class="p-1 text-center"><img src="{{ asset($teacher->getAvatarSrc()) }}"
                                alt="Hình ảnh đại diện" width="50" height="70">
                        </td>
                        <td class="text-capitalize  align-middle">
                            <span>{{ $teacher->name }}</span></td>
                        <td class="text-capitalize align-middle">
                            <span>{{ $teacher->getGenderAndLevel() }}</span>
                        </td>
                        <td class="text-center  align-middle">
                            @if ($record->isPendding())
                            <span class="label-status bg-warning">Chưa xét duyệt</span>
                            @elseif ($record->isEligible())
                            <span class="label-status bg-info">Đủ điều kiên</span>
                            @else
                            <span class="label-status bg-secondary">Không đủ điều
                                kiên</span>
                            @endif
                        </td>
                    </tr>
                    @endforeach
                </tbody>
            </table>
        </div>
    </div>
