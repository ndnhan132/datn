<div class="table-responsive list-course">
    <table class="table table-striped table-bordered">
        <thead class="bg-primary text-white">
            <tr class="text-nowrap">
                <th>Môn học</th>
                <th>Yêu cầu</th>
                <th>Học phí</th>
                <th>Thời gian</th>
                <th class="text-center"><span>Xem</span></th>
            </tr>
        </thead>
        <tbody>
        @foreach ($myReceived as $reg)
            <tr>
                <td><span>{{$reg->course->getSubjectAndLevel() ?? ''}}</span></td>
                <td><span>{{$reg->course->getDisplayTeacherLevelAndGender() ?? ''}}</span></td>
                <td><span>{{$reg->course->getDisplayTution() ?? ''}}</span></td>
                @if ($reg->updated_at)
                <td><span>{{date_format( $reg->updated_at, 'd/m/Y') }}</span></td>
                @else
                <td><span>--/--/----</span></td>
                @endif
                <td class="text-center">
                    <span class="btn-view-course" data-course="{{ $reg->course_id }}"><i class="fas fa-eye"></i></span>
                </td>
            </tr>
        @endforeach
        </tbody>
    </table>
</div>
<div class="modal fade modal-custom" id="view-course-modal" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
    <div class="modal-dialog">
      <div class="modal-content">
        <div class="modal-header">
          <h5 class="modal-title course-title border-0 text-capitalize" id="exampleModalLabel"></h5>
          <button type="button" class="close" data-dismiss="modal" aria-label="Close">
            <span aria-hidden="true">&times;</span>
          </button>
        </div>
        <div class="modal-body">
            <div>
                <table class="table table-sm table-bordered">
                    <tr>
                        <td>Người gửi</td>
                        <td col-span="2" class="course-val course-name">asdasdasd</td>
                    </tr>
                    <tr>
                        <td>Địa chỉ</td>
                        <td col-span="2" class="course-val course-address"></td>
                    </tr>
                    <tr>
                        <td>Điện thoại</td>
                        <td col-span="2" class="course-val course-phone"></td>
                    </tr>
                    <tr>
                        <td>Email</td>
                        <td col-span="2" class="course-val course-email"></td>
                    </tr>
                    <tr>
                        <td>Lương / buổi</td>
                        <td col-span="2" class="course-val course-tuition_per_month"></td>
                    </tr>
                    <tr>
                        <td>Môn học</td>
                        <td col-span="2" class="course-val course-subject"></td>
                    </tr>
                    <tr>
                        <td>Môn học khác</td>
                        <td col-span="2" class="course-val course-other_subject"></td>
                    </tr>
                    <tr>
                        <td>Khối lớp</td>
                        <td col-span="2" class="course-val course-level"></td>
                    </tr>
                    <tr>
                        <td>Khối lớp khác</td>
                        <td col-span="2" class="course-val course-other_level"></td>
                    </tr>
                    <tr>
                        <td>Yêu cầu giáo viên</td>
                        <td col-span="2" class="course-val course-teacher_level"></td>
                    </tr>
                    <tr>
                        <td>Yêu cầu giáo viên khác</td>
                        <td col-span="2" class="course-val course-other_teacher_level"></td>
                    </tr>
                    <tr>
                        <td>Yêu cầu giới tính</td>
                        <td col-span="2" class="course-val course-teacher_gender"></td>
                    </tr>
                    <tr>
                        <td>Thời gian dạy</td>
                        <td col-span="2" class="course-val course-time_working"></td>
                    </tr>
                    <tr>
                        <td>Số buổi / tuần</td>
                        <td col-span="2" class="course-val course-session_per_week"></td>
                    </tr>
                    <tr>
                        <td>Số học sinh</td>
                        <td col-span="2" class="course-val course-num_of_student"></td>
                    </tr>
                    <tr>
                        <td>Yêu cầu khác</td>
                        <td col-span="2" class="course-val course-other_requirement"></td>
                    </tr>
                    <tr>
                        <td>Ngày gửi</td>
                        <td col-span="2" class="course-val course-created_at">dasdsad</td>
                    </tr>
                </table>
            </div>
        </div>
      </div>
    </div>
  </div>

  <script>
    $(function() {
        $(document).on('click', '.btn-view-course', function() {
            var _modal = $('#view-course-modal');
            var courseId = $(this).data('course');
            _modal.find('.modal-body .course-val').empty();

            $.ajax({
                url: '/ajax/get-course-by-id/' + courseId,
                type: 'GET',
            })
            .done(function(data) {
                console.log(data);
                if(data.success){
                    var course = data.data;
                    console.log(course);
                    _modal.find('.modal-title').empty().append(course.title);
                    _modal.find('.course-name').empty().append(course.fullname);
                    _modal.find('.course-address').empty().append(course.address);
                    _modal.find('.course-phone').empty().append(course.phone);
                    _modal.find('.course-email').empty().append(course.email);
                    _modal.find('.course-tuition_per_month').empty().append(course.tuition_per_month + ' VND');
                    _modal.find('.course-subject').empty().append(course.subject.display_name);
                    if(course.other_subject){
                        _modal.find('.course-other_subject').empty().append(course.other_subject);
                    }else{
                        _modal.find('.course-other_subject').empty().append('Không');
                    }
                    _modal.find('.course-level').empty().append(course.course_level.display_name);
                    if(course.other_course_level){
                        _modal.find('.course-other_level').empty().append(course.other_course_level);
                    }else{
                        _modal.find('.course-other_level').empty().append('Không');
                    }
                    _modal.find('.course-teacher_level').empty().append(course.teacher_level.display_name);
                    var gender = 'Không';
                    if(course.teacher_gender == 'MALE') gender = 'Nam';
                    if(course.teacher_gender == 'FEMALE') gender = 'Nữ';
                    _modal.find('.course-teacher_gender').empty().append(gender);
                    if(course.other_teacher_level){
                        _modal.find('.course-other_teacher_level').empty().append(course.other_teacher_level);
                    }else{
                        _modal.find('.course-other_teacher_level').empty().append('Không');
                    }
                    _modal.find('.course-time_working').empty().append(course.time_working);
                    _modal.find('.course-session_per_week').empty().append(course.session_per_week);
                    _modal.find('.course-num_of_student').empty().append(course.num_of_student);
                    _modal.find('.course-other_requirement').empty().append(course.other_requirement);
                    _modal.find('.course-created_at').empty().append(course.created_at);
                    _modal.modal('show');
                }
            })
            .fail(function (jqXHR, textStatus, errorThrown) {
                console.log("error");
                alert(errorThrown);
            });
        });
    });
    </script>
