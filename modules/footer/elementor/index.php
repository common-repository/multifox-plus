<?php
if ( ! defined( 'ABSPATH' ) ) {
	exit; // Exit if accessed directly.
}

if( !class_exists( 'MultifoxPlusFooterElementor' ) ) {
    class MultifoxPlusFooterElementor {

        private static $_instance = null;

        public static function instance() {
            if ( is_null( self::$_instance ) ) {
                self::$_instance = new self();
            }

            return self::$_instance;
        }

        function __construct() {
        	$this->frontend();
        }

        function frontend() {
            add_filter( 'multifox_print_footer_template', array( $this, 'register_footer_template' ), 10, 1 );
        }

		function register_footer_template( $id ) {

			$elementor_instance = '';

            if( class_exists( '\Elementor\Plugin' ) ) {
                $elementor_instance = Elementor\Plugin::instance();
            }

            ob_start();

            $page_template = get_post_meta( $id, '_wp_page_template', true );
            if($page_template == 'elementor_header_footer') {
                $class = 'wdt-elementor-container-fluid';
            } else {
                $class = 'container';
            }

            echo '<footer id="footer">';
                echo '<div class="'.esc_attr($class).'">';
                    echo '<div id="footer-'.esc_attr( $id ).'" class="mfx-footer-tpl footer-' .esc_attr( $id ). '">';
                        if( class_exists( '\Elementor\Core\Files\CSS\Post' ) ) {
                            $css_file = new \Elementor\Core\Files\CSS\Post( $id );
                            $css_file->enqueue();

                            echo multifox_html_output($elementor_instance->frontend->get_builder_content_for_display( $id ));
                        } else {
                            $footer = get_post( $id );
                            echo apply_filters( 'the_content', $footer->post_content );
                        }
                    echo '</div>';
                echo '</div>';
            echo '</footer>';

            $content = ob_get_clean();
            return apply_filters( 'multifox_plus_footer_content', $content );
		}
    }
}

MultifoxPlusFooterElementor::instance();