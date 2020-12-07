<ul class="list-unstyled asidebar-list">
    @php
    $itemArray = array();
    $itemArray[] = array (
        'title' => 'Đăng tin tìm gia sư',
        'href'  => '',
    );
    $itemArray[] = array (
        'title' => 'Bảng giá tham khảo',
        'href'  => '',
    );
    $itemArray[] = array (
        'title' => 'Bảng giá tham khảo',
        'href'  => '',
    );
    $itemArray[] = array (
        'title' => 'Tìm kiếm gia sư',
        'href'  => '',
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
