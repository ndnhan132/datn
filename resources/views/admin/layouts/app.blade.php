<!DOCTYPE html>
<html  dir="ltr" lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>@yield('title')</title>
    {{-- <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css" integrity="sha384-JcKb8q3iqJ61gNV9KGb8thSsNjpSL0n8PARn9HuZOnIxN0hoP+VmmDGMN5t9UJ0Z" crossorigin="anonymous"> --}}
    <link rel="stylesheet" type="text/css" href="{{ asset('/web-admin/template/css/main.css')}}">
    <link rel="stylesheet" type="text/css" href="https://maxcdn.bootstrapcdn.com/font-awesome/4.7.0/css/font-awesome.min.css">
    <link href="{{ asset('/web-admin/css/stylesheet.css')  . '?' . time() }}" rel="stylesheet">
    <script src="https://code.jquery.com/jquery-3.5.1.min.js"
    integrity="sha256-9/aliU8dGd2tb6OSsuzixeV4y/faTqgFtohetphbbj0=" crossorigin="anonymous"></script>
    @yield('head')
</head>
<body class="app sidebar-mini">

<header class="app-header bg-primary">
    @include('admin.layouts.navbar')
</header>

<div class="app-sidebar__overlay" data-toggle="sidebar"></div>
<aside class="app-sidebar">
    @include('admin.layouts.asidebar')
</aside>

<main class="app-content">
    @yield('content')
</main>
<script src="https://cdn.jsdelivr.net/npm/popper.js@1.16.1/dist/umd/popper.min.js" integrity="sha384-9/reFTGAW83EW2RDu2S0VKaIzap3H66lZH81PoYlFhbGU+6BZp6G7niu735Sk7lN" crossorigin="anonymous"></script>
<script src="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js" integrity="sha384-B4gt1jrGC7Jh4AgTPSdUtOBvfO8shuf57BaghqFfPlYxofvL8/KUEfYiJOMMV+rV" crossorigin="anonymous"></script>
<script src="{{asset('/web-admin/template/js/main.js')}}"></script>
<!-- The javascript plugin to display page loading on top-->
<script src="{{asset('/web-admin/template/js/plugins/pace.min.js')}}"></script>
<script src="{{asset('/web-admin/template/js/plugins/sweetalert.min.js')}}"></script>
<script type="text/javascript" src="{{asset('/web-admin/template/js/plugins/bootstrap-notify.min.js')}}"></script>
<script src="{{asset('/web-admin/js/script.js') . '?' . time() }}" type="text/javascript"></script>
{{-- <script src="https://kit.fontawesome.com/71560e0a69.js" crossorigin="anonymous"></script> --}}
@yield('javascript')
</body>
</html>
