<?php if ( ! defined( 'ABSPATH' ) ) { exit; } ?>

<?php
	$img_size = array(
		'one-column' => 'full',
		'one-half-column' => 'mfx-blog-ii-column',
		'one-third-column' => 'mfx-blog-iii-column',
		'one-fourth-column' => 'mfx-blog-iv-column'
	);

	$post_column = multifox_get_archive_post_column();

	if( has_post_thumbnail( $post_ID ) ) :
		do_action( 'multifox_blog_archive_post_thumbnail', $post_ID, $img_size, $post_column );
	endif;
?>