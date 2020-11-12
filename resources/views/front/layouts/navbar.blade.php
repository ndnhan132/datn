<div class="container-fluid bg-primary position-relative" id="main-navbar">
    <div class="container">
        <nav class="navbar navbar-expand-lg p-0">
            <a class="navbar-brand" href="#"></a>
            <button class="navbar-toggler" type="button" data-toggle="collapse"
                data-target="#navbarSupportedContent"
                aria-controls="navbarSupportedContent" aria-expanded="false"
                aria-label="Toggle navigation">
                <span class="navbar-toggler-icon"></span>
            </button>

            <div class="collapse navbar-collapse" id="navbarSupportedContent">
                <ul class="navbar-nav mr-auto- w-100 justify-content-between ">
                    <li class="nav-item flex-fill text-center active">
                        <a class="nav-link" href="#">Trang chủ</a>
                    </li>
                    <li class="nav-item flex-fill text-center">
                        <a class="nav-link"
                            href="{{ route('front.getNewClassPage') }}">Lớp
                            mới</a>
                    </li>
                    <li class="nav-item flex-fill text-center">
                        <a class="nav-link" href="#">Phụ huynh</a>
                    </li>
                    <li class="nav-item flex-fill text-center border-left border-right position-relative">
                        <a class="nav-link" href="#"><span>Gia sư</span><i class="fas fa-angle-down pl-2"></i></a>
                        <div class="sub-menu">
                            <ul class="bg-primary">
                                <a href=""><li><i class="fas fa-caret-right"></i><span>List1</span></li></a>
                                <a href=""><li><i class="fas fa-caret-right"></i><span>List1</span></li></a>
                            </ul>
                        </div>
                    </li>
                    <li class="nav-item flex-fill text-center">
                        <a class="nav-link" href="#">Tin tức</a>
                    </li>
                    <li class="nav-item flex-fill text-center">
                        <a class="nav-link" href="#">Liên hệ</a>
                    </li>
                    <li class="nav-item flex-fill text-center">
                        <a class="nav-link"
                            href="{{ route('admin.dashboard.index') }}">Admin</a>
                    </li>
            </div>
        </nav>
    </div>
</div>
