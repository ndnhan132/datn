{{-- <p class="card-text">
    <a href="{{ route('front.getCourseRegisterPage')}}">dang ky tim
        gia su</a>
    <hr>
    <a href="{{ route('front.getTeacherRegisterPage')}}">dang ky lam
        gia su</a>
</p> --}}
<ul class="list-unstyled asidebar-list">
    {{-- @isset($courseLevels)
    @foreach ($courseLevels as $level)
    <li class="asidebar-item">
        <a href="" class="asidebar-link">
            {{ 'tìm gia sư dạy ' . $level->display_name }}
        </a>
    </li>
    @endforeach
    @endisset --}}
    @php
    $itemArray = array();
    $itemArray[] = array (
        'title' => 'T',
);
    @endphp
    @foreach ($itemArray as $level)
    <li class="asidebar-item">
        <a href="" class="asidebar-link">
            {{ $level['title'] }}
        </a>
    </li>
    @endforeach
</ul>
