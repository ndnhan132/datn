<table class="mb-0 w-100 table table-sm table-bordered text-left text-capitalize">
    <tbody>
            <tr>
                <td class="pr-3 text-nowrap" >Môn học</td>
                <td> {{ $parentRegister->course->subject->display_name ?? '' }}</td>
            </tr>
            <tr>
                <td class="pr-3 text-nowrap" >Khối lớp</td>
                <td> {{ $parentRegister->course->courseLevel->display_name ?? '' }}</td>
            </tr>
            <tr>
                <td class="pr-3 text-nowrap" >Số buổi/tuần</td>
                <td> {{ $parentRegister->course->session_per_week ?? '' }}</td>
            </tr>
            <tr>
                <td class="pr-3 text-nowrap" >Học phí</td>
                <td> {{ $parentRegister->tuition_per_session ?? '' }}</td>
            </tr>
            <tr>
                <td class="pr-3 text-nowrap" >Thời gian</td>
                <td> {{ $parentRegister->time_working ?? '' }}</td>
            </tr>
            <tr>
                <td class="pr-3 text-nowrap" >tên phụ huynh</td>
                <td> {{ $parentRegister->fullname?? '' }}</td>
            </tr>
            <tr>
                <td class="pr-3 text-nowrap" >Email phụ huynh</td>
                <td> {{ $parentRegister->email ?? '' }}</td>
            </tr>
            <tr>
                <td class="pr-3 text-nowrap" >Địa chỉ phụ huynh</td>
                <td> {{ $parentRegister->address ?? '' }}</td>
            </tr>
            <tr>
                <td class="pr-3 text-nowrap" >Số điện thoại phụ huynh</td>
                <td> {{ $parentRegister->phone ?? '' }}</td>
            </tr>
            <tr>
                <td class="pr-3 text-nowrap" >Trạng thái đăng ký</td>
                <td>
                    @if ($parentRegister->isConfirmed())
                    <span class="text-success"> Thông qua</span>
                    @elseif($parentRegister->isUnConfirmed())
                    <span class="text-secondary"> Ko hợp lệ</span>
                    @elseif($parentRegister->isNew())
                    <span class="text-danger"> Đăng ký mới</span>
                    @endif
                </td>
            </tr>
            <tr>
                <td class="pr-3 text-nowrap" >tên giáo viên</td>
                <td> {{ $parentRegister->teacher->name ?? '' }}</td>
            </tr>
            <tr>
                <td class="pr-3 text-nowrap" >Email giáo viên</td>
                <td> {{ $parentRegister->teacher->email ?? '' }}</td>
            </tr>
            <tr>
                <td class="pr-3 text-nowrap" >Địa chỉ giáo viên</td>
                <td> {{ $parentRegister->teacher->address ?? '' }}</td>
            </tr>
            <tr>
                <td class="pr-3 text-nowrap" >Số điện thoại giáo viên</td>
                <td> {{ $parentRegister->teacher->phone ?? '' }}</td>
            </tr>
            <tr>
                <td class="pr-3 text-nowrap" >Tuổi giáo viên</td>
                <td> {{ $parentRegister->teacher->getAge() ?? '' }}</td>
            </tr>
            <tr>
                <td class="pr-3 text-nowrap" >trình độ giáo viên</td>
                <td> {{ $parentRegister->teacher->getGenderAndLevel() ?? '' }}</td>
            </tr>

        </tbody>
    </table>

    <div class="w-100 text-right pt-3">
        <button class="btn btn-sm btn-primary px-3 btn-confirm" data-course-id="{{ $parentRegister->id }}" data-is-confirmed="1">
            Thông qua
        </button>
        &nbsp;&nbsp;&nbsp;
        <button class="btn btn-sm btn-secondary btn-confirm" data-course-id="{{ $parentRegister->id }}" data-is-confirmed="0">
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
                url: '/quan-ly/phu-huynh-dang-ky/ajax/confirm',
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
