@if ($success)
<div class="row">
    <div class="w-100 d-flex flex-wrap text-center py-5">
        <h3 class="col-12 text-primary mb-4">Đăng ký thành công</h3>
        <p class="col-4 offset-4">Vui lòng kiểm tra email của bạn để nhận liên kết kích hoạt tài khoản.</p>
        <span class="col-12 text-center"><a href="{{ route('front.home') }}">Trang chủ</a></span>
    </div>
</div>
@else
<div class="row">
    <div class="w-100 d-flex flex-wrap text-center py-5">
        <h3 class="col-12 text-primary mb-4">Đăng ký Thất bại</h3>
        <p class="col-4 offset-4">Có lỗi xảy ra trong quá trình đăng ký vui lòng <button class="btn btn-sm btn-outline-info">thử lại</button>.</p>
    </div>
</div>
@endif