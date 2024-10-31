(function ($) {

	var dtAdvancedCarouselsWidgetHandler = function($scope, $){

        var carouselElement = $scope.find('.mfx-advanced-carousel-wrapper').each(function(){
        	var $settings = $(this).data('settings');

        	$options = {
				adaptiveHeight: $settings.adaptiveHeight,
				arrows: $settings.arrows,
				autoplay: $settings.autoplay,
				autoplaySpeed: $settings.autoplaySpeed,
				dots: $settings.dots,
				draggable: $settings.draggable,
				swipe: $settings.swipe,
				infinite: $settings.infinite,
				pauseOnDotsHover: $settings.pauseOnDotsHover,
				pauseOnFocus: $settings.pauseOnFocus,
				pauseOnHover: $settings.pauseOnHover,
				slidesToShow: $settings.slidesToShow,
				slidesToScroll : $settings.slidesToScroll,
				speed: $settings.speed,
				touchMove: $settings.touchMove,
				vertical:$settings.vertical,
				dotsClass:$settings.dotsClass
        	};

			var responsiveSettings = $settings.responsive;
			var responsiveData = [];
			$.each(responsiveSettings, function (index, value) {
				var responsiveObjectStr = {
					breakpoint: value.breakpoint,
					settings: {
					  slidesToShow: value.toshow,
					  slidesToScroll: value.toscroll
					}
				};
				responsiveData.push(responsiveObjectStr);
			});
			$options['responsive'] = responsiveData;

        	if( $settings.arrowStyle !== 'undefined' && $settings.nextArrowLabel !== 'undefined') {
        		$options.nextArrow = '<button type="button" class="' + $settings.arrowStyle + ' slick-next"> <span class="' + $settings.nextArrowLabel + '"></span> </button>';
        	}

        	if( $settings.arrowStyle !== 'undefined' && $settings.prevArrowLabel !== 'undefined') {
        		$options.prevArrow = '<button type="button" class="' + $settings.arrowStyle + ' slick-prev"> <span class="' + $settings.prevArrowLabel + '"></span> </button>';
        	}

        	$(this).slick( $options );
        });
	};

    //Elementor JS Hooks
    $(window).on('elementor/frontend/init', function () {
		elementorFrontend.hooks.addAction('frontend/element_ready/mfx-advanced-carousel.default', dtAdvancedCarouselsWidgetHandler);
    });
})(jQuery);