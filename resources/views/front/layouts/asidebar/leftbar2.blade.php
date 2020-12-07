<ul class="list-unstyled asidebar-list">
    @php
    $itemArray = array();
    $itemArray[] = array (
        'title' => 'Hướng dẫn đăng ký làm gia sư',
        'href'  => '',
    );
    $itemArray[] = array (
        'title' => 'Hướng dẫn đăng ký nhận lớp',
        'href'  => '',
    );
    $itemArray[] = array (
        'title' => 'Hướng dẫn thanh toán',
        'href'  => '',
    );
    $itemArray[] = array (
        'title' => 'Nội qui nhân lớp',
        'href'  => '',
    );
    $itemArray[] = array (
        'title' => 'Tuyển dụng',
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
