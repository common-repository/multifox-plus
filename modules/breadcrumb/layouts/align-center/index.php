<?php
if ( ! defined( 'ABSPATH' ) ) {
	exit; // Exit if accessed directly.
}

if( !class_exists( 'MultifoxPlusBreadcrumbAlignCenter' ) ) {
    class MultifoxPlusBreadcrumbAlignCenter {

        private static $_instance = null;

        public static function instance() {
            if ( is_null( self::$_instance ) ) {
                self::$_instance = new self();
            }

            return self::$_instance;
        }

        function __construct() {
            add_filter( 'multifox_plus_breadcrumb_layouts', array( $this, 'add_option' ) );
        }

        function add_option( $options ) {
            $options['aligncenter'] = esc_html__('Align Center', 'multifox-plus');
            return $options;
        }
    }
}

MultifoxPlusBreadcrumbAlignCenter::instance();