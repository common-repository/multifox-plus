<?php
if ( ! defined( 'ABSPATH' ) ) {
	exit; // Exit if accessed directly.
}

if( !class_exists( 'MultifoxPlusSiteLoader' ) ) {
    class MultifoxPlusSiteLoader {

        private static $_instance = null;

        public static function instance() {
            if ( is_null( self::$_instance ) ) {
                self::$_instance = new self();
            }

            return self::$_instance;
        }

        function __construct() {
            $this->load_loader_layouts();
            $this->load_modules();

            $this->frontend();
        }

        function load_loader_layouts() {
            foreach( glob( MULTIFOX_PLUS_DIR_PATH. 'modules/site-loader/layouts/*/index.php'  ) as $module ) {
                include_once $module;
            }
        }

        function load_modules() {
            include_once MULTIFOX_PLUS_DIR_PATH.'modules/site-loader/customizer/index.php';
        }

        function frontend() {
            $show_site_loader = multifox_customizer_settings( 'show_site_loader' );
            if( $show_site_loader ) {
                add_filter( 'body_class', array( $this, 'add_body_classes' ) );
                add_action( 'multifox_after_main_css', array( $this, 'enqueue_assets' ) );
                add_action( 'multifox_hook_top', array( $this, 'load_template' ) );
            }
        }

        function add_body_classes( $classes ) {
            if(!function_exists( 'is_woocommerce' ) || (function_exists( 'is_woocommerce' ) && !is_cart() && !is_checkout())) {
                $classes[] = 'has-page-loader';
            }
            return $classes;
        }

        function enqueue_assets() {
             if(!function_exists( 'is_woocommerce' ) || (function_exists( 'is_woocommerce' ) && !is_cart() && !is_checkout())) {
                $site_loader = multifox_customizer_settings( 'site_loader' );
                if($site_loader != '') {
                    wp_enqueue_script( 'pace', MULTIFOX_PLUS_DIR_URL . 'modules/site-loader/assets/js/pace.min.js', array('jquery'), MULTIFOX_PLUS_VERSION, true );
                    wp_localize_script('pace', 'paceOptions', array(
                        'restartOnRequestAfter' => 'false',
                        'restartOnPushState'    => 'false'
                    ) );

                    wp_enqueue_script( 'site-loader', MULTIFOX_PLUS_DIR_URL . 'modules/site-loader/assets/js/site-loader.js', array('pace'), MULTIFOX_PLUS_VERSION, true );
                }
            }
        }

        function load_template() {
             if(!function_exists( 'is_woocommerce' ) || (function_exists( 'is_woocommerce' ) && !is_cart() && !is_checkout())) {
                $site_loader = multifox_customizer_settings( 'site_loader' );
                if($site_loader != '') {
                    echo multifox_get_template_part( 'site-loader/layouts/'.esc_attr($site_loader), '/template', '', array() );
                }
            }
        }

    }
}

MultifoxPlusSiteLoader::instance();
