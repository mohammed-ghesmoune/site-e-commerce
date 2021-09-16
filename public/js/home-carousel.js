(function ($) {
    $(document).ready(function () {
        $('.home-carousel').slick({
            slidesToShow: 1,
            slidesToScroll: 1,
            autoplay: true,
            autoplaySpeed: 6000,
            arrows: false,
            dots: false,
            pauseOnHover: true,

        });
    });
})(jQuery);