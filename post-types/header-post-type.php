<?php
if ( ! defined( 'ABSPATH' ) ) {
	exit; // Exit if accessed directly.
}

if (! class_exists ( 'MultifoxPlusHeaderPostType' ) ) {

	class MultifoxPlusHeaderPostType {

        private static $_instance = null;

        public static function instance() {
            if ( is_null( self::$_instance ) ) {
                self::$_instance = new self();
            }

            return self::$_instance;
        }

		function __construct() {

			add_action ( 'init', array( $this, 'multifox_register_cpt' ), 5 );
			add_filter ( 'template_include', array ( $this, 'multifox_template_include' ) );
		}

		function multifox_register_cpt() {

			$labels = array (
				'name'				 => __( 'Headers', 'multifox-plus' ),
				'singular_name'		 => __( 'Header', 'multifox-plus' ),
				'menu_name'			 => __( 'Headers', 'multifox-plus' ),
				'add_new'			 => __( 'Add Header', 'multifox-plus' ),
				'add_new_item'		 => __( 'Add New Header', 'multifox-plus' ),
				'edit'				 => __( 'Edit Header', 'multifox-plus' ),
				'edit_item'			 => __( 'Edit Header', 'multifox-plus' ),
				'new_item'			 => __( 'New Header', 'multifox-plus' ),
				'view'				 => __( 'View Header', 'multifox-plus' ),
				'view_item' 		 => __( 'View Header', 'multifox-plus' ),
				'search_items' 		 => __( 'Search Headers', 'multifox-plus' ),
				'not_found' 		 => __( 'No Headers found', 'multifox-plus' ),
				'not_found_in_trash' => __( 'No Headers found in Trash', 'multifox-plus' ),
			);

			$args = array (
				'labels' 				=> $labels,
				'public' 				=> true,
				'exclude_from_search'	=> true,
				'show_in_nav_menus' 	=> false,
				'show_in_rest' 			=> true,
				'menu_position'			=> 25,
				'menu_icon' 			=> 'dashicons-heading',
				'hierarchical' 			=> false,
				'supports' 				=> array ( 'title', 'editor', 'revisions' ),
			);

			register_post_type ( 'mfx_headers', $args );
		}

		function multifox_template_include($template) {
			if ( is_singular( 'mfx_headers' ) ) {
				if ( ! file_exists ( get_stylesheet_directory () . '/single-mfx_headers.php' ) ) {
					$template = MULTIFOX_PLUS_DIR_PATH . 'post-types/templates/single-mfx_headers.php';
				}
			}

			return $template;
		}
	}
}

MultifoxPlusHeaderPostType::instance();