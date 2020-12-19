<!DOCTYPE html>
<html  dir="ltr" lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>@yield('title')</title>
    {{-- <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css" integrity="sha384-JcKb8q3iqJ61gNV9KGb8thSsNjpSL0n8PARn9HuZOnIxN0hoP+VmmDGMN5t9UJ0Z" crossorigin="anonymous"> --}}
    <link rel="stylesheet" type="text/css" href="{{ asset_public_env('/web-admin/template/css/main.css')}}">
    <link rel="stylesheet" type="text/css" href="https://maxcdn.bootstrapcdn.com/font-awesome/4.7.0/css/font-awesome.min.css">
    <link href="{{ asset_public_env('/web-admin/css/stylesheet.css')  . '?' . time() }}" rel="stylesheet">
    <script src="https://code.jquery.com/jquery-3.5.1.min.js"
    integrity="sha256-9/aliU8dGd2tb6OSsuzixeV4y/faTqgFtohetphbbj0=" crossorigin="anonymous"></script>
    @yield('head')
</head>
<body class="app sidebar-mini">
    <section class="material-half-bg">
        <div class="cover"></div>
    </section>
    <section class="login-content">
        <div class="logo">
            <h1>Gia sư Đà Nẵng</h1>
        </div>
        <div class="login-box">
            <form class="login-form" action="{{ route('admin.postLogin') }}" method="POST">
                @csrf
                <h3 class="login-head"><i class="fa fa-lg fa-fw fa-user"></i>Đăng nhập</h3>
                <div class="form-group">
                    <label class="control-label">Email</label>
                    <input class="form-control" type="text" name="email" placeholder="Email" autofocus value="admin@giasudanang.com">
                </div>
                <div class="form-group">
                    <label class="control-label">Mật khẩu</label>
                    <input class="form-control" type="password" name="password" placeholder="Mật khẩu" value="111111">
                </div>
                <div class="form-group">
                    <div class="utility">
                        <div class="animated-checkbox">
                            <label>
                                <input type="checkbox" name="remember"><span class="label-text">Ghi nhớ đăng nhập</span>
                                <p>
                            </label>
                        </div>
                        <p class="semibold-text mb-2"><a href="#" data-toggle="flip">Quên mật khẩu ?</a></p>
                    </div>
                </div>
                <div class="form-group btn-container">
                    <button class="btn btn-primary btn-block" type="submit"><i class="fa fa-sign-in fa-lg fa-fw"></i>Đăng nhập</button>
                </div>
            </form>


            <form class="forget-form" method="POST">
                <h3 class="login-head"><i class="fa fa-lg fa-fw fa-lock"></i>Quên mật khẩu ?</h3>
                <div class="form-group">
                    <label class="control-label">EMAIL</label>
                    <input class="form-control" type="email" name="email" placeholder="Email">
                </div>
                <div class="form-group btn-container">
                    <button class="btn btn-primary btn-block" type="submit"><i class="fa fa-unlock fa-lg fa-fw"></i>RESET</button>
                </div>
                <div class="form-group mt-3">
                    <p class="semibold-text mb-0"><a href="#" data-toggle="flip"><i class="fa fa-angle-left fa-fw"></i>
                            Đăng nhập</a></p>
                </div>
            </form>
        </div>
    </section>

    <div class="modal fade" id="js-modal-errors" tabindex="-1" role="dialog">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="exampleModalLabel">Errors</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body">
                    <div class="">
                            <div class="" id="print-error-msg" style="display: none">
                            </div>
                    </div>
                </div>
                <div class="modal-footer">
                    <button class="btn btn-secondary"  data-dismiss="modal">
                        <i class="fa fa-fw fa-lg fa-times-circle"></i>Cancel
                    </button>
                </div>
            </div>
        </div>
    </div>
<div class="modal fade modal-custom" id="js-modal-detail" tabindex="-1"
	role="dialog">
	<div class="modal-dialog" role="document">
		<div class="modal-content rounded-0">
			<div class="modal-header py-2 border-bottom-0 bg-primary rounded-0">
				<h5 class="modal-title text-white" id="exampleModalLabel"><i class="fa fa-info-circle"></i> Chi tiết</h5>
				<button type="button" class="close" data-dismiss="modal"
					aria-label="Close">
					<span aria-hidden="true">&times;</span>
				</button>
			</div>
			<div class="modal-body py-0 my-3">

			</div>
		</div>
	</div>
</div>
<script src="https://cdn.jsdelivr.net/npm/popper.js@1.16.1/dist/umd/popper.min.js" integrity="sha384-9/reFTGAW83EW2RDu2S0VKaIzap3H66lZH81PoYlFhbGU+6BZp6G7niu735Sk7lN" crossorigin="anonymous"></script>
<script src="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js" integrity="sha384-B4gt1jrGC7Jh4AgTPSdUtOBvfO8shuf57BaghqFfPlYxofvL8/KUEfYiJOMMV+rV" crossorigin="anonymous"></script>
<script src="{{asset_public_env('/web-admin/template/js/main.js')}}"></script>
<!-- The javascript plugin to display page loading on top-->
<script src="{{asset_public_env('/web-admin/template/js/plugins/pace.min.js')}}"></script>
{{-- <script src="{{asset_public_env('/web-admin/template/js/plugins/sweetalert.min.js')}}"></script> --}}
{{-- <script type="text/javascript" src="{{asset_public_env('/web-admin/template/js/plugins/bootstrap-notify.min.js')}}"></script> --}}
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@10"></script>
<script src="{{asset_public_env('/js/admin.js') . '?' . time() }}" type="text/javascript"></script>
{{-- <script src="https://kit.fontawesome.com/71560e0a69.js" crossorigin="anonymous"></script> --}}
@yield('javascript')
</body>
</html>
