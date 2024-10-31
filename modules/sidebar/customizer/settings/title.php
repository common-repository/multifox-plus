<?php
if ( ! defined( 'ABSPATH' ) ) {
	exit; // Exit if accessed directly.
}

if( !class_exists( 'MultifoxPlusWidgetTitleSettings' ) ) {
    class MultifoxPlusWidgetTitleSettings {

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

        function register( $wp_customize ){

            /**
             * Title Section
             */
            $wp_customize->add_section(
                new Multifox_Customize_Section(
                    $wp_customize,
                    'site-widgets-title-style-section',
                    array(
                        'title'    => esc_html__('Widget Title', 'multifox-plus'),
                        'panel'    => 'site-widget-settings-panel',
                        'priority' => 5,
                    )
                )
            );

            if ( ! defined( 'MULTIFOX_PRO_VERSION' ) ) {
                $wp_customize->add_control(
                    new Multifox_Customize_Control_Separator(
                        $wp_customize, MULTIFOX_CUSTOMISER_VAL . '[multifox-plus-site-sidebar-title-separator]',
                        array(
                            'type'        => 'mfx-separator',
                            'section'     => 'site-widgets-title-style-section',
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

MultifoxPlusWidgetTitleSettings::instance();