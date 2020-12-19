<div class="w-100 teacher-detail">
    <div class="d-flex flex-column">
        <div class="row mb-3">
            <div class="col-4 mx-auto">
            <img src="{{ asset_public_env($teacher->getAvatarSrc()) }}" alt="Chưa cập nhật" class="img-thumbnail img-responsive">
            </div>
            {{-- <div class="col-8 d-flex flex-column">
                <h4 class="text-capitalize "></h4>
                <table>
                    <tr>
                        <td class="text-nowrap"><span>-&nbsp;Email</span></td>
                        <td><span>{{ $teacher->email }}</span></td>
                    </tr>
                    <tr>
                        <td class="text-nowrap"><span>-&nbsp;Điện thoại</span></td>
                        <td><span>{{ $teacher->phone ?? 'Chưa cập nhật' }}</span></td>
                    </tr>
                    <tr>
                        <td class="text-nowrap"><span>-&nbsp;Địa chỉ</span></td>
                        <td><span>{{ $teacher->address ?? 'Chưa cập nhật' }}</span></td>
                    </tr>
                    <tr>
                        <td class="text-nowrap"><span>-&nbsp;Giới tính</span></td>
                        <td>
                            @if(!isset($teacher->is_male))
                            <span>Chưa cập nhật</span>
                            @elseif ($teacher->is_male)
                            <span>Nam</span>
                            @else
                            <span>Nữ</span>
                            @endif
                        </td>
                    </tr>

                    <tr>
                        <td class="text-nowrap"><span>-&nbsp;Năm sinh</span></td>
                        <td>
                            @if ($teacher->year_of_birth)
                            <span>{{ $teacher->year_of_birth . ' ('. (date("Y") - $teacher->year_of_birth) .' tuổi)' }}</span>
                            @else
                            <span>Chưa cập nhật</span>
                            @endif
                        </td>
                    </tr>
                </table>
            </div> --}}
        </div>

        <div class="row d-flex flex-column mb-3">
            <div class="col-12">
                <h4 class="text-capitalize name text-center">{{ $teacher->name ?? 'Chưa cập nhật' }}</h4>
                <table>
                    <tr>
                        <td class="text-nowrap"><span>-&nbsp;Giới tính</span></td>
                        <td>
                            @if(!isset($teacher->is_male))
                            <span>Chưa cập nhật</span>
                            @elseif ($teacher->is_male)
                            <span>Nam</span>
                            @else
                            <span>Nữ</span>
                            @endif
                        </td>
                    </tr>

                    <tr>
                        <td class="text-nowrap"><span>-&nbsp;Năm sinh</span></td>
                        <td>
                            @if ($teacher->year_of_birth)
                            <span>{{ $teacher->year_of_birth . ' ('. (date("Y") - $teacher->year_of_birth) .' tuổi)' }}</span>
                            @else
                            <span>Chưa cập nhật</span>
                            @endif
                        </td>
                    </tr>
                    <tr>
                        <td class="text-nowrap"><span>-&nbsp;Trường đại học</span></td>
                        <td><span>{{ $teacher->university ?? 'Chưa cập nhật' }}</span></td>
                    </tr>
                    <tr>
                        <td class="text-nowrap"><span>-&nbsp;Chuyên nghành</span></td>
                        <td><span>{{ $teacher->speciality ?? 'Chưa cập nhật'  }}</span></td>
                    </tr>
                    <tr>
                        <td class="text-nowrap"><span>-&nbsp;Trình độ hiện tại</span></td>
                        <td><span>{{ $teacher->teacherLevel->display_name ?? 'Chưa cập nhật'  }}</span></td>
                    </tr>
                    <tr>
                        <td class="text-nowrap"><span>-&nbsp;Lương tham khảo</span></td>
                        <td><span>{{ $teacher->reference_tuition ?$teacher->getDisplayTution() . ' Vnđ/Buổi' : 'Chưa cập nhật' }}</span></td>
                    </tr>
                    <tr>
                        <td class="text-nowrap"><span>-&nbsp;Cập nhật lần cuối</span></td>
                        <td><span>{{ date( 'd-m-Y', $teacher->last_modified) ?? 'Chưa cập nhật' }}</span></td>
                    </tr>
                    <tr>
                        <td class="text-nowrap"><span>-&nbsp;Thông tin thêm</span></td>
                        <td><span>{{ $teacher->description ?? 'Chưa cập nhật' }}</span></td>
                    </tr>
                </table>
            </div>
        </div>
    </div>
</div>
