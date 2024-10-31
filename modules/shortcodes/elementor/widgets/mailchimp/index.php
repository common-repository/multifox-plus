<?php
if ( ! defined( 'ABSPATH' ) ) {
	exit; // Exit if accessed directly.
}

if( !class_exists( 'MultifoxPlusMailchimpWidget' ) ) {
    class MultifoxPlusMailchimpWidget {

        private static $_instance = null;

        public static function instance() {
            if ( is_null( self::$_instance ) ) {
                self::$_instance = new self();
            }

            return self::$_instance;
        }

        function __construct() {
            add_action( 'elementor/widgets/widgets_registered', array( $this, 'register_widgets' ) );
            add_action( 'elementor/frontend/after_register_styles', array( $this, 'register_widget_styles' ) );
            add_action( 'elementor/frontend/after_register_scripts', array( $this, 'register_widget_scripts' ) );
            add_action( 'elementor/preview/enqueue_styles', array( $this, 'register_preview_styles') );

            add_action( 'wp_ajax_multifox_mailchimp_subscribe', array( $this, 'multifox_mailchimp_subscribe' ) );
            add_action( 'wp_ajax_nopriv_multifox_mailchimp_subscribe', array( $this, 'multifox_mailchimp_subscribe' ) );
        }

        function register_widgets( $widgets_manager ) {
            require MULTIFOX_PLUS_DIR_PATH. 'modules/shortcodes/elementor/widgets/mailchimp/class-widget-mailchimp.php';
            $widgets_manager->register_widget_type( new \Elementor_Mailchimp() );
        }

        function register_widget_styles() {
            wp_register_style( 'mfx-mailchimp',
                MULTIFOX_PLUS_DIR_URL . 'modules/shortcodes/elementor/widgets/mailchimp/style.css', array(), MULTIFOX_PLUS_VERSION );
        }

        function register_widget_scripts() {
            wp_register_script( 'mfx-mailchimp',
                MULTIFOX_PLUS_DIR_URL . 'modules/shortcodes/elementor/widgets/mailchimp/script.js', array(), MULTIFOX_PLUS_VERSION, true );
        }

        function register_preview_styles() {
            wp_enqueue_style( 'mfx-mailchimp' );
            wp_enqueue_script( 'mfx-mailchimp' );
        }

        function multifox_mailchimp_subscribe() {

            $out    = '';
            $apiKey = multifox_sanitization($_REQUEST['mc_apikey']);
            $listId = multifox_sanitization($_REQUEST['mc_listid']);
            $mc_email = multifox_sanitization($_REQUEST['mc_email']);
            $mc_fname = multifox_sanitization($_REQUEST['mc_fname']);

            if($apiKey != '' && $listId != '') {
                $data = array();

                if($mc_fname == ''):
                    $data = array('email' => sanitize_email($mc_email), 'status' => 'subscribed');
                else:
                    $data = array('email' => sanitize_email($mc_email), 'status' => 'subscribed', 'merge_fields' => array ( 'FNAME' => $mc_fname ));
                endif;

                if($this->multifox_mailchimp_check_member_already_registered($data, $apiKey, $listId)) {
                    $out = '<span class="error-msg"><b>'.esc_html__('Error:', 'multifox-plus').'</b> '.esc_html__('You have already subscribed with us !', 'multifox-plus').'</span>';
                } else {
                    $out = $this->multifox_mailchimp_register_member($data, $apiKey, $listId);
                }
            } else {
                $out = '<span class="error-msg"><b>'.esc_html__('Error:', 'multifox-plus').'</b> '.esc_html__('Please make sure valid mailchimp details are provided.', 'multifox-plus').'</span>';
            }

            echo multifox_html_output($out);

            wp_die();

        }

        function multifox_mailchimp_check_member_already_registered($data, $apiKey, $listId) {

            $memberId = md5(strtolower($data['email']));
            $dataCenter = substr($apiKey,strpos($apiKey,'-')+1);
            $url = 'https://' . $dataCenter . '.api.mailchimp.com/3.0/lists/' . $listId . '/members/' . $memberId;

            $args = array(
				'headers' => array(
					'Authorization' => 'user: ' .  $apiKey
				)
			);
			$response = wp_remote_get( esc_url($url), $args );
			$results = json_decode(wp_remote_retrieve_body( $response ));


            if($results->status == 'subscribed') {
                return true;
            }

            return false;

        }

        function multifox_mailchimp_register_member($data, $apiKey, $listId) {

            $json = '';
            if(array_key_exists('merge_fields', $data)):
                $json = json_encode( array( 'email_address' => $data['email'], 'status' => $data['status'], 'merge_fields' => array ( 'FNAME' => $data['merge_fields']['FNAME'] ) ));
            else:
                $json = json_encode( array( 'email_address' => $data['email'], 'status' => $data['status'] ));
            endif;

            $args = array (
                'method' => 'PUT',
                'headers' => array (
                    'Authorization' => 'Basic ' . base64_encode( 'user:'. esc_attr($apiKey) )
                ),
                'body' => $json
            );

            $response = wp_remote_post( 'https://' . substr($apiKey,strpos($apiKey,'-')+1) . '.api.mailchimp.com/3.0/lists/' . $listId . '/members/' . md5(strtolower($data['email'])), $args );
            $results = json_decode(wp_remote_retrieve_body( $response ));

            if($results->status == 'subscribed') {
                $output = '<span class="success-msg">'.esc_html__('Success! Please check your inbox or spam folder.', 'multifox-plus').'</span>';
            } else {
                $output = '<span class="error-msg"><b>'.esc_html__('Something went wrong!', 'multifox-plus').'</span>';
            }

            return $output;

        }

    }
}

MultifoxPlusMailchimpWidget::instance();