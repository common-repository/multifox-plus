<?php
if ( ! defined( 'ABSPATH' ) ) {
	exit; // Exit if accessed directly.
}

if( !class_exists( 'MultifoxPlusSiteBoxedLayout' ) ) {
    class MultifoxPlusSiteBoxedLayout {

        private static $_instance = null;

        public static function instance() {
            if ( is_null( self::$_instance ) ) {
                self::$_instance = new self();
            }

            return self::$_instance;
        }

        function __construct() {
        	$this->backend();
            $this->frontend();
        }

        function backend() {
            add_filter( 'multifox_site_layouts', array( $this, 'add_boxed_layout_option' ) );
            add_filter( 'multifox_plus_customizer_default', array( $this, 'default' ) );
            add_action( 'multifox_site_layout_cutomizer_options', array( $this, 'register_site_layout' ) );
        }

        function frontend() {
            $enable = multifox_customizer_settings( 'customize_boxed_layout' );
            if( isset( $enable ) && ( $enable == true )  ) {
	            add_filter( 'multifox_add_inline_style', array( $this, 'base_style' ) );
	            add_filter( 'body_class', array( $this, 'body_class' ) );
	        }
        }

        function add_boxed_layout_option( $options ) {
            $options['layout-boxed'] = esc_html__('Boxed', 'multifox-plus');
            return $options;
        }

        function default( $option ) {
            $option['customize_boxed_layout']  = false;
            $option['boxed_layout_background'] = array(
                'background-color'      => 'rgb(0,0,0)',
                'background-repeat'     => 'repeat',
                'background-position'   => 'center center',
                'background-size'       => 'cover',
                'background-attachment' => 'inherit'
            );

            return $option;
        }

        function register_site_layout( $wp_customize ) {

                /**
                 * Option : Customize Site Boxed Layout
                 */
                $wp_customize->add_setting(
                    MULTIFOX_CUSTOMISER_VAL . '[customize_boxed_layout]', array(
                        'type'    => 'option',
                    )
                );

                $wp_customize->add_control(
                    new Multifox_Customize_Control_Switch(
                        $wp_customize, MULTIFOX_CUSTOMISER_VAL . '[customize_boxed_layout]', array(
                            'type'        => 'mfx-switch',
                            'section'     => 'site-layout-main-section',
                            'label'       => esc_html__( 'Customize Boxed Layout?', 'multifox-plus' ),
                            'description' => esc_html__('YES! to customize boxed layout.', 'multifox-plus'),
                            'dependency'  => array( 'site_layout', '==', 'layout-boxed' ),
                            'choices'     => array(
                                'on'  => esc_attr__( 'Yes', 'multifox-plus' ),
                                'off' => esc_attr__( 'No', 'multifox-plus' )
                            )
                        )
                    )
                );

                /**
                 * Option : Boxed Layout BG
                 */
                $wp_customize->add_setting(
                    MULTIFOX_CUSTOMISER_VAL . '[boxed_layout_background]', array(
                        'type'    => 'option',
                    )
                );

                $wp_customize->add_control(
                    new Multifox_Customize_Control_Background(
                        $wp_customize, MULTIFOX_CUSTOMISER_VAL . '[boxed_layout_background]', array(
                            'type'    => 'mfx-background',
                            'section' => 'site-layout-main-section',
                            'label'   => esc_html__( 'Background', 'multifox-plus' ),
                            'dependency' => array( 'site_layout|customize_boxed_layout', '==|==', 'layout-boxed|true' ),
                        )
                    )
                );

        }

        function base_style( $style ) {

            $css    = '';
            $bgoptions = multifox_customizer_settings('boxed_layout_background');

            if( !empty( $bgoptions ) ) {
                $css = !empty( $bgoptions['background-image'] ) ? 'background-image: url("'.esc_url($bgoptions['background-image']).'");':'';
                $css .= !empty( $bgoptions['background-attachment'] ) ? 'background-attachment:'.esc_attr($bgoptions['background-attachment']).';':'';
                $css .= !empty( $bgoptions['background-position'] ) ? 'background-position:'.esc_attr($bgoptions['background-position']).';':'';
                $css .= !empty( $bgoptions['background-size'] ) ? 'background-size:'.esc_attr($bgoptions['background-size']).';':'';
                $css .= !empty( $bgoptions['background-repeat'] ) ? 'background-repeat:'.esc_attr($bgoptions['background-repeat']).';':'';
                $css .= !empty( $bgoptions['background-color'] ) ? 'background-color:'.esc_attr($bgoptions['background-color']).';':'';
            }

            if( !empty( $css ) ) {
                $style .= 'body.layout-boxed {'.multifox_html_output($css).'}'."\n";
            }

            return $style;
        }

        function body_class( $classes ) {

        	$classes[] = 'layout-boxed';
        	return $classes;
        }
    }
}

MultifoxPlusSiteBoxedLayout::instance();