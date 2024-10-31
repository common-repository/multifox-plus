( function( $ ) {

	var MailchimpWidget = function( $scope, $ ) {

		var $container = $scope.find(".mfx-mailchimp-wrapper").eq(0);
		var $form      = $container.find('form[name="frmsubscribe"]');

		$form.on('submit', function(){

			var $this = $(this),
				$mc_fname = $this.find("input[name='mfx_mc_fname']").val(),
				$mc_email = $this.find("input[name='mfx_mc_emailid']").val(),
				$mc_apikey = $this.find("input[name='mfx_mc_apikey']").val(),
				$mc_listid = $this.find("input[name='mfx_mc_listid']").val();

			$.ajax({
				type: "post",
				dataType : "html",
				url: $this.find("input[name='ajax']").val(),
				data:	{
					action: 'multifox_mailchimp_subscribe',
					mc_fname: $mc_fname,
					mc_email: $mc_email,
					mc_apikey: $mc_apikey,
					mc_listid: $mc_listid
				},
				success: function (response) {
					$this.parent().find('.multifox_ajax_subscribe_msg').html(response);
					$this.parent().find('.multifox_ajax_subscribe_msg').slideDown('slow');
					if (response.match('success') != null) $this.slideUp('slow');
				}
			});

			return false;
		});
	};

    $(window).on('elementor/frontend/init', function(){

    	elementorFrontend.hooks.addAction( 'frontend/element_ready/mfx-mailchimp.default', MailchimpWidget);
    });
} )( jQuery );