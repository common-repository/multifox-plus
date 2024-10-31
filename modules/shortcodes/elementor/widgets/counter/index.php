<?php
if ( ! defined( 'ABSPATH' ) ) {
	exit; // Exit if accessed directly.
}

if( !class_exists( 'MultifoxPlusCounterWidget' ) ) {
    class MultifoxPlusCounterWidget {

        private static $_instance = null;

        public static function instance() {
            if ( is_null( self::$_instance ) ) {
                self::$_instance = new self();
            }

            return self::$_instance;
        }

        function __construct() {
            add_action( 'elementor/widgets/widgets_registered', array( $this, 'register_widgets' ) );
            add_action( 'elementor/frontend/after_register_styles', array( $this, 'register_widget_styles' ) );
            add_action( 'elementor/frontend/after_register_scripts', array( $this, 'register_widget_scripts' ) );
            add_action( 'elementor/preview/enqueue_styles', array( $this, 'register_preview_styles') );
        }

        function register_widgets( $widgets_manager ) {
            require MULTIFOX_PLUS_DIR_PATH. 'modules/shortcodes/elementor/widgets/counter/class-widget-counter.php';
            $widgets_manager->register_widget_type( new \Elementor_Counter() );
        }

        function register_widget_styles() {
            wp_register_style( 'mfx-counter',
                MULTIFOX_PLUS_DIR_URL . 'modules/shortcodes/elementor/widgets/counter/style.css', array(), MULTIFOX_PLUS_VERSION );
        }

        function register_widget_scripts() {
            wp_register_script( 'jquery-animateNumber',
                MULTIFOX_PLUS_DIR_URL . 'modules/shortcodes/elementor/widgets/assets/js/jquery.animateNumber.min.js', array('jquery'), MULTIFOX_PLUS_VERSION, true );
            wp_register_script( 'jquery-inview',
                MULTIFOX_PLUS_DIR_URL . 'modules/shortcodes/elementor/widgets/assets/js/jquery.inview.js', array(), MULTIFOX_PLUS_VERSION, true );
            wp_register_script( 'mfx-counter',
                MULTIFOX_PLUS_DIR_URL . 'modules/shortcodes/elementor/widgets/counter/script.js', array(), MULTIFOX_PLUS_VERSION, true );
        }

        function register_preview_styles() {
            wp_enqueue_style( 'mfx-counter' );
            wp_enqueue_script( 'jquery-animateNumber' );
            wp_enqueue_script( 'jquery-inview' );
            wp_enqueue_script( 'mfx-counter' );
        }
    }
}

MultifoxPlusCounterWidget::instance();