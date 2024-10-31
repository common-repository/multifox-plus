<?php
if ( ! defined( 'ABSPATH' ) ) {
	exit; // Exit if accessed directly.
}

if( !class_exists( 'MultifoxPlusBreadCrumbTypo' ) ) {
    class MultifoxPlusBreadCrumbTypo {

        private static $_instance = null;
        private $settings         = null;
        private $selector         = null;

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
            $wp_customize->add_section(
                new Multifox_Customize_Section(
                    $wp_customize,
                    'site-breadcrumb-typo-section',
                    array(
                        'title'    => esc_html__('Typograpy', 'multifox-plus'),
                        'panel'    => 'site-breadcrumb-main-panel',
                        'priority' => 15,
                    )
                )
            );

                if ( ! defined( 'MULTIFOX_PRO_VERSION' ) ) {
                    $wp_customize->add_control(
                        new Multifox_Customize_Control_Separator(
                            $wp_customize, MULTIFOX_CUSTOMISER_VAL . '[multifox-plus-site-breadcrumb-typo-separator]',
                            array(
                                'type'        => 'mfx-separator',
                                'section'     => 'site-breadcrumb-typo-section',
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

MultifoxPlusBreadCrumbTypo::instance();