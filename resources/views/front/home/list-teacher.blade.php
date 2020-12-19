<link rel="stylesheet" href="{{ asset_public_env('/css/lightslider.css')}}">
<script src="https://cdnjs.cloudflare.com/ajax/libs/lightslider/1.1.6/js/lightslider.min.js"></script>

<div id="list-teacher" class="mainbox mb-4">
    <div>
        @include('front.home.header-title', ['title' => 'Danh sách gia sư'])
    </div>
    <div id="list-teacher-content">
        <div class="d-flex justify-content-center my-auto py-5">
            <div class="spinner-border my-auto text-primary" role="status">
                <span class="sr-only">Loading...</span>
            </div>
        </div>
    </div>
</div>
<script>
(function () {
    loadListTeacherSlider();

    function loadListTeacherSlider() {
        console.log('loadListTeacherSlider');
        if ($('#list-teacher-content')) {
            $('#list-teacher-content').load("/front/ajax/load-list-teacher-slider", function () {
                // lightSlider();
                // // loadFirstProduct();
            });
        }
    }
}());
</script>
