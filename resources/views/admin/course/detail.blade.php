<table class="mb-0 w-100 table table-sm table-bordered text-left text-capitalize">
    <tbody>
        <tr><td class="pr-3">Họ & tên</td><td> {{ $course->fullname }}</td></tr>
            <tr><td class="pr-3">Thời gian dạy</td><td> {{ $course->time_working }}</td></tr>
            <tr><td class="pr-3">Điện thoại</td><td> {{ $course->phone }}</td></tr>
            <tr><td class="pr-3">E-mail</td><td> {{ $course->email }}</td></tr>
            <tr><td class="pr-3">Địa chỉ</td><td> {{ $course->address }}</td></tr>
            <tr><td class="pr-3">Môn học</td><td> {{ $course->subject->display_name }}</td></tr>
            <tr><td class="pr-3">Môn học khác</td><td> {{ $course->other_subject }}</td></tr>
            <tr><td class="pr-3">Trình độ học sinh</td><td> {{ $course->courseLevel->display_name ?? '' }}</td></tr>
            <tr><td class="pr-3">Trình độ khác</td><td> {{ $course->other_level }}</td></tr>
            <tr><td class="pr-3">Thời gian</td><td> {{ $course->session_per_week . ' buổi / Tuần' }}</td></tr>
            <tr><td class="pr-3">Email</td><td> {{ $course->time_per_session . ' phút / buổi'}}</td></tr>
            <tr><td class="pr-3">Số lượng học sinh</td><td> {{ $course->num_of_student }}</td></tr>
            <tr><td class="pr-3">Yêu cầu khác</td><td> {{ $course->other_requirement }}</td></tr>
            <tr><td class="pr-3">Thời gian tạo</td><td> {{ $course->created_at ?? '--/--/-- --:--'}}</td></tr>
        </tbody>
    </table>

    @if ($canConfirm)
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
                console.log(data);
                $(document).find('.btn-modal-dismiss').click();
                $(document).find('.btn-table-reload').click();
            })
            .fail(function(jqXHR, textStatus, errorThrown) {
                console.log("error");
            })
            .always(function() {
            });
        } else {
            $(document).find('.btn-modal-dismiss').click();
        }
    });
</script>
@endif
