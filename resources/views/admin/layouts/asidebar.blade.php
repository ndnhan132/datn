@php
$asideItems = array(
    'dashboard' => [
        'title'       => 'Dashboard',
        'fontawesome' => 'fa fa-dashboard',
        'routeName'   => 'admin.dashboard.index',
        'uri'         => 'quan-ly',
        'txt3'        => 'admin.dashboard.index',
    ],
    'teacher' => [
        'title'       => 'Danh sách gia sư',
        'fontawesome' => 'fa fa-graduation-cap',
        'routeName'   => 'admin.teacher.index',
        'uri'         => 'quan-ly/giao-vien',
        'txt3'        => 'admin.dashboard.index',
    ],
    'key3' => [
        'title'       => 'Đăng ký nhận lớp',
        'fontawesome' => 'fa fa-registered',
        'routeName'   => 'admin.teacherCourseRegistration.index',
        'uri'         => 'quan-ly/dang-ky-nhan-lop',
        'txt3'        => 'admin.dashboard.index',
],
    'key4' => [
        'title'       => 'Danh sách lớp',
        'fontawesome' => 'fa fa-file-text-o',
        'routeName' => 'admin.course.index',
        'uri' => 'quan-ly/khoa-hoc',
        'txt3' => 'admin.dashboard.index',
],
    'key6' => [
        'title'       => 'Tin tức/Trang',
        'fontawesome' => 'fa fa-newspaper-o',
        'routeName'   => 'admin.post.index',
        'uri'         => 'quan-ly/bai-viet',
'txt3' => 'admin.dashboard.index',
],
    'key7' => [
        'title'       => 'Liên hệ',
        'fontawesome' => 'fa fa-envelope',
        'routeName'   => 'admin.enquiry.index',
        'uri'         => 'quan-ly/lien-he',
        'txt3' => 'admin.dashboard.index',
],
);
@endphp


<div class="app-sidebar__user">
    <img class="app-sidebar__user-avatar rounded-0 mx-1"
        src="{{ asset('images/logo/5.png') }}"
        width="90"
        alt="User Image">
    <div>
        <p class="app-sidebar__user-name">{{ Auth::user()->name ?? 'Adminstrator'}}</p>
        {{-- <p class="app-sidebar__user-designation">Người Quản Lý</p> --}}
    </div>
</div>
<ul class="app-menu">
    @foreach ($asideItems as $key => $item)
    <li>
        <a class="app-menu__item
            {{ Request::is( $item['uri'] ) ? 'active' : ''}}"
            href="{{ route( $item['routeName']) }}">
            <i class="app-menu__icon {{ $item['fontawesome'] }}"></i>
            <span class="app-menu__label text-capitalize">{{ $item['title'] }}</span>
        </a>
    </li>
    @endforeach
</ul>
