<?php
if ( ! defined( 'ABSPATH' ) ) {
	exit; // Exit if accessed directly.
}

if( !class_exists( 'MultifoxPlusHeaderMenuWidget' ) ) {
    class MultifoxPlusHeaderMenuWidget {

        private static $_instance = null;

        public static function instance() {
            if ( is_null( self::$_instance ) ) {
                self::$_instance = new self();
            }

            return self::$_instance;
        }

        function __construct() {
            add_action( 'elementor/widgets/widgets_registered', array( $this, 'register_widgets' ) );
        }

        function register_widgets( $widgets_manager ) {
            require MULTIFOX_PLUS_DIR_PATH. 'modules/menu/elementor/widgets/header-menu/class-widget-header-menu.php';
            $widgets_manager->register_widget_type( new \Elementor_Header_Menu() );
        }
    }
}

MultifoxPlusHeaderMenuWidget::instance();