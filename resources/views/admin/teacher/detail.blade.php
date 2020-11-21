<table class="mb-0 w-100 table table-sm table-bordered text-left text-capitalize">
    <tbody>
        <tr><td class="pr-3">Họ & tên</td><td> {{ $teacher->name }}</td></tr>
        {{-- <tr><td class="pr-3">Thời gian dạy</td><td> {{ $teacher->time_working }}</td></tr>
        <tr><td class="pr-3">Điện thoại</td><td> {{ $teacher->phone }}</td></tr>
        <tr><td class="pr-3">E-mail</td><td> {{ $teacher->email }}</td></tr>
        <tr><td class="pr-3">Địa chỉ</td><td> {{ $teacher->address }}</td></tr>
        <tr><td class="pr-3">Môn học</td><td> {{ $teacher->subject->display_name }}</td></tr>
        <tr><td class="pr-3">Môn học khác</td><td> {{ $teacher->other_subject }}</td></tr>
        <tr><td class="pr-3">Trình độ học sinh</td><td> {{ $teacher->teacherLevel->display_name ?? '' }}</td></tr>
        <tr><td class="pr-3">Trình độ khác</td><td> {{ $teacher->other_teacher_level }}</td></tr>
        <tr><td class="pr-3">Thời gian</td><td> {{ $teacher->session_per_week . ' buổi / Tuần' }}</td></tr>
        <tr><td class="pr-3">Email</td><td> {{ $teacher->time_per_session . ' phút / buổi'}}</td></tr>
        <tr><td class="pr-3">Số lượng học sinh</td><td> {{ $teacher->num_of_student }}</td></tr>
        <tr><td class="pr-3">Yêu cầu khác</td><td> {{ $teacher->other_requirement }}</td></tr>
        <tr><td class="pr-3">Thời gian tạo</td><td> {{ $teacher->created_at ?? '--/--/-- --:--'}}</td></tr> --}}
        </tbody>
    </table>

    <div class="w-100 text-right pt-3">
        <button class="btn btn-sm btn-primary px-3 btn-confirm" data-teacher-id="{{ $teacher->id }}" data-is-active="1">
            Thông qua
        </button>
        &nbsp;&nbsp;&nbsp;
        <button class="btn btn-sm btn-secondary btn-confirm" data-teacher-id="{{ $teacher->id }}" data-is-active="0">
            Ko hợp lệ
        </button>
        &nbsp;&nbsp;&nbsp;
        <button class="btn btn-sm btn-secondary px-3 btn-modal-dismiss"  data-dismiss="modal">
           Huỷ
        </button>
    </div>
<script type="text/javascript">
    $(document).on('click', '#js-modal-detail .btn-confirm', function(){
        var teacherId = ($(this).data('teacher-id')) ? $(this).data('teacher-id') : '';
        var isActive = $(this).data('is-active');
        if(teacherId != '') {
            $.ajax({
                url: '/quan-ly/giao-vien/ajax/confirm',
                type: 'POST',
                dataType: 'json',
                data: {
                    isActive: isActive,
                    teacherId: teacherId,
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
