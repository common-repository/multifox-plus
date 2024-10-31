<?php
if ( ! defined( 'ABSPATH' ) ) {
	exit; // Exit if accessed directly.
}

if( !class_exists( 'MultifoxPlusBCRankMath' ) ) {
    class MultifoxPlusBCRankMath {

        private static $_instance = null;

        public static function instance() {
            if ( is_null( self::$_instance ) ) {
                self::$_instance = new self();
            }

            return self::$_instance;
        }

        function __construct() {
            add_action( 'plugins_loaded', array( $this, 'register_init' ) );
        }

        function register_init() {
            if ( function_exists('rank_math_the_breadcrumbs') ) {
                $this->load_backend();
                $this->load_frontend();
            }
        }

        function load_backend() {
            add_filter( 'multifox_breadcrumb_source', array( $this, 'register_option' ) );
        }

        function load_frontend() {
            add_filter( 'multifox_breadcrumb_get_template_part', array( $this, 'register_template' ) );
        }

        function register_option( $options ) {
            $options['rankmath-seo'] = esc_html__('Rank Math SEO','multifox-plus');
            return $options;
        }

        function register_template() {
            multifox_template_part( 'breadcrumb', 'templates/rankmath-seo/title-content', '', $template_args );
        }
    }
}

MultifoxPlusBCRankMath::instance();