<div class="col-md-12 px-0">
    <div class="tile">
        <div class="table-responsive">
            <table class="table table-bordered table-hover">
                <thead>
                    <tr>
                        <th>mã số</th>
                        <th>Người gửi</th>
                        <th>Người nhận</th>
                        <th>Yêu cầu</th>
                        <th>Duyệt</th>
                        <th>Tình trạng</th>
                        <th>Đăng ký</th>
                        <th>Tác vụ</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach ($teacherCourseRegistrations as $record)
                    <tr>
                        <td class="text-center">
                            <span>{{ $record->code }}</span>
                        </td>
                        <td>
                            <span>{{ $record->fullname }}</span>
                        </td>
                        <td class="text-center">
                            <span>{{ $record->received()->teacher->name ?? '' }}</span>
                        </td>
                        <td class="text-center">
                            <span class="btn btn-sm btn-info- course-btn-detail label-status-info" data-record-id="{{ $record->id }}">Chi tiết</span>
                        </td>
                        <td class="text-white text-center text-capitalize">
                            @if (!isset($record->confirmed))
                            <span class="label-status-danger">tin
                                Mới</span>
                            @elseif($record->confirmed)
                            <span class="label-status-success">Đã
                                duyệt</span>
                            @else
                            <span class="label-status-secondary">ko
                                đạt</span>
                            @endif
                        </td>
                        <td class="text-center">
                            @if ($record->received())
                            <span class="label-status-success">Đã nhận</span>
                            @else
                            <span class="label-status-secondary">Chưa nhận</span>
                            @endif
                        </td>
                        <td class="text-center">
                            <span>{{ $record->teacherCourseRegistrations->count() }}</span>
                        </td>
                        <td class="text-center">
                            <span class="btn btn-sm btn-info btn-display-teacher notification" data-course-id="{{ $record->id }}" type="button" {{ (!$record->teacherCourseRegistrations) ? 'disabled' : '' }}>
                                Danh sách&nbsp;
                                <i class="fa fa-arrow-right align-top-"></i>
                                @if ($record->countWait())
                                <span class="count">+{{ $record->countWait() }}</span>
                                @endif
                            </span>
                        </td>
                    </tr>
                    @endforeach
                </tbody>
            </table>
        </div>
    </div>
</div>

@isset($max)
@if($max > 1)
<div class="pagination-wrapper">
    <ul class="pagination pagination-sm flex-wrap justify-content-center">
        @for($i = 1; $i <= $max; $i++) <li
            class="page-item {{ $i == $page ? 'active' : '' }}"><button
                class="page-link pagination-item"
                data-pagenum="{{ $i }}">{{ $i }}</button></li>
            @endfor
    </ul>
</div>
@endif
@endisset
