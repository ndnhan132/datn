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
            </select>
        </div>
        <div class="form-group my-2">
            <button class="form-control ml-2 btn-submit"><i class="fa fa-search"></i></button>
        </div>
        <div class="form-group my-2">
            <button class="form-control ml-2 btn-table-reset-reload" type="reset"><i class="fa fa-refresh"></i></button>
        </div>
    </form>

    <div class="col-md-12 px-0">
        <div class="tile">
            <div class="table-responsive">
                <table class="table table-bordered- table-striped">
                    <thead>
                        <tr>
                            <th>mã số</th>
                            <th>Tiêu đề</th>
                            <th>Thời gian tạo</th>
                            <th>Thể loại</th>
                            <th>Xem</th>
                            <th>Tác vụ</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach ($posts as $post)
                        <tr>
                            <td class="text-center">
                                <span>{{ $post->id }}</span>
                            </td>
                            <td>
                                <span>{{ $post->title }}</span>
                            </td>
                            <td class="text-center">
                                <span>{{ date_format($post->created_at, 'd/m/Y') ?? '--/--/--' }}</span>
                            </td>
                            <td class="text-center">
                                @if ($post->category == 'PAGE')
                                <span>Trang</span>
                                @else
                                <span>Tin tức</span>
                                @endif
                            </td>
                            <td class="text-center">
                                <a class="" href="{{ route('front.readNews', $post->slug ) }}" target="_blank">Xem</a>
                            </td>
                            <td>
                                <div class="d-flex justify-content-center">
                                    <button class="btn btn-sm btn-warning text-white btn-edit" data-id="{{ $post->id }}">
                                        <i class="fa fa-edit m-0"></i>
                                    </button>
                                    <button class="btn btn-sm btn-danger text-white ml-2 btn-delete" data-id="{{ $post->id }}">
                                        <i class="fa fa-trash m-0"></i>
                                    </button>
                                </div>
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
