<ul class="list-unstyled asidebar-list">
    @php
    $itemArray = array();
    $itemArray[] = array (
        'title' => 'Hướng dẫn đăng ký làm gia sư',
        'href'  => route('front.readPage', 'huong-dan-dang-ky-lam-gia-su'),
    );
    $itemArray[] = array (
        'title' => 'Hướng dẫn nhận lớp',
        'href'  => route('front.readPage', 'huong-dan-nhan-lop'),
    );
    $itemArray[] = array (
        'title' => 'Hướng dẫn thanh toán',
        'href'  => route('front.readPage', 'huong-dan-thanh-toan'),
    );
    $itemArray[] = array (
        'title' => 'Tuyển dụng',
        'href'  => route('front.readPage', 'tuyen-dung'),
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
