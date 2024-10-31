<?php
if ( ! defined( 'ABSPATH' ) ) {
	exit; // Exit if accessed directly.
}

if( !class_exists( 'MultifoxPlusBreadcrumbAlignRight' ) ) {
    class MultifoxPlusBreadcrumbAlignRight {

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
            $options['alignright'] = esc_html__('Align Right', 'multifox-plus');
            return $options;
        }
    }
}

MultifoxPlusBreadcrumbAlignRight::instance();