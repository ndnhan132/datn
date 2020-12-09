<table class="mb-0 w-100 table table-sm table-bordered text-left text-capitalize"  style="table-layout:fixed">
    <tbody>
        <tr><td class="pr-3" COLSPAN="2">E-mail</td><td colspan="5"> {{ $teacher->email  ?? 'Chưa cập nhật'}}</td></tr>
        <tr><td class="pr-3" COLSPAN="2">Họ & tên</td><td colspan="5"> {{ $teacher->name ?? 'Chưa cập nhật' }}</td></tr>
        <tr><td class="pr-3" COLSPAN="2">Giới tính</td><td colspan="5"> {{ $teacher->is_male ? 'Nam' : 'Nữ' }}</td></tr>
        <tr><td class="pr-3" COLSPAN="2">Điện thoại</td><td colspan="5"> {{ $teacher->phone  ?? 'Chưa cập nhật'}}</td></tr>
        <tr><td class="pr-3" COLSPAN="2">Năm sinh</td><td colspan="5"> {{ $teacher->year_of_birth ?? 'Chưa cập nhật' }}</td></tr>
        <tr><td class="pr-3" COLSPAN="2">Cmnd</td><td colspan="5"> {{ $teacher->identity_card ?? 'Chưa cập nhật' }}</td></tr>
        <tr><td class="pr-3" COLSPAN="2">Địa chỉ</td><td colspan="5"> {{ $teacher->address  ?? 'Chưa cập nhật'}}</td></tr>
        <tr><td class="pr-3" COLSPAN="2">Đại học</td><td colspan="5"> {{ $teacher->university ?? 'Chưa cập nhật' }}</td></tr>
        <tr><td class="pr-3" COLSPAN="2">Chuyên ngành</td><td colspan="5"> {{ $teacher->speciality ?? 'Chưa cập nhật' }}</td></tr>
        <tr><td class="pr-3" COLSPAN="2">Môn dạy</td><td colspan="5"> {{ $teacher->getDisplaySubject() }}</td></tr>
        <tr><td class="pr-3" COLSPAN="2">Lớp dạy</td><td colspan="5"> {{ $teacher->getDisplayCourseLevel() }}</td></tr>
        <tr><td class="pr-3" COLSPAN="2">Lương tham khảo</td><td colspan="5"> {{ $teacher->reference_tuition ?$teacher->getDisplayTution() . ' Vnđ/Buổi' : 'Chưa cập nhật' }}</td></tr>
        <tr><td class="pr-3" COLSPAN="2">Trạng thái tài khoản</td><td colspan="5"> {{ $teacher->teacherAccountStatus->display_name ?? 'Tài khoản đăng ký mới' }}</td></tr>
        <tr><td class="pr-3" COLSPAN="2">Thời gian tạo</td><td colspan="5"> {{ (new Carbon\Carbon($teacher->verify_email_at))->setTimeZone('Asia/Ho_Chi_Minh')->isoFormat('DD/MM/YYYY') ?? '--/--/----' }}</td></tr>
        <tr><td class="pr-3" COLSPAN="2">Thông tin thêm</td><td colspan="5"> {{ $teacher->description ?? 'Không'}}</td></tr>
        </tbody>
    </table>
    @php
        $identityCardImages = $teacher->getIdentityCardImages();
        $degreeCardImages = $teacher->getDegreeImages();
        $images = array();
        $images = array_merge($images, $identityCardImages);
        $images = array_merge($images, $degreeCardImages);
    @endphp
    @if (count($images) > 0)
    <div class="w-100 my-3">
        <h5>Hình ảnh xác minh</h5>
        <div class="d-flex flex-wrap">
            @foreach ($images as $item)
            <div class="col-md-12 px-0">
                <img src="{{asset($item->src)}}" alt="" class="img-fluid img-thumbnail w-100">
            </div>
            @endforeach
        </div>
    </div>
    @else
    <div class="w-100 my-3">
        <h5 class="text-muted">Chưa cập nhật hình ảnh xác minh</h5>
    </div>
    @endif
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
