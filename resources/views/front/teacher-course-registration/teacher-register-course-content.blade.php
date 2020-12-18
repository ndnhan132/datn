
    <div class="coursedetail-box mt-0">
        <div class="w-100">
            <div class="w-100 p-0 p-md-1 p-lg-2 p-xl-3">
                <div class="d-flex flex-wrap">
                    <div class="col-12 col-sm-6 px-0">
                        <span class="text-nowrap"><span>Môn dạy&nbsp;&nbsp;:</span></span>
                        <span class="text-capitalize">{{ $course->subject->display_name ?? 'Chưa rõ' }}</span>
                    </div>
                    <div class="col-12 col-sm-6 px-0">
                        <span class="text-nowrap"><span>Lớp dạy&nbsp;&nbsp;&nbsp;:</span></span>
                       <span class="text-capitalize">{{ $course->courseLevel->display_name ?? 'Chưa rõ' }}</span>
                    </div>
                    <div class="col-12 col-sm-6 px-0">
                        <span class="text-nowrap"><span>Thời gian&nbsp;:</span></span>
                        <span>{{ $course->session_per_week . ' Buổi/tuần' }}</span>
                    </div>
                    <div class="col-12 col-sm-6 px-0">
                        <span class="text-nowrap"><span>Học phí&nbsp;&nbsp;&nbsp;&nbsp;:</span></span>
                       <span>{{ $course->getDisplayTution() }} vnd</span>
                    </div>

                </div>
            </div>
        </div>
        <div class="w-100">
            <div class="col-12 p-0" id="teacher-course-registration-box"
                data-course-id="{{ $course->id }}">
                @include('front.teacher-course-registration.registration-box',
                ['courseId'=> $course->id])
            </div>
        </div>
    </div>










    <div class="mainbox mb-3 mb-md-4">
        <h3 class="w-100 text-center text_georgia">DANH SÁCH GIA SƯ ĐÃ ĐĂNG KÝ</h3>
        <div class="w-100">
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
                            <td class="text-capitalize  align-middle text-nowrap p-1">
                                <span>{{ $teacher->name }}</span></td>
                            <td class="text-capitalize align-middle text-nowrap p-1">
                                <span>{{ $teacher->getGenderAndLevel() }}</span>
                            </td>
                            <td class="text-center  align-middle text-nowrap p-1">
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
    </div>
