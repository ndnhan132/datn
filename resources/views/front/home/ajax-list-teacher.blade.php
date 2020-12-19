<div >
    <div class="" id="carousel-slides" style="display: none-">
        @php
            $count = count($teachers);
        @endphp
        @for ($i = 0; $i < $count; $i)
        @php
            $item = $teachers->shift();
            $i++;
        @endphp
        @isset($item)
        <div class="align-self-end">
            <div class="w-100">
                <div class="position-relative">
                    <div class="border image">
                            <a href="">
                            <img src="{{ asset_public_env($item->getAvatarSrc()) }}" alt="image" class="w-100 img-fluid">
                        </a>
                    </div>
                    <div class="position-absolute text-center">
                        <h6 class="text-capitalize text-truncate">{{ strtolower($item->name) }}</h6>
                        <p class="text-capitalize">{{ strtolower($item->teacherLevel->display_name) }}</p>
                    </div>
                </div>
            </div>
        @endisset
            @php
                $item = $teachers->shift();
                $i++;
            @endphp
            @isset($item)
            <div class="w-100 mt-2">
                <div class="position-relative">
                    <div class="border image">
                            <a href="">
                            <img src="{{ asset_public_env($item->getAvatarSrc()) }}" alt="image" class="w-100 img-fluid">
                        </a>
                    </div>
                    <div class="position-absolute text-center">
                        <h6 class="text-capitalize text-truncate">{{ strtolower($item->name) }}</h6>
                        <p class="text-capitalize">{{ strtolower($item->teacherLevel->display_name) }}</p>
                    </div>
                </div>
            </div>
            @endisset
        </div>
        @endfor
    </div>
</div>
<div class="w-100 d-flex mt-3">
    <a href="{{ route('front.getAllClassPage') }}" class="btn btn-sm btn-primary rounded-pill text-uppercase px-4 ml-auto">Xem thêm</a>
</div>

<script>
    (function () {
    // loadBestSell();

    // function loadBestSell() {
    //     if ($('#mainCarousel')) {
    //         $('#mainCarousel').load("/ajax/index/best-sell", function () {
    //             lightSlider();
    //             // loadFirstProduct();
    //         });
    //     }
    // }
    // function productDisplayEffect(self, index) {
    //     setTimeout(function () {
    //         // $(self).show();
    //         // $(self).css('opacity', '1');
    //         // $(self).fadeIn();
    //         $(self).slideDown('fast');
    //         // $(self).slideDown('slow');
    //     }, index * 50);
    // }
    lightSlider();
    function lightSlider() {
        /* #region   */
        if ($('#carousel-slides').length) {
            $("#carousel-slides").lightSlider({
                item: 6,
                autoWidth: false,
                slideMove: 1, // slidemove will be 1 if loop is true
                // slideMargin: 10,

                addClass: '',
                mode: "slide",
                useCSS: true,
                cssEasing: 'ease', //'cubic-bezier(0.25, 0, 0.25, 1)',//
                easing: 'linear', //'for jquery animation',////

                speed: 2000, //ms'
                auto: true,
                loop: true,
                slideEndAnimation: true,
                pause: 3000,

                // keyPress: true,
                // controls: true,
                // prevHtml: '<img src="/images/previous-icon.png">',
                // nextHtml: '<img src="/images/next-icon.png">',

                rtl: false,
                adaptiveHeight: false,

                vertical: false,
                verticalHeight: 500,
                vThumbWidth: 100,

                thumbItem: 10,
                pager: false,
                gallery: true,
                galleryMargin: 5,
                thumbMargin: 5,
                currentPagerPosition: 'middle',

                enableTouch: true,
                enableDrag: true,
                freeMove: true,
                swipeThreshold: 40,

                responsive: [
                    {
                        breakpoint: 1600,
                        settings: {
                            item: 5,
                            slideMargin: 8,
                        }
                    },{
                        breakpoint: 1200,
                        settings: {
                            item: 4,
                            slideMargin: 6,
                        }
                    },
                    {
                        breakpoint: 992,
                        settings: {
                            item: 4,
                        }
                    },
                    {
                        breakpoint: 768,
                        settings: {
                            item: 3,
                        }
                    },
                    {
                        breakpoint: 576,
                        settings: {
                            item: 3,
                        }
                    },
                    {
                        breakpoint: 400,
                        settings: {
                            item: 2,
                        }
                    },
                    {
                        breakpoint: 250,
                        settings: {
                            item: 1,
                        }
                    }
                ],

                onBeforeStart: function (el) { },
                onSliderLoad: function (el) {
                    $('#carousel-slides').show();
                    $('#carousel-slides').slideDown();
                    $('#carousel-slides').css("height", "auto");
                    // $('#mainCarousel').slideDown();
                },
                onBeforeSlide: function (el) { },
                onAfterSlide: function (el) { },
                onBeforeNextSlide: function (el) { },
                onBeforePrevSlide: function (el) { }

            });
        }
        /* #endregion */
    }

}());
</script>
