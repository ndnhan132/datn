{{-- <div class="card">
    <div class="card-header bg-primary">
        Gia su dang nhap
    </div> --}}
    @if (Auth::guard('teacher')->check())
    <div class="card-body">
        <img src="{{ asset(Auth::guard('teacher')->user()->getAvatarSrc()) }}" alt="Ảnh đại diện gia sư">
        {{-- <h4 class="card-title">Title</h4>
        <p class="card-text">Text</p> --}}
        <a href="#" class="btn-teacher-logout btn btn-block btn-outline-secondary">Đăng xuất</a>
    </div>
    @else
    <div class="card-body">
        {{-- <h4 class="card-title">Title</h4>
        <p class="card-text">Text</p> --}}
        {{-- <a href="#" class="btn-teacher-login btn btn-block btn-outline-info">Đăng nhập</a> --}}
        <form action="" id="teacher-login-form" style="display: none-">
            <input type="text" name="email" placeholder="E-Mail" value="testteacher@gmail.com">
            <input type="password" name="password" placeholder="Mật khẩu" value="111111">
            <a href="#" class="btn-teacher-login btn btn-block btn-outline-info">Đăng nhập</a>
        </form>
    </div>
    @endif
{{-- </div> --}}
