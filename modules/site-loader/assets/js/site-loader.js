(function ($) {
    "use strict";
	$(document).ready(function () {

        if( $("body").hasClass("has-page-loader") ) {
            Pace.on("done", function(){
                $(".pre-loader").fadeOut(500);
                $(".pace").remove();
            });
        }
    });
})(jQuery);