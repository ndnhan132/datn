<div class="cover-container">
<div class="col-md-12 px-0">
    <div class="tile">
        <div class="table-responsive">
            <table class="table table-bordered- table-hover">
                <thead>
                    <tr>
                        <th><span class="btn-back-to-main-table d-block cursor-pointer"><i class="fa fa-backward"></i></span></th>
                        <th>Ảnh đại diện</th>
                        <th>Giáo viên đăng ký</th>
                        <th>So sánh</th>
                        <th>Tình trạng</th>
                    </tr>
                </thead>
                <tbody>
                    @php
                        $registrations = $courseRegistrations->teacherCourseRegistrations->sortByDesc('id')->all();
                    @endphp
                    @foreach ($registrations as $key => $record)
                        @php
                            $teacher = $record->teacher;
                        @endphp
                    <tr>
                        <td class="text-center">
                            <span>{{ $key + 1 }}</span>
                        </td>
                        <td class="text-center">
                            <span>
                                <img src="{{ asset($teacher->getAvatarSrc())}}" width="55" height="70" class="">
                            </span>
                        </td>
                        <td>
                            <span>{{ $teacher->name }}</span>
                        </td>
                        <td class="text-center">
                            <span class="btn btn-sm btn-info- registration-btn-compare label-status-info" data-registration-id="{{ $record->id }}">So sánh</span>
                        </td>
                        <td class="text-center">
                            @if ($record->isReceived())
                            <span class="label-status-success">Đã nhận</span>
                            @elseif ($record->isPendding())
                            <span class="label-status-warning">Chưa Kiểm tra</span>
                            @elseif ($record->isEligible())
                            <span class="label-status-info">Đủ điều kiên</span>
                            @else
                            <span class="label-status-secondary">Không đủ điều kiên</span>
                            @endif
                        </td>
                    </tr>
                    @endforeach
                </tbody>
            </table>
        </div>
    </div>
</div>
</div>
