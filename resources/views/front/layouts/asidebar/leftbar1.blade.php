<ul class="list-unstyled asidebar-list">
    @php
    $itemArray = array();
    $itemArray[] = array (
        'title' => 'Đăng tìm gia sư',
        'href'  => route('front.getCourseRegisterPage'),
    );
    $itemArray[] = array (
        'title' => 'Bảng giá tham khảo',
        'href'  => route('front.getReferenceTuitionPage'),
    );
    $itemArray[] = array (
        'title' => 'Phụ huynh cần biết',
        'href'  => route('front.readPage', 'phu-huynh-can-biet'),
    );
    $itemArray[] = array (
        'title' => 'Tìm kiếm gia sư',
        'href'  => route('front.getAllTeachersPage'),
    );
    @endphp
    @foreach ($itemArray as $level)
    <li class="asidebar-item">
        <a href=" {{ $level['href'] }}" class="asidebar-link">
            {{ $level['title'] }}
        </a>
    </li>
    @endforeach
</ul>
