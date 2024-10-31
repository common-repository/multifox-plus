<?php
if ( ! defined( 'ABSPATH' ) ) {
	exit; // Exit if accessed directly.
}

use Elementor\Settings;

if( !class_exists( 'MultifoxPlusShortcodesElementor' ) ) {
    class MultifoxPlusShortcodesElementor {

        private static $_instance = null;

        const MINIMUM_ELEMENTOR_VERSION = '3.0.0';

        const MINIMUM_PHP_VERSION = '7.2';

        public static function instance() {
            if ( is_null( self::$_instance ) ) {
                self::$_instance = new self();
            }

            return self::$_instance;
        }

        function __construct() {
            add_action( 'plugins_loaded', array( $this, 'register_init' ) );
        }

        function register_init() {
            if ( ! did_action( 'elementor/loaded' ) ) {
                return;
            }

            if ( ! version_compare( ELEMENTOR_VERSION, self::MINIMUM_ELEMENTOR_VERSION, '>=' ) ) {
                add_action( 'admin_notices', array( $this, 'minimum_elementor_version' ) );
                return;
            }

            if ( version_compare( PHP_VERSION, self::MINIMUM_PHP_VERSION, '<' ) ) {
                add_action( 'admin_notices', array( $this, 'minimum_php_version' ) );
                return;
            }

            add_action( 'elementor/elements/categories_registered', array( $this, 'register_category' ) );
            add_action( 'elementor/admin/after_create_settings/' . Settings::PAGE_ID, array( $this, 'register_multifox_tab' ) );
            add_action( 'elementor/admin/after_create_settings/' . Settings::PAGE_ID, array( $this, 'register_multifox_fields' ) );

            $this->load_modules();
        }

        function load_modules() {
            foreach( glob( MULTIFOX_PLUS_DIR_PATH. 'modules/shortcodes/elementor/widgets/*/index.php'  ) as $module ) {
                include_once $module;
            }
        }

        function minimum_elementor_version() {

            if(isset($_GET['activate'])) {
                $activate =  multifox_sanitization($_GET['activate']);
                if ( isset( $activate ) ) {
                    unset( $activate );
                }
            }

            $message = sprintf(
                /* translators: 1: Plugin name 2: Elementor 3: Required Elementor version */
                esc_html__( '"%1$s" recommends "%2$s" version %3$s or greater.', 'multifox-plus' ),
                '<strong>' . esc_html__( 'Multifox Plus Plugin', 'multifox-plus' ) . '</strong>',
                '<strong>' . esc_html__( 'Elementor', 'multifox-plus' ) . '</strong>',
                 self::MINIMUM_ELEMENTOR_VERSION
            );

            printf( '<div class="notice notice-info is-dismissible"><p>%1$s</p></div>', $message );
        }

        function minimum_php_version() {

            if(isset($_GET['activate'])) {
                $activate =  multifox_sanitization($_GET['activate']);
                if ( isset( $activate ) ) {
                    unset( $activate );
                }
            }

            $message = sprintf(
                /* translators: 1: Plugin name 2: PHP 3: Required PHP version */
                esc_html__( '"%1$s" recommends "%2$s" version %3$s or greater.', 'multifox-plus' ),
                '<strong>' . esc_html__( 'Multifox Plus Plugin', 'multifox-plus' ) . '</strong>',
                '<strong>' . esc_html__( 'PHP', 'multifox-plus' ) . '</strong>',
                 self::MINIMUM_PHP_VERSION
            );

            printf( '<div class="notice notice-info is-dismissible"><p>%1$s</p></div>', $message );
        }

        function register_category( $elements_manager ) {
            $elements_manager->add_category(
                'multifox-widgets', array(
                    'title' => esc_html__( 'Multifox', 'multifox-plus' ),
                    'icon'  => 'font'
                )
            );
        }

        function register_multifox_tab( Settings $settings ) {
            $settings->add_tab('multifox', array(
                'label' => esc_html__( 'Multifox', 'multifox-plus' ),
                'sections' => array(

                    'multifox_google_map_section' => array(
                        'label' => esc_html__( 'Google Map', 'multifox-plus' )
                    ),

                    'multifox_instagram_section' => array(
                        'label'    => esc_html__( 'Instagram', 'multifox-plus' ),
                        'callback' => function(){
                            echo sprintf( esc_html__( 'You can create your instagram application settings %1$s', 'multifox-plus' ), '<a href="https://developers.facebook.com/docs/instagram-basic-display-api/getting-started" target="_blank">'.esc_html__( 'here.', 'multifox-plus' ).'</a>' );
                        }
                    ),

                    'multifox_mailchimp_section' => array(
                        'label' => esc_html__( 'Mailchimp', 'multifox-plus' )
                    )
                )
            ) );
        }

        function register_multifox_fields( Settings $settings ) {

            $settings->add_field( 'multifox', 'multifox_google_map_section','multifox_google_map_api_key', array(
                'label'      => esc_html__('API Key', 'multifox-plus' ),
                'field_args' => array(
                    'type' => 'text',
                    'desc' => sprintf(
                        esc_html__('Please set Google maps API key before using Google Map widget. You can create own API key %1$s.','multifox-plus'),
                        '<a target="_blank" href="https://developers.google.com/maps/documentation/javascript/get-api-key">' . esc_html__( 'here', 'multifox-elements' ) . '</a>'
                    )
                )
            ) );

            $settings->add_field( 'multifox', 'multifox_instagram_section', 'multifox_instagram_app_id', array(
                'label'      => esc_html__('Instagram App ID','multifox-plus'),
                'field_args' => array(
                    'type' => 'text',
                )
            ) );

            $settings->add_field( 'multifox', 'multifox_instagram_section', 'multifox_instagram_app_secret', array(
                'label'      => esc_html__('Instagram App Secret','multifox-plus'),
                'field_args' => array(
                    'type' => 'text',
                )
            ) );

            $settings->add_field( 'multifox', 'multifox_instagram_section', 'multifox_instagram_app_access_token', array(
                'label'      => esc_html__('Instagram App Access Token','multifox-plus'),
                'field_args' => array(
                    'type' => 'text',
                )
            ) );

            $settings->add_field( 'multifox', 'multifox_mailchimp_section','multifox_mailchimp_api_key', array(
                'label'      => esc_html__('API Key', 'multifox-plus' ),
                'field_args' => array(
                    'type' => 'text',
                    'desc' => esc_html__('Please set Mailchimp API key before using Mailchimp widget.','multifox-plus'),
                )
            ) );
        }
    }
}

MultifoxPlusShortcodesElementor::instance();