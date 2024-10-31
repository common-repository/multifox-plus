<?php
if ( ! defined( 'ABSPATH' ) ) {
	exit; // Exit if accessed directly.
}

if( !class_exists( 'MultifoxPlusH6Settings' ) ) {
    class MultifoxPlusH6Settings {

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
            $this->selector = apply_filters( 'multifox_h6_selector', array( 'h6' ) );
            $this->settings = multifox_customizer_settings('h6_typo');

            add_filter( 'multifox_plus_customizer_default', array( $this, 'default' ) );
            add_action( 'customize_register', array( $this, 'register' ), 20);

            add_filter( 'multifox_h6_typo_customizer_update', array( $this, 'h6_typo_customizer_update' ) );

            add_filter( 'multifox_google_fonts_list', array( $this, 'fonts_list' ) );
            add_filter( 'multifox_add_inline_style', array( $this, 'base_style' ) );
            add_filter( 'multifox_add_tablet_landscape_inline_style', array( $this, 'tablet_landscape_style' ) );
            add_filter( 'multifox_add_tablet_portrait_inline_style', array( $this, 'tablet_portrait' ) );
            add_filter( 'multifox_add_mobile_res_inline_style', array( $this, 'mobile_style' ) );
        }

        function default( $option ) {
            $theme_defaults = function_exists('multifox_theme_defaults') ? multifox_theme_defaults() : array ();
            $option['h6_typo'] = $theme_defaults['h6_typo'];
            return $option;
        }

        function register( $wp_customize ) {

            $wp_customize->add_section(
                new Multifox_Customize_Section(
                    $wp_customize,
                    'site-h6-section',
                    array(
                        'title'    => esc_html__('H6 Typograpy', 'multifox-plus'),
                        'panel'    => 'site-typograpy-main-panel',
                        'priority' => 30,
                    )
                )
            );

            /**
             * Option :H6 Typo
             */
                $wp_customize->add_setting(
                    MULTIFOX_CUSTOMISER_VAL . '[h6_typo]', array(
                        'type'    => 'option',
                    )
                );

                $wp_customize->add_control(
                    new Multifox_Customize_Control_Typography(
                        $wp_customize, MULTIFOX_CUSTOMISER_VAL . '[h6_typo]', array(
                            'type'    => 'mfx-typography',
                            'section' => 'site-h6-section',
                            'label'   => esc_html__( 'H6 Tag', 'multifox-plus'),
                        )
                    )
                );

            /**
             * Option : H6 Color
             */
                $wp_customize->add_setting(
                    MULTIFOX_CUSTOMISER_VAL . '[h6_color]', array(
                        'default' => '',
                        'type'    => 'option',
                    )
                );

                $wp_customize->add_control(
                    new WP_Customize_Color_Control(
                        $wp_customize, MULTIFOX_CUSTOMISER_VAL . '[h6_color]', array(
                            'label'   => esc_html__( 'Color', 'multifox-plus' ),
                            'section' => 'site-h6-section',
                        )
                    )
                );

        }

        function h6_typo_customizer_update( $defaults ) {
            $h6_typo = multifox_customizer_settings( 'h6_typo' );
            if( !empty( $h6_typo ) ) {
                return  $h6_typo;
            }
            return $defaults;
        }

        function fonts_list( $fonts ) {
            return multifox_customizer_frontend_font( $this->settings, $fonts );
        }

        function base_style( $style ) {
            $css   = '';
            $color = multifox_customizer_settings('h6_color');

            $css .= multifox_customizer_typography_settings( $this->settings );
            $css .= multifox_customizer_color_settings( $color );

            $css = multifox_customizer_dynamic_style( $this->selector, $css );

            return $style.$css;
        }

        function tablet_landscape_style( $style ) {
            $css = multifox_customizer_responsive_typography_settings( $this->settings, 'tablet-ls' );
            $css = multifox_customizer_dynamic_style( $this->selector, $css );

            return $style.$css;
        }

        function tablet_portrait( $style ) {
            $css = multifox_customizer_responsive_typography_settings( $this->settings, 'tablet' );
            $css = multifox_customizer_dynamic_style( $this->selector, $css );

            return $style.$css;
        }

        function mobile_style( $style ) {
            $css = multifox_customizer_responsive_typography_settings( $this->settings, 'mobile' );
            $css = multifox_customizer_dynamic_style( $this->selector, $css );

            return $style.$css;
        }
    }
}

MultifoxPlusH6Settings::instance();