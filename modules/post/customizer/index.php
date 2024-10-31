<?php
if ( ! defined( 'ABSPATH' ) ) {
	exit; // Exit if accessed directly.
}

if( !class_exists( 'MultifoxPlusCustomizerBlogPost' ) ) {
    class MultifoxPlusCustomizerBlogPost {

        private static $_instance = null;

        public static function instance() {
            if ( is_null( self::$_instance ) ) {
                self::$_instance = new self();
            }

            return self::$_instance;
        }

        function __construct() {
			add_action( 'customize_register', array( $this, 'register' ), 15 );
        }

        function register( $wp_customize ) {

            $wp_customize->add_section(
                new Multifox_Customize_Section(
                    $wp_customize,
                    'site-blog-post-section',
                    array(
                        'title'    => esc_html__('Single Post', 'multifox-plus'),
                        'panel'    => 'site-blog-main-panel',
                        'priority' => 20,
                    )
                )
            );

			if ( ! defined( 'MULTIFOX_PRO_VERSION' ) ) {
				$wp_customize->add_control(
					new Multifox_Customize_Control_Separator(
						$wp_customize, MULTIFOX_CUSTOMISER_VAL . '[multifox-plus-site-single-blog-separator]',
						array(
							'type'        => 'mfx-separator',
							'section'     => 'site-blog-post-section',
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

MultifoxPlusCustomizerBlogPost::instance();