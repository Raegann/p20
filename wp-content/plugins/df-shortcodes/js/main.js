(function ($) {
    "use strict";
    $(document).ready(function () {

        // Tabs
        jQuery(".cs-tab-group").tabs();

        // Accordions
        jQuery(".cs-accordion-group").accordion({
            heightStyle: "content",
            collapsible: true,
            icons: false
        });

        // Lightbox - image
        jQuery(".cs-lightbox-image").magnificPopup({
            type: "image",
            mainClass: "mfp-with-zoom",
            zoom: {
                enabled: true,
                duration: 300,
                easing: "ease-in-out",
            }
        });

        // Lightbox - gallery
        jQuery(".cs-lightbox-gallery").each(function () {
            jQuery(this).magnificPopup({
                delegate: "a",
                type: "image",
                gallery: {
                    enabled: true
                },
                mainClass: "mfp-with-zoom",
                zoom: {
                    enabled: true,
                    duration: 300,
                    easing: "ease-in-out",
                }
            });
        });

        // Lightbox - iframe
        jQuery(".cs-lightbox-iframe").magnificPopup({
            type: "iframe",
            mainClass: "mfp-with-zoom",
            zoom: {
                enabled: true,
                duration: 300,
                easing: "ease-in-out",
            }
        });

    });
})(jQuery);
