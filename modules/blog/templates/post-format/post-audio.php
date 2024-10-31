<?php if ( ! defined( 'ABSPATH' ) ) { exit; } ?>

<?php
	if( isset( $meta['media-url'] ) && $meta['media-url'] != '' && $enable_video_audio ) :
		if( $meta['media-type'] == 'oembed' ) :
			echo wp_oembed_get($meta['media-url']);
		elseif( $meta['media-type'] == 'self' ) :
			echo wp_audio_shortcode( array('src' => $meta['media-url']) );
		endif;
	else:
		$template_args['post_ID'] = $post_ID;
		multifox_template_part( 'blog', 'templates/post-format/post', 'standard', $template_args );
	endif;
?>