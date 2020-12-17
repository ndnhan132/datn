@extends('front.layouts.app')
@section('title', 'Học phí tham khảo')
@section('head')
@endsection
@section('content')
<div class="mainbox mt-0">
    <div class="w-100">
        <div class="col-12">
            <div class="breadcrumbs">
                <span><h3 class="mb-0">Học phí tham khảo</h3></span>
            </div>
        </div>
    </div>
    <div class="col-12">
        <ul>
            <li>
                <p>Trung Tâm Gia Sư Đà Nẵng đưa ra Bảng Học Phí theo từng buổi dạy của gia sư cho quý phụ huynh và các bạn gia sư tham khảo.</p>
            </li>
            <li>
                <p>Một buổi dạy là 2 tiết = 1h30.</p>
            </li>
            <li>
                <p>Mức học phí áp dụng với 1 học sinh, nếu học nhóm hay có yêu cầu khác vui lòng liên hệ trung tâm.</p>
            </li>
            <li>
                <p>Học phí được tính từ buổi đầu tiên giữa sự đồng ý của phụ huynh và giáo viên, học sinh.</p>
            </li>
            <li>
                <p>Học phí được tính theo đơn vị VND.</p>
            </li>
            <li>
                <p>Học phí hiện tại được áp dụng với thời gian dạy là 3 buổi 1 tuần, học phí đối với các mức thời gian khác sẽ được cập nhật sau.</p>
            </li>
        </ul>
    </div>
</div>
<div id="xxddddasdasd" class="mainbox mb-4">
    <div>
        @include('front.home.header-title', ['title' => 'Bảng giá'])
    </div>
    <div id="reference-tuition-content">
        <div class="d-flex justify-content-center my-auto py-5">
            <div class="spinner-border my-auto text-primary" role="status">
                <span class="sr-only">Loading...</span>
            </div>
        </div>
    </div>
</div>
<script>
(function () {
    ajaxLoadReferenceTuition();

    function ajaxLoadReferenceTuition() {
        console.log('loadListTeacherSlider');
        if ($('#reference-tuition-content')) {
            $('#reference-tuition-content').load("/front/ajax/load-reference-tuition-without-readmore", function () {
                // lightSlider();
                // // loadFirstProduct();
            });
        }
    }
}());
</script>

@endsection
