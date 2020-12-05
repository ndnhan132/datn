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
                <option value="fullname" {{ $searchCriterion == 'fullname' ? 'selected' : '' }}>Họ tên</option>
                <option value="email" {{ $searchCriterion == 'email' ? 'selected' : '' }}>Email</option>
                <option value="address" {{ $searchCriterion == 'address' ? 'selected' : '' }}>Địa chỉ</option>
                <option value="phone" {{ $searchCriterion == 'phone' ? 'selected' : '' }}>Điện thoại</option>
                <option value="other_requirement" {{ $searchCriterion == 'other_requirement' ? 'selected' : '' }}>Số CMND</option>
            </select>
        </div>
        <div class="form-group my-2">
            <button class="form-control ml-2 btn-submit" style="display: none"><i class="fa fa-search"></i></button>
        </div>
        <span type="button" class="btn btn-sm btn-outline-dark rounded-pill btn-table-reset-reload px-3 ml-2">Reset</span>
        <div class="text-right col">
            @if ($totalNewCourse > 0)
            <span class="text-danger">* Có {{ $totalNewCourse }} lớp cần xét duyệt</span>
            @else
            <span class="text-success">* Không có lớp cần xét duyệt</span>
            @endif
        </div>
    </form>

    <div class="col-md-12 px-0">
        <div class="tile">
            <div class="table-responsive">
                <table class="table table-bordered table-striped">
                    <thead>
                        <tr>
                            <th>mã số</th>
                            <th>Người gửi</th>
                            <th>tg đăng ký</th>
                            <th class="text-center py-1">
                                <select name="select_course_level"  class="form-control select_course_level rounded-pill mx-auto text-center">
                                    <option value="">Trình độ</option>
                                    @foreach ($courseLevels as $item)
                                    <option value="{{$item->id}}" {{ ($select_course_level == $item->id) ? 'selected' : '' }}>{{ $item->display_name}}</option>
                                    @endforeach
                                </select>
                            </th>
                            <th class="text-center py-1">
                                <select name="select_subject"  class="form-control select_subject rounded-pill mx-auto text-center">
                                    <option value="">Môn học</option>
                                    @foreach ($subjects as $item)
                                    <option value="{{$item->id}}" {{ ($select_subject == $item->id) ? 'selected' : '' }}>{{ $item->display_name}}</option>
                                    @endforeach
                                </select>
                            </th>
                            <th class="text-center py-1">
                                <select name="course_status"  class="form-control course_status rounded-pill mx-auto text-center">
                                    <option value="">Xét duyệt</option>
                                    <option value="YES" {{ ($course_status === 'YES') ? 'selected' : '' }}>Thông qua</option>
                                    <option value="NO" {{ ($course_status === 'NO') ? 'selected' : '' }}>Không hợp lệ</option>
                                    <option value="NEW" {{ ($course_status === 'NEW') ? 'selected' : '' }}>Đăng ký mới</option>
                                </select>
                            </th>
                            <th class="text-center py-1">
                                <select name="is_received" class="form-control is_received rounded-pill mx-auto text-center">
                                    <option value="">Trạng thái</option>
                                    <option value="YES" {{ ($is_received === 'YES') ? 'selected' : '' }}>Đã nhận</option>
                                    <option value="NO" {{ ($is_received === 'NO') ? 'selected' : '' }}>Chưa nhận</option>
                                </select>
                            </th>
                            <th>Yêu cầu</th>
                            <th>Tác vụ</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach ($courses as $course)
                        <tr>
                            <td class="text-center">
                                <span>#{{ $course->id }}</span>
                            </td>
                            <td>
                                <span>{{ $course->fullname }}</span>
                            </td>
                            <td class="text-center">
                                <span>{{ $course->created_at ?? '--/--/-- --:--' }}</span>
                            </td>
                            <td class="text-center">
                                <span>{{ $course->courseLevel->display_name ?? $course->other_course_level }}</span>
                            </td>
                            <td class="text-center">
                                <span>{{ $course->subject->display_name ?? $course->other_subject }}</span>
                            </td>
                            <td class="text-white text-center text-capitalize">
                                @if ($course->isConfirmed())
                                <span class="label-status bg-success">Thông qua</span>
                                @elseif($course->isUnConfirmed())
                                <span class="label-status bg-secondary">Ko hợp lệ</span>
                                @elseif($course->isNew())
                                <span class="label-status bg-danger">Đăng ký mới</span>
                                @endif
                            </td>

                            <td class="text-center">
                                @if ($course->isConfirmed())
                                    @if ($course->received())
                                    <span class="label-status bg-success">Đã nhận</span>
                                    @else
                                    <span class="label-status bg-secondary">Chưa nhận</span>
                                    @endif
                                @endif
                            </td>
                            <td class="text-center">
                                <span class="btn btn-sm btn-info- btn-detail label-status-info" data-type="course" data-course-id="{{ $course->id }}" data-can-confirm="yes">Chi tiết</span>
                            </td>
                            <td class="text-center">
                                <span>
                                    <button class="btn-outline-danger btn-delete" data-id="{{ $course->id }}" {{ $course->received() ? 'disabled' : '' }} ><i class="fa fa-trash-o" aria-hidden="true"></i></button>
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

    @if (isset($searchText) && $searchText != '')
        <input type="hidden" name="is_search" value="1">
    @else
        <input type="hidden" name="is_search" value="0">
    @endif

    <input type="hidden" value="{{ $is_received ?? '' }}" name="is_received">
    <input type="hidden" value="{{ $course_status ?? '' }}" name="course_status">
    <input type="hidden" value="{{ $select_course_level ?? '' }}" name="select_course_level">
    <input type="hidden" value="{{ $select_subject ?? '' }}" name="select_subject">
</form>
