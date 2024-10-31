<?php
if ( ! defined( 'ABSPATH' ) ) {
	exit; // Exit if accessed directly.
}

if( !class_exists( 'MultifoxPlusDemoContent' ) ) {
    class MultifoxPlusDemoContent {

        private static $_instance = null;

        public static function instance() {
            if ( is_null( self::$_instance ) ) {
                self::$_instance = new self();
            }

            return self::$_instance;
        }

        function __construct() {
            add_filter('fw:ext:backups-demo:demos', array( $this, 'fw_ext_backups_demos' ), 10);
        }

        function fw_ext_backups_demos($demos) {
            $free_demos = array(
                'default-lite' => array(
                    'title' => esc_html__('Default', 'multifox-plus'),
                    'screenshot' => MULTIFOX_PLUS_DIR_URL.'/modules/demo-content/screenshots/default-lite.png',
                    'preview_link' => 'https://multifoxtheme.com/lite'
                ),
                'gardening-lite' => array(
                    'title' => esc_html__('Gardening Lite', 'multifox-plus'),
                    'screenshot' => MULTIFOX_PLUS_DIR_URL.'/modules/demo-content/screenshots/gardening-lite.png',
                    'preview_link' => 'https://multifoxtheme.com/gardening-lite/'
                ),
                'krearc-lite' => array(
                    'title' => esc_html__('Krearc Lite', 'multifox-plus'),
                    'screenshot' => MULTIFOX_PLUS_DIR_URL.'/modules/demo-content/screenshots/krearc-lite.png',
                    'preview_link' => 'https://multifoxtheme.com/krearc-lite/'
                ),
                'skincare-lite' => array(
                    'title' => esc_html__('Skin Care Lite', 'multifox-plus'),
                    'screenshot' => MULTIFOX_PLUS_DIR_URL.'/modules/demo-content/screenshots/skincare-lite.png',
                    'preview_link' => 'https://multifoxtheme.com/skincare-lite/'
                ),
                'elsa-lite' => array(
                    'title' => esc_html__('Elsa Lite', 'multifox-plus'),
                    'screenshot' => MULTIFOX_PLUS_DIR_URL.'/modules/demo-content/screenshots/elsa-lite.png',
                    'preview_link' => 'https://multifoxtheme.com/elsa-lite/'
                ),
                'fredie-lite' => array(
                    'title' => esc_html__('Fredie Lite', 'multifox-plus'),
                    'screenshot' => MULTIFOX_PLUS_DIR_URL.'/modules/demo-content/screenshots/fredie-lite.png',
                    'preview_link' => 'https://multifoxtheme.com/fredie-lite/'
                ),
                'fason-lite' => array(
                    'title' => esc_html__('Fason Lite', 'multifox-plus'),
                    'screenshot' => MULTIFOX_PLUS_DIR_URL.'/modules/demo-content/screenshots/fason-lite.png',
                    'preview_link' => 'https://multifoxtheme.com/fason-lite/'
                ),
                'taxi-lite' => array(
                    'title' => esc_html__('Taxi Lite', 'multifox-plus'),
                    'screenshot' => MULTIFOX_PLUS_DIR_URL.'/modules/demo-content/screenshots/taxi-lite.png',
                    'preview_link' => 'https://multifoxtheme.com/taxi-lite/'
                ),
                'symba-lite' => array(
                    'title' => esc_html__('Symba Lite', 'multifox-plus'),
                    'screenshot' => MULTIFOX_PLUS_DIR_URL.'/modules/demo-content/screenshots/symba-lite.png',
                    'preview_link' => 'https://multifoxtheme.com/symba-lite/'
                )
            );

            $download_url = 'https://multifoxtheme.com/demo-content/index.php';

            foreach ($free_demos as $id => $data) {
                $demo = new FW_Ext_Backups_Demo($id, 'piecemeal', array(
                    'url' => $download_url,
                    'file_id' => $id,
                ));
                $demo->set_title($data['title']);
                $demo->set_screenshot($data['screenshot']);
                $demo->set_preview_link($data['preview_link']);

                $demos[ $demo->get_id() ] = $demo;

                unset($demo);
            }

            return $demos;
        }

    }
}

MultifoxPlusDemoContent::instance();