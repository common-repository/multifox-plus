<?php
if ( ! defined( 'ABSPATH' ) ) {
	exit; // Exit if accessed directly.
}

if( !class_exists( 'MultifoxPlusBreadcrumbTRTC' ) ) {
    class MultifoxPlusBreadcrumbTRTC {

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
            $options['breadcrumb-top-right-title-center'] = esc_html__('Top Right Title Center', 'multifox-plus');
            return $options;
        }
    }
}

MultifoxPlusBreadcrumbTRTC::instance();