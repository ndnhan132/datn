@foreach ($articles as $item)
    <article class="news-item">
        <div class="w-100 d-flex">
            <div class="news-img col-lg-4 col-md-4 col-sm-4 col-xs-12">
                <a href="">
                    <img src="{{ asset('images/noimage.jpg') }}" alt="@">
                </a>
            </div>
            <div class="col-lg-8 col-md-8 col-sm-8 col-xs-12">
                <a href="{{ route('front.readNews', $item->slug) }}" class="news-title">
                    <h2 class="text-truncate">{{$item->title ?? ''}}</h2>
                </a>
                <div class="date">
                    <i class="far fa-calendar-alt"></i>&nbsp;&nbsp;07 02/2017
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
