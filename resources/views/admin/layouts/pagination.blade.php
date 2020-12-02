<div class="footer-control w-100 d-flex flex-wrap">
    <div class="col-sm-4 h-100">
        <select name="record_per_page" id="" class="form-control record_per_page rounded-pill">
            <option value="10" {{ $recordPerPage == 10 ? 'selected' : ''}}>10 nội dung/trang</option>
            <option value="15" {{ $recordPerPage == 15 ? 'selected' : ''}}>15 nội dung/trang</option>
            <option value="20" {{ $recordPerPage == 20 ? 'selected' : ''}}>20 nội dung/trang</option>
            <option value="30" {{ $recordPerPage == 30 ? 'selected' : ''}}>30 nội dung/trang</option>
            <option value="50" {{ $recordPerPage == 50 ? 'selected' : ''}}>50 nội dung/trang</option>
            <option value="100" {{ $recordPerPage == 100 ? 'selected' : ''}}>100 nội dung/trang</option>
        </select>
    </div>
    <div class="col-sm-4 text-center align-middle d-flex h-100">
        <span class="center-counttext my-auto mx-auto py-1">
            Từ {{ '#' . ($startFrom + 1) . ' đến #' . ( ($total > $recordPerPage) ? ($startFrom + $recordPerPage) : ($startFrom + $total)) }} trên tổng số {{ $total }}
        </span>
    </div>
    <div class="col-sm-4 align-middle d-flex h-100">
        @isset($max)
            @if($max > 1)
            <div class="d-flex flex-wrap control-pagination ml-auto text-center">
                @php
                    $pag_max = $page + 2;
                    $pag_min = $page - 2;
                    if(($page + 2) > $max) {
                        $pag_max = $max;
                        $pag_min = $max - 4;
                    }
                    if(($page - 2) < 1) {
                        $pag_min = 1;
                        $pag_max = $pag_min + 4;
                    }
                    if($pag_max > $max) $pag_max = $max;
                    if($pag_min < 1) $pag_min = 1;
                    $paginationArray = array();
                    for($i = $pag_min; $i <= $pag_max; $i++) {
                        $paginationArray[] = $i;
                    }
                @endphp
                {{-- @for($i = $page; $i <= $max; $i++) <li --}}
                @foreach($paginationArray as $i)
                    <a class="pag-link {{ $i == $page ? 'active' : '' }}"  data-pagenum="{{ $i }}">
                        <span class="pag-button">{{ $i }}</span>
                    </a>
                {{-- @endfor --}}
                @endforeach
            </div>
            @endif
        @endisset
    </div>
</div>
