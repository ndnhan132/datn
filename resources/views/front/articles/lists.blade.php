@foreach ($articles as $item)
    <article class="news-item">
        <div class="w-100 d-flex">
            <div class="news-img col-lg-4 col-md-4 col-sm-4 col-4">
                <a href="">
                    @if ($item->image)
                    <img src="{{ asset_public_env($item->image) }}" alt="@" class="img-fluid">
                    @else
                    <img src="{{ asset_public_env('images/noimage.jpg') }}" alt="@" class="img-fluid">
                    @endif
                </a>
            </div>
            <div class="col-lg-8 col-md-8 col-sm-8 col-8">
                <a href="{{ route('front.readNews', $item->slug) }}" class="news-title">
                    <h2 class="text-truncate text_georgia">{{ $item->title ? ucfirst($item->title) : ''}}</h2>
                </a>
                <div class="date">
                    <i class="far fa-calendar-alt"></i>&nbsp;&nbsp;{{ (new Carbon\Carbon($item->created_at))->setTimeZone('Asia/Ho_Chi_Minh')->isoFormat('DD MM/Y') ?? '-- --/----' }}
                </div>
            </div>
        </div>
    </article>
@endforeach
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
