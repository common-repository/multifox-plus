<?php
if ( ! defined( 'ABSPATH' ) ) {
	exit; // Exit if accessed directly.
}

if( !class_exists( 'MultifoxPlusGoogleMapWidget' ) ) {
    class MultifoxPlusGoogleMapWidget {

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
            require MULTIFOX_PLUS_DIR_PATH. 'modules/shortcodes/elementor/widgets/google-map/class-widget-google-map.php';
            $widgets_manager->register_widget_type( new \Elementor_Google_Map() );
        }

        function register_widget_styles() {
            wp_register_style( 'mfx-google-map',
                MULTIFOX_PLUS_DIR_URL . 'modules/shortcodes/elementor/widgets/google-map/style.css', array(), MULTIFOX_PLUS_VERSION );
        }

        function register_widget_scripts() {
            $gmap_api_key = get_option( 'elementor_multifox_google_map_api_key' );
            $gmap_api_key = ( isset( $gmap_api_key ) && $gmap_api_key != '' ) ? $gmap_api_key : '';

            $gmap_api_url = 'https://maps.googleapis.com/maps/api/js';
            if( !empty( $gmap_api_key ) ) {
                $gmap_api_url = add_query_arg( array( 'key' => $gmap_api_key ) , $gmap_api_url );
            }

            wp_register_script( 'google-map', $gmap_api_url, array('jquery'), MULTIFOX_PLUS_VERSION, true );
            wp_register_script( 'mfx-google-map',
                MULTIFOX_PLUS_DIR_URL . 'modules/shortcodes/elementor/widgets/google-map/script.js', array(), MULTIFOX_PLUS_VERSION, true );
        }

        function register_preview_styles() {
            wp_enqueue_style( 'mfx-google-map' );
            wp_enqueue_script( 'google-map' );
            wp_enqueue_script( 'mfx-google-map' );
        }
    }
}

MultifoxPlusGoogleMapWidget::instance();