<ul class="list-unstyled asidebar-list">
    @php
    $itemArray = array();
    $itemArray[] = array (
        'title' => 'Chính sách thanh toán',
        'href'  => '',
    );
    $itemArray[] = array (
        'title' => 'chính sách nhận lớp dạy',
        'href'  => '',
    );
    $itemArray[] = array (
        'title' => 'Thỏa thuận sử dụng',
        'href'  => '',
    );
    $itemArray[] = array (
        'title' => 'Chính sách bảo mật thông tin',
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
