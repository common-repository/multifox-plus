<?php
if ( ! defined( 'ABSPATH' ) ) {
    exit; // Exit if accessed directly.
}

if( !class_exists( 'MultifoxPlusSidebar' ) ) {
    class MultifoxPlusSidebar {

        private static $_instance = null;
        private $global_layout  = '';
        private $hide_standard_sidebar   = '';

        public static function instance() {
            if ( is_null( self::$_instance ) ) {
                self::$_instance = new self();
            }

            return self::$_instance;
        }

        function __construct() {

            $this->global_layout  = multifox_customizer_settings('global_sidebar_layout');
            $this->hide_standard_sidebar = multifox_customizer_settings('hide_standard_sidebar');

            if($this->hide_standard_sidebar) {
                $this->global_layout = 'content-full-width';
            }

            $this->load_modules();
            $this->frontend();

        }

        function load_modules() {
            include_once MULTIFOX_PLUS_DIR_PATH.'modules/sidebar/customizer/index.php';
        }

        function frontend() {
            add_filter('multifox_primary_classes', array( $this, 'primary_classes' ), 10 );
            add_filter('multifox_secondary_classes', array( $this, 'secondary_classes' ), 10 );
        }

        function primary_classes( $primary_class ) {

            $primary_class = $this->global_layout;

            if( $primary_class == 'with-left-sidebar' ) {
                $primary_class = 'page-with-sidebar with-left-sidebar';
            } elseif( $primary_class == 'with-right-sidebar' ) {
                $primary_class = 'page-with-sidebar with-right-sidebar';
            }

            return $primary_class;

        }

        function secondary_classes( $secondary_class ) {

            $secondary_class = $this->global_layout;

            if( $secondary_class == 'with-left-sidebar' ) {
                $secondary_class = 'secondary-sidebar secondary-has-left-sidebar';
            } elseif( $secondary_class == 'with-right-sidebar' ) {
                $secondary_class = 'secondary-sidebar secondary-has-right-sidebar';
            }

            return $secondary_class;

        }

    }
}

MultifoxPlusSidebar::instance();