<?php
if ( ! defined( 'ABSPATH' ) ) {
	exit; // Exit if accessed directly.
}

if( !class_exists( 'MultifoxPlus404' ) ) {
    class MultifoxPlus404 {

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
            include_once MULTIFOX_PLUS_DIR_PATH.'modules/404/customizer/index.php';
        }

    }
}

MultifoxPlus404::instance();