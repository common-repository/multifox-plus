<?php get_header(); ?>

<!-- Primary -->
<section id="primary" class="<?php echo esc_attr( multifox_get_primary_classes() ); ?>">
<?php
    do_action( 'multifox_before_single_page_content_wrap' );

    if( have_posts() ) {
        while( have_posts() ) {
            the_post();?>
            <!-- #post-<?php the_ID(); ?> -->
            <div id="post-<?php the_ID(); ?>" <?php post_class(); ?>>
                <?php
                    do_action( 'multifox_before_single_page_content' );

                    the_content();

                    do_action( 'multifox_after_single_page_content' );?>
            </div><!-- #post-<?php the_ID(); ?> --><?php
        }
    }

    do_action( 'multifox_after_single_page_content_wrap' );?>
</section><!-- Primary End -->

<?php get_footer(); ?>