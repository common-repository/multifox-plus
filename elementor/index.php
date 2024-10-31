<?php
if ( ! defined( 'ABSPATH' ) ) {
	exit; // Exit if accessed directly.
}

if (! class_exists ( 'MultifoxPlusElementor' )) {
	/**
	 *
	 * @author iamdesigning11
	 *
	 */
	class MultifoxPlusElementor {

        private static $_instance = null;

        public static function instance() {
            if ( is_null( self::$_instance ) ) {
                self::$_instance = new self();
            }

            return self::$_instance;
        }

		function __construct() {
            add_action( 'elementor/widgets/widgets_registered', array( $this, 'register_widgets' ) );
            add_action( 'wp_enqueue_scripts', array( $this, 'enqueue_assets' ) );
		}

        function register_widgets( $widgets_manager ) {
            require MULTIFOX_PLUS_DIR_PATH . 'elementor/class-common-widget-base.php';
        }

        function enqueue_assets() {
            wp_enqueue_style( 'multifox-plus-elementor', MULTIFOX_PLUS_DIR_URL . 'elementor/assets/css/elementor.css', false, MULTIFOX_PLUS_VERSION, 'all');
        }

	}
}

MultifoxPlusElementor::instance();