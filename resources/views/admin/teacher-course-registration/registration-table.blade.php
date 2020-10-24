<div class="col-md-12 px-0">
    <div class="tile">
        <div class="table-responsive">
            <table class="table table-bordered table-hover">
                <thead>
                    <tr>
                        <th><span class="btn btn-sm btn-block btn-back-to-main-table">back</span></th>
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
                    @php
                        $registrations = $courseRegistrations->teacherCourseRegistrations;
                    @endphp
                    @foreach ($registrations as $record)
                        @php
                            $teacher = $record->teacher;
                        @endphp
                    <tr>
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
                            <span class="label-status-warning">Đang chờ</span>
                            @elseif ($record->isEligible())
                            <span class="label-status-info">Đủ điều kiên</span>
                            @else
                            <span class="label-status-secondary">Không đủ điều kiên</span>
                            @endif
                        </td>
                        <td class="text-white text-center text-capitalize">
                            {{-- @if (!isset($record->confirmed))
                            <span class="label-status-danger">tin
                                Mới</span>
                            @elseif($record->confirmed)
                            <span class="label-status-success">Đã
                                duyệt</span>
                            @else
                            <span class="label-status-secondary">ko
                                đạt</span>
                            @endif --}}
                        </td>
                    </tr>
                    @endforeach
                </tbody>
            </table>
        </div>
    </div>
</div>
<script type="text/javascript">
    $(document).on('click', '.teacher-course-registration .registration-btn-compare', function(){
        var registrationId = ($(this).data('registration-id')) ? $(this).data('registration-id') : '';
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
