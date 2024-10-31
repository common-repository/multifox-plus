<?php
if ( ! defined( 'ABSPATH' ) ) {
	exit; // Exit if accessed directly.
}

if (! class_exists ( 'MultifoxPlusFooterPostType' ) ) {

	class MultifoxPlusFooterPostType {

        private static $_instance = null;

        public static function instance() {
            if ( is_null( self::$_instance ) ) {
                self::$_instance = new self();
            }

            return self::$_instance;
        }

		function __construct() {

			add_action ( 'init', array( $this, 'multifox_register_cpt' ) );
			add_filter ( 'template_include', array ( $this, 'multifox_template_include' ) );
		}

		function multifox_register_cpt() {

			$labels = array (
				'name'				 => __( 'Footers', 'multifox-plus' ),
				'singular_name'		 => __( 'Footer', 'multifox-plus' ),
				'menu_name'			 => __( 'Footers', 'multifox-plus' ),
				'add_new'			 => __( 'Add Footer', 'multifox-plus' ),
				'add_new_item'		 => __( 'Add New Footer', 'multifox-plus' ),
				'edit'				 => __( 'Edit Footer', 'multifox-plus' ),
				'edit_item'			 => __( 'Edit Footer', 'multifox-plus' ),
				'new_item'			 => __( 'New Footer', 'multifox-plus' ),
				'view'				 => __( 'View Footer', 'multifox-plus' ),
				'view_item' 		 => __( 'View Footer', 'multifox-plus' ),
				'search_items' 		 => __( 'Search Footers', 'multifox-plus' ),
				'not_found' 		 => __( 'No Footers found', 'multifox-plus' ),
				'not_found_in_trash' => __( 'No Footers found in Trash', 'multifox-plus' ),
			);

			$args = array (
				'labels' 				=> $labels,
				'public' 				=> true,
				'exclude_from_search'	=> true,
				'show_in_nav_menus' 	=> false,
				'show_in_rest' 			=> true,
				'menu_position'			=> 26,
				'menu_icon' 			=> 'dashicons-editor-insertmore',
				'hierarchical' 			=> false,
				'supports' 				=> array ( 'title', 'editor', 'revisions' ),
			);

			register_post_type ( 'mfx_footers', $args );
		}

		function multifox_template_include($template) {
			if ( is_singular( 'mfx_footers' ) ) {
				if ( ! file_exists ( get_stylesheet_directory () . '/single-mfx_footers.php' ) ) {
					$template = MULTIFOX_PLUS_DIR_PATH . 'post-types/templates/single-mfx_footers.php';
				}
			}

			return $template;
		}
	}
}

MultifoxPlusFooterPostType::instance();