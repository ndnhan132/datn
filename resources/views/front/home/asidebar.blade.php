<div id="asidebar">
    <div>
        <div class="card">
            <div class="card-header bg-primary">
                Gia su dang nhap
            </div>
            <div id="teacher-login-box" class="w-100">
                @include('front.layouts.teacher-login-box')
            </div>
        </div>
    </div>

    <div class="card">
        <div class="card-header bg-primary">
            Hỗ trợ trực tuyến
        </div>
        <div class="card-body">
            <h4 class="card-title">Title</h4>
            <p class="card-text">Text</p>
            <p class="card-text">
            <a href="{{ route('front.getCourseRegisterPage')}}">dang ky tim gia su</a>
            <hr>
            <a href="{{ route('front.getTeacherRegisterPage')}}">dang ky lam gia su</a>
            </p>
        </div>
    </div>
        <div class="card">
        <div class="card-header bg-primary">
            Gia sư các khối lớp
        </div>
        <div class="card-body">
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
