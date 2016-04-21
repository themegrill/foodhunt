jQuery(document).ready(function() {

	// Slider Setting
	if ( typeof jQuery.fn.bxSlider !== 'undefined' && typeof foodhunt_slider_value !== 'undefined' ) {

		var slider_controls = '1' == foodhunt_slider_value.slider_controls ? false : true;
		var slider_pager = '1' == foodhunt_slider_value.slider_pager ? false : true;

		jQuery('#home-slider .bxslider').bxSlider({
			auto: true,
			mode: 'fade',
			caption: true,
			controls: slider_controls,
			pager: slider_pager,
			prevText: '<i class="fa fa-angle-left"> </i>',
			nextText: '<i class="fa fa-angle-right"> </i>',
			onSliderLoad: function(){
				jQuery('#home-slider .bxslider').css('visibility', 'visible');
			}
		});
	}

	//Ticker Setting
	if ( typeof jQuery.fn.ticker !== 'undefined' ) {
		jQuery('.header-ticker').ticker();
	}

	jQuery(window).on('load', function() {
		jQuery('.header-ticker > div').css('visibility', 'visible');
	});

	jQuery('.mobile-menu-wrapper .menu-toggle').click(function() {
	  jQuery('.mobile-menu-wrapper .menu').slideToggle('slow');
	});

	jQuery('.mobile-menu-wrapper .menu-item-has-children,.mobile-menu-wrapper .page_item_has_children').append('<span class="sub-toggle"> <i class="fa fa-angle-right"></i> </span>');

	jQuery('.mobile-menu-wrapper .sub-toggle').click(function() {
		jQuery(this).parent('.page_item_has_children,.menu-item-has-children').children('ul.sub-menu,ul.children').first().slideToggle('1000');
		jQuery(this).children('.fa-angle-right').first().toggleClass('fa-angle-down');
	});

   // scroll up setting
   jQuery(".scrollup").hide();
   jQuery(function () {
      jQuery(window).scroll(function () {
         if (jQuery(this).scrollTop() > 800) {
            jQuery('.scrollup').fadeIn();
         } else {
            jQuery('.scrollup').fadeOut();
         }
      });
      jQuery('.scrollup').click(function () {
         jQuery('body,html').animate({
            scrollTop: 0
         }, 1400);
         return false;
      });
   });

	// Parallax Setting
	if ( typeof jQuery.fn.parallax !== 'undefined' ) {
		jQuery(window).on('load', function() {
			var width = Math.max(window.innerWidth, document.documentElement.clientWidth);

			if ( width && width > 768 ) {
				jQuery('.section-wrapper-with-bg-image').each(function() {
					jQuery(this).parallax('center', 0.6, true);
				});
			}
		});
	}

	var width = Math.max(window.innerWidth, document.documentElement.clientWidth);

	if ( width && width <= 768 ) {
			jQuery('.home-search').insertAfter('.menu-toggle');
	}

	//search popup
	jQuery('.search-icon i').click(function() {
	    jQuery('.search-box').toggleClass('active');
	    jQuery('#page').css({
	    	'filter': 'blur(8px)',
	    	'-webkit-filter': 'blur(8px)',
	    	'-moz-filter': 'blur(8px)'
	    });
	});

	jQuery('.search-form-wrapper .close').click(function() {
	    jQuery('.search-box').removeClass('active');
	    jQuery('#page').css({
	        'filter': 'blur(0px)',
	        '-webkit-filter': 'blur(0px)',
	        '-moz-filter': 'blur(0px)'
	    });

	});

	//stikcy menu
	var previousScroll = 0, headerOrgOffset = jQuery('.bottom-header').offset().top;

	jQuery(window).scroll(function() {
	    var currentScroll = jQuery(this).scrollTop();
	    if(currentScroll > headerOrgOffset) {
	        if (currentScroll > previousScroll) {
	            jQuery('.bottom-header').addClass('nav-up');
	        } else {
	            jQuery('.bottom-header').addClass('nav-down');
	            jQuery('.bottom-header').removeClass('nav-up');
	        }
	    } else {
	         jQuery('.bottom-header').removeClass('nav-down');
	    }
	    previousScroll = currentScroll;
	});
});
