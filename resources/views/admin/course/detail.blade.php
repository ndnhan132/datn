<table class="mb-0 w-100 table table-sm table-bordered text-left text-capitalize">
    <tbody>
        <tr><td class="pr-3 text-nowrap" >Họ & tên</td><td> {{ $course->fullname }}</td></tr>
            <tr><td class="pr-3 text-nowrap" >Thời gian dạy</td><td> {{ $course->time_working }}</td></tr>
            <tr><td class="pr-3 text-nowrap" >Điện thoại</td><td> {{ $course->phone }}</td></tr>
            <tr><td class="pr-3 text-nowrap" >E-mail</td><td> {{ $course->email }}</td></tr>
            <tr><td class="pr-3 text-nowrap" >Địa chỉ</td><td> {{ $course->address }}</td></tr>
            <tr><td class="pr-3 text-nowrap" >Môn học</td><td> {{ $course->subject->display_name }}</td></tr>
            <tr><td class="pr-3 text-nowrap" >Môn học khác</td><td> {{ $course->other_subject ?? 'Không' }}</td></tr>
            <tr><td class="pr-3 text-nowrap" >Trình độ học sinh</td><td> {{ $course->courseLevel->display_name ?? '' }}</td></tr>
            <tr><td class="pr-3 text-nowrap" >Trình độ khác</td><td> {{ $course->other_teacher_level ?? 'Không' }}</td></tr>
            <tr><td class="pr-3 text-nowrap" >Thời gian</td><td> {{ $course->session_per_week . ' buổi / Tuần' }}</td></tr>
            <tr><td class="pr-3 text-nowrap" >Email</td><td> {{ $course->time_per_session . ' phút / buổi'}}</td></tr>
            <tr><td class="pr-3 text-nowrap" >Số lượng học sinh</td><td> {{ $course->num_of_student }}</td></tr>
            <tr><td class="pr-3 text-nowrap" >Yêu cầu khác</td><td> {{ $course->other_requirement }}</td></tr>
            <tr><td class="pr-3 text-nowrap" >Thời gian tạo</td><td> {{ $course->created_at ?? '--/--/-- --:--'}}</td></tr>
        </tbody>
    </table>

    @if ($canConfirm && !$course->received())
    <div class="w-100 text-right pt-3">
        <button class="btn btn-sm btn-primary px-3 btn-confirm" data-course-id="{{ $course->id }}" data-is-confirmed="1">
            Thông qua
        </button>
        &nbsp;&nbsp;&nbsp;
        <button class="btn btn-sm btn-secondary btn-confirm" data-course-id="{{ $course->id }}" data-is-confirmed="0">
            Ko đạt
        </button>
        &nbsp;&nbsp;&nbsp;
        <button class="btn btn-sm btn-secondary px-3 btn-modal-dismiss"  data-dismiss="modal">
           Huỷ
        </button>
    </div>
<script type="text/javascript">
    $(document).on('click', '#js-modal-detail .btn-confirm', function(){
        var courseId = ($(this).data('course-id')) ? $(this).data('course-id') : '';
        var isConfirmed = $(this).data('is-confirmed');
        if(courseId != '' && [0, 1].includes(isConfirmed)) {
            $.ajax({
                url: '/quan-ly/khoa-hoc/ajax/confirm',
                type: 'POST',
                dataType: 'json',
                data: {
                    isConfirmed: isConfirmed,
                    courseId: courseId,
                },
            })
            .done(function(data) {
                $(document).find('.btn-modal-dismiss').click();
                if(data.success) {
                    msgSuccess();
                    $(document).find('.btn-table-reload').click();
                }else{
                    msgError(data.message);
                }
            })
            .fail(function(jqXHR, textStatus, errorThrown) {
                console.log("error");
                msgErrors();
            })
            .always(function() {
            });
        } else {
            $(document).find('.btn-modal-dismiss').click();
        }
    });
</script>
@elseif($course->received())
<div class="w-100 text-right pt-3">
    <span class="text-danger float-left border-bottom">
        * Khoá học này đã có người nhận. Không thể thay đổi trạng thái!
    </span>
</div>
@endif
