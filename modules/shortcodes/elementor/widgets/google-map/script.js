( function( $ ) {
	var GoogleMapWidget = function( $scope, $ ) {

		if ( ! window.google ) {
			return;
		}

		var $map;
		var $container    = $scope.find(".mfx-google-map").eq(0);
		var $init         = $container.data( 'init' );
		var $markers      = $container.data( 'markers' );
		var $animation    = $container.data( 'marker-animation' );
		var $iw_max_width = $container.data( 'iw-max-width' );

		if( $animation == "drop" ) {
			$animation = google.maps.Animation.DROP;
		} else if( $animation == "bounce" ) {
			$animation = google.maps.Animation.BOUNCE;
		} else {
			$animation = '';
		}

		$map = new google.maps.Map($container[0], $init );

		$markers.forEach( function( $item ) {

			var $icon = '';

			if( typeof( $item.icon ) != 'undefined' ) {

				$icon = {
					url        : $item.icon,
					scaledSize : new google.maps.Size( $item.icon_size, $item.icon_size  ),
					origin     : new google.maps.Point( 0, 0 ),
					anchor     : new google.maps.Point( 0, 0 )
				};
			}

			var $marker = new google.maps.Marker({
				position  : new google.maps.LatLng( $item.latitude, $item.longitude ),
				map       : $map,
				title     : $item.title,
				icon      : $icon,
				animation : $animation
			});

			if( $item.show_info_window == "yes" ) {

				var $content = '';
				if( $item.title.length ) {
					$content += '<div class="map-info-content-title">' + $item.title + '</div>';
				}

				if( $item.desc.length ) {
					$content += '<div class="map-info-content-desc">' + $item.desc + '</div>';
				}

				if( $content.length ) {
					$content = '<div class="map-info-content-container">' + $content + '</div>';
				}

				if( $iw_max_width !== '' ) {
					var $infowindow = new google.maps.InfoWindow({
						content  : $content,
						maxWidth : parseInt( $iw_max_width )
					});
				} else {
					var $infowindow = new google.maps.InfoWindow({
						content : $content
					});
				}

				if( $item.load_info_window == "load" ) {
					$infowindow.open( $map, $marker );
				}

				$marker.addListener( 'click', function() {
					$infowindow.open($map, $marker);
				});
			}
		});
	};

    $(window).on('elementor/frontend/init', function(){

    	elementorFrontend.hooks.addAction( 'frontend/element_ready/mfx-google-map.default', GoogleMapWidget);
    });
} )( jQuery );