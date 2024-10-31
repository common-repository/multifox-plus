<?php
if ( ! defined( 'ABSPATH' ) ) {
	exit; // Exit if accessed directly.
}

if( !class_exists( 'MultifoxPlusCustomizerSiteLoader' ) ) {
    class MultifoxPlusCustomizerSiteLoader {

        private static $_instance = null;

        public static function instance() {
            if ( is_null( self::$_instance ) ) {
                self::$_instance = new self();
            }

            return self::$_instance;
        }

        function __construct() {
            add_filter( 'multifox_plus_customizer_default', array( $this, 'default' ) );
            add_action( 'multifox_general_cutomizer_options', array( $this, 'register_general' ), 30 );
        }

        function default( $option ) {

            $option['show_site_loader'] = '1';
            $option['site_loader']      = '';
            $option['site_loader_image']      = '';

            return $option;
        }

        function register_general( $wp_customize ) {

            $wp_customize->add_section(
                new Multifox_Customize_Section(
                    $wp_customize,
                    'site-loader-section',
                    array(
                        'title'    => esc_html__('Loader', 'multifox-plus'),
                        'panel'    => 'site-general-main-panel',
                        'priority' => 30,
                    )
                )
            );

                /**
                 * Option : Enable Site Loader
                 */
                $wp_customize->add_setting(
                    MULTIFOX_CUSTOMISER_VAL . '[show_site_loader]', array(
                        'type' => 'option',
                    )
                );

                $wp_customize->add_control(
                    new Multifox_Customize_Control_Switch(
                        $wp_customize, MULTIFOX_CUSTOMISER_VAL . '[show_site_loader]', array(
                            'type'    => 'mfx-switch',
                            'section' => 'site-loader-section',
                            'label'   => esc_html__( 'Enable Loader', 'multifox-plus' ),
                            'choices' => array(
                                'on'  => esc_attr__( 'Yes', 'multifox-plus' ),
                                'off' => esc_attr__( 'No', 'multifox-plus' )
                            )
                        )
                    )
                );

                /**
                 * Option :Site Loader
                 */
                $wp_customize->add_setting(
                    MULTIFOX_CUSTOMISER_VAL . '[site_loader]', array(
                        'type'    => 'option',
                    )
                );

                $wp_customize->add_control(
                    new Multifox_Customize_Control(
                        $wp_customize, MULTIFOX_CUSTOMISER_VAL . '[site_loader]', array(
                            'type'       => 'select',
                            'section'    => 'site-loader-section',
                            'label'      => esc_html__( 'Select Loader', 'multifox-plus' ),
                            'choices'    => apply_filters( 'multifox_loader_layouts', array() ),
                            'dependency' => array( 'show_site_loader', '!=', '' ),
                        )
                    )
                );

                $wp_customize->add_setting(
                    MULTIFOX_CUSTOMISER_VAL . '[site_loader_image]', array(
                        'type'    => 'option',
                    )
                );

                $wp_customize->add_control(
                    new Multifox_Customize_Control_Upload(
                        $wp_customize, MULTIFOX_CUSTOMISER_VAL . '[site_loader_image]', array(
                            'type'       => 'mfx-upload',
                            'section'    => 'site-loader-section',
                            'label'      => esc_html__( 'Upload Loader Image', 'multifox-plus' ),
                            'dependency' => array( 'site_loader|show_site_loader', '==|!=', 'loader-3| ' ),
                        )
                    )
                );
        }

    }
}

MultifoxPlusCustomizerSiteLoader::instance();