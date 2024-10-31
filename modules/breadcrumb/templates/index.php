<?php
if ( ! defined( 'ABSPATH' ) ) {
	exit; // Exit if accessed directly.
}

if( !class_exists( 'MultifoxPlusBCTemplate' ) ) {
    class MultifoxPlusBCTemplate {

        private static $_instance = null;

        public static function instance() {
            if ( is_null( self::$_instance ) ) {
                self::$_instance = new self();
            }

            return self::$_instance;
        }

        function __construct() {
            $this->load_frontend();
        }

        function load_frontend() {
            add_filter( 'multifox_breadcrumb_params', array( $this, 'register_breadcrumb_params' ) );
            add_filter( 'multifox_breadcrumb_get_template_part', array( $this, 'register_template' ), 10, 2 );

            add_action( 'multifox_after_main_css', array( $this, 'enqueue_assets' ) );

            add_filter( 'multifox_header_wrapper_classes', array( $this, 'register_header_class' ) );
        }

        function register_header_class() {

            $header_cls = multifox_customizer_settings('breadcrumb_position');

            if( is_singular() ) {

                $post_id = get_the_ID();
                $bc_meta       = $this->register_meta_params( $post_id );

                if( array_key_exists( 'layout', $bc_meta ) && $bc_meta['layout'] == 'individual-option' ) {
                    $header_cls = $bc_meta['position'];
                }
                return $header_cls;
            } else {
                return $header_cls;
            }
        }

        function enqueue_assets() {
            wp_enqueue_style( 'site-breadcrumb', MULTIFOX_PLUS_DIR_URL . 'modules/breadcrumb/assets/css/breadcrumb.css', MULTIFOX_PLUS_VERSION );
        }

        function register_breadcrumb_params() {

            $enable_delimiter = multifox_customizer_settings( 'change_breadcrumb_delimiter' );
            $delimiter        = multifox_customizer_settings( 'breadcrumb_delimiter' );

            $delimiter = ( $enable_delimiter ) ? '<span class="'.esc_attr($delimiter).'"></span>' : '<span class="breadcrumb-default-delimiter"></span>';

            $wrapper_class    = array();
            $enable_darkbg    = multifox_customizer_settings( 'enable_dark_bg_breadcrumb' );
            $breadcrumb_style = multifox_customizer_settings( 'breadcrumb_style' );
            $enable_parallax  = multifox_customizer_settings( 'breadcrumb_parallax' );

            if( $enable_darkbg ) {
                $wrapper_class[] = 'dark-bg-breadcrumb';
            }

            $wrapper_class[] = $breadcrumb_style;

            if( $enable_parallax ) {
                $wrapper_class[] = 'mfx-parallax-bg';
            }

            $params = array(
                'home'             => esc_html__( 'Home', 'multifox-plus' ),
                'home_link'        => home_url('/'),
                'delimiter'        => $delimiter,
                'wrapper_classes'  => implode( ' ', $wrapper_class )
            );

            return $params;
        }

        function register_meta_params( $post_id ) {

            $post_meta = get_post_meta( $post_id, '_multifox_breadcrumb_settings', true );
            $post_meta = is_array( $post_meta ) ? $post_meta : array();

            return $post_meta;
        }

        function register_template( $args, $post_id ) {

            $style         = '';
            $enable_bc     = multifox_customizer_settings( 'enable_breadcrumb' );

            if( ! $enable_bc ) {
                return;
            }

            $template_args = $this->register_breadcrumb_params();
            $bc_meta       = $this->register_meta_params( $post_id );

            if( empty($bc_meta) || ( array_key_exists( 'layout', $bc_meta ) && $bc_meta['layout'] != 'disable' ) ) {

                if( array_key_exists( 'layout', $bc_meta ) && $bc_meta['layout'] == 'individual-option' ) {

                    $wrapper_class    = array();
                    $enable_darkbg    = array_key_exists( 'enable_dark_bg', $bc_meta ) ? $bc_meta['enable_dark_bg'] : '';
                    $breadcrumb_style = multifox_customizer_settings( 'breadcrumb_style' );
                    $enable_parallax  = multifox_customizer_settings( 'breadcrumb_parallax' );

                    if( $enable_darkbg ) {
                        $wrapper_class[] = 'dark-bg-breadcrumb';
                    }

                    $wrapper_class[] = $breadcrumb_style;

                    if( $enable_parallax ) {
                        $wrapper_class[] = 'mfx-parallax-bg';
                    }

                    //$wrapper_class = apply_filters( 'multifox_breadcrumb_wrapper_class', $wrapper_class);

                    $template_args['wrapper_classes'] = implode( ' ', $wrapper_class );
                }

                $bc_source = multifox_customizer_settings( 'breadcrumb_source' );

                switch( $bc_source ):

                    case 'default':
                    default:
                        multifox_template_part( 'breadcrumb', 'templates/default/title-content', '', $template_args );
                    break;

                endswitch;
            }
        }

    }
}

MultifoxPlusBCTemplate::instance();