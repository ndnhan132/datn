<div id="asidebar">
    <div class="card">
        <div class="card-header bg-primary">
            Hỗ trợ trực tuyến
        </div>
        <div class="card-body">
            <h4 class="card-title">Title</h4>
            <p class="card-text">Text</p>
        </div>
    </div>
        <div class="card">
        <div class="card-header bg-primary">
            Gia sư các khối lớp
        </div>
        <div class="card-body">
                        <ul class="list-unstyled asidebar-list">
            @foreach ($courseLevels as $level)
            <li class="asidebar-item">
            <a href="" class="asidebar-link">
                {{ 'tìm gia sư dạy ' . $level->display_name }}
            </a>
            </li>
            @endforeach
            </ul>
        </div>
    </div>
    <div class="card">
        <div class="card-header bg-primary">
            Gia sư theo bộ môn
        </div>
        <div class="card-body">
            <ul class="list-unstyled asidebar-list">
            @foreach ($subjects as $subject)
            <li class="asidebar-item">
            <a href="" class="asidebar-link">
                {{ 'tìm gia sư dạy ' . $subject->display_name }}
            </a>
            </li>
            @endforeach
            </ul>
        </div>
    </div>
</div>
