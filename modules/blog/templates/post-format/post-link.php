<?php if ( ! defined( 'ABSPATH' ) ) { exit; } ?>

<?php
	$link_text = ( isset( $meta['fieldset_link'] ) && $meta['fieldset_link']['fieldset_link_title'] != '' ) ? $meta['fieldset_link']['fieldset_link_title'] : get_the_title($post_ID);
	$link_url  = ( isset( $meta['fieldset_link'] ) && $meta['fieldset_link']['fieldset_link_url'] != '' ) ? $meta['fieldset_link']['fieldset_link_url'] : get_permalink($post_ID); ?>

	<div class="entry-link-inner">
		<div class="entry-link-wrapper">
			<span class="mfxicon-link"></span>
			<h4 class="link-text"><?php echo esc_html($link_text); ?></h4>
			<span class="link-author"><?php echo esc_url($link_url); ?></span>
			<a itemprop="url" class="entry-link-url" href="<?php echo esc_url($link_url);?>" target="_blank"></a>
		</div><!-- Link Text -->
	</div><!-- Link Inner --><?php
?>