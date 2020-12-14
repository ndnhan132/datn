<table class="mb-0 w-100 table table-sm table-bordered text-left text-capitalize">
    <tbody>
            <tr><td class="pr-3 text-nowrap" >Môn học</td><td> {{ $course->subject->display_name }}</td></tr>
            <tr><td class="pr-3 text-nowrap" >Khối lớp</td><td> {{ $course->courseLevel->display_name ?? '' }}</td></tr>
            <tr><td class="pr-3 text-nowrap" >Số buổi/tuần</td><td> {{ $course->session_per_week ?? '' }}</td></tr>
            <tr><td class="pr-3 text-nowrap" >Học phí</td><td> {{ $course->tuition_per_session ?? '' }}</td></tr>
            <tr><td class="pr-3 text-nowrap" >Số giáo viên đăng ký</td><td> {{ ($course->teacherCourseRegistrations->count()) }}</td></tr>
            <tr><td class="pr-3 text-nowrap" >Số phụ huynh đăng ký</td><td> {{ ($course->parentRegisters->count()) }}</td></tr>
            <tr><td class="pr-3 text-nowrap" >Thời gian tạo</td><td> {{ $course->created_at ?? '--/--/-- --:--'}}</td></tr>
        </tbody>
    </table>

    <div class="w-100 text-right pt-3">
        {{-- <button class="btn btn-sm btn-primary px-3 btn-confirm" data-course-id="{{ $course->id }}" data-is-confirmed="1">
            Thông qua
        </button>
        &nbsp;&nbsp;&nbsp;
        <button class="btn btn-sm btn-secondary btn-confirm" data-course-id="{{ $course->id }}" data-is-confirmed="0">
            Ko đạt
        </button> --}}
        &nbsp;&nbsp;&nbsp;
        <button class="btn btn-sm btn-secondary px-3 btn-modal-dismiss"  data-dismiss="modal">
           Đóng
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
