<ul class="list-unstyled asidebar-list">
    @isset($subjects)
    @foreach ($subjects as $subject)
    <li class="asidebar-item">
        <a href="" class="asidebar-link">
            {{ 'tìm gia sư dạy ' . $subject->display_name }}
        </a>
    </li>
    @endforeach
    @endisset
</ul>
