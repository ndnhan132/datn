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
<div class="form-wrap- mb-0 mb-md-5" id="profile">
    <div>
        <div class="row d-flex flex-wrap pb-0">
            <div class="form-group col-sm-12">
                {{-- <label class="col-sm-12">Tải lên</small></label> --}}
                <div class="col-sm-12">
                    <div class="profile-box- d-flex flex-wrap">
                        <div class="col-12 col-lg-3 h-100 px-0 text-center">
                            <div class="profile-box avatar">
                                <img src="{{ asset(Auth::guard('teacher')->user()->getAvatarSrc() ?? '/image/noimage.jpg') }}" alt="" class="img-thumbnail">
                            </div>
                        </div>
                        <div class="col profile-box ml-lg-3">
                            <div class="d-flex flex-column px-2">
                                <h4 class="text-capitalize name text-center"> {{ $teacher->name ?? 'Chưa cập nhật' }}</h4>
                                <table>
                                    <tr>
                                        <td class="text-nowrap"><span>-&nbsp;Email</span></td>
                                        <td><span>{{ $teacher->email }}</span></td>
                                    </tr>
                                    <tr>
                                        <td class="text-nowrap"><span>-&nbsp;Điện thoại</span></td>
                                        <td><span>{{ $teacher->phone ?? 'Chưa cập nhật' }}</span></td>
                                    </tr>
                                    <tr>
                                        <td class="text-nowrap"><span>-&nbsp;Địa chỉ</span></td>
                                        <td><span>{{ $teacher->address ?? 'Chưa cập nhật' }}</span></td>
                                    </tr>
                                    <tr>
                                        <td class="text-nowrap"><span>-&nbsp;Giới tính</span></td>
                                        <td>
                                            @if(!isset($teacher->is_male))
                                            <span>Chưa cập nhật</span>
                                            @elseif ($teacher->is_male)
                                            <span>Nam</span>
                                            @else
                                            <span>Nữ</span>
                                            @endif
                                        </td>
                                    </tr>

                                    <tr>
                                        <td class="text-nowrap"><span>-&nbsp;Năm sinh</span></td>
                                        <td>
                                            @if ($teacher->year_of_birth)
                                            <span>{{ $teacher->year_of_birth . ' ('. (date("Y") - $teacher->year_of_birth) .' tuổi)' }}</span>
                                            @else
                                            <span>Chưa cập nhật</span>
                                            @endif
                                        </td>
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
                                        <td class="text-nowrap"><span>-&nbsp;Nhận dạy</span></td>
                                        <td><span>{{ $teacher->getDisplayCourseLevel() ?? 'Chưa cập nhật'  }}</span></td>
                                    </tr>
                                    <tr>
                                        <td class="text-nowrap"><span>-&nbsp;Các môn</span></td>
                                        <td><span>{{ $teacher->getDisplaySubject() ?? 'Chưa cập nhật'  }}</span></td>
                                    </tr>
                                    <tr>
                                        <td class="text-nowrap"><span>-&nbsp;Lương tham khảo</span></td>
                                        <td><span>{{ $teacher->reference_tuition ?$teacher->getDisplayTution() . ' Vnđ/Buổi' : 'Chưa cập nhật' }}</span></td>
                                    </tr>
                                    <tr>
                                        <td class="text-nowrap"><span>-&nbsp;Thông tin thêm</span></td>
                                        <td><span>{{ $teacher->description ?? 'Chưa cập nhật' }}</span></td>
                                    </tr>
                                    <tr>
                                        <td class="text-nowrap"><span>-&nbsp;Cập nhật lần cuối</span></td>
                                        <td><span>{{ date( 'd-m-Y', $teacher->last_modified) ?? 'Chưa cập nhật' }}</span></td>
                                    </tr>
                                    <tr>
                                        <td class="text-nowrap"><span>-&nbsp;Tình trạng tài khoản</span></td>
                                        <td class="account-status">
                                            @if ($teacher->isConfirmed())
                                            <span>Đã kích hoạt</span>
                                            @elseif($teacher->canSendRequestConfirmation())
                                            <span>Chưa được xét duyệt</span> <a href="#" class="btn-send-request-confirmation">Gửi yêu cầu xét duyệt</a>
                                            @elseif ($teacher->isRequestVerification())
                                            <span>Đăng xử lý yêu cầu xét duyệt</span>
                                            @else
                                            <span>không đạt yêu cầu</span> <a href="#" class="btn-send-request-confirmation">Gửi yêu cầu xét duyệt</a>
                                            @endif
                                        </td>
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
                                        <div class="col-12 col-sm-6 col-md-4 px-1 pb-2">
                                            <div class="" data-id="{{ $item->id }}">
                                                <img src="{{asset_public_env( $item->src )}}" alt="" class="img-thumbnail">
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
<div class="modal fade modal-custom" id="view-image-modal" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
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
    $(document).on('click', '.btn-send-request-confirmation', function(event) {
        event.preventDefault();
        $is_confirm = confirm('Chắc chắn gửi yêu cầu.');
        if($is_confirm){
            $.ajax({
                url: '/ajax/teacher-manager/send-request-confirmation',
                type: 'GET',
            })
            .done(function(data) {
                console.log(data);
                if(data.success){
                    alert('Gửi yêu cầu thành công');
                    $('.account-status').empty().append('<span>Đăng xử lý yêu cầu xét duyệt</span>');
                }
                else if(data.message) {
                    // msgError(data.message);
                    alert(data.message);
                }
            })
            .fail(function (jqXHR, textStatus, errorThrown) {
                console.log("error");
                alert(errorThrown);
                // msgError(errorThrown);
            });
        }
    });
});
</script>
@endsection
