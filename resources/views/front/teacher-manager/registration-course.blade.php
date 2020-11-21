<div class="table-responsive list-course">
    <table class="table table-striped table-bordered">
        <thead class="bg-primary text-white">
            <tr class="text-nowrap">
                <th>Môn học</th>
                <th>Yêu cầu</th>
                <th>Học phí</th>
                <th><span>Tình trạng</span></th>
                <th class="text-center"><span>Tác vụ</span></th>
            </tr>
        </thead>
        <tbody>
        @foreach ($registrations as $reg)
            <tr>
                <td><span>{{$reg->course->getSubjectAndLevel() ?? ''}}</span></td>
                <td><span>{{$reg->course->getRequiredGenderAndLevel() ?? ''}}</span></td>
                <td><span>{{$reg->course->getDisplayTution() ?? ''}}</span></td>
                <td><span class="text-capitalize">{{ $reg->registrationStatus->display_name }}</span></td>
                <td class="text-center">
                    <span><i class="fas fa-eye"></i></span>
                    <span><i class="fas fa-times"></i></span>
                </td>
            </tr>
        @endforeach
        </tbody>
    </table>
</div>
