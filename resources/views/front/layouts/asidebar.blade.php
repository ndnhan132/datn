<div id="asidebar" data-type="main">
    <div id="teacher-login-box" class="mb-3">
        @include('front.layouts.asidebar.teacher-login-box')
    </div>

    <div class="panel border-0 d-none"  id="asidebar-support">
        <div class="panel-header bg-primary">
            Hỗ trợ trực tuyến
        </div>
        <div class="panel-body border asidebar-box-body">
            @include('front.layouts.asidebar.loading')
        </div>
    </div>
    <div class="panel d-none d-lg-block" id="asidebar-teacher-by-courselevel">
        <div class="panel-header">
            Phụ huynh
        </div>
        <div class="panel-body asidebar-box-body">
            @include('front.layouts.asidebar.leftbar1')
        </div>
    </div>
    <div class="panel d-none d-lg-block">
        <div class="panel-header">
            Gia sư
        </div>
        <div class="panel-body asidebar-box-body">
            @include('front.layouts.asidebar.leftbar2')
        </div>
    </div>
    <div class="panel d-none d-lg-block">
        <div class="panel-header">
            Chính sách
        </div>
        <div class="panel-body asidebar-box-body">
            @include('front.layouts.asidebar.leftbar3')
        </div>
    </div>
    {{-- <div class="panel">
        <div class="panel-header">
            Fanpage
        </div>
        <div class="panel-body asidebar-box-body">
        </div>
    </div>
    <div class="panel">
        <div class="panel-header">
            bản đồ
        </div>
        <div class="panel-body asidebar-box-body">
        </div>
    </div> --}}
    {{-- <div class="panel" id="asidebar-teacher-by-courselevel">
        <div class="panel-header">
            Gia sư các khối lớp
        </div>
        <div class="panel-body asidebar-box-body">
            @include('front.layouts.asidebar.loading')
        </div>
    </div>
    <div class="panel" id="asidebar-teacher-by-subject">
        <div class="panel-header">
            Gia sư theo bộ môn
        </div>
        <div class="panel-body asidebar-box-body">
            @include('front.layouts.asidebar.loading')
        </div>
    </div>
    <div class="panel" id="asidebar-fanpage">
        <div class="panel-body asidebar-box-body">
            @include('front.layouts.asidebar.loading')
        </div>
    </div> --}}
</div>
