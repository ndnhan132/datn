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
                <option value="">Không search</option>
                <option value="name" {{ $searchCriterion == 'name' ? 'selected' : '' }}>Họ tên</option>
                <option value="email" {{ $searchCriterion == 'email' ? 'selected' : '' }}>Email</option>
                <option value="address" {{ $searchCriterion == 'address' ? 'selected' : '' }}>Địa chỉ</option>
                <option value="phone" {{ $searchCriterion == 'phone' ? 'selected' : '' }}>Điện thoại</option>
                <option value="identity_card" {{ $searchCriterion == 'identity_card' ? 'selected' : '' }}>Số CMND</option>
                <option value="university" {{ $searchCriterion == 'university' ? 'selected' : '' }}>Đại học</option>
                <option value="speciality" {{ $searchCriterion == 'speciality' ? 'selected' : '' }}>Chuyên ngành</option>
            </select>
        </div>
        <div class="form-group my-2">
            <button class="form-control ml-2 btn-submit"><i class="fa fa-search"></i></button>
        </div>
        <div class="form-group my-2">
            <button class="form-control ml-2 btn-table-reset-reload" type="reset"><i class="fa fa-refresh"></i></button>
        </div>
        <div class="text-right col">
            @if ($totalRequestVerify > 0)
            <span class="text-danger">* Có {{ $totalRequestVerify }} tài khoản cần xét duyệt</span>
            @else
            <span class="text-success">* Không có tài khoản cần xét duyệt</span>
            @endif
        </div>
    </form>
    <div class="col-md-12 px-0">
        <div class="tile">
            <div class="table-responsive">
                <table class="table table-bordered- table-striped">
                    <thead>
                        <tr>
                            <th>Thứ tự</th>
                            <th class="text-left">Họ tên</th>
                            <th class="text-left">Email</th>
                            <th class="text-center py-1">
                                <select name="teacher_level" id="" class="form-control select_custom_control teacher_level rounded-pill mx-auto text-center text-capitalize">
                                    <option value="">Trình độ</option>
                                    @foreach ($teacherLevels as $item)
                                    <option value="{{ $item->id }}" {{ $item->id == $teacherLevelId ? 'selected' : ''}}>{{ $item->display_name }}</option>
                                    @endforeach
                                </select>
                            </th>
                            <th class="text-center py-1">
                                <select name="teacher_account_status" id="" class="form-control select_custom_control teacher_account_status rounded-pill mx-auto text-center">
                                    <option value="">Trạng thái</option>
                                    <option value="{{ \App\Models\TeacherAccountStatus::CONFIRMED_ID }}" {{ \App\Models\TeacherAccountStatus::CONFIRMED_ID == $teacherAccountStatus ? 'selected' : '' }}><span>Đã xét duyệt</span></option>
                                    <option value="{{ \App\Models\TeacherAccountStatus::INELIGIBLE_ID }}" {{ \App\Models\TeacherAccountStatus::INELIGIBLE_ID == $teacherAccountStatus ? 'selected' : '' }}>Không phù hợp</option>
                                    <option value="{{ \App\Models\TeacherAccountStatus::REQUEST_VERIFICATION_ID }}" {{ \App\Models\TeacherAccountStatus::REQUEST_VERIFICATION_ID == $teacherAccountStatus ? 'selected' : '' }}>Yêu cầu xét duyệt</option>
                                    <option value="NEW">Đăng ký mới</option>
                                </select>
                            </th>
                            <th>Số lớp nhận</th>
                            {{-- <th>Chi tiết</th> --}}
                            <th>Tác vụ</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach ($teachers as $record)
                        <tr>
                            <td class="text-center">#{{ $record->id }}</td>
                            <td class=""><span>{{ $record->name ?? 'Chưa cập nhật' }}</span></td>
                            <td class=""><span>{{ $record->email }}</span></td>
                            <td class="text-center"><span>{{ $record->teacherLevel->display_name ?? 'Chưa cập nhật' }}</span></td>
                            <td class="text-center">
                                @if ($record->isRequestVerification())
                                    <span class="label-status bg-warning">Yêu cầu xác nhận</span>
                                @elseif($record->isConfirmed())
                                    <span class="label-status bg-success">Đã xác nhận</span>
                                @elseif($record->isIneligible())
                                    <span class="label-status bg-secondary">Không đạt điều kiên</span>
                                @else
                                <span class="label-status bg-success">Chưa Xem xét</span>
                                @endif
                            </td>
                            <td class="text-center">
                                @if($record->isConfirmed())
                                    <span>{{ $record->getMyReceivedRegistration() ? count($record->getMyReceivedRegistration()) : '0' }}</span>
                                @else
                                <span>--</span>
                                @endif
                            </td>
                            {{-- <td class="text-center">
                                <span class="btn btn-sm btn-info- btn-detail label-status-info" data-type="teacher" data-teacher-id="{{ $record->id }}">Chi tiết</span>
                            </td> --}}
                            <td class="text-center">
                                <span >
                                    <button class="btn- btn-sm- btn-info- btn-outline-info btn-detail" data-type="teacher" data-teacher-id="{{ $record->id }}">
                                        <i class="fa fa-eye" aria-hidden="true"></i>
                                    </button>
                                    </span>
                                <span>
                                    <button class="btn-outline-danger btn-delete-record" data-record-id="{{ $record->id }}">
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
<form id="page-control-form">
    <input type="hidden" value="{{ $page ?? '1' }}" name="page">
    <input type="hidden" value="{{ $recordPerPage ?? '10' }}" name="record_per_page">

    @if (isset($searchText) && $searchText != '')
        <input type="hidden" name="is_search" value="1">
    @else
        <input type="hidden" name="is_search" value="0">
    @endif

    <input type="hidden" value="{{ $teacherAccountStatus ?? '0' }}" name="teacher_account_status">
    <input type="hidden" value="{{ $teacher_level ?? '0' }}" name="teacher_level">
</form>
