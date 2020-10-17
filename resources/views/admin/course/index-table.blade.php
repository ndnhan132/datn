<div class="col-md-12 px-0">
    <div class="tile">
        {{-- <h3 class="tile-title">
        <i class="fa fa-table pr-2"></i>&nbsp;Danh sách gia sư
      </h3> --}}
        <div class="table-responsive">
            <table class="table table-bordered table-hover">
                <thead>
                    <tr>
                        <th>mã số</th>
                        <th>Người gửi</th>
                        <th>tg đăng ký</th>
                        <th>Duyệt</th>
                        <th>Yêu cầu</th>
                        <th>Tình trạng</th>
                        <th>Tác vụ</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach ($courses as $course)
                    {{ \Debugbar::debug($course) }}
                    <tr>
                        <td>
                            <span>{{ $course->code }}</span>
                        </td>
                        <td>
                            <span>{{ $course->fullname }}</span>
                        </td>
                        <td class="text-center">
                            <span>{{ $course->created_at ?? '--/--/--' }}</span>
                        </td>
                        <td class="text-white text-center text-capitalize">
                            @if (!isset($course->confirmed))
                            <span class="label-status-danger">tin
                                Mới</span>
                            @elseif($course->confirmed)
                            <span class="label-status-success">Đã
                                duyệt</span>
                            @else
                            <span class="label-status-secondary">ko
                                đạt</span>
                            @endif
                        </td>
                        <td class="text-center">
                            <span class="btn btn-sm btn-info">Chi
                                tiết</span>
                        </td>
                        <td>
                            @if ($course->confirmed)
                            <span class="label-status-success">Đã nhận</span>
                            @endif
                        </td>
                        <td>
                            <div class="d-flex justify-content-center">
                                <button class="btn btn-sm btn-warning text-white btn-edit" data-id="{{ $course->id }}">Edit</button>
                                <button class="btn btn-sm btn-danger text-white ml-2 btn-delete" data-id="{{ $course->id }}">Del</button>
                            </div>
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
