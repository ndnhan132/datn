<a class="app-header__logo bg-primary" href="{{ route('front.home') }}"
    target="_blank">Gia sư Đà Nẵng</a>
<!-- Sidebar toggle button-->
<a class="app-sidebar__toggle" href="#" data-toggle="sidebar"
    aria-label="Hide Sidebar">
</a>
<!-- Navbar Right Menu-->
<ul class="app-nav">
    <!--Notification Menu-->
    <li class="dropdown">
        <a class="app-nav__item" href="#" data-toggle="dropdown"
            aria-label="Show notifications">
            <i class="fa fa-bell-o fa-lg">
            </i>
        </a>
    </li>
    <!-- User Menu-->
    <li class="dropdown">
        <a class="app-nav__item" href="#" data-toggle="dropdown"
            aria-label="Open Profile Menu">
            <i class="fa fa-user fa-lg">
            </i>
        </a>
        <ul class="dropdown-menu settings-menu dropdown-menu-right">
            <li>
                <a class="dropdown-item" href="{{ route('admin.logout') }}">
                    <i class="fa fa-sign-out fa-lg">
                    </i> Logout</a>
            </li>
        </ul>
    </li>
</ul>
