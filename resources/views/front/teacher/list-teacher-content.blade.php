@isset($total)
<div class="w-100 opacity_transition_effect">
    <div class="col-12 px-0">
        <div class="total-results">
            <span>{{ $total }} Kết quả tìm thấy</span>
        </div>
    </div>
</div>
@endisset
<div class="d-flex flex-wrap opacity_transition_effect">
    @foreach ($teachers as $teacher)
    <article class="teacher-item col-sm-6 px-0 border-bottom">
        <div class="w-100 d-flex bg-white p-3">
            <div class="teacher-img col-lg-4 col-md-4 col-sm-4 col-xs-12">
                <a href="" class="btn-view-teacher-modal" data-teacher="{{ $teacher->id }}">
                    <img src="{{ $teacher->getAvatarSrc() }}" alt="@">
                </a>
            </div>
            <div class="col-lg-8 col-md-8 col-sm-8 col-xs-12">
                <a href="" class="teacher-name btn-view-teacher-modal" data-teacher="{{ $teacher->id }}">
                    <h2 class="text-truncate">{{ $teacher->name }}</h2>
                </a>
                <div class="date">
                    Trình độ :&nbsp;&nbsp;{{ $teacher->getGenderAndLevel() }}
                </div>
                <div class="date">
                    Nhận dạy môn :&nbsp;&nbsp;<span class="text-capitalize">{{ $teacher->getDisplaySubject() }}</span>
                </div>
                <div class="date">
                    Nhận dạy lớp :&nbsp;&nbsp;<span class="text-capitalize">{{ $teacher->getDisplayCourseLevel() }}</span>
                </div>

            </div>
        </div>
    </article>
    @endforeach
</div>
@isset($max)
@if($max > 1)
<div class="pagination-wrapper mt-3 opacity_transition_effect">
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
