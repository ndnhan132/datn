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
            <button class="form-control ml-2 btn-submit"><i class="fa fa-search"></i></button>
        </div>
        <div class="form-group my-2">
            <button class="form-control ml-2 btn-table-reset-reload" type="reset"><i class="fa fa-refresh"></i></button>
        </div>
        <div class="form-group my-2">
            <button class="form-control ml-2 btn-course-create" ><i class="fa fa-plus-circle"></i></button>
        </div>
    </form>

    <div class="col-md-12 px-0">
        <div class="tile">
            <div class="table-responsive">
                <table class="table table-bordered- table-striped">
                    <thead>
                        <tr>
                            <th>mã số</th>

                            <th class="text-center py-1">
                                <select name="select_course_level"  class="form-control select_custom_control select_course_level rounded-pill mx-auto text-center">
                                    <option value="">Trình độ</option>
                                    @foreach ($courseLevels as $item)
                                    <option value="{{$item->id}}" {{ ($select_course_level == $item->id) ? 'selected' : '' }}>{{ $item->display_name}}</option>
                                    @endforeach
                                </select>
                            </th>
                            <th class="text-center py-1">
                                <select name="select_subject"  class="form-control select_custom_control select_subject rounded-pill mx-auto text-center">
                                    <option value="">Môn học</option>
                                    @foreach ($subjects as $item)
                                    <option value="{{$item->id}}" {{ ($select_subject == $item->id) ? 'selected' : '' }}>{{ $item->display_name}}</option>
                                    @endforeach
                                </select>
                            </th>
                            <th>Số buổi/tuần</th>
                            <th>học phí</th>
                            <th>Tác vụ</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach ($courses as $course)
                        <tr>
                            <td class="text-center">
                                <span>#{{ $course->id }}</span>
                            </td>

                            <td class="text-center">
                                <span>{{ $course->courseLevel->display_name ?? $course->other_course_level }}</span>
                            </td>
                            <td class="text-center">
                                <span>{{ $course->subject->display_name ?? $course->other_subject }}</span>
                            </td>
                            <td class="text-center">
                                <span>{{ $course->session_per_week }}</span>
                            </td>
                            <td class="text-center">
                                <span>{{ $course->tuition_per_session }}</span>
                            </td>
                            <td class="text-center">
                                <span>
                                    <button class="btn- btn-sm- btn-info- btn-outline-info btn-detail" data-type="course" data-course-id="{{ $course->id }}" data-can-confirm="yes">
                                        <i class="fa fa-eye" aria-hidden="true"></i>
                                    </button>
                                </span>

                                <span>
                                    <button class="btn-outline-warning btn-course-edit" data-id="{{ $course->id }}">
                                        <i class="fa fa-edit m-0"></i>
                                    </button>
                                </span>

                                <span>
                                    <button class="btn-outline-danger btn-delete-record" data-record-id="{{ $course->id }}">
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
