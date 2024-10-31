<?php
if ( ! defined( 'ABSPATH' ) ) {
	exit; // Exit if accessed directly.
}

if( !class_exists( 'MultifoxPlusHeader' ) ) {
    class MultifoxPlusHeader {

        private static $_instance = null;

        public static function instance() {
            if ( is_null( self::$_instance ) ) {
                self::$_instance = new self();
            }

            return self::$_instance;
        }

        function __construct() {
            $this->load_header_layouts();
            $this->load_modules();
            $this->frontend();
        }

        function load_header_layouts() {
            foreach( glob( MULTIFOX_PLUS_DIR_PATH. 'modules/header/layouts/*/index.php'  ) as $module ) {
                include_once $module;
            }
        }

        function load_modules() {
            include_once MULTIFOX_PLUS_DIR_PATH.'modules/header/customizer/index.php';
            include_once MULTIFOX_PLUS_DIR_PATH.'modules/header/elementor/index.php';
        }

        function frontend() {
            add_action( 'multifox_after_main_css', array( $this, 'enqueue_assets' ) );
        }

        function enqueue_assets() {
            wp_enqueue_style( 'site-header', MULTIFOX_PLUS_DIR_URL . 'modules/header/assets/css/header.css', MULTIFOX_PLUS_VERSION );
        }

    }
}

MultifoxPlusHeader::instance();