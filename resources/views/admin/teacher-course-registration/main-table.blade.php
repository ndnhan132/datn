<div class="cover-container">
    <form class="col-md-12 px-0 form-inline" id="form-search">
        <div class="form-group my-2 pl-1">
            <input type="text" name="search_text" class="form-control ml-2" placeholder="Search" value="{{ $searchText ?? '' }}">
        </div>
        <div class="form-group my-2">
            <select name="search_criterion" class="form-control ml-2">
                @php
                    if(!isset($searchCriterion)){
                        $searchCriterion = '';
                    }
                @endphp
                <option value="">Không tìm kiếm</option>
                {{-- <option value="COURSE_FULLNAME" {{ $searchCriterion == 'COURSE_FULLNAME' ? 'selected' : '' }}>Họ tên người gửi</option>
                <option value="COURSE_EMAIL" {{ $searchCriterion == 'COURSE_EMAIL' ? 'selected' : '' }}>Email</option>
                <option value="COURSE_ADDRESS" {{ $searchCriterion == 'COURSE_ADDRESS' ? 'selected' : '' }}>Địa chỉ</option>
                <option value="COURSE_PHONE" {{ $searchCriterion == 'COURSE_PHONE' ? 'selected' : '' }}>Điện thoại</option> --}}
                <option value="TEACHER_FULLNAME" {{ $searchCriterion == 'TEACHER_FULLNAME' ? 'selected' : '' }}>Họ tên người gửi</option>
                <option value="TEACHER_EMAIL" {{ $searchCriterion == 'TEACHER_EMAIL' ? 'selected' : '' }}>Email</option>
                <option value="TEACHER_PHONE" {{ $searchCriterion == 'TEACHER_PHONE' ? 'selected' : '' }}>Điện thoại</option>
            </select>
        </div>
        <div class="form-group my-2">
            <button class="form-control ml-2 btn-submit"><i class="fa fa-search"></i></button>
        </div>
        <div class="form-group my-2">
            <button class="form-control ml-2 btn-table-reset-reload" type="reset"><i class="fa fa-refresh"></i></button>
        </div>
        <div class="text-right col">
            @if ($totalNewRegistration > 0)
            <span class="text-danger">* Có {{ $totalNewRegistration }} đăng ký cần xét duyệt</span>
            @else
            <span class="text-success">* Không có đăng ký cần xét duyệt</span>
            @endif
        </div>
    </form>

    <div class="col-md-12 px-0">
        <div class="tile">
            <div class="table-responsive">
                <table class="table table-bordered- table-striped">
                    <thead>
                        <tr class="text-center">
                            <th>#</th>
                            <th colspan="2">Yêu cầu lớp</th>
                            <th colspan="2">Giáo viên đăng ký</th>
                            <th>Trạng thái</th>
                            <th colspan="2">Tác vụ</th>
                        </tr>
                        <tr class="">
                            <th>mã số</th>
                            <th class="text-left">Môn học</th>
                            <th class="text-left">
                                khối lớp
                            </th>
                            <th class="text-left">
                                Họ tên
                            </th>
                            <th class="text-left">
                                Trình độ
                            </th>
                            <th class="text-center py-1">
                                <select name="select_registration_status" class="form-control select_custom_control select_registration_status rounded-pill mx-auto text-center">
                                    <option value="">Tất cả</option>
                                    @foreach ($registrationStatuses as $status)
                                    <option value="{{ $status->id}}" {{ $status->id == $select_registration_status ? 'selected' : '' }}>{{ ucfirst($status->display_name)}}</option>
                                    @endforeach
                                </select>
                            </th>
                            <th>Xem</th>
                            <th>Xóa</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach ($teacherCourseRegistrations as $record)
                        <tr>
                            <td class="text-center">
                                <span>#{{ $record->id }}</span>
                            </td>
                            <td class="text-left">
                                <span>{{ $record->course->getDisplaySubject() }}</span>
                            </td>
                            <td class="text-left">
                                <span>{{ $record->course->getDisplayCourseLevel() }}</span>
                            </td>
                            <td class="text-left">
                                <span>{{$record->teacher->name ?? '' }}</span>
                            </td>
                            <td class="text-left">
                                <span>{{$record->teacher->getGenderAndLevel() }}</span>
                            </td>
                            <td class="text-center">
                                <span class="label-status bg-{{ $record->getStatusColor() }}">{{ $record->registrationStatus->display_name }}</span>

                            </td>
                            <td class="text-center">
                                <span>
                                    <button class="btn-outline-info registration-btn-compare" data-id="{{ $record->id }}" data-registration-id="{{ $record->id }}">
                                        <i class="fa fa-eye"></i>
                                    </button>
                                </span>
                            </td>
                            <td class="text-center">
                                <span>
                                    <button class="btn-outline-danger btn-delete-record" data-record-id="{{ $record->id }}" >
                                        <i class="fa fa-trash-o" aria-hidden="true"></i>
                                    </button>
                                </span>
                            </td>
                        </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
        </div>
    </div>

    @include('admin.layouts.pagination')
</div>
<form id="page-control-form" class="d-none">
    <input type="hidden" value="{{ $page ?? '1' }}" name="page">
    <input type="hidden" value="{{ $recordPerPage ?? '10' }}" name="record_per_page">

    @if (isset($textSearch) && $textSearch != '')
        <input type="hidden" name="is_search" value="1">
    @else
        <input type="hidden" name="is_search" value="0">
    @endif

    <input type="hidden" value="{{ $select_registration_status ?? '' }}" name="select_registration_status">
</form>
