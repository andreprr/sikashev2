(function ($) {

	"use strict";

	// Page loading animation
	$(window).on('load', function () {

		$('#js-preloader').addClass('loaded');

	});


	$(window).scroll(function () {
		var scroll = $(window).scrollTop();
		var box = $('.header-text').height();
		var header = $('header').height();

		if (scroll >= box - header) {
			$("header").addClass("background-header");
		} else {
			$("header").removeClass("background-header");
		}
	})

	var width = $(window).width();
	$(window).resize(function () {
		if (width > 767 && $(window).width() < 767) {
			location.reload();
		}
		else if (width < 767 && $(window).width() > 767) {
			location.reload();
		}
	})

	const elem = document.querySelector('.event_box');
	const filtersElem = document.querySelector('.event_filter');
	if (elem) {
		const rdn_events_list = new Isotope(elem, {
			itemSelector: '.event_outer',
			layoutMode: 'masonry'
		});
		if (filtersElem) {
			filtersElem.addEventListener('click', function (event) {
				if (!matchesSelector(event.target, 'a')) {
					return;
				}
				const filterValue = event.target.getAttribute('data-filter');
				rdn_events_list.arrange({
					filter: filterValue
				});
				filtersElem.querySelector('.is_active').classList.remove('is_active');
				event.target.classList.add('is_active');
				event.preventDefault();
			});
		}
	}


	$('.owl-banner').owlCarousel({
		center: true,
		items: 1,
		loop: true,
		nav: true,
		navText: ['<i class="fa fa-angle-left" aria-hidden="true"></i>', '<i class="fa fa-angle-right" aria-hidden="true"></i>'],
		margin: 30,
		responsive: {
			992: {
				items: 1
			},
			1200: {
				items: 1
			}
		}
	});

	$('.owl-testimonials').owlCarousel({
		center: true,
		items: 1,
		loop: true,
		nav: true,
		navText: ['<i class="fa fa-angle-left" aria-hidden="true"></i>', '<i class="fa fa-angle-right" aria-hidden="true"></i>'],
		margin: 30,
		responsive: {
			992: {
				items: 1
			},
			1200: {
				items: 1
			}
		}
	});


	// Menu Dropdown Toggle
	if ($('.menu-trigger').length) {
		$(".menu-trigger").on('click', function () {
			$(this).toggleClass('active');
			$('.header-area .nav').slideToggle(200);
		});
	}


	// Menu elevator animation
	$('.scroll-to-section a[href*=\\#]:not([href=\\#])').on('click', function () {
		if (location.pathname.replace(/^\//, '') == this.pathname.replace(/^\//, '') && location.hostname == this.hostname) {
			var target = $(this.hash);
			target = target.length ? target : $('[name=' + this.hash.slice(1) + ']');
			if (target.length) {
				var width = $(window).width();
				if (width < 767) {
					$('.menu-trigger').removeClass('active');
					$('.header-area .nav').slideUp(200);
				}
				$('html,body').animate({
					scrollTop: (target.offset().top) - 80
				}, 700);
				return false;
			}
		}
	});

	$(document).ready(function () {
		$(document).on("scroll", onScroll);

		// Smooth scroll functionality
		$('.scroll-to-section a[href^="#"]').on('click', function (e) {
			e.preventDefault();
			$(document).off("scroll");

			$('.scroll-to-section a').each(function () {
				$(this).removeClass('active');
			});
			$(this).addClass('active');

			var target = this.hash;  // Ensure `target` is just the hash string (e.g., "#about-us")

			var $target = $(target);  // jQuery object for scrolling

			$('html, body').stop().animate({
				scrollTop: ($target.offset().top) - 79
			}, 500, 'swing', function () {
				// Set the location hash to the string value of `target`
				window.location.hash = target;
				$(document).on("scroll", onScroll);
			});
		});
	});


	function onScroll(event) {
		var scrollPos = $(document).scrollTop();
		$('.nav li.scroll-to-section a').each(function () {
			var currLink = $(this);
			var hrefValue = currLink.attr("href");
			var refElement = $(hrefValue);

			if (refElement.length && refElement.position().top <= scrollPos && refElement.position().top + refElement.height() > scrollPos) {
				$('.nav ul li a').removeClass("active");
				currLink.addClass("active");
			} else {
				currLink.removeClass("active");
			}
		});
	}

	// modal video 
	$(document).ready(function () {
		$('#helpModal .close').on('click', function () {
			$('#helpVideo').attr('src', '');
			$('#helpModal').modal('hide');
		});

		$(document).on('click', '.help-button', function () {
			// Use the YouTube embed URL format
			const videoSrc = "https://www.youtube.com/embed/w0lyv6AYdIk?autoplay=1&rel=0";

			// Set the YouTube video URL as the iframe source
			$('#helpVideo').attr('src', videoSrc);

			// Show the modal
			$('#helpModal').modal('show');
		});

		// Clear the iframe source when the modal is closed to stop the video
		$('#helpModal').on('hidden.bs.modal', function () {
			$('#helpVideo').attr('src', '');
		});

	});

	// banner set solid when 
	$(document).ready(function () {
		function setBackgroundFromImage(item, imgUrl) {
			var img = new Image();
			img.src = imgUrl;

			img.onload = function () {
				var vibrant = new Vibrant(img);
				vibrant.getPalette().then(function (palette) {
					var dominantColor = palette.Vibrant.hex;

					// Remove background image and set the solid color
					item.css('background-image', 'none');
					item.css('background-color', dominantColor);
				});
			};
		}

		function applyVibrantToSmallDevices() {
			var screenWidth = $(window).width();
			console.log("Current screen width: " + screenWidth + "px");

			if (window.matchMedia("(max-width: 1199.98px)").matches) {
				$('.owl-carousel.owl-banner .item').each(function () {
					var item = $(this);
					var imgUrl = item.css('background-image').replace(/^url\(["']?/, '').replace(/["']?\)$/, '');
					if (imgUrl) {
						setBackgroundFromImage(item, imgUrl);
					}
				});
			} else {
				// Optional: Reset background for large devices if needed
				$('.owl-carousel.owl-banner .item').each(function () {
					$(this).css('background-image', ''); // Reset to the original background image
				});
			}
		}

		// Initial check
		applyVibrantToSmallDevices();

		// Reapply on window resize
		$(window).resize(function () {
			applyVibrantToSmallDevices();
		});
	});


	// Page loading animation
	$(window).on('load', function () {
		if ($('.cover').length) {
			$('.cover').parallax({
				imageSrc: $('.cover').data('image'),
				zIndex: '1'
			});
		}

		$("#preloader").animate({
			'opacity': '0'
		}, 600, function () {
			setTimeout(function () {
				$("#preloader").css("visibility", "hidden").fadeOut();
			}, 300);
		});
	});

	const dropdownOpener = $('.main-nav ul.nav .has-sub > a');

	// Open/Close Submenus
	if (dropdownOpener.length) {
		dropdownOpener.each(function () {
			var _this = $(this);

			_this.on('tap click', function (e) {
				var thisItemParent = _this.parent('li'),
					thisItemParentSiblingsWithDrop = thisItemParent.siblings('.has-sub');

				if (thisItemParent.hasClass('has-sub')) {
					var submenu = thisItemParent.find('> ul.sub-menu');

					if (submenu.is(':visible')) {
						submenu.slideUp(450, 'easeInOutQuad');
						thisItemParent.removeClass('is-open-sub');
					} else {
						thisItemParent.addClass('is-open-sub');

						if (thisItemParentSiblingsWithDrop.length === 0) {
							thisItemParent.find('.sub-menu').slideUp(400, 'easeInOutQuad', function () {
								submenu.slideDown(250, 'easeInOutQuad');
							});
						} else {
							thisItemParent.siblings().removeClass('is-open-sub').find('.sub-menu').slideUp(250, 'easeInOutQuad', function () {
								submenu.slideDown(250, 'easeInOutQuad');
							});
						}
					}
				}

				e.preventDefault();
			});
		});
	}

})(window.jQuery);