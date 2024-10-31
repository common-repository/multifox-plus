<?php if ( ! defined( 'ABSPATH' ) ) { exit; } ?>

<!-- Entry Author -->
<div class="entry-author">
    <i class="mfxicon-user"> </i>
    <a href="<?php echo get_author_posts_url(get_the_author_meta('ID'));?>"
        title="<?php esc_attr_e('View all posts by ', 'multifox-plus'); echo get_the_author();?>"><?php echo get_the_author();?></a>
</div><!-- Entry Author -->