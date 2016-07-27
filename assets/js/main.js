+function ($) {
	'use strict';

	$(document).ready(function() {

		/*  [ Page scroll animation ]
		- - - - - - - - - - - - - - - - - - - - */
		$('a.page-scroll').bind('click', function(event) {
			var $anchor = $(this);
			$('html, body').stop().animate({
				scrollTop: $($anchor.attr('href')).offset().top
			}, 1500, 'easeInOutExpo');
			event.preventDefault();
		});
		$('li.page-scroll a').bind('click', function(event) {
			var $anchor = $(this);
			$('html, body').stop().animate({
				scrollTop: $($anchor.attr('href')).offset().top
			}, 1500, 'easeInOutExpo');
			event.preventDefault();
		});

		/*  [ magnific-popup ]
		- - - - - - - - - - - - - - - - - - - - */
		if ( $().magnificPopup ) {
			var zoom = false, gallery = false;

			if ( typeof check_popup_gallery_zoom !== 'undefined' && check_popup_gallery_zoom == 'true' ) {
				zoom = true;
			}

			if ( typeof check_popup_gallery !== 'undefined' && check_popup_gallery == 'true' ) {
				gallery = true;
			}

			$('.popup-gallery').magnificPopup({
				type: 'image',
				mainClass: 'mfp-with-zoom', // this class is for CSS animation below
				zoom: {
					enabled: zoom, // By default it's false, so don't forget to enable it

					duration: 300, // duration of the effect, in milliseconds
					easing: 'ease-in-out', // CSS transition easing function

					// The "opener" function should return the element from which popup will be zoomed in
					// and to which popup will be scaled down
					// By defailt it looks for an image tag:
					opener: function(openerElement) {
					// openerElement is the element on which popup was initialized, in this case its <a> tag
					// you don't need to add "opener" option if this code matches your needs, it's defailt one.
						return openerElement.is('img') ? openerElement : openerElement.find('img');
					}
				},
				gallery: {
					// options for gallery
					enabled: gallery
				},
				image: {
					// options for image content type
					titleSrc: 'title'
				}
			});
		}

		/*  [ Shop: Filter Category ]
		- - - - - - - - - - - - - - - - - - - - */
		$( '.category-parent' ).change(function(){
			var val = $( this ).val();
			var parent = $( this ).parent();
			if ( val != '' ) {
				$( '.loading', parent.parent() ).addClass( 'enable' );
				$.ajax({
					type: "GET",
					url: ajax_object.ajax_url,
					dataType: 'html',
					data: ({ action: 'load_product_categories_child', parent: val }),
					success: function( data ) {
						if( data != '' && parent.next().find( '.category-parent' ).length ) {
							parent.next().find( '.category-parent' ).append( data );
						}
						$( '.loading', parent.parent() ).removeClass( 'enable' );
					}			
				});
			}
		});

		/*  [ Slider: Owl Carousel ]
		- - - - - - - - - - - - - - - - - - - - */
		if ( $().owlCarousel ) {
			var owl = jQuery(".owl-carousel");
			owl.each(function(){
				var items 			= $(this).attr('data-items'),
					autoplay 		= $(this).attr('data-autoplay'),
					margin 			= $(this).attr('data-margin'),
					loop 			= $(this).attr('data-loop'),
					center 			= $(this).attr('data-center'),
					nav 			= $(this).attr('data-nav'),
					dots 			= $(this).attr('data-dots'),
					mobile 			= $(this).attr('data-mobile'),
					tablet 			= $(this).attr('data-tablet'),
					desktop 		= $(this).attr('data-desktop'),
					URLhashListener = $(this).attr('data-URLhashListener'),
					autoheight 		= $(this).attr('data-autoheight');

				$(this).owlCarousel({
					items: items,
					margin: parseInt( margin ),
					loop: loop == "true" ? true : false,
					center: center == "true" ? true : false,
					autoplay: autoplay == "true" ? true : false,
					autoplayTimeout: 2000,
					nav: nav == "true" ? true : false,
					autoHeight : autoheight == "true" ? true : false,
					navText: [
						'<i class="fa fa-angle-left"></i>',
						'<i class="fa fa-angle-right"></i>'
					],
					dots: dots == "true" ? true : false,
					lazyLoad: true,
					lazyContent: true,
					responsive: {
						320: {
							items: mobile
						},
						480: {
							items: mobile
						},
						768: {
							items: tablet
						},
						992: {
							items: desktop
						},
						1200: {
							items: items
						}
					},
					// URLhashListener: URLhashListener == "true" ? true : false,
				});
			});
		}

		/*  [ Slider: RCarousel Master ] */
		if ( $().rcarousel ) {
			var carousel_master = jQuery(".rcarousel-master");
			carousel_master.each(function(){
				var items 			= $(this).attr('data-items'),
					autoplay 		= $(this).attr('data-autoplay'),
					margin 			= $(this).attr('data-margin'),
					width 			= $(this).attr('data-width'),
					height 			= $(this).attr('data-height');
				
				$(this).rcarousel({
					visible: parseInt( items ),
					margin: parseInt( margin ),
					step: 1,
					speed: 700,
					auto: {
						enabled: autoplay == "true" ? true : false
					},
					width: parseInt( width ),
					height: parseInt( height ),
					orientation: "vertical",
					// start: generatePages,
					// pageLoaded: pageLoaded
				});
			});
		}

		/*  [ Banner Siteout: Check and Run banners siteout in site ]
		- - - - - - - - - - - - - - - - - - - - */
		if ( $('.rt-ads-left').length ) {
			var obj = $('.rt-ads-left'),
				csstransition = obj.attr('data-csstransition') == 'true' ? true : false,
				easing = obj.attr('data-easing');

			obj.stickyfloat({ duration: 400, cssTransition: csstransition, easing: easing });
		}
		if ( $('.rt-ads-right').length ) {
			var obj = $('.rt-ads-right'),
				csstransition = obj.attr('data-csstransition') == 'true' ? true : false,
				easing = obj.attr('data-easing');

			obj.stickyfloat({ duration: 400, cssTransition: csstransition, easing: easing });
		}

		/*  [ Popup ]
		- - - - - - - - - - - - - - - - - - - - */
		$('.topcoat-button--cta').click(function(){
			var container = '#wrapper',
				popup = '.register-web-popup[data-block="in"]',
				animation = 'bounce-in',
				customOverlay = document.querySelector('.transition-overlay');

			AnimateTransition({
				container: container,
				blockIn: popup,
				animation: animation,
				beforeTransition: function (blockIn, blockOut, container) {
					$(popup).removeClass('hide-display');
				},
				onTransitionStart: function (blockIn, blockOut, container, event) {
					customOverlay.style.display = 'block';
				},
				onTransitionEnd: function (blockIn, blockOut, container, event) {
					$(popup).removeClass('hide-opacity');
				}
			});
		});
		$('.popup-close').click(function(){
			var popup = '.register-web-popup[data-block="in"]',
				customOverlay = document.querySelector('.transition-overlay');

			customOverlay.style.display = 'none';
			$(popup).addClass('hide-opacity');
			$(popup).addClass('hide-display');
		});

		/*  [ Plugin RT - Brand Dropdown Menu Link Conect]
		- - - - - - - - - - - - - - - - - - - - */
		if ( $('.widget-content-link').length ) {
			$('.widget-content-link select').change(function() {
				var url = $(this).val();
				if(url.length) window.open(url);
			});
		}

	});
}(jQuery);