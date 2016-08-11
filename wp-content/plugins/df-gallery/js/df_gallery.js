
"use strict";




/* -------------------------------------------------------------------------*
 * 									GALLERY	
 * -------------------------------------------------------------------------*/

	var DF_gallery = {

		//the main image location
		main_image :  function (element) {
			if(element) {
				return element.closest('.df-slide-item').find(".df-gallery-image"); 
			} else {
				return jQuery(".df-gallery-image"); 
			}
		 
		 },

		//next button location
		next_button :  function (element) {
		 	return element.closest('.df-slide-item').find(".next"); 
		 },

		//previous button location
		prev_button :  function (element) {
		 	return element.closest('.df-slide-item').find(".prev"); 
		 },

		//next image number
		next_image :  function (element) {
		 	return element.closest('.df-slide-item').find(".next-image"); 
		 },

		//the opened image number
		opened_image :  function (element) {
		 	return DF_gallery.main_image(element).attr("data-id"); 
		 },

		//the active thumbnail
		active_thumb :  function (element) {
		 	return jQuery(".the-thumbs a"); 
		 },

		//total image count
		total_img :  function (element) {
		 	return jQuery(".the-thumbs a.gal-thumbs").size(); 
		 },

		//lightbox
		a_click : function (adminUrl, gallery_id) {
			DF_gallery.swipe(100);

			//if images loaded
			if(DF_gallery.main_image().attr("src")=="") {
				DF_gallery.main_image().load(function(){
					DF_gallery.main_image().fadeIn('slow');
					//gallery
					jQuery(".waiter").removeClass("loading").addClass("loaded");
				});
			} else {
				DF_gallery.main_image().fadeIn('slow');
				//gallery
				jQuery(".waiter").removeClass("loading").addClass("loaded");
			}

		
			//set active thumbnail by page load in lightbox
			jQuery.each(DF_gallery.active_thumb(), function() {
				jQuery(this).removeClass("active");
				if(jQuery(this).attr("data-nr") == DF_gallery.opened_image(jQuery(this))) {
					jQuery(this).addClass("active");
				}

			});
			
			//show the loading after click
			jQuery('.df-slide-item').on( "click", ".next, .prev, .gal-thumbs", function() {
				DF_gallery.Loading(jQuery(this),adminUrl,false);

			});

			//load the next image
			jQuery('.df-slide-item').on( "click", ".next", function() {
				DF_gallery.NextImage(jQuery(this));
				return false;
			});	
			
			//load the previous image
			jQuery('.df-slide-item').on( "click", ".prev", function() {
				DF_gallery.PrevImage(jQuery(this));
				return false;
			});

			//load the clicked thumbnail
			jQuery('.df-slide-item').on( "click", ".gal-thumbs", function() {	

				var next = jQuery(this).attr("rel");

				if(jQuery(this).attr("rel")!=DF_gallery.total_img()) { 
					DF_gallery.next_button(jQuery(this)).attr("rel", parseInt(next)+1); 
					DF_gallery.prev_button(jQuery(this)).attr("rel", parseInt(next)-1); 
					DF_gallery.next_image(jQuery(this)).attr("data-next", parseInt(next)+1); 
					DF_gallery.main_image(jQuery(this)).attr("data-id", parseInt(next)); 
				} else {
					DF_gallery.next_button(jQuery(this)).attr("rel",DF_gallery.total_img()); 
					DF_gallery.prev_button(jQuery(this)).attr("rel", parseInt(DF_gallery.total_img())-1); 
					DF_gallery.next_image(jQuery(this)).attr("data-next", DF_gallery.total_img()); 
					DF_gallery.main_image(jQuery(this)).attr("data-id", parseInt(next)); 

				}
				if(jQuery(this).attr("rel")==1) { 
					DF_gallery.prev_button(jQuery(this)).attr("rel", 0); 
					DF_gallery.main_image(jQuery(this)).attr("data-id", parseInt(next)); 
				}

			});
			
			//set active image after click for the next image
			jQuery('.df-slide-item').on( "click", ".next, .prev, .gal-thumbs", function() {	
				DF_gallery.Thumbs(jQuery(this));
			});
			

		},
				
		NextImage : function (clicked) {
			if(parseInt(DF_gallery.total_img()) > DF_gallery.opened_image(clicked)) {
				DF_gallery.main_image(clicked).attr("data-id", parseInt(DF_gallery.opened_image(clicked))+1);
				DF_gallery.prev_button(clicked).attr("rel", parseInt(DF_gallery.prev_button(clicked).attr("rel"))+1);
			}	
			if(parseInt(DF_gallery.total_img()) > parseInt(clicked.attr("rel"))) {
				clicked.attr("rel", parseInt(clicked.attr("rel"))+1);
				DF_gallery.next_image(clicked).attr("data-next", parseInt(clicked.attr("rel"))); 
			}
		},	
				
		PrevImage : function (clicked) {
			if(parseInt(DF_gallery.opened_image(clicked)) > 1 && parseInt(DF_gallery.opened_image(clicked)) != jQuery(".next").attr("rel")) {
				DF_gallery.next_button(clicked).attr("rel", parseInt(DF_gallery.next_button(clicked).attr("rel"))-1);
				DF_gallery.next_image(clicked).attr("data-next", parseInt(DF_gallery.next_button(clicked).attr("rel"))); 
			}
			if(parseInt(DF_gallery.opened_image(clicked)) > 1) {
				clicked.attr("rel", parseInt(clicked.attr("rel"))-1);
				DF_gallery.main_image(clicked).attr("data-id", parseInt(DF_gallery.opened_image(clicked))-1);
			}
		},	
				
		Loading : function (clicked,adminUrl,swipe) {
			var ID = jQuery('.df-slide-item').attr("id");
			var clicked = clicked;
			var next = clicked.attr("rel");
			var waiter = jQuery('.df-slide-item').find('.waiter');
			var image = DF_gallery.main_image(clicked);
			
			

			if( (parseInt(DF_gallery.opened_image(clicked)) < parseInt(DF_gallery.total_img()) || next!=parseInt(DF_gallery.total_img())) && next!=0 && next!=DF_gallery.opened_image(clicked)) {
				waiter.removeClass("loaded");
				waiter.addClass("loading");

				jQuery.ajax({
					url:adminUrl,
					type:"POST",
					data:"action=df_plugin_load_next_image&gallery_id="+ID+"&next_image="+next,
					success:function(results) {
						image.attr("src", results);
						//image resize
						image.css("max-height", jQuery(window).height()+"px");
						image.load(function(){
							setTimeout(function () {
							    waiter.removeClass("loading");
							   	waiter.addClass("loaded");
							}, 800);

						
						});
						jQuery(".numbers span.current").html(next);
					}
				});
				
			}
		},			
				
		Thumbs : function (clicked) {

			jQuery.each(DF_gallery.active_thumb(), function() {
				jQuery(this).removeClass("active");

				if(jQuery(this).attr("data-nr") == DF_gallery.opened_image(clicked)) {
					jQuery(this).addClass("active");

				}

			});


		},
				

				
		// swipe navigation
		swipe : function (xx) {

					(function(jQuery, undefined) {
						
							var adminUrl = dfp.adminUrl;
							var wrap = jQuery('.waiter'),
								slides = wrap.find('.image-big-gallery'),

								width = wrap.width();

							// Listen for swipe events on slides, and use a custom 'activate'
							// or next slide, and to keep the index up-to-date. The class
							
							slides

							.on('swipeleft', function(e) {
								DF_gallery.Loading(jQuery('.df-slide-item .next'),adminUrl,true);
								DF_gallery.NextImage(jQuery('.df-slide-item .next'));
								DF_gallery.Thumbs(jQuery('.df-slide-item .next'));
							})

							.on('swiperight', function(e) {
								DF_gallery.Loading(jQuery('.df-slide-item .prev'),adminUrl,true);
								DF_gallery.PrevImage(jQuery('.df-slide-item .prev'));
								DF_gallery.Thumbs(jQuery('.df-slide-item .prev'));
							})

			

							// The code below handles what happens before any swipe event is triggered.
							// It makes the slides demo on this page work nicely, but really doesn't
							// have much to do with demonstrating the swipe events themselves. For more
							// on move events see:
							//
							// http://stephband.info/jquery.event.move

							.on('movestart', function(e) {
								// If the movestart heads off in a upwards or downwards
								// direction, prevent it so that the browser scrolls normally.
								if ((e.distX > e.distY && e.distX < -e.distY) ||
									(e.distX < e.distY && e.distX > -e.distY)) {
									e.preventDefault();
									return;
								}

								// To allow the slide to keep step with the finger,
								// temporarily disable transitions.
								wrap.addClass('notransition');
							})

							.on('move', function(e) {
								var left = xx * e.distX / width;

								// Move slides with the finger
								if (e.distX < 0) {
									if (slides) {
										slides.css("left", left + '%');
										slides.css("left", (left+0)+'%');
									}
									else {
										slides.css("left", left/4 + '%');
									}
								}
								if (e.distX > 0) {
									if (slides) {
										slides.css("left", left + '%');
										slides.css("left", (left-0)+'%');
									}
									else {
										slides.css("left", left/5 + '%');
									}
								}
							})

							.on('moveend', function(e) {
								wrap.removeClass('notransition');
								
								slides.css("left", '');
								
								if (slides) {
									slides.css("left", '');
								}
								if (slides) {
									slides.css("left", '');
								}
							});

						
					})(jQuery);	
				
				}
	}


	jQuery(document).ready(function($){	
		var adminUrl = dfp.adminUrl;
		var gallery_id = dfp.gallery_id;

		DF_gallery.a_click(adminUrl, gallery_id);

		//image resize
		jQuery(".df-gallery-image").css("max-height", jQuery(window).height()+"px");
	});

	//image resize by resizing window
	jQuery(window).resize(function() {
	  	jQuery(".df-gallery-image").css("max-height", jQuery(window).height()+"px");
	});	

	//key navigation
	jQuery(document).keydown(function(e){
		var adminUrl = dfp.adminUrl;
		if (e.keyCode == 39) { 
			DF_gallery.Loading(jQuery('.df-slide-item .next'),adminUrl,false);
			DF_gallery.NextImage(jQuery('.df-slide-item .next'));
			DF_gallery.Thumbs(jQuery('.df-slide-item .next'));
		   //return false;
		}
		if (e.keyCode == 37) { 
			DF_gallery.Loading(jQuery('.df-slide-item .prev'),adminUrl,false);
			DF_gallery.PrevImage(jQuery('.df-slide-item .prev'));
			DF_gallery.Thumbs(jQuery('.df-slide-item .prev'));
		   //return false;
		}
	});


// Photo gallery thumbs
jQuery("button.photo-gallery-nav").click(function(){
	var df_gallery_scrolling_global = false;
	if(df_gallery_scrolling_global)return false;
	var thisel = jQuery(this),
		direction = (thisel.hasClass("nav-me-left"))?"left":"right";
	if(direction == "left"){
		var current = thisel.siblings(".photo-gallery-thumb-list").children(".item").eq(0),
			currentmargin = (parseInt(current.css("margin-left"))+204);
		if(Math.abs(parseInt(current.css("margin-left"))) <= 204) currentmargin = 0;
		current.css("margin-left", currentmargin+"px");
	}else if(direction == "right"){
		var current = thisel.siblings(".photo-gallery-thumb-list").children(".item").eq(0),
			currentmargin = (parseInt(current.css("margin-left"))-204),
			newval = 102*parseInt(thisel.siblings(".photo-gallery-thumb-list").children(".item").size())-thisel.siblings(".photo-gallery-thumb-list").width()-12;
		if(newval <= 0)return false;
		if(Math.abs(parseInt(current.css("margin-left")))+204 >= newval) currentmargin = -newval;
		current.css("margin-left", currentmargin+"px");
	}
	df_gallery_scrolling_global = true;
	setTimeout(function(){
		df_gallery_scrolling_global = false;
	}, 200);
	return false;
});