<?php
if ( ! defined( 'ABSPATH' ) ) {
	exit; // Exit if accessed directly.
}

if( !class_exists( 'MultifoxPlusHeaderIconsWidget' ) ) {
    class MultifoxPlusHeaderIconsWidget {

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

            add_action( 'wp_ajax_yith_wcwl_update_wishlist_count', array( $this, 'yith_wcwl_ajax_update_count' ) );
            add_action( 'wp_ajax_nopriv_yith_wcwl_update_wishlist_count', array( $this, 'yith_wcwl_ajax_update_count' ) );
        }

        function register_widgets( $widgets_manager ) {
            require MULTIFOX_PLUS_DIR_PATH. 'modules/menu/elementor/widgets/header-icons/class-widget-header-icons.php';
            $widgets_manager->register_widget_type( new \Elementor_Header_Icons() );
        }

        function register_widget_styles() {
            wp_register_style( 'mfx-header-icons',
                MULTIFOX_PLUS_DIR_URL . 'modules/menu/elementor/widgets/assets/css/header-icons.css', array(), MULTIFOX_PLUS_VERSION );

            if( function_exists( 'is_woocommerce' ) ) {
                wp_register_style( 'mfx-header-carticons',
                    MULTIFOX_PLUS_DIR_URL . 'modules/menu/elementor/widgets/assets/css/header-carticon.css', array(), MULTIFOX_PLUS_VERSION );
            }
        }

        function register_widget_scripts() {
            wp_register_script( 'jquery-nicescroll',
                MULTIFOX_PLUS_DIR_URL . 'modules/menu/elementor/widgets/assets/js/jquery.nicescroll.js', array(), MULTIFOX_PLUS_VERSION, true );
            wp_register_script( 'mfx-header-icons',
                MULTIFOX_PLUS_DIR_URL . 'modules/menu/elementor/widgets/assets/js/header-icons.js', array(), MULTIFOX_PLUS_VERSION, true );
        }

        function register_preview_styles() {
            wp_enqueue_style( 'mfx-header-icons' );
            wp_enqueue_style( 'mfx-header-carticons' );
            wp_enqueue_script( 'jquery-nicescroll' );
            wp_enqueue_script( 'mfx-header-icons' );
        }

        function yith_wcwl_ajax_update_count() {
            wp_send_json( array(
                'count' => yith_wcwl_count_products()
            ) );
        }
    }
}

MultifoxPlusHeaderIconsWidget::instance();
