(function($) {
	"use strict";



	jQuery(".widget_timeline_posts .item").on({
	    mouseenter: function() {
	   	 	var pin = $( this ).find('.inside');
	   	 	pin.css("background-color", pin.data("hover"));
	    },
	    mouseleave: function() {
	   	 	var pin = $( this ).find('.inside');
	   	 	pin.css("background-color", 'transparent' );
	    }
	});



})(jQuery);