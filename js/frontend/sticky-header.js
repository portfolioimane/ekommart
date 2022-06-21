(function ($) {
    'use strict';
    $(function () {
        var $header = $('.site-header'),
             $headerelement = $('.elementor-location-header'),
            $header_sticky = $('.header-sticky');
        var headerHeight = $header.height() + $headerelement.height();
        var lastScrollTop = 0;

        $(window).scroll(function (event) {
            if ($(window).scrollTop() <= headerHeight + 50) {
                $header_sticky.removeClass('active');
            }
            var st = $(this).scrollTop();
            if (st > lastScrollTop) {
                $header_sticky.removeClass('active');
            } else {
                if ($(window).scrollTop() > headerHeight) {
                    $header_sticky.addClass('active');
                } else {
                    $header_sticky.removeClass('active');
                }
            }

            lastScrollTop = st;
        });

    });
})(jQuery);
