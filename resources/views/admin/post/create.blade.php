<div class="cover-container">
    <div class="col-md-12 px-0">
        <div class="tile">
            @if (isset($post))
            <form id="js-form-update" class="post-form p-3">
                <input type="hidden" name="id" value="{{ $post->id}}">
                @if ($post->category == 'PAGE')
                <div class="col-md-12 pl-0">
                    <div class="alert alert-danger alert-dismissible fade show" role="alert">
                        <strong>Lưu ý!</strong> Khi thay đổi tiêu đề trang có thể sẽ thay đổi đường dẫn đang được sử dụng.
                        <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                          <span aria-hidden="true">&times;</span>
                        </button>
                      </div>
                </div>
                @endif
            @else
            <form id="js-form-create" class="post-form p-3">
            @endif
                <div class="row">
                    <div class="col-lg-12 d-flex flex-wrap">
                        <div class="form-group col-sm-6 pl-0">
                            <label for="input-name">Tiêu đề</label>
                            <input class="form-control" id="input-title" name="title" type="text" value="{{ $post->title ?? ''}}">
                            <div class="form-control-feedback"></div>
                        </div>
                        <div class="form-group col-sm-6 pl-0">
                            <label for="input-slug">Slug</label>
                            <input class="form-control" id="input-slug" name="slug" type="text" value="{{ $post->slug ?? '' }}">
                            <div class="form-control-feedback"></div>
                        </div>
                        <div class="form-group col-sm-6 pl-0">
                            <label for="input-slug">Thể loại</label>
                            <select class="form-control " id="input-category" name="category">
                                @if (isset($post))
                                <option value="NEWS" {{ $post->category == 'NEWS' ? 'selected' : '' }}>Bài tin tức</option>
                                <option value="PAGE" {{ $post->category == 'PAGE' ? 'selected' : '' }}>Trang</option>
                                @else
                                <option value="NEWS">Bài tin tức</option>
                                <option value="PAGE">Trang</option>
                                @endif
                            </select>
                        </div>
                        <div class="form-group col-sm-6 pl-0">
                            <label for="input-slug">Đường dẫn</label>
                            @if (isset($post))
                            @php
                            if($post->category == 'PAGE'){
                                $url = route('front.readPage', $post->slug);

                            }else{
                                $url = route('front.readNews', $post->slug);
                            }
                            @endphp
                            <input class="form-control" id="input-url" type="text" value="{{ $url ?? '' }}" readonly>
                            @else
                            <input class="form-control" id="input-url" type="text" readonly>
                            @endif
                            <div class="form-control-feedback"></div>
                        </div>
                    </div>
                    <div class="col-md-12">
                        <div class="form-group">
                            <div class="row">
                                <label for="input-content" class="col-1">Hình ảnh</label>
                                <input type="file" class="form-control-file col-9" name="image">
                            </div>
                        </div>
                    </div>
                    <div class="col-md-12">
                        <div class="form-group">
                            <label for="input-content">Nội dung</label>
                            <div class="form-control-feedback"></div>
                            <textarea class="form-control" id="input-content" name="content">{{ $post->content ?? '' }}</textarea>
                        </div>
                    </div>
                </div>
                <div class="tile-footer">
                    <button class="btn btn-primary btn-submit" type="submit">Lưu</button>
                        <button class="btn btn-secondary ml-2 btn-table-reset-reload" type="reset">Quay lại</button>
                </div>
            </form>
        </div>
    </div>
</div>
<script>
    $(function() {
        var waitForLoadFormNew = function (selector, callback) {
            if (jQuery(selector).length) {
                callback();
            } else {
                setTimeout(function () {
                    waitForLoadFormNew(selector, callback);
                }, 100);
            }
        };
        waitForLoadFormNew("#input-content", function () {
            // CKEDITOR.config.height = 300;
            CKEDITOR.replace('input-content', {
                height: 300,
                filebrowserUploadUrl: "{{route('admin.ckeditor.upload')}}",
                filebrowserUploadMethod: 'form'
           });
        });
    });

    $(document).on('keyup', '#input-title', function (){
        var title = $(this).val();
        var slug = title2Slug(title);
        var url = slug2Url(slug);
        $(document).find('#input-slug').val(slug);
        $(document).find('#input-url').val(url);
    });

    $(document).on('change', '#input-slug', function (){
        var slug =  $(this).val();
        var url = slug2Url(slug);
        $(document).find('#input-url').val(url);
    });

    $(document).on('change', '#input-category', function (){
        var slug =  $('#input-slug').val();
        var url = slug2Url(slug);
        $(document).find('#input-url').val(url);
    });

    function title2Slug(title)
    {
        var slug;
        slug = title.toLowerCase();
        slug = slug.replace(/á|à|ả|ạ|ã|ă|ắ|ằ|ẳ|ẵ|ặ|â|ấ|ầ|ẩ|ẫ|ậ/gi, 'a');
        slug = slug.replace(/é|è|ẻ|ẽ|ẹ|ê|ế|ề|ể|ễ|ệ/gi, 'e');
        slug = slug.replace(/i|í|ì|ỉ|ĩ|ị/gi, 'i');
        slug = slug.replace(/ó|ò|ỏ|õ|ọ|ô|ố|ồ|ổ|ỗ|ộ|ơ|ớ|ờ|ở|ỡ|ợ/gi, 'o');
        slug = slug.replace(/ú|ù|ủ|ũ|ụ|ư|ứ|ừ|ử|ữ|ự/gi, 'u');
        slug = slug.replace(/ý|ỳ|ỷ|ỹ|ỵ/gi, 'y');
        slug = slug.replace(/đ/gi, 'd');
        slug = slug.replace(/\`|\~|\!|\@|\#|\||\$|\%|\^|\&|\*|\(|\)|\+|\=|\,|\.|\/|\?|\>|\<|\'|\"|\:|\;|_/gi, '');
        slug = slug.replace(/ /gi, " - ");
        slug = slug.replace(/\-\-\-\-\-/gi, '-');
        slug = slug.replace(/\-\-\-\-/gi, '-');
        slug = slug.replace(/\-\-\-/gi, '-');
        slug = slug.replace(/\-\-/gi, '-');
        slug = '@' + slug + '@';
        slug = slug.replace(/\@\-|\-\@|\@/gi, '');
        slug = slug.replace(/\s/g,'')
        return slug;
    }

    function slug2Url(slug){
        var url;
        var category = $(document).find('#input-category').val();
        url = window.location.protocol + '//';
        url += window.location.hostname;
        if(category == 'PAGE'){
            url += '/trang/';
        }else {
            url += '/tin-tuc/';
        }
        url += slug + '.html';
        return url;
    }
</script>
