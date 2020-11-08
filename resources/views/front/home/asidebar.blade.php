<div id="asidebar">
    <div  id="teacher-login-box" class="mb-3">
        @include('front.layouts.teacher-login-box')
    </div>

    <div class="card border-0">
        <div class="card-header bg-primary">
            Hỗ trợ trực tuyến
        </div>
        <div class="card-body border">
            <div class="">
                <img src="{{ asset('images/support.png')}}" alt="support" class="w-100 px-3">
            </div>
        </div>
    </div>
        <div class="card">
        <div class="card-header bg-primary">
            Gia sư các khối lớp
        </div>
        <div class="card-body">
            <p class="card-text">
                <a href="{{ route('front.getCourseRegisterPage')}}">dang ky tim gia su</a>
                <hr>
                <a href="{{ route('front.getTeacherRegisterPage')}}">dang ky lam gia su</a>
                </p>
            <ul class="list-unstyled asidebar-list">
            @isset($courseLevels)
            @foreach ($courseLevels as $level)
            <li class="asidebar-item">
                <a href="" class="asidebar-link">
                    {{ 'tìm gia sư dạy ' . $level->display_name }}
                </a>
            </li>
            @endforeach
            @endisset
            </ul>
        </div>
    </div>
    <div class="card">
        <div class="card-header bg-primary">
            Gia sư theo bộ môn
        </div>
        <div class="card-body">
            <ul class="list-unstyled asidebar-list">
                @isset($subject)

                @foreach ($subjects as $subject)
                <li class="asidebar-item">
                    <a href="" class="asidebar-link">
                        {{ 'tìm gia sư dạy ' . $subject->display_name }}
                    </a>
                </li>
                @endforeach
                @endisset
            </ul>
        </div>
    </div>
</div>
