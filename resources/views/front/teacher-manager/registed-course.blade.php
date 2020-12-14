<div class="table-responsive list-course">
    <table class="table table-striped table-bordered">
        <thead class="bg-primary text-white">
            <tr class="text-nowrap">
                <th>Môn học</th>
                <th>Người gửi</th>
                <th>Học phí</th>
                <th>Thời gian</th>
                <th class="text-center"><span>Xem</span></th>
            </tr>
        </thead>
        <tbody>
        @foreach ($myReceived as $reg)
            <tr>
                <td><span>{{$reg->course->getSubjectAndLevel() ?? ''}}</span></td>
                <td><span>{{$reg->fullname ?? ''}}</span></td>
                <td><span>{{$reg->getDisplayTution() ?? ''}}</span></td>
                <td><span>{{ $reg->time_working }}</span></td>
                <td class="text-center">
                    <span class="btn-view-parentregister" data-parentregister="{{ $reg->id }}"><i class="fas fa-eye"></i></span>
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
                    <tr class="showIfReceived">
                        <td>Người gửi</td>
                        <td colspan="2" class="course-val course-name"></td>
                    </tr>
                    <tr class="showIfReceived">
                        <td>Địa chỉ</td>
                        <td colspan="2" class="course-val course-address"></td>
                    </tr>
                    <tr class="showIfReceived">
                        <td>Điện thoại</td>
                        <td colspan="2" class="course-val course-phone"></td>
                    </tr>
                    <tr  class="showIfReceived">
                        <td>Email</td>
                        <td colspan="2" class="course-val course-email"></td>
                    </tr>
                    <tr>
                        <td>Lương / buổi</td>
                        <td colspan="2" class="course-val course-tuition_per_session"></td>
                    </tr>
                    <tr>
                        <td>Môn học</td>
                        <td colspan="2" class="course-val course-subject"></td>
                    </tr>
                    <tr>
                        <td>Khối lớp</td>
                        <td colspan="2" class="course-val course-level"></td>
                    </tr>
                    <tr   class="showIfReceived">
                        <td>Thời gian dạy</td>
                        <td colspan="2" class="course-val course-time_working"></td>
                    </tr>
                    <tr>
                        <td>Số buổi / tuần</td>
                        <td colspan="2" class="course-val course-session_per_week"></td>
                    </tr>
                    <tr>
                        <td>Ngày gửi</td>
                        <td colspan="2" class="course-val course-created_at">dasdsad</td>
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
                    if(course.isReceived){
                        $(document).find('.showIfReceived').show();
                    }else{
                        $(document).find('.showIfReceived').hide();
                    }
                    _modal.find('.modal-title').empty().append(course.title);
                    _modal.find('.course-name').empty().append(course.fullname);
                    _modal.find('.course-address').empty().append(course.address);
                    _modal.find('.course-phone').empty().append(course.phone);
                    _modal.find('.course-email').empty().append(course.email);
                    _modal.find('.course-tuition_per_session').empty().append(course.tuition_per_session + ' VND');
                    _modal.find('.course-subject').empty().append(course.subject.display_name);
                    _modal.find('.course-level').empty().append(course.course_level.display_name);
                    _modal.find('.course-session_per_week').empty().append(course.session_per_week);
                    _modal.find('.course-created_at').empty().append(course.created_at);
                    _modal.modal('show');
                }
            })
            .fail(function (jqXHR, textStatus, errorThrown) {
                console.log("error");
                alert(errorThrown);
            });
        });

        $(document).on('click', '.btn-view-parentregister', function() {
            var _modal = $('#view-course-modal');
            var parentRegisterId = $(this).data('parentregister');
            _modal.find('.modal-body .course-val').empty();

            $.ajax({
                url: '/front/ajax/get-parent-register-by-id/' + parentRegisterId,
                type: 'GET',
            })
            .done(function(data) {
                console.log(data);
                if(data.success){
                    var register = data.data;
                    console.log(register);
                    if(register.isReceived){
                        $(document).find('.showIfReceived').show();
                    }else{
                        $(document).find('.showIfReceived').hide();
                    }
                    _modal.find('.modal-title').empty().append(register.title);
                    _modal.find('.course-name').empty().append(register.fullname);
                    _modal.find('.course-address').empty().append(register.address);
                    _modal.find('.course-phone').empty().append(register.phone);
                    _modal.find('.course-email').empty().append(register.email);
                    _modal.find('.course-tuition_per_session').empty().append(register.tuition_per_session + ' VND');
                    _modal.find('.course-subject').empty().append(register.subject);
                    _modal.find('.course-level').empty().append(register.course_level);
                    _modal.find('.course-time_working').empty().append(register.time_working);
                    _modal.find('.course-session_per_week').empty().append(register.session_per_week);
                    _modal.find('.course-created_at').empty().append(register.created_at);
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
