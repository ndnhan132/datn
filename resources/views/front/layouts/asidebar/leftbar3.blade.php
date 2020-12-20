<ul class="list-unstyled asidebar-list">
    @php
    $itemArray = array();
    $itemArray[] = array (
        'title' => 'Chính sách thanh toán',
        'href'  => route('front.readPage', 'chinh-sach-thanh-toan'),
    );
    $itemArray[] = array (
        'title' => 'chính sách nhận lớp',
        'href'  => route('front.readPage', 'chinh-sach-nhan-lop'),
    );
    $itemArray[] = array (
        'title' => 'Chính sách hoàn tiền',
        'href'  => route('front.readPage', 'chinh-sach-hoan-tien'),
    );
    @endphp
    @foreach ($itemArray as $level)
    <li class="asidebar-item">
        <a href="{{ $level['href'] }}" class="asidebar-link">
            {{ $level['title'] }}
        </a>
    </li>
    @endforeach
</ul>
