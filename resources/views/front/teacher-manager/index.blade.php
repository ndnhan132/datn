@extends('front.layouts.teacher-manager-master')
@section('title', 'Hồ Sơ ' . (Auth::guard('teacher')->user()->name ?? 'Cá Nhân'))
@section('head')
@endsection
@section('content')
@php
    $teacher = Auth::guard('teacher')->user();
    $identityCardImages = $teacher->getIdentityCardImages();
    $degreeCardImages = $teacher->getDegreeImages();
    $images = array();
    $images = array_merge($images, $identityCardImages);
    $images = array_merge($images, $degreeCardImages);
    $registrations = $teacher->teacherCourseRegistrations->sortByDesc('id')->all();
    $myReceived = $teacher->getMyReceivedRegistration();
@endphp
<div class="content- mb-5" id="profile">
    <div>
        <div class="row d-flex flex-wrap pb-4">
            <div class="form-group col-sm-12">
                {{-- <label class="col-sm-12">Tải lên</small></label> --}}
                <div class="col-sm-12">
                    <div class="profile-box- d-flex flex-wrap">
                        <div class="profile-box avatar">
                            <img src="{{ asset(Auth::guard('teacher')->user()->getAvatarSrc() ?? '/image/noimage.jpg') }}" alt="" class="img-thumbnail">
                        </div>
                        <div class="col profile-box ml-3">
                            <div class="d-flex flex-column px-2">
                                <h4 class="text-capitalize name"> {{ $teacher->name }}</h4>
                                <table>
                                    <tr>
                                        <td class="text-nowrap"><span>-&nbsp;Email</span></td>
                                        <td><span>{{ $teacher->email }}</span></td>
                                    </tr>
                                    <tr>
                                        <td class="text-nowrap"><span>-&nbsp;Điện thoại</span></td>
                                        <td><span>{{ $teacher->phone }}</span></td>
                                    </tr>
                                    <tr>
                                        <td class="text-nowrap"><span>-&nbsp;Địa chỉ</span></td>
                                        <td><span>{{ $teacher->address }}</span></td>
                                    </tr>
                                    <tr>
                                        <td class="text-nowrap"><span>-&nbsp;Giới tính</span></td>
                                        <td><span>{{ $teacher->is_male ? 'Nam' : 'Nữ' }}</span></td>
                                    </tr>

                                    <tr>
                                        <td class="text-nowrap"><span>-&nbsp;Năm sinh</span></td>
                                        <td><span>{{ $teacher->year_of_birth . ' ('. (date("Y") - $teacher->year_of_birth) .' tuổi)' }}</span></td>
                                    </tr>
                                </table>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <div class="form-group col-sm-12">
                <div class="col-sm-12">
                    <div class="profile-box d-flex flex-wrap">
                        <div class="col-12">
                            <div class="d-flex flex-column">
                                <h5 class="text-capitalize name">Thông tin khác</h5>
                                <table>
                                    <tr>
                                        <td class="text-nowrap"><span>-&nbsp;Trường đại học</span></td>
                                        <td><span>{{ $teacher->university ?? 'Chưa cập nhật' }}</span></td>
                                    </tr>
                                    <tr>
                                        <td class="text-nowrap"><span>-&nbsp;Chuyên nghành</span></td>
                                        <td><span>{{ $teacher->speciality ?? 'Chưa cập nhật'  }}</span></td>
                                    </tr>
                                    <tr>
                                        <td class="text-nowrap"><span>-&nbsp;Trình độ hiện tại</span></td>
                                        <td><span>{{ $teacher->teacherLevel->display_name ?? 'Chưa cập nhật'  }}</span></td>
                                    </tr>
                                    <tr>
                                        <td class="text-nowrap"><span>-&nbsp;Lương tham khảo</span></td>
                                        <td><span>{{ $teacher->reference_tuition ?$teacher->getDisplayTution() . ' Vnđ/Tháng' : 'Chưa cập nhật' }}</span></td>
                                    </tr>
                                    <tr>
                                        <td class="text-nowrap"><span>-&nbsp;Tình trạng tài khoản</span></td>
                                        <td><span>{{ $teacher->isActive() ? 'Đã kích hoạt' : 'Chưa được xét duyệt' }}</span></td>
                                    </tr>
                                    <tr>
                                        <td class="text-nowrap"><span>-&nbsp;Thông tin thêm</span></td>
                                        <td><span>{{ $teacher->description ?? 'Chưa cập nhật' }}</span></td>
                                    </tr>
                                </table>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <div class="form-group col-sm-12">
                <div class="col-sm-12">
                    <div class="profile-box d-flex flex-wrap">
                        <div class="col-12">
                            <div class="d-flex flex-column">
                                <h5 class="text-capitalize name">Lớp đã nhận</h5>
                                @if ($myReceived)
                                @include('front.teacher-manager.registed-course')
                                @else
                                <span>Chưa Nhận lớp nào</span>
                                @endif
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <div class="form-group col-sm-12">
                <div class="col-sm-12">
                    <div class="profile-box d-flex flex-wrap ">
                        <div class="col-12">
                            <div class="d-flex flex-column image">
                                <h5 class="text-capitalize name">Hình ảnh</h5>
                                <div class="d-flex flex-wrap">
                                    @if (count($images))
                                        @foreach ($images as $item)
                                        <div class="col-md-4 px-1 pb-2">
                                            <div class="" data-id="{{ $item->id }}">
                                                <img src="{{asset( $item->src )}}" alt="" class="img-thumbnail">
                                            </div>
                                        </div>
                                        @endforeach
                                    @else
                                        <span>Chưa có hình ảnh</span>
                                    @endif
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
<div class="modal fade" id="view-image-modal" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
    <div class="modal-dialog">
      <div class="modal-content">
        <div class="modal-header">
          <h5 class="modal-title" id="exampleModalLabel">Hình ảnh</h5>
          <button type="button" class="close" data-dismiss="modal" aria-label="Close">
            <span aria-hidden="true">&times;</span>
          </button>
        </div>
        <div class="modal-body">
        </div>
      </div>
    </div>
  </div>

<script>
$(function() {
    $(document).on('click', '.image img', function() {
        var _modal = $('#view-image-modal');
        _modal.find('.modal-body').empty();
        _modal.find('.modal-body').append('<img src="' + $(this).attr('src') + '" alt="" class="img-thumbnail img-fluid w-100">');
        _modal.modal('show');
    });
});
</script>
@endsection
