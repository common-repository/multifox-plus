<?php if ( ! defined( 'ABSPATH' ) ) { exit; } ?>

<?php
	if( isset( $meta['post-gallery-items'] ) && $meta['post-gallery-items'] != '' && $enable_gallery_slider ) : ?>
		<ul class="entry-gallery-post-slider"><?php
			$items = explode(',', $meta["post-gallery-items"]);
			foreach ( $items as $item ) { ?>
				<li><?php echo wp_get_attachment_image( $item, 'full' ); ?></li><?php
			}?>
		</ul><?php
	else:
		$template_args['post_ID'] = $post_ID;
		multifox_template_part( 'blog', 'templates/post-format/post', 'standard', $template_args );
	endif;
?>