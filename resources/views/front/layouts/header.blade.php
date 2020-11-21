<nav class="navbar navbar-expand-lg fixed-top" id="mainNav">
    <div class="container nav-container">
        <div class="logo">
            <a class="navbar-brand js-scroll-trigger p-0" href="{{ route('front.home') }}">
                <img src="{{asset('/images/logo/4.png')}}" alt="" />
            </a>
        </div>
        <button class="navbar-toggler navbar-toggler-right" type="button" data-toggle="collapse" data-target="#navbarResponsive" aria-controls="navbarResponsive" aria-expanded="false" aria-label="Toggle navigation">Menu<i class="fas fa-bars ml-1"></i></button>
        <div class="collapse navbar-collapse" id="navbarResponsive">
            <ul class="navbar-nav ml-auto">
                <li class="nav-item">
                    <a class="nav-link" href="{{ route('front.home') }}">Trang chủ</a>
                </li>
                <li class="nav-item  position-relative">
                    <a class="nav-link" href="{{ route('front.getNotReceivedClassPage') }}"><span>Lớp mới</span><i class="fas fa-angle-down pl-2"></i></a>
                    <div class="sub-menu py-1 mt-2 fade-down fade-up-">
                        <a href="{{ route('front.getNotReceivedClassPage') }}"><i class="fas fa-caret-right"></i><span>Lớp chưa giao</span></a>
                        <a href="{{ route('front.getAllClassPage') }}"><i class="fas fa-caret-right"></i><span>Tất cả các lớp</span></a>
                    </div>
                </li>
                <li class="nav-item  position-relative">
                    <a class="nav-link" href="{{ route('front.forTeacher')}}"><span>Phụ huynh</span><i class="fas fa-angle-down pl-2"></i></a>
                    <div class="sub-menu py-1 mt-2 fade-down fade-up-">
                        <a href=""><i class="fas fa-caret-right"></i><span>Đăng ký tìm gia sư</span></a>
                        <a href=""><i class="fas fa-caret-right"></i><span>Bảng giá tham khảo</span></a>
                        <a href=""><i class="fas fa-caret-right"></i><span>Phụ huynh cần biết</span></a>
                    </div>
                </li>
                <li class="nav-item  position-relative">
                    <a class="nav-link" href="{{ route('front.forTeacher')}}"><span>Gia sư</span><i class="fas fa-angle-down pl-2"></i></a>
                    <div class="sub-menu py-1 mt-2 fade-down fade-up-">
                        <a href=""><i class="fas fa-caret-right"></i><span>Lớp mới</span></a>
                        <a href=""><i class="fas fa-caret-right"></i><span>List1</span></a>
                    </div>
                </li>
                <li class="nav-item"><a class="nav-link" href="/help/notices">Tin tức</a></li>
                <li class="nav-item"><a class="nav-link" href="/help/notices">Liên hệ</a></li>
                @if (Auth::guard('teacher')->check())
                <li class="nav-item"><a class="nav-link" href="{{ route('front.teacherManager.index') }}">Hồ sơ</a></li>
                @endif
            </ul>
        </div>
    </div>
</nav>
