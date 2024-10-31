// Counter Js
(function ($) {

	var dtCounterWidgetHandler = function($scope, $){

        var counterElement = $scope.find('.mfx-counter-wrapper').each(function(){

			$(this).one('inview', function (event, visible) {

				if(visible === true) {
					var val = $(this).find('.mfx-counter-number').attr('data-value');
					$(this).find('.mfx-counter-number .mfx-number').animateNumber({ number: val }, 4000);
				}
			});

		});

	};

    //Elementor JS Hooks
    $(window).on('elementor/frontend/init', function () {

		elementorFrontend.hooks.addAction('frontend/element_ready/mfx-counter.default', dtCounterWidgetHandler);

	});

})(jQuery);