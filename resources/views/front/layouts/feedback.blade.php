<div class="feedback-btn btn-show-feedback">
    <span>Liên hệ</span>
</div>

<div class="feedback-form show">
    <div class="w-100 d-flex justify-content-end">
        <span class="text-white btn-close"><i class="far fa-window-close p-2"></i></span>
    </div>
    <form action="">
        <ul class="list-unstyled p-2 m-0">
            <li>
                <input type="text" name="name" placeholder="Họ tên" value="{{ Auth::guard('teacher')->user()->name ?? '' }}">
            </li>
            <li>
                <input type="text" name="email" placeholder="Email" value="{{ Auth::guard('teacher')->user()->email ?? '' }}">
            </li>
            <li>
                <input type="text" name="phone" placeholder="Điện thoại" value="{{ Auth::guard('teacher')->user()->phone ?? '' }}">
            </li>
            <li>
                <input type="text" name="title" placeholder="Tiêu đề">
            </li>
            <li>
                <textarea type="text" name="content" placeholder="Nội dung" rows="4"></textarea>
            </li>
            <li class="w-100 d-flex justify-content-center">
                <button class="feedback-submit">Gửi</button>
            </li>
        </ul>
    </form>
</div>
