<div class="cover-container">

    <form class="col-md-12 px-0 form-inline" id="form-search">
        <div class="form-group my-2 pl-1">
            <input type="text" name="search_text" class="form-control ml-2" placeholder="Search" value="{{ $search_text ?? '' }}">
        </div>
        <div class="form-group my-2">
            trạng thái
            <select name="enquiry_status" class="form-control select_custom_control ml-2 enquiry_status">
                <option value="ALL">Tất cả</option>
                <option value="CHECKED" {{ $enquiry_status == 'CHECKED' ? 'selected' : '' }}>Đã xử lý</option>
                <option value="UNCHECKED" {{ $enquiry_status == 'UNCHECKED' ? 'selected' : '' }}>Chưa xử lý ({{ $totalUnChecked ?? '' }})</option>
            </select>
        </div>
        <div class="form-group my-2">
            <button class="form-control ml-2 btn-submit" style=""><i class="fa fa-search"></i></button>
        </div>
        <div class="form-group my-2">
            <button class="form-control ml-2 btn-table-reset-reload" type="reset"><i class="fa fa-refresh"></i></button>
        </div>
    </form>

    <div class="col-md-12 px-0">
        <div class="tile">
            <div class="table-responsive">
                <table class="table table-bordered- table-striped enquiry-table">
                    <thead>
                        <tr>
                            <th class="col-1 r-1">ID</th>
                            <th class="col-1 r-2">Trạng thái</th>
                            <th class="col-2 r-3 text-left">Người gửi</th>
                            <th class="col-1 r-4">tg gửi</th>
                            <th class="col-3 r-5">Nội dung</th>
                            <th class="col-1 r-6">Tác vụ</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach ($enquiries as $enquiry)
                        <tr>
                            <td class="text-center">
                                <span>#{{ $enquiry->id }}</span>
                            </td>
                            <td class="text-center enquiry-status">
                                @if ($enquiry->flag_is_checked)
                                <span class="btn-change-post-status" data-record-id="{{ $enquiry->id }}">
                                    <i class="fa fa-check-circle-o text-success"></i>
                                </span>
                                @else
                                <span class="btn-change-post-status" data-record-id="{{ $enquiry->id }}">
                                    <i class="fa fa-clock-o text-warning"></i>
                                </span>
                                @endif
                            </td>
                            <td class="text-nowrap">
                                <span>{{ $enquiry->name }}</span>
                            </td>
                            <td class="text-center text-nowrap">
                                <span>{{ (new Carbon\Carbon($enquiry->created_at))->setTimeZone('Asia/Ho_Chi_Minh')->isoFormat('DD/MM') ?? '--/--' }}</span>
                            </td>

                            <td class="text-left btn-enquiry-detail" data-enquiry="{{ $enquiry->id }}">
                                {!! $enquiry->getPreviewHtml() !!}
                            </td>
                            <td class="text-center">
                                <span>
                                    <button class="btn-outline-danger btn-delete-record" data-record-id="{{ $enquiry->id }}" {{ !$enquiry->flag_is_checked ? 'disabled' : '' }}>
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
<div class="modal modal-enquiry-detail" tabindex="-1">
    <div class="modal-dialog">
      <div class="modal-content">
        <div class="modal-header">
          <h5 class="modal-title">Chi tiết</h5>
          <button type="button" class="close" data-dismiss="modal" aria-label="Close">
            <span aria-hidden="true">&times;</span>
          </button>
        </div>
        <div class="modal-body">
          <div class="d-flex flex-column">
              <label for="">Họ tên</label>
              <div class="field-val field-val-name"></div>
              <label for="">Điện thoại</label>
              <div class="field-val field-val-phone"></div>
              <label for="">Email</label>
              <div class="field-val field-val-email"></div>
              <label for="">Trạng thái</label>
              <div class="field-val field-val-status"></div>
              <label for="">Nội dung</label>
              <div class="field-val field-val-content"></div>
          </div>
        </div>
        <div class="modal-footer">
          <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
          <button type="button" class="btn btn-primary">Save changes</button>
        </div>
      </div>
    </div>
  </div>
<form id="page-control-form" class="d-none">
    <input type="hidden" value="{{ $page ?? '1' }}" name="page">
    <input type="hidden" value="{{ $recordPerPage ?? '10' }}" name="record_per_page">

    @if (isset($search_text) && $search_text != '')
        <input type="hidden" name="is_search" value="1">
    @else
        <input type="hidden" name="is_search" value="0">
    @endif

    <input type="hidden" value="{{ $enquiry_status ?? 'ALL' }}" name="enquiry_status">
</form>
