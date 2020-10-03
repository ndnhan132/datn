<div id="list-course">
    <div>
        @include('front.home.header-title', ['title' => 'Danh sách lớp mới', 'icon' => 'fas fa-star-of-life'])
        <table class="table">
            <thead>
                <tr>
                    <th>Mã số</th>
                    <th>Môn học</th>
                    <th>Thời gian</th>
                    <th>Địa chỉ</th>
                    <th>Học phí</th>
                    <th>Yêu cầu</th>
                    <th>Tình trạng</th>
                </tr>
            </thead>
            <tbody>
            @foreach (range(0, 5) as $item)
                <tr>
                    <td>{{ $item + 1 }}</td>
                    <td></td>
                    <td></td>
                    <td></td>
                    <td></td>
                    <td></td>
                    <td></td>
                </tr>
            @endforeach
            </tbody>
        </table>
    </div>
</div>
