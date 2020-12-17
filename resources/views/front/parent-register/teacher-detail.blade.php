<table class="mb-0 w-100 table table-sm table-bordered text-left text-capitalize"  style="table-layout:fixed">
    <tbody>
        {{-- <tr><td class="pr-3" COLSPAN="2">E-mail</td><td colspan="5"> {{ $teacher->email  ?? 'Chưa cập nhật'}}</td></tr> --}}
        <tr><td class="pr-3" COLSPAN="2">Họ & tên</td><td colspan="5"> {{ $teacher->name ?? 'Chưa cập nhật' }}</td></tr>
        <tr><td class="pr-3" COLSPAN="2">Giới tính</td><td colspan="5"> {{ $teacher->is_male ? 'Nam' : 'Nữ' }}</td></tr>
        {{-- <tr><td class="pr-3" COLSPAN="2">Điện thoại</td><td colspan="5"> {{ $teacher->phone  ?? 'Chưa cập nhật'}}</td></tr> --}}
        <tr><td class="pr-3" COLSPAN="2">Năm sinh</td><td colspan="5"> {{ $teacher->year_of_birth ?? 'Chưa cập nhật' }}</td></tr>
        <tr><td class="pr-3" COLSPAN="2">Địa chỉ</td><td colspan="5"> {{ $teacher->address  ?? 'Chưa cập nhật'}}</td></tr>
        <tr><td class="pr-3" COLSPAN="2">Đại học</td><td colspan="5"> {{ $teacher->university ?? 'Chưa cập nhật' }}</td></tr>
        <tr><td class="pr-3" COLSPAN="2">Chuyên ngành</td><td colspan="5"> {{ $teacher->speciality ?? 'Chưa cập nhật' }}</td></tr>
        <tr><td class="pr-3" COLSPAN="2">Môn dạy</td><td colspan="5"> {{ $teacher->getDisplaySubject() }}</td></tr>
        <tr><td class="pr-3" COLSPAN="2">Lớp dạy</td><td colspan="5"> {{ $teacher->getDisplayCourseLevel() }}</td></tr>
        <tr><td class="pr-3" COLSPAN="2">Lương tham khảo</td><td colspan="5"> {{ $teacher->reference_tuition ?$teacher->getDisplayTution() . ' Vnđ/Buổi' : 'Chưa cập nhật' }}</td></tr>
        <tr><td class="pr-3" COLSPAN="2">Thời gian tạo</td><td colspan="5"> {{ (new Carbon\Carbon($teacher->verify_email_at))->setTimeZone('Asia/Ho_Chi_Minh')->isoFormat('DD/MM/YYYY') ?? '--/--/----' }}</td></tr>
        <tr><td class="pr-3" COLSPAN="2">Thông tin thêm</td><td colspan="5"> {{ $teacher->description ?? 'Không'}}</td></tr>
        </tbody>
    </table>
    <div class="w-100 text-right pt-3">
        <button class="btn btn-sm btn-primary px-3 btn-parent-register-submit" data-teacher-id="{{ $teacher->id }}">
            Gửi đăng ký
        </button>
        &nbsp;&nbsp;&nbsp;
        {{-- <button class="btn btn-sm btn-secondary btn-confirm" data-teacher-id="{{ $teacher->id }}" data-is-active="0">
            Ko hợp lệ
        </button> --}}
        &nbsp;&nbsp;&nbsp;
        <button class="btn btn-sm btn-secondary px-3 btn-modal-dismiss"  data-dismiss="modal">
           Huỷ
        </button>
    </div>
