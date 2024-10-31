<?php if ( ! defined( 'ABSPATH' ) ) { exit; } ?>


<!-- Entry Categories -->
<?php
$cats = wp_get_object_terms($post_ID, 'category');
if( !empty($cats) ):
	echo'<div class="entry-categories">';
		$count = count($cats);
		$out = '';
		foreach( $cats as $key => $term ) {
			$out .= '<a href="'.get_term_link( $term->slug ,'category').'">'.esc_html( $term->name ).'</a>';
			$key += 1;

			if( $key !== $count ){
				$out .= ' ';
			}
		}
		echo "<i class='mfxicon-folder'> </i>{$out}";
	echo '</div>';
endif; ?><!-- Entry Categories -->