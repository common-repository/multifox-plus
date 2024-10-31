<?php
if ( ! defined( 'ABSPATH' ) ) {
	exit; // Exit if accessed directly.
}

if( !class_exists( 'MultifoxPlusSkinPrimayColor' ) ) {
    class MultifoxPlusSkinPrimayColor {
        private static $_instance = null;

        public static function instance() {
            if ( is_null( self::$_instance ) ) {
                self::$_instance = new self();
            }

            return self::$_instance;
        }

        function __construct() {
            add_filter( 'multifox_plus_customizer_default', array( $this, 'default' ) );
            add_action( 'customize_register', array( $this, 'register' ), 15);

            add_filter( 'multifox_primary_color_css_var', array( $this, 'primary_color_var' ) );
            add_filter( 'multifox_primary_rgb_color_css_var', array( $this, 'primary_rgb_color_var' ) );
            add_filter( 'multifox_add_inline_style', array( $this, 'base_style' ) );
        }

        function default( $option ) {
            $theme_defaults = function_exists('multifox_theme_defaults') ? multifox_theme_defaults() : array ();
            $option['primary_color'] = $theme_defaults['primary_color'];
            return $option;
        }

        function register( $wp_customize ) {

            /**
             * Option : Primary Color
             */
            $wp_customize->add_setting(
                MULTIFOX_CUSTOMISER_VAL . '[primary_color]', array(
                    'type'    => 'option',
                )
            );

            $wp_customize->add_control(
                new Multifox_Customize_Control_Color(
                    $wp_customize, MULTIFOX_CUSTOMISER_VAL . '[primary_color]', array(
                        'section' => 'site-skin-main-section',
                        'label'   => esc_html__( 'Primary Color', 'multifox-plus' ),
                    )
                )
            );
        }

        function primary_color_var( $var ) {
            $primary_color = multifox_customizer_settings( 'primary_color' );
            if( !empty( $primary_color ) ) {
                $var = '--mfxPrimaryColor:'.esc_attr($primary_color).';';
            }

            return $var;
        }

        function primary_rgb_color_var( $var ) {
            $primary_color = multifox_customizer_settings( 'primary_color' );
            if( !empty( $primary_color ) ) {
                $var = '--mfxPrimaryColorRgb:'.multifox_hex2rgba($primary_color, false).';';
            }

            return $var;
        }

        function base_style( $style ) {
            $style = apply_filters( 'multifox_primary_color_style', $style );
            return $style;
        }
    }
}

MultifoxPlusSkinPrimayColor::instance();