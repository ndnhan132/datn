<div class="d-flex flex-column">
    <h5 class="text-capitalize name">Lớp đăng ký</h5>
    @if ($registrations)
    <div class="table-responsive list-course">
        <table class="table table-striped table-bordered">
            <thead class="bg-primary text-white">
                <tr class="text-nowrap">
                    <th>Môn học</th>
                    <th>Khối lớp</th>
                    <th>Học phí</th>
                    <th><span>Tình trạng</span></th>
                    <th class="text-center"><span>Tác vụ</span></th>
                </tr>
            </thead>
            <tbody>
            @foreach ($registrations as $reg)
                <tr>
                    <td><span class="text-capitalize">{{$reg->course->subject->display_name ?? ''}}</span></td>
                    <td><span class="text-capitalize">{{$reg->course->courseLevel->display_name ?? ''}}</span></td>
                    <td><span class="text-capitalize">{{$reg->course->getDisplayTution() ?? ''}}</span></td>
                    <td><span class="text-capitalize">{{ $reg->registrationStatus->display_name }}</span></td>
                    <td class="text-center">
                        <span  class="btn-view-course" data-course="{{ $reg->course_id }}"><i class="fas fa-eye"></i></span>
                        <span class="btn-del-registration" data-course="{{ $reg->course_id }}"><i class="fas fa-times"></i></span>
                    </td>
                </tr>
            @endforeach
            </tbody>
        </table>
    </div>
    @else
    <span>Chưa đăng ký lớp nào</span>
    @endif
</div>
