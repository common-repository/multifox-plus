<?php
if ( ! defined( 'ABSPATH' ) ) {
	exit; // Exit if accessed directly.
}

if( !class_exists( 'MultifoxPlusBlogPostsWidget' ) ) {
    class MultifoxPlusBlogPostsWidget {

        private static $_instance = null;
        public $blog_settings     = null;

        public static function instance() {
            if ( is_null( self::$_instance ) ) {
                self::$_instance = new self();
            }

            return self::$_instance;
        }

        function __construct() {
            add_action( 'elementor/widgets/widgets_registered', array( $this, 'register_widgets' ) );
            add_action( 'elementor/frontend/after_register_styles', array( $this, 'register_widget_styles' ) );
            add_action( 'elementor/frontend/after_register_scripts', array( $this, 'register_widget_scripts' ) );
            add_action( 'elementor/preview/enqueue_styles', array( $this, 'register_preview_styles') );

            add_action( 'call_blog_elementor_sc_filters', array( $this, 'register_call_blog_elementor_sc_filters' ) );
            add_action( 'wp_ajax_blog_elementor_sc_load_more_post', array( $this, 'blog_elementor_sc_load_more_post' ) );
            add_action( 'wp_ajax_nopriv_blog_elementor_sc_load_more_post', array( $this, 'blog_elementor_sc_load_more_post' ) );
        }

        function register_widgets( $widgets_manager ) {
            require MULTIFOX_PLUS_DIR_PATH. 'modules/blog/elementor/widgets/blog-posts/class-widget-blog-posts.php';
            $widgets_manager->register_widget_type( new \Elementor_Blog_Posts() );
        }

        public function register_call_blog_elementor_sc_filters( $settings ) {

            $this->blog_settings = $settings;

            add_filter( 'post_class', array( $this, 'register_add_remove_post_class' ), 15, 3 );
            add_filter( 'multifox_archive_post_hld_class', array( $this, 'register_archive_post_hld_class' ) );
            add_filter( 'multifox_archive_post_cmb_class', array( $this, 'register_archive_post_cmb_class' ) );
            add_filter( 'register_archive_post_cmb_elementor_class', array( $this, 'register_archive_post_cmb_class' ) );
            add_filter( 'multifox_archive_blog_post_params', array( $this, 'register_archive_blog_post_params' ) );
            add_filter( 'multifox_blog_archive_elem_order_params', array( $this, 'register_blog_archive_elem_order_params' ), 20, 1 );
        }

        public function register_add_remove_post_class( $classes, $class, $post_id ) {

            if( !array_key_exists( 'feature_image', $this->register_get_post_elements() ) ) {
                if( ( $key = array_search( 'has-post-thumbnail', $classes ) ) !== false ) {
                    unset( $classes[$key] );
                }
            }

            $post_meta = get_post_meta( $post_id, '_multifox_post_settings', TRUE );
            $post_meta = is_array( $post_meta ) ? $post_meta  : array();

            $post_format = !empty( $post_meta['post-format-type'] ) ? $post_meta['post-format-type'] : get_post_format($post_id);
            $classes[] = 'blog-entry';
            $classes[] = !empty( $post_format ) ? 'format-'.esc_attr($post_format) : 'format-standard';

            $blog_params = $this->register_archive_blog_post_params();

            if( $blog_params['enable_post_format'] ) {
                $classes[] = 'has-post-format';
            }

            if( $blog_params['enable_video_audio'] && ( $post_format === 'video' || $post_format === 'audio' ) ) {
                $classes[] = 'has-post-media';
            }

            if( get_the_title( $post_id ) == '' ) {
                $classes[] = 'post-without-title';
            }

            return $classes;
        }

        public function register_archive_post_hld_class( $option = array() ) {

            $settings = $this->blog_settings;

            $option['enable-equal-height'] = $settings['enable_equal_height'];
            $option['enable-no-space']     = $settings['enable_no_space'];

            return $option;
        }

        public function register_archive_post_cmb_class( $option = array() ) {

            $settings = $this->blog_settings;

            $option['post-layout']      = $settings['blog_post_layout'];
            $option['post-gl-style']    = $settings['blog_post_grid_list_style'];
            $option['post-cover-style'] = $settings['blog_post_cover_style'];
            $option['list-type']        = $settings['blog_list_thumb'];
            $option['hover-style']      = $settings['blog_image_hover_style'];
            $option['overlay-style']    = $settings['blog_image_overlay_style'];
            $option['post-align']       = $settings['blog_alignment'];
            $option['post-column']      = $settings['blog_post_columns'];

            return $option;
        }

        public function register_archive_blog_post_params() {

            $settings = $this->blog_settings;

            $params = array(
                'enable_post_format'      => $settings['enable_post_format'],
                'enable_video_audio'      => $settings['enable_video_audio'],
                'enable_gallery_slider'   => $settings['enable_gallery_slider'],
                'archive_post_elements'   => $this->register_get_post_elements(),
                'archive_meta_elements'   => $this->register_get_meta_elements(),
                'archive_readmore_text'   => $settings['blog_readmore_text'],
                'enable_excerpt_text'     => $settings['enable_excerpt_text'],
                'archive_excerpt_length'  => $settings['blog_excerpt_length'],
                'enable_disqus_comments'  => multifox_customizer_settings( 'enable_disqus_comments' ),
                'post_disqus_shortname'   => multifox_customizer_settings( 'post_disqus_shortname' ),
                'archive_blog_pagination' => $settings['blog_pagination'],
            );

            return $params;
        }

        function register_blog_archive_elem_order_params( $template_args ) {

            $archive_post_elements = $this->register_get_post_elements();
            $post_layout           = $this->register_archive_post_cmb_class();
            $post_layout           = $post_layout['post-layout'];

            if( array_key_exists( 'feature_image', $archive_post_elements ) && ( $post_layout == 'entry-list' || $post_layout == 'entry-cover' ) ) {
                $archive_post_elements = array( 'feature_image' => $archive_post_elements['feature_image'] ) + $archive_post_elements;
                $template_args['archive_post_elements'] = $archive_post_elements;
            }

            return $template_args;
        }

        public function register_get_post_elements() {

            $settings = $this->blog_settings;
            $newEles = array();

            $element_position = !empty( $settings['blog_elements_position'] ) ? $settings['blog_elements_position'] : explode( ',', $blog_elements_position );

            if( is_array( $element_position[0] ) ) {
                foreach($element_position as $key => $items) {
                    $newEles[$items['element_value']] = $items['element_value'];
                }
            } else {
                foreach($element_position as $item) {
                    $newEles[$item] = $item;
                }
            }

            return $newEles;
        }

        public function register_get_meta_elements() {

            $settings = $this->blog_settings;
            $newMEles = array();

            $meta_group_position = !empty( $settings['blog_meta_position'] ) ? $settings['blog_meta_position'] : explode( ',', $blog_meta_position );

            if( is_array( $meta_group_position[0] ) ) {
                foreach($meta_group_position as $key => $items) {
                    $newMEles[$items['element_value']] = $items['element_value'];
                }
            } else {
                foreach($meta_group_position as $item) {
                    $newMEles[$item] = $item;
                }
            }

            return $newMEles;
        }

        public function blog_elementor_sc_load_more_post() {

            $blogpostloadmore_nonce = multifox_sanitization($_POST['blogpostloadmore_nonce']);
            if( isset( $blogpostloadmore_nonce ) && wp_verify_nonce( $blogpostloadmore_nonce, 'blogpostloadmore_nonce' ) ) {

                $parse_str = ( isset( $_REQUEST['settings'] ) ) ? parse_str( multifox_sanitization($_REQUEST['settings']), $settings ) : '';
                $this->blog_settings = $settings;

                $count = ( isset( $_REQUEST['count'] ) ) ? multifox_sanitization($_REQUEST['count']) : get_option( 'posts_per_page' );
                $page  = ( isset( $_REQUEST['pageNumber'] ) ) ? multifox_sanitization($_REQUEST['pageNumber']) : 2;
                $cats  = ( isset( $_REQUEST['cats'] ) ) ? explode( ',', multifox_sanitization($_REQUEST['cats']) ) : '';

                $args = array( 'post_type' => 'post', 'posts_per_page' => $count, 'post_status' => 'publish', 'paged' => $page, 'ignore_sticky_posts' => true, 'cat' => $cats );
                $the_query = new WP_Query( $args );

                if( $the_query->have_posts() ) {

                    add_filter( 'post_class', array( $this, 'register_add_remove_post_class' ), 15, 3 );
                    add_filter( 'multifox_archive_post_cmb_class', array( $this, 'register_archive_post_cmb_class' ) );
                    add_filter( 'multifox_archive_blog_post_params', array( $this, 'register_archive_blog_post_params' ) );

                    $combine_class = multifox_get_archive_post_combine_class();
                    $post_style    = multifox_get_archive_post_style();

                    $template_args['Post_Style'] = $post_style;
                    $template_args = array_merge( $template_args, multifox_archive_blog_post_params() );

                    while( $the_query->have_posts() ) :
                        $the_query->the_post();
                        $post_ID = get_the_ID(); ?>

                        <div class="<?php echo esc_attr($combine_class);?>">
                            <article id="post-<?php the_ID(); ?>" <?php post_class(); ?>><?php
                                $template_args['ID'] = $post_ID;
                                multifox_template_part( 'blog', 'templates/'.esc_attr($post_style).'/post', '', $template_args ); ?>
                            </article>
                        </div><?php
                    endwhile;
                    wp_reset_postdata();
                }
            }
            die();
        }

        function register_widget_styles() {
            wp_register_style( 'swiper',
                MULTIFOX_PLUS_DIR_URL . 'modules/blog/elementor/widgets/assets/css/swiper.min.css', array(), MULTIFOX_PLUS_VERSION );
            wp_register_style( 'mfx-blogcarousel',
                MULTIFOX_PLUS_DIR_URL . 'modules/blog/elementor/widgets/assets/css/blogcarousel.css', array(), MULTIFOX_PLUS_VERSION );
        }

        function register_widget_scripts() {
            wp_register_script( 'jquery-swiper',
                MULTIFOX_PLUS_DIR_URL . 'modules/blog/elementor/widgets/assets/js/swiper.min.js', array( 'jquery' ), MULTIFOX_PLUS_VERSION, true );
            wp_register_script( 'mfx-blogcarousel',
                MULTIFOX_PLUS_DIR_URL . 'modules/blog/elementor/widgets/assets/js/blogcarousel.js', array(), MULTIFOX_PLUS_VERSION, true );
        }

        function register_preview_styles() {
            wp_enqueue_style( 'swiper' );
            wp_enqueue_style( 'mfx-blogcarousel' );
        }
    }
}

MultifoxPlusBlogPostsWidget::instance();