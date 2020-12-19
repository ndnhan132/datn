@if (Auth::guard('teacher')->check())
    <div class="teacher-profile">
        <div class="profile-name">
            {{ Auth::guard('teacher')->user()->name }}
        </div>
        <div class="w-100">
            <div class="profile-body">
                <div class="d-flex flex-row">
                    <div class="px-0 col-auto" style="width: 65px; height: 97px;">
                        <img src="{{ asset(Auth::guard('teacher')->user()->getAvatarSrc()) }}" alt="Ảnh đại diện gia sư" class="img-fluid rounded-circle">
                    </div>
                    <div class="pl-3 flex-shrink-1-" style="width: calc(100% - 65px)">
                        <ul class="w-100 d-flex flex-column list-unstyled mb-0">
                            <li  class="w-100 text-truncate">
                                <img src="{{ asset_public_env('images/icon/email16x.png') }}" alt="...">
                                <span>{{ ucfirst(Auth::guard('teacher')->user()->email) }}</span>
                            </li>
                            <li>
                                <img src="{{ asset_public_env('images/icon/info16x.png') }}" alt="...">
                                <span>{{ ucfirst(Auth::guard('teacher')->user()->getGenderAndLevel()) }}</span>
                            </li>
                            <li>
                                <img src="{{ asset_public_env('images/icon/icon_owner13x.gif') }}" alt="...">
                                <a href="{{ route('front.teacherManager.index') }}" class="btn-teacher-profile"><u>Hồ sơ</u></a>
                            </li>
                            <li>
                                <img src="{{ asset_public_env('images/icon/logout16x.png') }}" alt="...">
                                <a href="#" class="btn-teacher-logout"><u>Đăng xuất</u></a>
                            </li>
                        </ul>
                    </div>
                </div>
                @isset( Auth::guard('teacher')->user()->description )
                    <div class="profile-description" style="">
                        <p class="mb-0">{{ ucfirst(Auth::guard('teacher')->user()->description) }}</p>
                    </div>
                @endisset
            </div>
        </div>
    </div>
@else
    <div class="panel mb-0 pl-0 text_georgia">
        <div class="panel-header bg-primary btn-teacher-show-login pl-2 text-white">
            <span>Gia sư đăng nhập</span>
        </div>
        <div class="w-100 form-box"  style="display: none">
            <div class="panel-body p-2">
                <form action="" id="teacher-login-form" style="display: none-">
                    <ul class="m-0 list-unstyled">
                        <li>Địa chỉ Email：</li>
                        <li><input name="email" type="text" id="email" value="giasu@gmail.com"></li>
                        <li>Mật khẩu：</li>
                        <li><input name="password" type="password" id="password" value="111111"></li>
                        <li class="text-center">
                            <div class="position-relative col-6 px-0 ml-auto">
                                <img src="{{ asset_public_env('/images/icon/lock24.png') }}" alt="lock" class="btn-login-icon">
                                <span class="btn-teacher-login my-2 btn-login">Đăng nhập</span>
                            </div>
                        </li>
                        <li class="text-left">
                            <div class="form-check">
                                <a >
                                    <label class="form-check-label ml-1" for="remember">
                                        <input type="checkbox" class="form-check-input pb-1" name="remember" id="remember">
                                        Giữ trạng thái đăng nhập
                                        </label>
                                </a>
                            </div>
                        </li>
                        <li>
                            <img src="{{ asset_public_env('/images/icon/help_icon.gif') }}" alt="help">
                            <a href="#">Quên mật khẩu</a>
                        </li>
                        <li>
                            <img src="{{ asset_public_env('/images/icon/help_icon.gif') }}" alt="help">
                            <a href="#">Không đăng nhập được</a>
                        </li>
                    </ul>
                </form>
            </div>
        </div>
    </div>
@endif
