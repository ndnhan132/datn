<div class="cover-container">
    <div class="col-md-12 px-0">
        <div class="tile">
            <div class="table-responsive">
                <table class="table table-bordered table-hover">
                    <thead>
                        <tr>
                            <th>Ảnh đại diện</th>
                            <th>Họ tên</th>
                            <th>trình độ</th>
                            <th>xét Duyệt</th>
                            <th>Tình trạng</th>
                            <th>chi tiết</th>
                            <th>Tác vụ</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach ($teachers as $record)
                        <tr>
                            <td class="text-center"><img src="{{ asset($record->getAvatarSrc()) }}" alt="" width="55" height="70" /></td>
                            <td class="text-center"><span>{{ $record->name }}</span></td>
                            <td class="text-center"><span>{{ $record->teacherLevel->display_name }}</span></td>
                            <td class="text-center">
                                @if (!$record->flag_is_checked)
                                    <span class="label-status-warning">Chưa Xem xét</span>
                                @elseif($record->isActive())
                                    <span class="label-status-success">Đã xét duyệt</span>
                                @else
                                    <span class="label-status-secondary">Không hợp lệ</span>
                                @endif
                            </td>
                            <td class="text-center">
                                <span class="btn btn-sm btn-info- btn-detail label-status-info" data-type="teacher" data-teacher-id="{{ $record->id }}">Chi tiết</span>
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
</div>
