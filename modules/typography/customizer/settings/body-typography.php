<?php
if ( ! defined( 'ABSPATH' ) ) {
	exit; // Exit if accessed directly.
}

if( !class_exists( 'MultifoxPlusBodySettings' ) ) {
    class MultifoxPlusBodySettings {

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
            $this->selector = apply_filters( 'multifox_body_selector', array( 'body' ) );
            $this->settings = multifox_customizer_settings('body_typo');

            add_filter( 'multifox_plus_customizer_default', array( $this, 'default' ) );
            add_action( 'customize_register', array( $this, 'register' ), 20);

            add_filter( 'multifox_google_fonts_list', array( $this, 'fonts_list' ) );

            add_filter( 'multifox_body_typo_customizer_update', array( $this, 'body_typo_customizer_update' ) );
            add_filter( 'multifox_body_text_color_css_var', array( $this, 'body_text_color_var' ) );
            add_filter( 'multifox_body_text_rgb_color_css_var', array( $this, 'body_text_rgb_color_var' ) );
            add_filter( 'multifox_headalt_color_css_var', array( $this, 'body_headalt_color_var' ) );
            add_filter( 'multifox_headalt_rgb_color_css_var', array( $this, 'body_headalt_rgb_color_var' ) );
            add_filter( 'multifox_link_color_css_var', array( $this, 'body_link_color_var' ) );
            add_filter( 'multifox_link_rgb_color_css_var', array( $this, 'body_link_rgb_color_var' ) );
            add_filter( 'multifox_link_hover_color_css_var', array( $this, 'body_link_hover_color_var' ) );
            add_filter( 'multifox_link_hover_rgb_color_css_var', array( $this, 'body_link_hover_rgb_color_var' ) );
            add_filter( 'multifox_border_color_css_var', array( $this, 'body_border_color_var' ) );
            add_filter( 'multifox_border_rgb_color_css_var', array( $this, 'body_border_rgb_color_var' ) );
            add_filter( 'multifox_accent_text_color_css_var', array( $this, 'body_accent_text_color_var' ) );
            add_filter( 'multifox_accent_text_rgb_color_css_var', array( $this, 'body_accent_text_rgb_color_var' ) );

            add_filter( 'multifox_add_inline_style', array( $this, 'base_style' ) );
            add_filter( 'multifox_add_tablet_landscape_inline_style', array( $this, 'tablet_landscape_style' ) );
            add_filter( 'multifox_add_tablet_portrait_inline_style', array( $this, 'tablet_portrait' ) );
            add_filter( 'multifox_add_mobile_res_inline_style', array( $this, 'mobile_style' ) );
        }

        function default( $option ) {
            $theme_defaults = function_exists('multifox_theme_defaults') ? multifox_theme_defaults() : array ();
            $option['body_typo'] = $theme_defaults['body_typo'];
            $option['body_content_color'] = $theme_defaults['body_text_color'];
            $option['body_headalt_color'] = $theme_defaults['headalt_color'];
            $option['body_link_color'] = $theme_defaults['link_color'];
            $option['body_link_hover_color'] = $theme_defaults['link_hover_color'];
            $option['body_border_color'] = $theme_defaults['border_color'];
            $option['body_accent_text_color'] = $theme_defaults['accent_text_color'];
            return $option;
        }


        function register( $wp_customize ) {

            $wp_customize->add_section(
                new Multifox_Customize_Section(
                    $wp_customize,
                    'site-body-section',
                    array(
                        'title'    => esc_html__('Body Content Typograpy', 'multifox-plus'),
                        'panel'    => 'site-typograpy-main-panel',
                        'priority' => 35,
                    )
                )
            );

            /**
             * Option :Body Typo
             */
                $wp_customize->add_setting(
                    MULTIFOX_CUSTOMISER_VAL . '[body_typo]', array(
                        'type'    => 'option',
                    )
                );

                $wp_customize->add_control(
                    new Multifox_Customize_Control_Typography(
                        $wp_customize, MULTIFOX_CUSTOMISER_VAL . '[body_typo]', array(
                            'type'    => 'mfx-typography',
                            'section' => 'site-body-section',
                            'label'   => esc_html__( 'Body', 'multifox-plus'),
                        )
                    )
                );

            /**
             * Option : Body Content Color
             */
                $wp_customize->add_setting(
                    MULTIFOX_CUSTOMISER_VAL . '[body_content_color]', array(
                        'default' => '',
                        'type'    => 'option',
                    )
                );

                $wp_customize->add_control(
                    new WP_Customize_Color_Control(
                        $wp_customize, MULTIFOX_CUSTOMISER_VAL . '[body_content_color]', array(
                            'label'   => esc_html__( 'Color', 'multifox-plus' ),
                            'section' => 'site-body-section',
                        )
                    )
                );

            /**
             * Option : Heading Color
             */
                $wp_customize->add_setting(
                    MULTIFOX_CUSTOMISER_VAL . '[body_headalt_color]', array(
                        'default' => '',
                        'type'    => 'option',
                    )
                );

                $wp_customize->add_control(
                    new WP_Customize_Color_Control(
                        $wp_customize, MULTIFOX_CUSTOMISER_VAL . '[body_headalt_color]', array(
                            'label'   => esc_html__( 'Heading Color', 'multifox-plus' ),
                            'section' => 'site-body-section',
                        )
                    )
                );

            /**
             * Option : Body Content Link Color
             */
                $wp_customize->add_setting(
                    MULTIFOX_CUSTOMISER_VAL . '[body_link_color]', array(
                        'default' => '',
                        'type'    => 'option',
                    )
                );

                $wp_customize->add_control(
                    new WP_Customize_Color_Control(
                        $wp_customize, MULTIFOX_CUSTOMISER_VAL . '[body_link_color]', array(
                            'label'   => esc_html__( 'Link Color', 'multifox-plus' ),
                            'section' => 'site-body-section',
                        )
                    )
                );

            /**
             * Option : Body Content Link Hover Color
             */
                $wp_customize->add_setting(
                    MULTIFOX_CUSTOMISER_VAL . '[body_link_hover_color]', array(
                        'default' => '',
                        'type'    => 'option',
                    )
                );

                $wp_customize->add_control(
                    new WP_Customize_Color_Control(
                        $wp_customize, MULTIFOX_CUSTOMISER_VAL . '[body_link_hover_color]', array(
                            'label'   => esc_html__( 'Link Hover Color', 'multifox-plus' ),
                            'section' => 'site-body-section',
                        )
                    )
                );

            /**
             * Option : Body Border Color
             */
                $wp_customize->add_setting(
                    MULTIFOX_CUSTOMISER_VAL . '[body_border_color]', array(
                        'default' => '',
                        'type'    => 'option',
                    )
                );

                $wp_customize->add_control(
                    new WP_Customize_Color_Control(
                        $wp_customize, MULTIFOX_CUSTOMISER_VAL . '[body_border_color]', array(
                            'label'   => esc_html__( 'Border Color', 'multifox-plus' ),
                            'section' => 'site-body-section',
                        )
                    )
                );

            /**
             * Option : Accent Text Color
             */
                $wp_customize->add_setting(
                    MULTIFOX_CUSTOMISER_VAL . '[body_accent_text_color]', array(
                        'default' => '',
                        'type'    => 'option',
                    )
                );

                $wp_customize->add_control(
                    new WP_Customize_Color_Control(
                        $wp_customize, MULTIFOX_CUSTOMISER_VAL . '[body_accent_text_color]', array(
                            'label'   => esc_html__( 'Accent Text Color', 'multifox-plus' ),
                            'section' => 'site-body-section',
                        )
                    )
                );

        }

        function fonts_list( $fonts ) {
            return multifox_customizer_frontend_font( $this->settings, $fonts );
        }

        function body_typo_customizer_update( $defaults ) {
            $body_typo = multifox_customizer_settings( 'body_typo' );
            if( !empty( $body_typo ) ) {
                return  $body_typo;
            }
            return $defaults;
        }

        function body_text_color_var( $var ) {
            $body_content_color = multifox_customizer_settings( 'body_content_color' );
            if( !empty( $body_content_color ) ) {
                $var = '--mfxBodyTxtColor:'.esc_attr($body_content_color).';';
            }

            return $var;
        }

        function body_text_rgb_color_var( $var ) {
            $body_content_color = multifox_customizer_settings( 'body_content_color' );
            if( !empty( $body_content_color ) ) {
                $var = '--mfxBodyTxtColorRgb:'.multifox_hex2rgba($body_content_color, false).';';
            }

            return $var;
        }

        function body_headalt_color_var( $var ) {
            $body_headalt_color = multifox_customizer_settings( 'body_headalt_color' );
            if( !empty( $body_headalt_color ) ) {
                $var = '--mfxHeadAltColor:'.esc_attr($body_headalt_color).';';
            }

            return $var;
        }

        function body_headalt_rgb_color_var( $var ) {
            $body_headalt_color = multifox_customizer_settings( 'body_headalt_color' );
            if( !empty( $body_headalt_color ) ) {
                $var = '--mfxHeadAltColorRgb:'.multifox_hex2rgba($body_headalt_color, false).';';
            }

            return $var;
        }

        function body_link_color_var( $var ) {
            $body_link_color = multifox_customizer_settings( 'body_link_color' );
            if( !empty( $body_link_color ) ) {
                $var = '--mfxLinkColor:'.esc_attr($body_link_color).';';
            }

            return $var;
        }

        function body_link_rgb_color_var( $var ) {
            $body_link_color = multifox_customizer_settings( 'body_link_color' );
            if( !empty( $body_link_color ) ) {
                $var = '--mfxLinkColorRgb:'.multifox_hex2rgba($body_link_color, false).';';
            }

            return $var;
        }

        function body_link_hover_color_var( $var ) {
            $body_link_hover_color = multifox_customizer_settings( 'body_link_hover_color' );
            if( !empty( $body_link_hover_color ) ) {
                $var = '--mfxLinkHoverColor:'.esc_attr($body_link_hover_color).';';
            }

            return $var;
        }

        function body_link_hover_rgb_color_var( $var ) {
            $body_link_hover_color = multifox_customizer_settings( 'body_link_hover_color' );
            if( !empty( $body_link_hover_color ) ) {
                $var = '--mfxLinkHoverColorRgb:'.multifox_hex2rgba($body_link_hover_color, false).';';
            }

            return $var;
        }

        function body_border_color_var( $var ) {
            $body_border_color = multifox_customizer_settings( 'body_border_color' );
            if( !empty( $body_border_color ) ) {
                $var = '--mfxBorderColor:'.esc_attr($body_border_color).';';
            }

            return $var;
        }

        function body_border_rgb_color_var( $var ) {
            $body_border_color = multifox_customizer_settings( 'body_border_color' );
            if( !empty( $body_border_color ) ) {
                $var = '--mfxBorderColorRgb:'.multifox_hex2rgba($body_border_color, false).';';
            }

            return $var;
        }

        function body_accent_text_color_var( $var ) {
            $body_accent_text_color = multifox_customizer_settings( 'body_accent_text_color' );
            if( !empty( $body_accent_text_color ) ) {
                $var = '--mfxAccentTxtColor:'.esc_attr($body_accent_text_color).';';
            }

            return $var;
        }

        function body_accent_text_rgb_color_var( $var ) {
            $body_accent_text_color = multifox_customizer_settings( 'body_accent_text_color' );
            if( !empty( $body_accent_text_color ) ) {
                $var = '--mfxAccentTxtColorRgb:'.multifox_hex2rgba($body_accent_text_color, false).';';
            }

            return $var;
        }

        function base_style( $style ) {
            $css   = '';
            $color = multifox_customizer_settings('body_content_color');

            $css .= multifox_customizer_typography_settings( $this->settings );
            $css .= multifox_customizer_color_settings( $color );

            $css = multifox_customizer_dynamic_style( $this->selector, $css );

            $l_color = multifox_customizer_settings('body_link_color');
            if( !empty( $l_color ) ) {
                $css .= 'a { color:'.esc_attr($l_color).';}'."\n";
            }

            $lh_color = multifox_customizer_settings('body_link_hover_color');
            if( !empty( $lh_color ) ) {
                $css .= 'a:hover { color:'.esc_attr($lh_color).';}'."\n";
            }

            if( isset( $settings['text-decoration'] ) && !empty( $settings['text-decoration'] ) ) {
                $css .= 'body p { text-decoration:'.esc_attr($settings['text-decoration']).';}'."\n";
            }

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

MultifoxPlusBodySettings::instance();