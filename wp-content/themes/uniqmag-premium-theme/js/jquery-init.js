(function ($) {
    "use strict";
    $(document).ready(function () {

        // Thumbnail slider
        var galleryTop = new Swiper('.cs-gallery-top', {
            nextButton: '.swiper-button-next',
            prevButton: '.swiper-button-prev',
            spaceBetween: 15,
            autoHeight: true
        });
        var galleryThumbs = new Swiper('.cs-gallery-thumbs', {
            spaceBetween: 10,
            centeredSlides: true,
            slidesPerView: 'auto',
            slideToClickedSlide: true
        });
        galleryTop.params.control = galleryThumbs;
        galleryThumbs.params.control = galleryTop;

        // Breaking news slider
        var mySwiper = new Swiper ("#cs-breaking-news .swiper-container", {
            autoplayDisableOnInteraction: false,
            grabCursor: true,
            autoplay: 3000,
            loop: true
        });

        // Post overlay slider
        var mySwiper = new Swiper (".cs-post-block-overlay.swiper-container", {
            slidesPerView: 3,
            setWrapperSize: true,
            nextButton: '.cpbo-swiper-button-next',
            prevButton: '.cpbo-swiper-button-prev',
            breakpoints: {
                768: {
                    slidesPerView: 1,
                    spaceBetween: 0
                }
            }
        });

        // Post carousel slider
        var mySwiper = new Swiper (".cs-post-carousel-layout .swiper-container", {
            slidesPerView: 3,
            setWrapperSize: true,
            nextButton: '.cpcl-swiper-button-next',
            prevButton: '.cpcl-swiper-button-prev',
            spaceBetween: 2,
            breakpoints: {
                768: {
                    slidesPerView: 1,
                    spaceBetween: 15
                }
            }
        });

        // Post slider
        var mySwiper = new Swiper (".cs-post-slider-layout.swiper-container", {
            autoplayDisableOnInteraction: false,
            grabCursor: true,
            autoplay: 3000,
            loop: true,
            nextButton: '.cpsl-swiper-button-prev',
            prevButton: '.cpsl-swiper-button-next'
        });

        // Widget gallery slider
        var mySwiper = new Swiper (".cs-widget_gallery_post .swiper-container", {
            autoplayDisableOnInteraction: false,
            grabCursor: true,
            nextButton: '.wgp-swiper-button-prev',
            prevButton: '.wgp-swiper-button-next'
        });

        // Get height body
        var heightBody = $("body").height();
        $("#cs-main-navigation").css("max-height", heightBody -43);

    	// Top mobile navigation
        jQuery(".cs-toggle-top-navigation").on("click", function () {
        	jQuery("#cs-top-navigation").toggle();
        });

        // Sticky main menu
        jQuery(window).scroll(function () {
            var mainmenu = jQuery("#cs-header-menu.cs-header-menu-is-sticky");
            if (parseInt(mainmenu.attr("rel"),10) <= Math.abs(parseInt(jQuery(window).scrollTop()),10)) {
                mainmenu.addClass("fixed");
            } else {
                mainmenu.removeClass("fixed");
            }
        });

        if ( jQuery("#cs-header-menu.cs-header-menu-is-sticky").length ) {
            jQuery("#cs-header-menu.cs-header-menu-is-sticky").wrap("<div class='cs-header-menu-parent'></div>").attr("rel", jQuery("#cs-header-menu.cs-header-menu-is-sticky").offset().top).parent().height($("#cs-header-menu.cs-header-menu-is-sticky").height());
        }

        // Main mobile navigation
        jQuery(".cs-toggle-main-navigation").on("click", function () {
            jQuery("#cs-main-navigation").toggle();
        });

        // Footer mobile navigation
        jQuery(".cs-toggle-footer-navigation").on("click", function () {
            jQuery("#cs-footer-navigation").toggle();
        });

        // Sticky social
        jQuery(".cs-single-post-share").theiaStickySidebar({
            additionalMarginTop: 25
        });

        // Header menu search form
        jQuery("#cs-header-menu-search-button-show").on("click", function () {
            jQuery("#cs-header-menu-search-form").show();
        });
        jQuery("#cs-header-menu-search-button-hide").on("click", function () {
            jQuery("#cs-header-menu-search-form").hide();
        });

        // Viewportchecker
        jQuery(".cs-post-item, .cs-single-post-media").addClass("hidden").viewportChecker({
            classToAdd: "visible cs-animate-element",
            offset: 100
        });

	    // Fitvids
	    jQuery("body").fitVids();

    });
})(jQuery);
