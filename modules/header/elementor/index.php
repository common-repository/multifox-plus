<?php
if ( ! defined( 'ABSPATH' ) ) {
	exit; // Exit if accessed directly.
}

if( !class_exists( 'MultifoxPlusHeaderElementor' ) ) {
    class MultifoxPlusHeaderElementor {

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
            add_filter( 'multifox_print_header_template', array( $this, 'register_header_template' ), 10, 1 );
        }

		function register_header_template( $id ) {

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
            echo '<div class="'.esc_attr($class).'">';

                echo '<div id="header-'.esc_attr( $id ).'" class="mfx-header-tpl header-' .esc_attr( $id ). '">';

                    if( class_exists( '\Elementor\Core\Files\CSS\Post' ) ) {
                        $css_file = new \Elementor\Core\Files\CSS\Post( $id );
                        $css_file->enqueue();

                        echo multifox_html_output($elementor_instance->frontend->get_builder_content_for_display( $id ));
                    } else {
                        $header = get_post( $id );
                        echo apply_filters( 'the_content', $header->post_content );
                    }

                echo '</div>';
                
            echo '</div>';

            $content = ob_get_clean();
            return apply_filters( 'multifox_plus_header_content', $content );
		}
    }
}

MultifoxPlusHeaderElementor::instance();