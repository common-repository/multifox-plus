<?php
	global $wp_query;
	$count = get_option( 'posts_per_page' );
	//$pos = $count % $columns;
	//$pos += 1;
	$pos = 1;

	$post_equal_height 		= $params['enable-equal-height'];
	$post_layout 	   		= $params['post-layout'];
	$post_style 	   		= ( $post_layout == 'entry-cover' ) ? $params['post-cover-style'] : $params['post-gl-style'];
	$post_columns 	   		= $params['post-column'];
	$post_list_type    		= $params['list-type'];
	$post_img_hover_style   = $params['hover-style'];
	$post_img_overlay_style = $params['overlay-style'];
	$post_alignment			= $params['post-align']; ?>

    <div class="pagination blog-pagination">
    	<div class="infinite-btn more-items" data-maxpage="<?php echo esc_attr($wp_query->max_num_pages); ?>" data-pos="<?php echo esc_attr($pos); ?>" data-eheight="<?php echo esc_attr($post_equal_height); ?>" data-style="<?php echo esc_attr($post_style); ?>" data-layout="<?php echo esc_attr($post_layout); ?>" data-column="<?php echo esc_attr($post_columns); ?>" data-listtype="<?php echo esc_attr($post_list_type); ?>" data-hover="<?php echo esc_attr($post_img_hover_style); ?>" data-overlay="<?php echo esc_attr($post_img_overlay_style); ?>" data-align="<?php echo esc_attr($post_alignment); ?>" data-meta="" data-blogpostloadmore-nonce="<?php echo wp_create_nonce('blogpostloadmore_nonce'); ?>"></div>
	</div>