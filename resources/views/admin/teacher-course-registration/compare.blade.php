@php
    $course = $registration->course;
    $teacher = $registration->teacher;
@endphp
<div class="container-fluid" id="js-teacher-course-registration-compare">
    <div class="row">
        <div class="col-md-6">
            <h4 class="border-bottom">Yêu cầu</h4>
            <table class="table table-borderless">
                <tbody>
                    <tr>
                        <td class="text-nowrap"><span>Môn học</span></td>
                        <td><span>{{ ($course->subject) ? $course->subject->display_name : $course->other_subject }}</span></td>
                    </tr>
                    <tr>
                        <td class="text-nowrap"><span>Lớp học</span></td>
                        <td><span>{{ ($course->courseLevel) ? $course->courseLevel->display_name : $course->other_teacher_level }}</span></td>
                    </tr>
                    <tr>
                        <td class="text-nowrap"><span class="text-nowrap">Số buổi / tuần</span></td>
                        <td><span>{{ $course->session_per_week . ' Buổi' }}</span></td>
                    </tr>
                    <tr>
                        <td class="text-nowrap"><span class="text-nowrap"></span>Học phí</td>
                        <td><span>{{ $course->tuition_per_session . ' vnd/Buổi' }}</span></td>
                    </tr>
                </tbody>
            </table>
        </div>
        <div class="col-md-6 border-left">
            <h4 class="border-bottom">Thông tin gia sư</h4>
            <table class="table table-borderless">
                <tbody>
                    <tr>
                        <td class="text-nowrap"><span>Họ tên</span></td>
                        <td><span>{{ $teacher->name }}</span></td>
                    </tr>
                    <tr>
                        <td class="text-nowrap"><span>Giới tính</span></td>
                        <td>
                            @if ($teacher->is_male)
                            <span>Nam</span>
                            @else
                            <span>Nữ</span>
                            @endif
                        </td>
                    </tr>
                    <tr>
                        <td class="text-nowrap"><span>Trương học</span></td>
                        <td><span>{{ $teacher->university }}</span></td>
                    </tr>
                    <tr>
                        <td class="text-nowrap"><span>Chuyên ngành</span></td>
                        <td><span>{{ $teacher->speciality }}</span></td>
                    </tr>
                    <tr>
                        <td class="text-nowrap"><span>Trình độ</span></td>
                        <td><span>{{ $teacher->teacherLevel->display_name }}</span></td>
                    </tr>
                    <tr>
                        <td class="text-nowrap"><span>Môn dạy</span></td>
                        <td><span>{{ $teacher->getDisplaySubject() }}</span></td>
                    </tr>
                    <tr>
                        <td class="text-nowrap"><span>Khối lớp</span></td>
                        <td><span>{{ $teacher->getDisplayCourseLevel() }}</span></td>
                    </tr>
                    <tr>
                        <td class="text-nowrap"><span class="text-nowrap">Thông tin thêm</span></td>
                        <td><span>{{ $teacher->description ?? 'Không có' }}</span></td>
                    </tr>
                </tbody>
            </table>
        </div>
      </div>

      <div>
          <div class="w-100 text-right pt-3">

            {{-- <button class="btn btn-sm btn-success px-3 btn-confirm" data-registration-id="{{ $registration->id }}" data-status="{{ \App\Models\RegistrationStatus::RECEIVED_NAME }}"  data-course-id="{{ $course->id }}">
                    Đã nhận
                </button> --}}
                &nbsp;&nbsp;&nbsp;
                <button class="btn btn-sm btn-primary px-3 btn-confirm" data-registration-id="{{ $registration->id }}" data-status="{{ \App\Models\RegistrationStatus::ELIGIBLE_NAME }}" data-course-id="{{ $course->id }}">
                    Đủ điều kiện
                </button>
                &nbsp;&nbsp;&nbsp;
                <button class="btn btn-sm btn-secondary btn-confirm" data-registration-id="{{ $registration->id }}" data-status="{{ \App\Models\RegistrationStatus::INELIGIBLE_NAME }}"  data-course-id="{{ $course->id }}">
                    Ko đạt
                </button>
                &nbsp;&nbsp;&nbsp;
                <button class="btn btn-sm btn-warning px-3 btn-modal-dismiss text-white"  data-dismiss="modal">
                Huỷ
                </button>
            </div>
        </div>
</div>
