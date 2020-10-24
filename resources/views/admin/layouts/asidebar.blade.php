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
        'title'       => 'DS gia sư',
        'fontawesome' => 'fa fa-pie-chart',
        'routeName'   => 'admin.teacher.index',
        'uri'         => 'quan-ly/giao-vien',
        'txt3'        => 'admin.dashboard.index',
    ],
    'key3' => [
        'title'       => 'Đk nhận lớp',
        'fontawesome' => 'fa fa-laptop',
        'routeName'   => 'admin.teacherCourseRegistration.index',
        'uri'         => 'quan-ly/dang-ky-nhan-lop',
        'txt3'        => 'admin.dashboard.index',
],
    'key4' => [
        'title'       => 'Đk tìm gia sư',
        'fontawesome' => 'fa fa-ravelry',
        'routeName' => 'admin.course.index',
        'uri' => 'quan-ly/khoa-hoc',
        'txt3' => 'admin.dashboard.index',
],
    'key5' => [
        'title'       => 'Bình luận',
        'fontawesome' => 'fa fa-comments',
    'routeName' => 'admin.dashboard.index',
'uri' => 'admin.dashboard.index',
'txt3' => 'admin.dashboard.index',
],
    'key6' => [
        'title'       => 'Tin tức',
        'fontawesome' => 'fa fa-newspaper-o',
    'routeName' => 'admin.dashboard.index',
'uri' => 'admin.dashboard.index',
'txt3' => 'admin.dashboard.index',
],
    'key7' => [
        'title'       => 'Liên hệ',
        'fontawesome' => 'fa fa-envelope',
    'routeName' => 'admin.dashboard.index',
'uri' => 'admin.dashboard.index',
'txt3' => 'admin.dashboard.index',
],
);
@endphp


<div class="app-sidebar__user">
    <img class="app-sidebar__user-avatar"
        src="https://s3.amazonaws.com/uifaces/faces/twitter/jsa/48.jpg"
        alt="User Image">
    <div>
        <p class="app-sidebar__user-name">John Doe</p>
        <p class="app-sidebar__user-designation">Người Quản Lý</p>
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
