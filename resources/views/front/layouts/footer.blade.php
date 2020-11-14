<footer class="container-fluid">
    <div class="container text-white py-5 information">
        <div class="row">
            <div class="col-md-2 col-12">
                <div class="align-top m-0 h-100">
<div>
<img src="{{ asset('/images/logo/5.png')}}" alt="footer icon" class="img-fluid">
</div>
                </div>
            </div>

            <div class="col-md-3 col-12">
                <div class="align-top m-0 h-100">
                    <h5 class="text-uppercase">Trung tâm gia sư đà nẵng</h5>
                    <ul class="list-unstyled">
                        <li>
                            <a href=""><i class="fas fa-phone-volume"></i>&nbsp;&nbsp;Điện thoại: +84368054220</a>
                        </li>
                        <li>
                            <a href=""><i class="fas fa-at"></i>&nbsp;&nbsp;Email: ndnhan132@gmail.com</a>
                        </li>
                        <li>
                            @php
                                if(isset($_SERVER['HTTPS']) && $_SERVER['HTTPS'] === 'on'){
                                    $domain = "https";
                                }
                                else{
                                    $domain = "http";
                                }
                                $domain .= "://www." . $_SERVER['HTTP_HOST'];
                            @endphp
                            <a href=""><i class="fas fa-globe"></i>&nbsp;&nbsp;Website:&nbsp;{{ $domain }}</a>
                        </li>
                        <li>
                            <a><i class="fa fa-map-marker"
                                    aria-hidden="true"></i>&nbsp;&nbsp;K856 Đường Tôn Đức Thắng, Quân Liên Chiểu, Tp Đà Nẵng</a>
                        </li>
                    </ul>
                </div>
            </div>

            <div class="col-md-3 col-12">
                <div class="align-top m-0 h-100">
                    <h5 class="text-warning">HỖ TRỢ</h5>
                    <ul class="list-unstyled">
                        <li>
                            <a href=""><i class="far fa-comment-dots"></i>&nbsp;&nbsp;Liên hệ</a>
                        </li>
                        <li>
                            <a href="mailto:"><i class="fas fa-envelope"></i>&nbsp;&nbsp;Support@giasudanang.com</a>
                        </li>
						<li>
                           <i class="fab fa-skype"></i><a>&nbsp;&nbsp;Skype:Gia Sư Đà Nẵng</a>
                        </li>
						<li>
                            <a><i class="fas fa-headset"></i>&nbsp;&nbsp;+8415175357</a>
                        </li>
                        <li>
                            <a href="https://t.me/shopkeys"><i class="fab fa-telegram-plane"></i>&nbsp;&nbsp;Telegram</a>
                        </li>
                    </ul>
                </div>
            </div>
            <div class="col-md-4 col-12">
                <div class="align-top m-0 h-100">
                    <h5 class="text-warning">BẢN ĐỒ</h5>
                    <div class="bg-white" style="height: 200px;">
                    </div>
                </div>
            </div>
        </div>
    </div>
    <div class="row social border-top border-dark">
        <div class="col-auto ml-auto">
            <a href="#">
                <i class="fab fa-invision"></i>
            </a>
            <a href="#">
                <i class="fab fa-facebook-square"></i>
            </a>
            <a href="#">
                <i class="fab fa-twitter"></i>
            </a>
            <a href="#">
                <i class="fab fa-google-plus-g"></i>
            </a>
            <a href="#">
                <i class="fab fa-youtube"></i>
            </a>
        </div>
    </div>
</footer>
