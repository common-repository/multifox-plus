// Search js
(function ($) {

    var dtHeaderIconsWidgetHandler = function($scope, $){

        $search = $scope.find("div.search-overlay");
        if( $search.length ) {
            $form = $search.find(".mfx-search-form-container").clone();
            $search.find(".mfx-search-form-container").remove();
            $form.appendTo( $("body") );

            $search.find("a.mfx-search-icon").on("click",function(e){
                $('.mfx-search-form-container').toggleClass('show');
            });
        }

        $('.mfx-search-form-close').on('click', function(e){
            if ($(this).parents('.mfx-search-menu-icon').length) {
                $(this).parents('.mfx-search-form-container').removeClass('show');
            } else {
                $('.mfx-search-form-container').toggleClass('show');
            }
        });

        $scope.find('.mfx-search-icon').on('click', function(e) {
            $(this).parents('.mfx-search-menu-icon').find('.mfx-search-form-container').toggleClass('show');
        });

        $scope.find('.mfx-shop-menu-cart-icon').on('click', function(e) {

            if($('.mfx-shop-cart-widget').hasClass('activate-sidebar-widget')) {

                $('.mfx-shop-cart-widget').addClass('mfx-shop-cart-widget-active');
                $('.mfx-shop-cart-widget-overlay').addClass('mfx-shop-cart-widget-active');

                // Nice scroll script

                var winHeight = $(window).height();
                var headerHeight = $('.mfx-shop-cart-widget-header').height();
                var footerHeight = $('.woocommerce-mini-cart-footer').height();

                var height = parseInt((winHeight-headerHeight-footerHeight), 10);

                $('.mfx-shop-cart-widget-content').height(height).niceScroll({ cursorcolor:"#000", cursorwidth: "5px", background:"rgba(20,20,20,0.3)", cursorborder:"none" });

                e.preventDefault();
            }

        });

        // Wishlist count update
        $(document).on( 'added_to_wishlist removed_from_wishlist', function(){

            var html = $('.mfx-wishlist-count');
            $.ajax({
                url: yith_wcwl_l10n.ajax_url,
                data: {
                    action: 'yith_wcwl_update_wishlist_count'
                },
                dataType: 'json',
                success: function( data ){
                    html.html( data.count );
                }
            })
        } );
    };

    //Elementor JS Hooks
    $(window).on('elementor/frontend/init', function () {

        elementorFrontend.hooks.addAction('frontend/element_ready/mfx-header-icons.default', dtHeaderIconsWidgetHandler);

    });

})(jQuery);