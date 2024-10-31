<?php
if ( ! defined( 'ABSPATH' ) ) {
	exit; // Exit if accessed directly.
}

if( !class_exists( 'MultifoxPlusCustomizerSite404' ) ) {
    class MultifoxPlusCustomizerSite404 {

        private static $_instance = null;

        public static function instance() {
            if ( is_null( self::$_instance ) ) {
                self::$_instance = new self();
            }

            return self::$_instance;
        }

        function __construct() {
            add_action( 'customize_register', array( $this, 'register' ), 15);
        }

        function register( $wp_customize ) {

            /**
             * 404 Page
             */
            $wp_customize->add_section(
                new Multifox_Customize_Section(
                    $wp_customize,
                    'site-404-page-section',
                    array(
                        'title'    => esc_html__('404 Page', 'multifox-plus'),
                        'priority' => multifox_customizer_panel_priority( '404' )
                    )
                )
            );

            if ( ! defined( 'MULTIFOX_PRO_VERSION' ) ) {
                $wp_customize->add_control(
                    new Multifox_Customize_Control_Separator(
                        $wp_customize, MULTIFOX_CUSTOMISER_VAL . '[multifox-plus-site-404-separator]',
                        array(
                            'type'        => 'mfx-separator',
                            'section'     => 'site-404-page-section',
                            'settings'    => array(),
                            'caption'     => MULTIFOX_PLUS_REQ_CAPTION,
                            'description' => MULTIFOX_PLUS_REQ_DESC,
                        )
                    )
                );
            }

        }

    }
}

MultifoxPlusCustomizerSite404::instance();