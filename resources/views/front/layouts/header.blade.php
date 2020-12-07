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
                    <a class="nav-link" href="{{ route('front.getAllClassPage') }}"><span>Lớp hiện có</span>
                        {{-- <i class="fas fa-angle-down pl-2"></i> --}}
                    </a>
                    {{-- <div class="sub-menu py-1 mt-2 fade-down fade-up-">
                        <a href="{{ route('front.getNotReceivedClassPage') }}"><i class="fas fa-caret-right"></i><span>Lớp chưa giao</span></a>
                        <a href="{{ route('front.getAllClassPage') }}"><i class="fas fa-caret-right"></i><span>Tất cả các lớp</span></a>
                    </div> --}}
                </li>
                <li class="nav-item  position-relative">
                    <a class="nav-link" href="{{ route('front.forParent')}}"><span>Phụ huynh</span><i class="fas fa-angle-down pl-2"></i></a>
                    <div class="sub-menu py-1 mt-2 fade-down fade-up-">
                        <a href="{{ route('front.getCourseRegisterPage') }}"><i class="fas fa-caret-right"></i><span>Đăng ký tìm gia sư</span></a>
                        <a href="{{ route('front.readPage', 'bang-gia-tham-khao') }}"><i class="fas fa-caret-right"></i><span>Bảng giá tham khảo</span></a>
                        <a href="{{ route('front.readPage', 'phu-huynh-can-biet') }}"><i class="fas fa-caret-right"></i><span>Phụ huynh cần biết</span></a>
                        <a href="{{ route('front.getAllTeachersPage') }}"><i class="fas fa-caret-right"></i><span>Danh sách gia sư</span></a>
                    </div>
                </li>
                <li class="nav-item  position-relative">
                    <a class="nav-link" href="{{ route('front.forTeacher')}}"><span>Gia sư</span><i class="fas fa-angle-down pl-2"></i></a>
                    <div class="sub-menu py-1 mt-2 fade-down fade-up-">
                        <a href="{{ route('front.getTeacherRegisterPage') }}"><i class="fas fa-caret-right"></i><span>Đăng ký làm gia sư</span></a>
                        <a href=""><i class="fas fa-caret-right"></i><span>Lớp mới cần gia sư</span></a>
                        <a href=""><i class="fas fa-caret-right"></i><span>Tìm kiếm lớp mới</span></a>
                        <a href="{{ route('front.readPage', 'huong-dan-dang-ky-lam-gia-su') }}"><i class="fas fa-caret-right"></i><span>Hướng dẫn đăng ký làm gia sư</span></a>
                        <a href="{{ route('front.readPage', 'huong-dan-nhan-lop') }}"><i class="fas fa-caret-right"></i><span>Hướng dẫn nhận lớp</span></a>
                        <a href="{{ route('front.readPage', 'hop-dong-gia-su') }}"><i class="fas fa-caret-right"></i><span>Hợp đồng gia sư</span></span></a>
                        <a href="{{ route('front.readPage', 'gia-su-can-biet') }}"><i class="fas fa-caret-right"></i><span>Gia sư cần biết</span></a>
                        <a href="#"><i class="fas fa-caret-right"></i><span><span>Hướng dẫn thanh toán</span></a>
                    </div>
                </li>
                <li class="nav-item"><a class="nav-link" href="{{ route('front.getListNews') }}">Tin tức</a></li>
                <li class="nav-item"><a class="nav-link" href="{{ route('front.readPage', 'gioi-thieu') }}">Giới thiệu</a></li>
                <li class="nav-item"><a class="nav-link" href="{{ route('front.readPage', 'phuong-thuc-lien-he') }}">Liên hệ</a></li>
                @if (Auth::guard('teacher')->check())
                <li class="nav-item"><a class="nav-link" href="{{ route('front.teacherManager.index') }}">Hồ sơ</a></li>
                @endif
            </ul>
        </div>
    </div>
</nav>
