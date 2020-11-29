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
                <option value="no">Không search</option>
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
            <button class="form-control ml-2 btn-submit" style="display: none"><i class="fa fa-search"></i></button>
        </div>
    </form>
    <div class="col-md-12 px-0">
        <div class="tile">
            <div class="table-responsive">
                <table class="table table-bordered table-hover">
                    <thead>
                        <tr>
                            <th>Thứ tự</th>
                            <th class="text-left">Họ tên</th>
                            <th class="text-center py-1">
                                <select name="teacher_level" id="" class="form-control teacher_level rounded-pill mx-auto text-center text-capitalize">
                                    <option value="">Trình độ</option>
                                    @foreach ($teacherLevels as $item)
                                    <option value="{{ $item->id }}" {{ $item->id == $teacherLevelId ? 'selected' : ''}}>{{ $item->display_name }}</option>
                                    @endforeach
                                </select>
                            </th>
                            <th class="text-center py-1">
                                <select name="teacher_account_status" id="" class="form-control teacher_account_status rounded-pill mx-auto text-center">
                                    <option value="">Trạng thái</option>
                                    <option value="{{ \App\Models\TeacherAccountStatus::CONFIRMED_ID }}" {{ \App\Models\TeacherAccountStatus::CONFIRMED_ID == $teacherAccountStatus ? 'selected' : '' }}><span>Đã xét duyệt</span></option>
                                    <option value="{{ \App\Models\TeacherAccountStatus::INELIGIBLE_ID }}" {{ \App\Models\TeacherAccountStatus::INELIGIBLE_ID == $teacherAccountStatus ? 'selected' : '' }}>Không phù hợp</option>
                                    <option value="{{ \App\Models\TeacherAccountStatus::REQUEST_VERIFICATION_ID }}" {{ \App\Models\TeacherAccountStatus::REQUEST_VERIFICATION_ID == $teacherAccountStatus ? 'selected' : '' }}>Yêu cầu xét duyệt</option>
                                    <option value="NEW">Đăng ký mới</option>
                                </select>
                            </th>
                            <th>Số lớp nhận</th>
                            <th>Chi tiết</th>
                            <th>Tác vụ</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach ($teachers as $record)
                        <tr>
                            <td class="text-center">#{{ $record->id }}</td>
                            <td class=""><span>{{ $record->name }}</span></td>
                            <td class="text-center"><span>{{ $record->teacherLevel->display_name ?? 'Chưa cập nhật' }}</span></td>
                            <td class="text-center">
                                @if ($record->isRequestVerification())
                                    <span class="label-status bg-warning">Yêu cầu</span>
                                @elseif($record->isConfirmed())
                                    <span class="label-status bg-success">Đã xét duyệt</span>
                                @elseif($record->isIneligible())
                                    <span class="label-status bg-secondary">Không hợp lệ</span>
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
                            <td class="text-center">
                                <span class="btn btn-sm btn-info- btn-detail label-status-info" data-type="teacher" data-teacher-id="{{ $record->id }}">Chi tiết</span>
                            </td>
                            <td class="text-center">
                                <span>Xóa</span>
                            </td>
                        </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
        </div>
    </div>


<div class="footer-control w-100 d-flex flex-wrap">
    <div class="col-sm-4 h-100">
        <select name="record_per_page" id="" class="form-control record_per_page rounded-pill">
            <option value="10" {{ $recordPerPage == 10 ? 'selected' : ''}}>10 nội dung/trang</option>
            <option value="15" {{ $recordPerPage == 15 ? 'selected' : ''}}>15 nội dung/trang</option>
            <option value="20" {{ $recordPerPage == 20 ? 'selected' : ''}}>20 nội dung/trang</option>
            <option value="30" {{ $recordPerPage == 30 ? 'selected' : ''}}>40 nội dung/trang</option>
            <option value="50" {{ $recordPerPage == 50 ? 'selected' : ''}}>50 nội dung/trang</option>
            <option value="100" {{ $recordPerPage == 100 ? 'selected' : ''}}>100 nội dung/trang</option>
        </select>
    </div>
    <div class="col-sm-4 text-center align-middle d-flex h-100">
        <span class="center-counttext my-auto mx-auto py-1">
            Từ {{ '#' . ($startFrom + 1) . ' đến #' . ( ($count > $recordPerPage) ? ($startFrom + $recordPerPage) : ($startFrom + $count)) }} trên tổng số {{ $count }}
        </span>
    </div>
    <div class="col-sm-4 align-middle d-flex h-100">
        @isset($max)
            @if($max > 1)
            <div class="d-flex flex-wrap control-pagination ml-auto text-center">
                @php
                    $pag_max = $page + 2;
                    $pag_min = $page - 2;
                    if(($page + 2) > $max) {
                        $pag_max = $max;
                        $pag_min = $max - 4;
                    }
                    if(($page - 2) < 1) {
                        $pag_min = 1;
                        $pag_max = $pag_min + 4;
                    }
                    if($pag_max > $max) $pag_max = $max;
                    if($pag_min < 1) $pag_min = 1;
                    $paginationArray = array();
                    for($i = $pag_min; $i <= $pag_max; $i++) {
                        $paginationArray[] = $i;
                    }
                @endphp
                {{-- @for($i = $page; $i <= $max; $i++) <li --}}
                @foreach($paginationArray as $i)
                    <a class="pag-link {{ $i == $page ? 'active' : '' }}"  data-pagenum="{{ $i }}">
                        <span class="pag-button">{{ $i }}</span>
                    </a>
                {{-- @endfor --}}
                @endforeach
            </div>
            @endif
        @endisset
    </div>
</div>

</div>
<form id="page-control-form">
    <input type="hidden" value="{{ $page ?? '1' }}" name="page">
    <input type="hidden" value="{{ $recordPerPage ?? '10' }}" name="record_per_page">

    @if (isset($textSearch) && $textSearch != '')
        <input type="hidden" name="is_search" value="1">
    @else
        <input type="hidden" name="is_search" value="0">
    @endif

    <input type="hidden" value="{{ $teacherAccountStatus ?? '0' }}" name="teacher_account_status">
    <input type="hidden" value="{{ $teacher_level ?? '0' }}" name="teacher_level">
</form>
