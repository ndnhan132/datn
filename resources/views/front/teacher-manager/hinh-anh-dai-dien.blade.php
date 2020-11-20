@extends('front.layouts.teacher-manager-master')
@section('title', 'Cài đặt chung')
@section('head')
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/croppie/2.6.4/croppie.min.css">
@endsection
@section('content')
@php
    $teacher = Auth::guard('teacher')->user();
@endphp
<div class="content mb-5">
    <form action="" method="post" id="avatar-form" enctype='multipart/form-data'>
        <div class="setting-alert">
        </div>
        <div class="row d-flex flex-wrap border-bottom py-3">
            <div class="form-group col-sm-12">
                <div class="d-flex justify-content-center">
                    <div class=" select-avatar">
                        <div class="upload">
                            <i class="fas fa-camera"></i>
                        </div>
                        <div class="preview">
                            <img src="{{ asset(Auth::guard('teacher')->user()->getAvatarSrc()) }}" alt="#" class="img-fluid">
                        </div>
                    </div>
                </div>
                {{-- <input type="file" class="d-none" name="avatar"> --}}
                <input type="hidden" class="d-none" name="file_extension">
                <input type="hidden" class="d-none" name="file_name">
                <input type="hidden" class="d-none" name="file_data">
                <input type="hidden" class="d-none" name="file_src" value="{{ Auth::guard('teacher')->user()->getAvatarSrc() }}">
            </div>
        </div>
        <div class="w-100 d-flex py-4">
            <a href="#" class="btn btn-info rounded-pill text-uppercase px-5 mx-auto btn-submit">Lưu</a>
        </div>
    </form>
</div>

  <div class="modal fade" id="crop-image-modal" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
    <div class="modal-dialog">
      <div class="modal-content">
        <div class="modal-header">
          <h5 class="modal-title" id="exampleModalLabel">Modal title</h5>
          <button type="button" class="close" data-dismiss="modal" aria-label="Close">
            <span aria-hidden="true">&times;</span>
          </button>
        </div>
        <div class="modal-body">
          <div><input type='file' value="upload" id="choose_image"></div>
          <div>
              <div id="image-croppie">

              </div>
          </div>
        </div>
        <div class="modal-footer">
          <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
          <button type="button" class="btn btn-primary btn-save">Save changes</button>
        </div>
      </div>
    </div>
  </div>

<script src="https://cdnjs.cloudflare.com/ajax/libs/croppie/2.6.4/croppie.min.js"></script>
<script>
$(function() {
    var imageCrop = $("#image-croppie").croppie({
                    enableExif: true,
                    viewport: {
                        width: 150,
                        height: 225,
                        type: "square",
                    },
                    boundary: {
                        width: 250,
                        height: 300,
                    },
                    showZoomer: false,
                    enforceBoundary: false,
                });
    $(document).on('click', '#avatar-form .upload', function() {
        // $(document).find('#avatar-form input[name=avatar]').click();
        imageCrop.croppie("bind", {
                                url: $('#avatar-form .preview img').attr('src'),
                                zoom: 1
                            })
                            .then(function () {
                                console.log("complete");
                                // $("#image-preview").addClass("is-valid");
                            });
        $('#crop-image-modal').modal('show');
    });

    $(document).on('change', '#choose_image', function(){
        var _fileData = $(this).prop('files')[0];
        var _ext = $(this).val().split('.').pop().toLowerCase();
        if ($.inArray(_ext, ['png', 'jpg', 'jpeg']) == -1) {
            // $('#avatar-form').reset();
            alert('ko ho tro');
            return;
        }
        if (_fileData.size > 4200000) /* 2mb*/ {
            // $('#avatar-form').reset();
            alert('file qua lon');
            return;
        }
        $('#avatar-form input[name=file_extension]').val(_ext);
        $('#avatar-form input[name=file_name]').val(_fileData.name);
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
                    $('#avatar-form input[name=file_data]').val(response);
                    $('#avatar-form input[name=file_src]').val('');
                    $('#avatar-form .preview img').attr('src', response);
                    $('#crop-image-modal').modal('hide');
                });
    })
});
</script>
@endsection
