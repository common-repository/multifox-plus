<?php
use MultifoxElementor\Widgets\MultifoxElementorWidgetBase;
use Elementor\Controls_Manager;

class Elementor_Mailchimp extends MultifoxElementorWidgetBase {

	public function get_name() {
		return 'mfx-mailchimp';
	}

	public function get_title() {
		return esc_html__( 'Mailchimp', 'multifox-plus' );
	}

    public function get_icon() {
		return 'eicon-mailchimp mfx-icon';
	}

	public function get_script_depends() {
		return array( 'mfx-mailchimp' );
	}

	public function get_style_depends() {
		return array( 'mfx-mailchimp' );
	}

	public function list_ids() {

		$lists = array();

		$apiKey = get_option( 'elementor_multifox_mailchimp_api_key' );

		if( !empty( $apiKey ) ) {

        	$dataCenter = substr($apiKey,strpos($apiKey,'-')+1);
        	$url = 'https://' . $dataCenter . '.api.mailchimp.com/3.0/lists/';

			$args = array(
				'headers' => array(
					'Authorization' => 'user: ' .  $apiKey
				)
			);
			$response = wp_remote_get( esc_url($url), $args );
			$results = json_decode(wp_remote_retrieve_body( $response ));

			foreach( $results->lists as $list  ) {
        		$lists[$list->id] = $list->name;
        	}

		}

        return $lists;

	}

	protected function _register_controls() {

		$this->start_controls_section( 'general_settings', array(
			'label' => esc_html__( 'General', 'multifox-plus' ),
		));

			$key = get_option( 'elementor_multifox_mailchimp_api_key' );
			if( !$key ) {

				$this->add_control( 'api_key_info', array(
					'type'            => Controls_Manager::RAW_HTML,
					'raw'             => sprintf(
						__('To display customized Mailchimp widget without an issue, you need to configure API key. Please configure API key from <a href="%s" target="_blank" rel="noopener">here</a>.', 'multifox-plus'),
						add_query_arg( array('page' => 'elementor#tab-multifox' ), esc_url( admin_url( 'admin.php') ) )
					),
					'content_classes' => 'elementor-panel-alert elementor-panel-alert-warning',
				) );
			}

			$this->add_control( 'type', array(
				'label'     => esc_html__('Type', 'multifox-plus'),
				'type'      => Controls_Manager::SELECT,
				'default'   => 'default',
				'options'   => array(
					'default'  => esc_html__( 'Default', 'multifox-plus' ),
					'type1'  => esc_html__( 'Type 1', 'multifox-plus' ),
					'type2'  => esc_html__( 'Type 2', 'multifox-plus' ),
					'type3'  => esc_html__( 'Type 3', 'multifox-plus' ),
					'type4'  => esc_html__( 'Type 4', 'multifox-plus' ),
					'type5'  => esc_html__( 'Type 5', 'multifox-plus' ),
					'type6'  => esc_html__( 'Type 6', 'multifox-plus' ),
					'type7'  => esc_html__( 'Type 7', 'multifox-plus' ),
				)
			) );

			$this->add_control( 'title', array(
				'label'   => esc_html__( 'Title', 'multifox-plus' ),
				'type'    => Controls_Manager::TEXT,
				'default' => esc_html__( 'Title', 'multifox-plus' ),
			) );

			$this->add_control( 'subtitle', array(
				'label'     => esc_html__( 'Sub Title', 'multifox-plus' ),
				'type'      => Controls_Manager::TEXT,
				'default'   => esc_html__( 'Sub Title', 'multifox-plus' ),
				'condition' => array( 'type' => array( 'type4', 'type5', 'type6', 'type7' ) ),
			) );

			$this->add_control( 'tooltip', array(
				'label'     => esc_html__( 'Tooltip', 'multifox-plus' ),
				'type'      => Controls_Manager::TEXT,
				'default'   => esc_html__( 'Tool tip', 'multifox-plus' ),
				'condition' => array( 'type' => 'type7' ),
			) );

			$this->add_control( 'listid', array(
				'label'     => esc_html__('List', 'multifox-plus'),
				'type'      => Controls_Manager::SELECT,
				'default'   => '',
				'options'   => $this->list_ids()
			) );

		$this->end_controls_section();

		$this->start_controls_section( 'label_settings', array(
			'label' => esc_html__( 'Label', 'multifox-plus' ),
		));

			$this->add_control( 'show_name_field', array(
				'label'        => esc_html__( 'Show Name Field', 'multifox-plus' ),
				'type'         => Controls_Manager::SWITCHER,
				'default'      => 'yes',
				'label_on'     => esc_html__( 'On', 'multifox-plus' ),
				'label_off'    => esc_html__( 'Off', 'multifox-plus' ),
				'return_value' => 'yes',
				'condition'    => array( 'type' =>  array( 'default', 'type4', 'type5' ) ),
			) );

			$this->add_control( 'label_name', array(
				'label'     => esc_html__( 'Name', 'multifox-plus' ),
				'type'      => Controls_Manager::TEXT,
				'default'   => esc_html__( 'Your Name', 'multifox-plus' ),
				'condition' => array(
					'show_name_field' => 'yes',
					'type'            =>  array( 'default', 'type4', 'type5' )
				),
			) );

			$this->add_control( 'label_email', array(
				'label'   => esc_html__( 'Email', 'multifox-plus' ),
				'type'    => Controls_Manager::TEXT,
				'default' => esc_html__( 'Your Email', 'multifox-plus' ),
			) );

			$this->add_control( 'label_button', array(
				'label'   => esc_html__( 'Button', 'multifox-plus' ),
				'type'    => Controls_Manager::TEXT,
				'default' => esc_html__( 'Subscribe Now', 'multifox-plus' ),
			) );
		$this->end_controls_section();

		$this->start_controls_section( 'content_settings', array(
			'label'     => esc_html__( 'Content', 'multifox-plus' ),
			'condition' => array(
				'type'    =>  array( 'type4', 'type5', 'type6', 'type7' )
			)
		));

			$this->add_control( 'content', array(
				'label'     => esc_html__('Content', 'multifox-plus'),
				'type'      => Controls_Manager::WYSIWYG,
				'condition' => array('type' =>  array( 'type4', 'type5', 'type6', 'type7' ) ),
				'default'   => '<br><p>Sign-up to get the latest offers and news and stay updated.</p><i>Note: We do not spam</i><br>',
			) );

		$this->end_controls_section();
	}

	protected function render() {

		$settings = $this->get_settings_for_display();
		extract( $settings );


		$this->add_render_attribute( 'wrapper', array(
			'id'    => 'mfx-mailchimp-'.esc_attr( $this->get_id() ),
			'class' => 'mfx-mailchimp-wrapper'
		) );

		$this->add_render_attribute( 'wrapper', 'class', $type );

		echo '<div '.multifox_html_output($this->get_render_attribute_string( 'wrapper' )).'>';

			if(!empty($subtitle))
				echo "<i>{$subtitle}</i>";

			if(!empty($title))
				echo "<h2>{$title}</h2>";

			if(!empty($content) && ($type != 'type1') && ($type != 'type2') && ($type != 'type3') && ($type != 'default'))
				echo '<div class="content">'.do_shortcode( $content ).'</div>';


			$apiKey = get_option( 'elementor_multifox_mailchimp_api_key' );
			echo '<form class="mfx-subscribe-frm" name="frmsubscribe" action="#" method="post">';

				if($show_name_field == 'yes') {
					echo '<input type="text" name="mfx_mc_fname" placeholder="'.esc_attr($label_name).'">';
				}

				echo '<input type="email" name="mfx_mc_emailid" required="required" placeholder="'.esc_attr($label_email).'" value="">';

				echo '<input type="hidden" name="ajax" value="'.admin_url('admin-ajax.php').'" />';
				echo '<input type="hidden" name="mfx_mc_apikey" value="'.esc_attr($apiKey).'" />';
				echo '<input type="hidden" name="mfx_mc_listid" value="'.esc_attr($listid).'" />';

				if( ($type == 'type4') || ($type == 'type5') ):
					echo apply_filters('multifox_sc_mailchimp_form_elements', '', $settings );
				endif;

				echo '<input type="submit" name="mc_submit" value="'.esc_attr($label_button).'">';

				if( ($type == 'default') || ($type == 'type1') || ($type == 'type2') || ($type == 'type3') || ($type == 'type6') || ($type == 'type7') ):
					echo apply_filters('multifox_sc_mailchimp_form_elements', '', $settings );
				endif;

			echo '</form>';

			if(!empty($tooltip))
				echo "<div class='newsletter-tooltip'>{$tooltip}</div>";

			echo '<div class="multifox_ajax_subscribe_msg"></div>';

		echo '</div>';
	}

}