// Tabs Js
(function ($) {

	var dtTabsWidgetHandler = function($scope, $){

		var tabsElement = $scope.find('ul.mfx-tab-titles').each(function(){
			jQuery(this).dtTabs('> .mfx-tab-content', {
				effect: 'fade'
			});
		});

	};

    //Elementor JS Hooks
    $(window).on('elementor/frontend/init', function () {

		elementorFrontend.hooks.addAction('frontend/element_ready/mfx-tabs.default', dtTabsWidgetHandler);

	});

})(jQuery);