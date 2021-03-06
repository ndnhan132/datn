@extends('front.layouts.teacher-manager-master')
@section('title', 'Xác minh')
@section('head')
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/croppie/2.6.4/croppie.min.css">
@endsection
@section('content')
@php
    $teacher = Auth::guard('teacher')->user();
    $identityCardImages = $teacher->getIdentityCardImages();
    $degreeCardImages = $teacher->getDegreeImages();
@endphp
<div class="form-wrap mb-5">
    <form action="" method="post" id="verify-form">
        <div class="form-alert">
        </div>
        <div class="row d-flex flex-wrap pb-4">
            <div class="form-group col-sm-12 d-none">
                {{-- <label class="col-sm-12">Tải lên</small></label> --}}
                <div class="col-sm-12">
                    <div class="images-box d-flex flex-wrap border-warning">
                    </div>
                </div>
            </div>
            <div class="form-group col-sm-12">
                <label class="col-sm-12">Chứng minh nhân dân <small class="text-danger">(Tối đa 2 hình ảnh)</small></label>
                <div class="col-sm-12">
                    <div class="images-box d-flex flex-wrap" data-max="2">
                        @if (count($identityCardImages))
                            @foreach ($identityCardImages as $item)
                            <div class="image-thumbnail">
                                <div class="image-cover" data-id="{{ $item->id }}">
                                    <img src="{{asset( $item->src )}}" alt="">
                                    <div class="image-action">
                                        <div class="body">
                                            <span class="btn-view"><i class="fas fa-eye"></i></span>
                                            <span class="btn-del"><i class="fas fa-trash-alt"></i></span>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            @endforeach
                        @endif
                        @if (count($identityCardImages) < 2)
                        <div class="image-upload"  data-upload-type="IDENTITY">
                            <div class="image-cover" data-id="">
                                <img src="{{ asset_public_env('images/upload.gif') }}" alt="">
                                <div class="image-action">
                                    <div class="body">
                                        <span class="btn-view"><i class="fas fa-eye"></i></span>
                                        <span class="btn-del"><i class="fas fa-trash-alt"></i></span>
                                    </div>
                                </div>
                            </div>
                        </div>
                        @endif
                    </div>
                </div>
            </div>
            <div class="form-group col-sm-12">
                <label class="col-sm-12">Bằng cấp <small class="text-danger">(Tối đa 4 hình ảnh)</small></label>
                <div class="col-sm-12">
                    <div class="images-box d-flex flex-wrap {{ $item->id }}" data-max="4">
                        @if (count($degreeCardImages))
                            @foreach ($degreeCardImages as $item)
                            <div class="image-thumbnail {{ $item->id }}">
                                <div class="image-cover" data-id="{{ $item->id }}">
                                    <img src="{{asset( $item->src )}}" alt="">
                                    <div class="image-action">
                                        <div class="body">
                                            <span class="btn-view"><i class="fas fa-eye"></i></span>
                                            <span class="btn-del"><i class="fas fa-trash-alt"></i></span>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            @endforeach
                        @endif
                        @if (count($degreeCardImages) < 4)
                        <div class="image-upload" data-upload-type="DEGREE">
                            <div class="image-cover" data-id="">
                                <img src="{{ asset_public_env('images/upload.gif') }}" alt="">
                                <div class="image-action">
                                    <div class="body">
                                        <span class="btn-view"><i class="fas fa-eye"></i></span>
                                        <span class="btn-del"><i class="fas fa-trash-alt"></i></span>
                                    </div>
                                </div>
                            </div>
                        </div>
                        @endif
                    </div>
                </div>
            </div>
        </div>
        <input type="hidden" class="d-none" name="file_extension">
        <input type="hidden" class="d-none" name="file_name">
        <input type="hidden" class="d-none" name="file_data">
        <input type="hidden" class="d-none" name="file_type">
    </form>
</div>
<div class="modal fade verify-page" id="crop-image-modal" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
    <div class="modal-dialog">
      <div class="modal-content">
        <div class="modal-header">
          <h5 class="modal-title" id="exampleModalLabel">Upload hình ảnh</h5>
          <button type="button" class="close" data-dismiss="modal" aria-label="Close">
            <span aria-hidden="true">&times;</span>
          </button>
        </div>
        <div class="modal-body">
            <div>
                <div id="image-croppie">

                </div>
            </div>
            <input type='file' value="upload" id="choose_image" class="d-none">
            <div class="d-flex justify-content-center" onclick="document.getElementById('choose_image').click()"><button>Chọn File</button></div>
        </div>
        <div class="modal-footer">
          <button type="button" class="btn btn-secondary" data-dismiss="modal">Huỷ</button>
          <button type="button" class="btn btn-primary btn-save">Ok</button>
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

<script src="https://cdnjs.cloudflare.com/ajax/libs/croppie/2.6.4/croppie.min.js"></script>
<script>
$(function() {
    var boxSelected ;
    var uploadType;
    var imageUploadHtml = `
<div class="image-upload" data-upload-type="DEGREE">
    <div class="image-cover" data-id="">
        <img src="{{ asset_public_env('images/upload.gif') }}" alt="">
        <div class="image-action">
            <div class="body">
                <span class="btn-view"><i class="fas fa-eye"></i></span>
                <span class="btn-del"><i class="fas fa-trash-alt"></i></span>
            </div>
        </div>
    </div>
</div>
`;
    var imageCrop = $("#image-croppie").croppie({
                    enableExif: true,
                    viewport: {
                        width: 300,
                        height: 200,
                        type: "square",
                    },
                    boundary: {
                        width: 350,
                        height: 250,
                    },
                    showZoomer: false,
                    enforceBoundary: false,
                });

    $(document).on('click', '#verify-form .image-upload', function() {
        boxSelected = $(this);
        uploadType = $(this).data('upload-type');
        $('#verify-form input[name=file_type]').val(uploadType);
        $('#image-croppie img').attr('src', 'null');
        $('#crop-image-modal').modal('show');
    });

    $(document).on('change', '#choose_image', function(){
        var _fileData = $(this).prop('files')[0];
        var _ext = $(this).val().split('.').pop().toLowerCase();
        if ($.inArray(_ext, ['png', 'jpg', 'jpeg']) == -1) {
            // $('#avatar-form').reset();
            alert('Không hỗ trợ ' + _ext );
            return;
        }
        if (_fileData.size > 4200000) /* 2mb*/ {
            // $('#avatar-form').reset();
            alert('file qua lon');
            return;
        }
        $('#verify-form input[name=file_extension]').val(_ext);
        $('#verify-form input[name=file_name]').val(_fileData.name);
        var reader = new FileReader();
            reader.onload = function (event) {
                imageCrop
                    .croppie("bind", {
                        url: event.target.result,
                    })
                    .then(function () {
                        console.log("complete");
                    });
            };
        reader.readAsDataURL(this.files[0]);
    });

    $('.btn-save').on('click', function (){
        imageCrop.croppie("result", {
                    type: "canvas",
                    size: "viewport",
                })
                .then(function (response) {
                    // console.log(response);
                    $('#verify-form input[name=file_data]').val(response);
                    var _formData = $('.teacher-manager form#verify-form').serialize();
                    $.ajax({
                        url: '/ajax/teacher-manager/update/image',
                        type: 'POST',
                        dataType: 'json',
                        data: _formData,
                    })
                    .done(function (data) {
                            console.log(data);
                            // $(boxSelected).find('img').attr('src', response);
                            $(boxSelected).addClass('image-thumbnail').removeClass('image-upload');
                            $('#verify-form input[name=file_data]').val('');
                            $('#verify-form input[name=file_extension]').val('');
                            $('#verify-form input[name=file_name]').val('');
                            $('#verify-form input[name=file_type]').val('');
                            if(data.success && data.url){
                                console.log($(boxSelected));
                                $(boxSelected).find('img').attr('src', data.url);
                                $(boxSelected).find('.image-cover').attr('data-id', data.id);
                                var _imagesBox = $(boxSelected).closest('.images-box');
                                var _max = _imagesBox.data('max');
                                if(_imagesBox.find('.image-thumbnail').length < (_max)){
                                    _imagesBox.append(imageUploadHtml);
                                    if(_max == 2){
                                        _imagesBox.find('.image-upload').attr('data-upload-type', "IDENTITY");
                                    }
                                 }
                            }
                            boxSelected = '';
                            uploadType = '';
                            $('#crop-image-modal').modal('hide');
                        })
                        .fail(function (jqXHR, textStatus, errorThrown) {
                            console.log("error");
                            $('#verify-form input[name=file_data]').val('');
                            $('#verify-form input[name=file_extension]').val('');
                            $('#verify-form input[name=file_name]').val('');
                            $('#verify-form input[name=file_type]').val('');
                            boxSelected = '';
                            uploadType = '';
                            $('#crop-image-modal').modal('hide');
                        });
                });
    })

    $(document).on('click', '#verify-form .btn-view', function() {
        var _modal = $('#view-image-modal');
        _modal.find('.modal-body').empty();
        var _src = $(this).closest('.image-cover').find('img').attr('src');
        console.log(_src);
        _modal.find('.modal-body').append('<img src="' + _src + '" alt="" class="img-thumbnail img-fluid w-100">');
        _modal.modal('show');
    });
    $(document).on('click', '#verify-form .btn-del', function() {
        var _element = $(this);

        Swal.fire({
            title: 'Bạn chắc chắn muốn xoá ảnh!',
            showDenyButton: true,
            // showCancelButton: true,
            confirmButtonText: 'Xoá',
            denyButtonText: 'Không',
        }).then((result) => {
            if (result.isConfirmed) {
                $.ajax({
                url: '/ajax/teacher-manager/update/delete-image',
                type: 'POST',
                dataType: 'json',
                data: {image_id : _element.closest('.image-cover').data('id')},
            })
            .done(function (data) {
                    console.log(data);
                    if(data.success){
                        var _thumb = _element.closest('.image-thumbnail');
                        var _imagesBox = _element.closest('.images-box');
                        var _max = _imagesBox.data('max');
                        _thumb.remove();
                        if(_imagesBox.find('.image-thumbnail').length == (_max - 1)){
                            _imagesBox.append(imageUploadHtml);
                            if(_max == 2){
                                _imagesBox.find('.image-upload').attr('data-upload-type', "IDENTITY");
                            }
                        }
                    }
                })
                .fail(function (jqXHR, textStatus, errorThrown) {
                });
            }
        });
    });
});
</script>
@endsection
