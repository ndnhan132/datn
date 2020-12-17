<div id="xxddddasdasd" class="mainbox mb-4">
    <div>
        @include('front.home.header-title', ['title' => 'Học phí tham khảo'])
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
            $('#reference-tuition-content').load("/front/ajax/load-reference-tuition", function () {
                // lightSlider();
                // // loadFirstProduct();
            });
        }
    }
}());
</script>
