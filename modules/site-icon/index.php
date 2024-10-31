<?php
if ( ! defined( 'ABSPATH' ) ) {
	exit; // Exit if accessed directly.
}

if( !class_exists( 'MultifoxPlusSiteIcon' ) ) {
    class MultifoxPlusSiteIcon {

        private static $_instance = null;

        public static function instance() {
            if ( is_null( self::$_instance ) ) {
                self::$_instance = new self();
            }

            return self::$_instance;
        }

        function __construct() {
            $this->load_modules();
        }

        function load_modules() {
            include_once MULTIFOX_PLUS_DIR_PATH.'modules/site-icon/customizer/index.php';
        }
    }
}

MultifoxPlusSiteIcon::instance();