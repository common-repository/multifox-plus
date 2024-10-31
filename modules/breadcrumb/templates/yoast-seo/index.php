<?php
if ( ! defined( 'ABSPATH' ) ) {
	exit; // Exit if accessed directly.
}

if( !class_exists( 'MultifoxPlusBCYoast' ) ) {
    class MultifoxPlusBCYoast {

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
            if ( function_exists('yoast_breadcrumb') ) {
                $this->load_backend();
                $this->load_frontend();
            }
        }

        function load_backend() {
            add_filter( 'multifox_breadcrumb_source', array( $this, 'register_option' ) );
        }

        function load_frontend() {
        }

        function register_option( $options ) {
            $options['yoast-seo'] = esc_html__('Yoast SEO','multifox-plus');
            return $options;
        }
    }
}

MultifoxPlusBCYoast::instance();