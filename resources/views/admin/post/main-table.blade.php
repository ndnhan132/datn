<div class="cover-container">
    <div class="col-md-12 px-0">
        <div class="tile">
            <div class="table-responsive">
                <table class="table table-bordered- table-hover">
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

    @isset($max)
    @if($max > 1)
    <div class="pagination-wrapper">
        <ul class="pagination pagination-sm flex-wrap justify-content-center">
            @for($i = 1; $i <= $max; $i++) <li
                class="page-item {{ $i == $page ? 'active' : '' }}"><button
                    class="page-link pagination-item"
                    data-pagenum="{{ $i }}">{{ $i }}</button></li>
                @endfor
        </ul>
    </div>
    @endif
    @endisset
</div>
