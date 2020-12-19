<div class="aside">
    <div class="body">
        <a href="{{ route('front.teacherManager.index') }}" class="text-primary {{ Request::is('ho-so/thong-tin.html') ? 'active' : ''}}">
            <i class="text-primary fas fa-id-badge"></i>Tất cả thông tin</a>
        <a href="{{ route('front.teacherManager.registrationCourse') }}" class="{{ Request::is('ho-so/lop-dang-ky.html') ? 'active' : ''}}" style="color:purple">
            <i class="fas fa-id-badge"  style="color:purple"></i>Danh sách lớp</a>
        <a href="{{ route('front.teacherManager.getManager', 'chung') }}" class="text-info {{ Request::is('ho-so/cai-dat-chung.html') ? 'active' : ''}}">
            <i class="text-info fas fa-info-circle"></i>Thông tin chung</a>
        <a href="{{ route('front.teacherManager.getManager', 'hoc-van') }}" class="text-success {{ Request::is('ho-so/cai-dat-hoc-van.html') ? 'active' : ''}}">
            <i class="text-success fas fa-graduation-cap"></i>Học vấn</a>
        <a href="{{ route('front.teacherManager.getManager', 'hinh-anh-dai-dien') }}" class="text-warning {{ Request::is('ho-so/cai-dat-hinh-anh-dai-dien.html') ? 'active' : ''}}">
            <i class="text-warning fas fa-image"></i>Hình ảnh đại diện</a>
        <a href="{{ route('front.teacherManager.getManager', 'hinh-anh-xac-minh') }}" class="{{ Request::is('ho-so/cai-dat-hinh-anh-xac-minh.html') ? 'active' : ''}}">
            <i class="far fa-images"></i>Hình ảnh xác minh</a>
        <a href="{{ route('front.teacherManager.getManager', 'mat-khau') }}" class="text-danger {{ Request::is('ho-so/cai-dat-mat-khau.html') ? 'active' : ''}}">
            <i class="text-danger fas fa-key"></i>Mật khẩu</a>
            <a href="{{ route('front.teacherLogout') }}" class="text-muted">
                <i class="text-muted fas fa-sign-out-alt"></i>Đăng xuất
            </a>

    </div>
</div>
