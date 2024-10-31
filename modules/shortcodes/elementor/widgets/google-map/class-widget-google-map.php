<?php
use MultifoxElementor\Widgets\MultifoxElementorWidgetBase;
use Elementor\Controls_Manager;
use Elementor\Repeater;
use Elementor\Group_Control_Border;
use Elementor\Group_Control_Box_Shadow;
use Elementor\Group_Control_Typography;

class Elementor_Google_Map extends MultifoxElementorWidgetBase {

	public function get_name() {
		return 'mfx-google-map';
	}

	public function get_title() {
		return esc_html__( 'Google Map', 'multifox-plus' );
	}

    public function get_icon() {
		return 'eicon-map-pin mfx-icon';
	}

	public function get_script_depends() {
		return array( 'mfx-google-map', 'google-map' );
	}

	public function get_style_depends() {
		return array( 'mfx-google-map' );
	}

	protected function _register_controls() {
		$this->map_general_section();
		$this->markers_section();
		$this->map_control_section();
		$this->map_theme_section();

		$this->map_general_style_section();
		$this->map_info_window_style_section();
	}

	public function map_general_section() {

		$this->start_controls_section( 'map_general_section', array(
			'label' => esc_html__( 'General', 'multifox-plus' ),
		) );

			$key = get_option( 'elementor_multifox_google_map_api_key' );
			if( !$key ) {

				$this->add_control( 'api_key_info', array(
					'type'            => Controls_Manager::RAW_HTML,
					'raw'             => sprintf(
						__('To display customized Google Map without an issue, you need to configure Google Map API key. Please configure API key from <a href="%s" target="_blank" rel="noopener">here</a>.', 'multifox-plus'),
						add_query_arg( array('page' => 'elementor#tab-multifox' ), esc_url( admin_url( 'admin.php') ) )
					),
					'content_classes' => 'elementor-panel-alert elementor-panel-alert-warning',
				) );
			}

			$this->add_control( 'latitude', array(
				'label'       => esc_html__('Center Latitude','multifox-plus'),
				'type'        => Controls_Manager::TEXT,
				'label_block' => true,
				'description' => sprintf(
					esc_html__('Click %1$s to get your location coordinates', 'multifox-plus'),
					'<a href="https://www.latlong.net/" target="_blank">'.esc_html__('here', 'multifox-plus').'</a>'
				)
			) );

			$this->add_control( 'longitude', array(
				'label'       => esc_html__('Center Longitude','multifox-plus'),
				'type'        => Controls_Manager::TEXT,
				'label_block' => true,
				'description' => sprintf(
					esc_html__('Click %1$s to get your location coordinates', 'multifox-plus'),
					'<a href="https://www.latlong.net/" target="_blank">'.esc_html__('here', 'multifox-plus').'</a>'
				)
			) );

			$this->add_control( 'map_zoom', array(
				'label'   => esc_html__( 'Zoom Level', 'multifox-plus' ),
				'type'    => Controls_Manager::SLIDER,
				'default' => array( 'size' => 10 ),
				'range'   => array( 'px' => array( 'min' => 0, 'max' => 20 ) )
			) );

			$this->add_control( 'map_type', array(
				'label'   => esc_html__( 'Map Type', 'multifox-plus' ),
				'type'    => Controls_Manager::SELECT,
				'default' => 'roadmap',
				'options' => array(
					'roadmap'   => esc_html__( 'Road Map', 'multifox-plus' ),
					'satellite' => esc_html__( 'Satellite', 'multifox-plus' ),
					'hybrid'    => esc_html__( 'Hybrid', 'multifox-plus' ),
					'terrain'   => esc_html__( 'Terrain', 'multifox-plus' ),
				)
			) );

			$this->add_control( 'marker_animation', array(
				'label'   => esc_html__( 'Marker Animation', 'multifox-plus' ),
				'type'    => Controls_Manager::SELECT,
				'default' => '',
				'options' => array(
					''       => esc_html__( 'None', 'multifox-plus' ),
					'drop'   => esc_html__( 'Drop', 'multifox-plus' ),
					'bounce' => esc_html__( 'Bounce', 'multifox-plus' ),
				)
			) );

		$this->end_controls_section();
	}

	public function markers_section() {

		$this->start_controls_section( 'markers_section', array(
			'label' => esc_html__( 'Markers', 'multifox-plus' ),
		) );

			$repeater = new Repeater();

			$repeater->add_control( 'latitude', array(
				'label'       => esc_html__('Latitude','multifox-plus'),
				'type'        => Controls_Manager::TEXT,
				'label_block' => true,
				'description' => sprintf(
					esc_html__('Click %1$s to get your location coordinates', 'multifox-plus'),
					'<a href="https://www.latlong.net/" target="_blank">'.esc_html__('here', 'multifox-plus').'</a>'
				)
			) );

			$repeater->add_control( 'longitude', array(
				'label'       => esc_html__('Longitude','multifox-plus'),
				'type'        => Controls_Manager::TEXT,
				'label_block' => true,
				'description' => sprintf(
					esc_html__('Click %1$s to get your location coordinates', 'multifox-plus'),
					'<a href="https://www.latlong.net/" target="_blank">'.esc_html__('here', 'multifox-plus').'</a>'
				)
			) );

			$repeater->add_control( 'title', array(
				'label'       => esc_html__('Title', 'multifox-plus'),
				'type'        => Controls_Manager::TEXT,
				'label_block' => true,
				'default'     => esc_html__( 'Marker Title', 'multifox-plus' )
			) );

			$repeater->add_control( 'show_info_window', array(
				'label'        => esc_html__( 'Show Info Window', 'multifox-plus' ),
				'type'         => Controls_Manager::SWITCHER,
				'default'      => 'yes',
				'label_on'     => esc_html__( 'On', 'multifox-plus' ),
				'label_off'    => esc_html__( 'Off', 'multifox-plus' ),
				'return_value' => 'yes',
			) );

			$repeater->add_control( 'load_info_window', array(
				'label'     => esc_html__( 'Show info Window On', 'multifox-plus' ),
				'type'      => Controls_Manager::SELECT,
				'default'   => 'click',
				'condition' => array( 'show_info_window' => 'yes' ),
				'options'   => array(
					'click' => esc_html__( 'Mouse Click', 'multifox-plus' ),
					'load'  => esc_html__( 'Page Load', 'multifox-plus' ),
				)
			) );

			$repeater->add_control( 'desc', array(
				'label'       => esc_html__('Description', 'multifox-plus'),
				'type'        => Controls_Manager::WYSIWYG,
				'condition'   => array( 'show_info_window' => 'yes' ),
				'label_block' => true
			) );

			$repeater->add_control( 'icon', array(
				'label'     => esc_html__( 'Marker Icon', 'multifox-plus' ),
				'type'      => Controls_Manager::SELECT,
				'default'   => 'default',
				'options'   => array(
					'default' => esc_html__( 'Default', 'multifox-plus' ),
					'custom'  => esc_html__( 'Custom', 'multifox-plus' ),
				)
			) );

			$repeater->add_control( 'custom_icon', array(
				'label'     => esc_html__('Custom Color', 'multifox-plus'),
				'type'      => Controls_Manager::MEDIA,
				'condition' => array( 'icon' => 'custom' ),
			) );

			$repeater->add_control( 'custom_icon_size', array(
				'label'      => esc_html__('Icon Size', 'multifox-plus'),
				'type'       => Controls_Manager::SLIDER,
				'size_units' => array('px'),
				'default'    => array( 'size' => 30, 'unit' => 'px'),
				'range'      => array( 'px' => array( 'min' => 5, 'max' => 100 ) ),
				'condition'  => array( 'icon' => 'custom' )
			) );

			$this->add_control( 'markers', array(
				'type'        => Controls_Manager::REPEATER,
				'fields'      => $repeater->get_controls(),
				'title_field' => '{{title}}',
			) );

		$this->end_controls_section();
	}

	public function map_control_section() {
		$this->start_controls_section( 'map_control_section', array(
			'label' => esc_html__( 'Controls', 'multifox-plus' ),
		) );

			$this->add_control( 'street_view_control', array(
				'label'        => esc_html__( 'Street View Controls', 'multifox-plus' ),
				'type'         => Controls_Manager::SWITCHER,
				'default'      => 'yes',
				'label_on'     => esc_html__( 'On', 'multifox-plus' ),
				'label_off'    => esc_html__( 'Off', 'multifox-plus' ),
				'return_value' => 'yes',
			) );

			$this->add_control( 'map_type_control', array(
				'label'        => esc_html__( 'Map Type Controls', 'multifox-plus' ),
				'type'         => Controls_Manager::SWITCHER,
				'default'      => 'yes',
				'label_on'     => esc_html__( 'On', 'multifox-plus' ),
				'label_off'    => esc_html__( 'Off', 'multifox-plus' ),
				'return_value' => 'yes',
			) );

			$this->add_control( 'zoom_control', array(
				'label'        => esc_html__( 'Zoom Control', 'multifox-plus' ),
				'type'         => Controls_Manager::SWITCHER,
				'default'      => 'yes',
				'label_on'     => esc_html__( 'On', 'multifox-plus' ),
				'label_off'    => esc_html__( 'Off', 'multifox-plus' ),
				'return_value' => 'yes',
			) );

			$this->add_control( 'full_screen_control', array(
				'label'        => esc_html__( 'Full Screen Control', 'multifox-plus' ),
				'type'         => Controls_Manager::SWITCHER,
				'default'      => 'yes',
				'label_on'     => esc_html__( 'On', 'multifox-plus' ),
				'label_off'    => esc_html__( 'Off', 'multifox-plus' ),
				'return_value' => 'yes',
			) );

			$this->add_control( 'scale_control', array(
				'label'        => esc_html__( 'Scale Control', 'multifox-plus' ),
				'type'         => Controls_Manager::SWITCHER,
				'default'      => 'yes',
				'label_on'     => esc_html__( 'On', 'multifox-plus' ),
				'label_off'    => esc_html__( 'Off', 'multifox-plus' ),
				'return_value' => 'yes',
			) );

			$this->add_control( 'rotate_control', array(
				'label'        => esc_html__( 'Rotate Control', 'multifox-plus' ),
				'type'         => Controls_Manager::SWITCHER,
				'default'      => 'yes',
				'label_on'     => esc_html__( 'On', 'multifox-plus' ),
				'label_off'    => esc_html__( 'Off', 'multifox-plus' ),
				'return_value' => 'yes',
			) );

			$this->add_control( 'scroll_zoom_control', array(
				'label'        => esc_html__( 'Scroll Wheel Zoom Control', 'multifox-plus' ),
				'type'         => Controls_Manager::SWITCHER,
				'default'      => 'yes',
				'label_on'     => esc_html__( 'On', 'multifox-plus' ),
				'label_off'    => esc_html__( 'Off', 'multifox-plus' ),
				'return_value' => 'yes',
			) );

			$this->add_control( 'draggable_control', array(
				'label'        => esc_html__( 'Is Map Draggable ?', 'multifox-plus' ),
				'type'         => Controls_Manager::SWITCHER,
				'default'      => 'yes',
				'label_on'     => esc_html__( 'On', 'multifox-plus' ),
				'label_off'    => esc_html__( 'Off', 'multifox-plus' ),
				'return_value' => 'yes',
			) );
		$this->end_controls_section();
	}

	public function map_theme_section() {
		$this->start_controls_section( 'map_theme_section', array(
			'label' => esc_html__( 'Theme', 'multifox-plus' ),
		) );

			$this->add_control( 'theme', array(
				'label'   => esc_html__( 'Theme Source', 'multifox-plus' ),
				'type'    => Controls_Manager::CHOOSE,
				'options' => array(
					'gstandards'  => array( 'title' => esc_html__( 'Google Standard', 'multifox-plus' ), 'icon' => 'fa fa-map' ),
					'snazzymaps' => array( 'title' => esc_html__( 'Snazzy Maps', 'multifox-plus' ), 'icon' => 'fa fa-map-marker' ),
					'custom'     => array( 'title' => esc_html__( 'Custom', 'multifox-plus' ), 'icon' => 'fa fa-edit' )
				),
				'default' => 'gstandards'
            ) );

            $this->add_control( 'gstandards', array(
				'label'       => esc_html__( 'Google Themes', 'multifox-plus' ),
				'type'        => Controls_Manager::SELECT,
				'default'     => 'standard',
				'options'     => array(
					'standard'  => esc_html__( 'Standard', 'multifox-plus' ),
					'silver'    => esc_html__( 'Silver', 'multifox-plus' ),
					'retro'     => esc_html__( 'Retro', 'multifox-plus' ),
					'dark'      => esc_html__( 'Dark', 'multifox-plus' ),
					'night'     => esc_html__( 'Night', 'multifox-plus' ),
					'aubergine' => esc_html__( 'Aubergine', 'multifox-plus' )
				),
				'description' => sprintf( '<a href="https://mapstyle.withgoogle.com/" target="_blank">%1$s</a> %2$s',__( 'Click here', 'multifox-plus' ), esc_html__( 'to generate your own theme and use JSON within Custom style field.', 'multifox-plus' ) ),
				'condition'   => array( 'theme'	=> 'gstandards' )
			) );

			$this->add_control( 'snazzymaps', array(
					'label'       => esc_html__( 'SnazzyMaps Themes', 'multifox-plus' ),
					'type'        => Controls_Manager::SELECT,
					'label_block' => true,
					'default'     => 'colorful',
					'options'     => array(
						'simple'     => esc_html__( 'Simple', 'multifox-plus' ),
						'colorful'   => esc_html__( 'Colorful', 'multifox-plus' ),
						'complex'    => esc_html__( 'Complex', 'multifox-plus' ),
						'dark'       => esc_html__( 'Dark', 'multifox-plus' ),
						'greyscale'  => esc_html__( 'Greyscale', 'multifox-plus' ),
						'light'      => esc_html__( 'Light', 'multifox-plus' ),
						'monochrome' => esc_html__( 'Monochrome', 'multifox-plus' ),
						'nolabels'   => esc_html__( 'No Labels', 'multifox-plus' ),
						'twotone'    => esc_html__( 'Two Tone', 'multifox-plus' )
					),
					'description' => sprintf( '<a href="https://snazzymaps.com/explore" target="_blank">%1$s</a> %2$s',__( 'Click here', 'multifox-plus' ), esc_html__( 'to explore more themes and use JSON within custom style field.', 'multifox-plus' ) ),
					'condition'   => array( 'theme'	=> 'snazzymaps' )
			) );

			$this->add_control( 'custom_theme', array(
				'label'       => esc_html__( 'Custom Style', 'multifox-plus' ),
				'description' => sprintf( '<a href="https://mapstyle.withgoogle.com/" target="_blank">%1$s</a> %2$s',__( 'Click here', 'multifox-plus' ), esc_html__( 'to get JSON style code to style your map', 'multifox-plus' ) ),
				'type'        => Controls_Manager::TEXTAREA,
				'condition'   => array(
                    'theme'     => 'custom',
                )
			) );

		$this->end_controls_section();
	}

	public function map_general_style_section() {

		$this->start_controls_section( 'map_general_style_section', array(
			'label' => esc_html__( 'Map', 'multifox-plus' ),
			'tab'   => Controls_Manager::TAB_STYLE,
		) );

			$this->add_group_control( Group_Control_Border::get_type(), array(
				'name'     => 'map_border',
				#'selector' => '{{WRAPPER}}'
			) );

			$this->add_control( 'map_border_radius', array(
				'label'      => esc_html__('Border Radius', 'multifox-plus'),
				'type'       => Controls_Manager::SLIDER,
				'size_units' => array( 'px', '%' ),
				'selectors'  => array(
                    # '{{WRAPPER}} .premium-maps-container,{{WRAPPER}} .premium_maps_map_height' => 'border-radius: {{SIZE}}{{UNIT}};'
				)
			) );

			$this->add_group_control( Group_Control_Box_Shadow::get_type(), array(
				'name'     => 'map_box_shadow',
				#'selector' => '{{WRAPPER}}'
			) );

			$this->add_responsive_control( 'map_max_width', array(
				'label'      => esc_html__( 'Max Width', 'multifox-plus' ),
				'type'       => Controls_Manager::SLIDER,
				'default'    => array( 'size' => 1140, 'unit' => 'px' ),
				'size_units' => array( 'px' ),
				'range'      => array( 'px' => array( 'min' => 0, 'max' => 1400, 'step' => 10 ) ),
				'selectors'  => array(
					#'{{WRAPPER}} .eael-google-map' => 'max-width: {{SIZE}}{{UNIT}};',
				)
			) );
			$this->add_responsive_control( 'map_max_height', array(
				'label'      => esc_html__( 'Max Height', 'multifox-plus' ),
				'type'       => Controls_Manager::SLIDER,
				'default'    => array( 'size' => 400, 'unit' => 'px' ),
				'size_units' => array( 'px' ),
				'range'      => array( 'px' => array( 'min' => 0, 'max' => 1400, 'step' => 10 ) ),
				'selectors'  => array(
					#'{{WRAPPER}} .eael-google-map' => 'height: {{SIZE}}{{UNIT}};',
				)
			) );

			$this->add_responsive_control( 'map_margin', array(
				'label'      => esc_html__( 'Margin', 'multifox-plus' ),
				'type'       => Controls_Manager::DIMENSIONS,
				'size_units' => array( 'px', '%' ),
				'selectors'  => array(
					#'{{WRAPPER}} .eael-google-map' => 'margin: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
		 		)
			) );

			$this->add_responsive_control( 'map_padding', array(
				'label'      => esc_html__( 'Padding', 'multifox-plus' ),
				'type'       => Controls_Manager::DIMENSIONS,
				'size_units' => array( 'px', '%' ),
				'selectors'  => array(
					#'{{WRAPPER}} .eael-google-map' => 'margin: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
		 		)
			) );

		$this->end_controls_section();
	}

	public function map_info_window_style_section() {

		$this->start_controls_section( 'map_info_window_style_section', array(
			'label' => esc_html__( 'Info Window', 'multifox-plus' ),
			'tab'   => Controls_Manager::TAB_STYLE,
		) );

	        $this->add_responsive_control( 'map_text_align', array(
				'label'     => esc_html__( 'Alignment', 'multifox-plus' ),
				'type'      => Controls_Manager::CHOOSE,
				'default'   => '',
				'options'   => array(
					'left'   => array( 'title'   => esc_html__( 'Left', 'multifox-plus' ), 'icon'    => 'eicon-h-align-left' ),
					'center' => array( 'title'   => esc_html__( 'Center', 'multifox-plus' ), 'icon'    => 'eicon-h-align-center' ),
					'right'  => array( 'title'   => esc_html__( 'Right', 'multifox-plus' ), 'icon'    => 'eicon-h-align-right' ),
				),
				#'selectors' => array( '{{WRAPPER}} ' => 'text-align: {{VALUE}};' ),
			) );

	        $this->add_control( 'iw_max_width', array(
				'label'   => esc_html__( 'Info Window Max Width', 'multifox-plus' ),
				'type'    => Controls_Manager::SLIDER,
				'default' => array( 'size' => 240 ),
				'range'   => array( 'px' => array( 'min' => 40, 'max' => 500, 'step' => 1 ) )
	        ) );

	        $this->add_responsive_control( 'info_padding', array(
				'label'      => esc_html__( 'Padding', 'multifox-plus' ),
				'type'       => Controls_Manager::DIMENSIONS,
				'size_units' => array( 'px', 'em', '%' ),
				'selectors'  => array(
					#'{{WRAPPER}} .gm-style .oew-infowindow-content' => 'padding: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
				)
			) );

			$this->add_control( 'title_heading', array(
				'label'     => esc_html__( 'Title', 'multifox-plus' ),
				'type'      => Controls_Manager::HEADING,
				'separator' => 'before',
	        ) );

			$this->add_control( 'title_color', array(
				'label'     => esc_html__( 'Color', 'multifox-plus' ),
				'type'      => Controls_Manager::COLOR,
				'selectors' => array(
					# '{{WRAPPER}} .gm-style .oew-infowindow-title' => 'color: {{VALUE}};'
				)
			) );

	        $this->add_responsive_control( 'title_spacing', array(
				'label'      => esc_html__( 'Bottom Spacing', 'multifox-plus' ),
				'type'       => Controls_Manager::SLIDER,
				'range'      => array( 'px' => array( 'min' => 0, 'max' => 100, 'step' => 1 ) ),
				'size_units' => array( 'px', 'em', '%' ),
				'selectors'  => array(
					# '{{WRAPPER}} .gm-style .oew-infowindow-title' => 'margin-bottom: {{SIZE}}{{UNIT}}',
				)
	        ) );

	        $this->add_group_control( Group_Control_Typography::get_type(), array(
				'name'     => 'title_typography',
				#'selector' => '{{WRAPPER}} .gm-style .oew-infowindow-title',
	        ) );

	        $this->add_control( 'description_heading', array(
				'label'     => esc_html__( 'Description', 'multifox-plus' ),
				'type'      => Controls_Manager::HEADING,
				'separator' => 'before',
	        ) );

			$this->add_control( 'description_color', array(
				'label'     => esc_html__( 'Color', 'multifox-plus' ),
				'type'      => Controls_Manager::COLOR,
				'selectors' => array(
					#'{{WRAPPER}} .gm-style .oew-infowindow-description' => 'color: {{VALUE}};',
				)
			) );

			$this->add_group_control( Group_Control_Typography::get_type(), array(
				'name'     => 'description_typography',
				'selector' => '{{WRAPPER}} .gm-style .oew-infowindow-description',
			) );
		$this->end_controls_section();
	}

	protected function map_styles() {

		$gstandards = array(
			'standard'  => '[]',
			'silver'    => '[{"elementType":"geometry","stylers":[{"color":"#f5f5f5"}]},{"elementType":"labels.icon","stylers":[{"visibility":"off"}]},{"elementType":"labels.text.fill","stylers":[{"color":"#616161"}]},{"elementType":"labels.text.stroke","stylers":[{"color":"#f5f5f5"}]},{"featureType":"administrative.land_parcel","elementType":"labels.text.fill","stylers":[{"color":"#bdbdbd"}]},{"featureType":"poi","elementType":"geometry","stylers":[{"color":"#eeeeee"}]},{"featureType":"poi","elementType":"labels.text.fill","stylers":[{"color":"#757575"}]},{"featureType":"poi.park","elementType":"geometry","stylers":[{"color":"#e5e5e5"}]},{"featureType":"poi.park","elementType":"labels.text.fill","stylers":[{"color":"#9e9e9e"}]},{"featureType":"road","elementType":"geometry","stylers":[{"color":"#ffffff"}]},{"featureType":"road.arterial","elementType":"labels.text.fill","stylers":[{"color":"#757575"}]},{"featureType":"road.highway","elementType":"geometry","stylers":[{"color":"#dadada"}]},{"featureType":"road.highway","elementType":"labels.text.fill","stylers":[{"color":"#616161"}]},{"featureType":"road.local","elementType":"labels.text.fill","stylers":[{"color":"#9e9e9e"}]},{"featureType":"transit.line","elementType":"geometry","stylers":[{"color":"#e5e5e5"}]},{"featureType":"transit.station","elementType":"geometry","stylers":[{"color":"#eeeeee"}]},{"featureType":"water","elementType":"geometry","stylers":[{"color":"#c9c9c9"}]},{"featureType":"water","elementType":"labels.text.fill","stylers":[{"color":"#9e9e9e"}]}]',
			'retro'     => '[{"elementType":"geometry","stylers":[{"color":"#ebe3cd"}]},{"elementType":"labels.text.fill","stylers":[{"color":"#523735"}]},{"elementType":"labels.text.stroke","stylers":[{"color":"#f5f1e6"}]},{"featureType":"administrative","elementType":"geometry.stroke","stylers":[{"color":"#c9b2a6"}]},{"featureType":"administrative.land_parcel","elementType":"geometry.stroke","stylers":[{"color":"#dcd2be"}]},{"featureType":"administrative.land_parcel","elementType":"labels.text.fill","stylers":[{"color":"#ae9e90"}]},{"featureType":"landscape.natural","elementType":"geometry","stylers":[{"color":"#dfd2ae"}]},{"featureType":"poi","elementType":"geometry","stylers":[{"color":"#dfd2ae"}]},{"featureType":"poi","elementType":"labels.text.fill","stylers":[{"color":"#93817c"}]},{"featureType":"poi.park","elementType":"geometry.fill","stylers":[{"color":"#a5b076"}]},{"featureType":"poi.park","elementType":"labels.text.fill","stylers":[{"color":"#447530"}]},{"featureType":"road","elementType":"geometry","stylers":[{"color":"#f5f1e6"}]},{"featureType":"road.arterial","elementType":"geometry","stylers":[{"color":"#fdfcf8"}]},{"featureType":"road.highway","elementType":"geometry","stylers":[{"color":"#f8c967"}]},{"featureType":"road.highway","elementType":"geometry.stroke","stylers":[{"color":"#e9bc62"}]},{"featureType":"road.highway.controlled_access","elementType":"geometry","stylers":[{"color":"#e98d58"}]},{"featureType":"road.highway.controlled_access","elementType":"geometry.stroke","stylers":[{"color":"#db8555"}]},{"featureType":"road.local","elementType":"labels.text.fill","stylers":[{"color":"#806b63"}]},{"featureType":"transit.line","elementType":"geometry","stylers":[{"color":"#dfd2ae"}]},{"featureType":"transit.line","elementType":"labels.text.fill","stylers":[{"color":"#8f7d77"}]},{"featureType":"transit.line","elementType":"labels.text.stroke","stylers":[{"color":"#ebe3cd"}]},{"featureType":"transit.station","elementType":"geometry","stylers":[{"color":"#dfd2ae"}]},{"featureType":"water","elementType":"geometry.fill","stylers":[{"color":"#b9d3c2"}]},{"featureType":"water","elementType":"labels.text.fill","stylers":[{"color":"#92998d"}]}]',
			'dark'      => '[{"elementType":"geometry","stylers":[{"color":"#212121"}]},{"elementType":"labels.icon","stylers":[{"visibility":"off"}]},{"elementType":"labels.text.fill","stylers":[{"color":"#757575"}]},{"elementType":"labels.text.stroke","stylers":[{"color":"#212121"}]},{"featureType":"administrative","elementType":"geometry","stylers":[{"color":"#757575"}]},{"featureType":"administrative.country","elementType":"labels.text.fill","stylers":[{"color":"#9e9e9e"}]},{"featureType":"administrative.land_parcel","stylers":[{"visibility":"off"}]},{"featureType":"administrative.locality","elementType":"labels.text.fill","stylers":[{"color":"#bdbdbd"}]},{"featureType":"poi","elementType":"labels.text.fill","stylers":[{"color":"#757575"}]},{"featureType":"poi.park","elementType":"geometry","stylers":[{"color":"#181818"}]},{"featureType":"poi.park","elementType":"labels.text.fill","stylers":[{"color":"#616161"}]},{"featureType":"poi.park","elementType":"labels.text.stroke","stylers":[{"color":"#1b1b1b"}]},{"featureType":"road","elementType":"geometry.fill","stylers":[{"color":"#2c2c2c"}]},{"featureType":"road","elementType":"labels.text.fill","stylers":[{"color":"#8a8a8a"}]},{"featureType":"road.arterial","elementType":"geometry","stylers":[{"color":"#373737"}]},{"featureType":"road.highway","elementType":"geometry","stylers":[{"color":"#3c3c3c"}]},{"featureType":"road.highway.controlled_access","elementType":"geometry","stylers":[{"color":"#4e4e4e"}]},{"featureType":"road.local","elementType":"labels.text.fill","stylers":[{"color":"#616161"}]},{"featureType":"transit","elementType":"labels.text.fill","stylers":[{"color":"#757575"}]},{"featureType":"water","elementType":"geometry","stylers":[{"color":"#000000"}]},{"featureType":"water","elementType":"labels.text.fill","stylers":[{"color":"#3d3d3d"}]}]',
			'night'     => '[{"elementType":"geometry","stylers":[{"color":"#242f3e"}]},{"elementType":"labels.text.fill","stylers":[{"color":"#746855"}]},{"elementType":"labels.text.stroke","stylers":[{"color":"#242f3e"}]},{"featureType":"administrative.locality","elementType":"labels.text.fill","stylers":[{"color":"#d59563"}]},{"featureType":"poi","elementType":"labels.text.fill","stylers":[{"color":"#d59563"}]},{"featureType":"poi.park","elementType":"geometry","stylers":[{"color":"#263c3f"}]},{"featureType":"poi.park","elementType":"labels.text.fill","stylers":[{"color":"#6b9a76"}]},{"featureType":"road","elementType":"geometry","stylers":[{"color":"#38414e"}]},{"featureType":"road","elementType":"geometry.stroke","stylers":[{"color":"#212a37"}]},{"featureType":"road","elementType":"labels.text.fill","stylers":[{"color":"#9ca5b3"}]},{"featureType":"road.highway","elementType":"geometry","stylers":[{"color":"#746855"}]},{"featureType":"road.highway","elementType":"geometry.stroke","stylers":[{"color":"#1f2835"}]},{"featureType":"road.highway","elementType":"labels.text.fill","stylers":[{"color":"#f3d19c"}]},{"featureType":"transit","elementType":"geometry","stylers":[{"color":"#2f3948"}]},{"featureType":"transit.station","elementType":"labels.text.fill","stylers":[{"color":"#d59563"}]},{"featureType":"water","elementType":"geometry","stylers":[{"color":"#17263c"}]},{"featureType":"water","elementType":"labels.text.fill","stylers":[{"color":"#515c6d"}]},{"featureType":"water","elementType":"labels.text.stroke","stylers":[{"color":"#17263c"}]}]',
			'aubergine' => '[{"elementType":"geometry","stylers":[{"color":"#1d2c4d"}]},{"elementType":"labels.text.fill","stylers":[{"color":"#8ec3b9"}]},{"elementType":"labels.text.stroke","stylers":[{"color":"#1a3646"}]},{"featureType":"administrative.country","elementType":"geometry.stroke","stylers":[{"color":"#4b6878"}]},{"featureType":"administrative.land_parcel","elementType":"labels.text.fill","stylers":[{"color":"#64779e"}]},{"featureType":"administrative.province","elementType":"geometry.stroke","stylers":[{"color":"#4b6878"}]},{"featureType":"landscape.man_made","elementType":"geometry.stroke","stylers":[{"color":"#334e87"}]},{"featureType":"landscape.natural","elementType":"geometry","stylers":[{"color":"#023e58"}]},{"featureType":"poi","elementType":"geometry","stylers":[{"color":"#283d6a"}]},{"featureType":"poi","elementType":"labels.text.fill","stylers":[{"color":"#6f9ba5"}]},{"featureType":"poi","elementType":"labels.text.stroke","stylers":[{"color":"#1d2c4d"}]},{"featureType":"poi.park","elementType":"geometry.fill","stylers":[{"color":"#023e58"}]},{"featureType":"poi.park","elementType":"labels.text.fill","stylers":[{"color":"#3C7680"}]},{"featureType":"road","elementType":"geometry","stylers":[{"color":"#304a7d"}]},{"featureType":"road","elementType":"labels.text.fill","stylers":[{"color":"#98a5be"}]},{"featureType":"road","elementType":"labels.text.stroke","stylers":[{"color":"#1d2c4d"}]},{"featureType":"road.highway","elementType":"geometry","stylers":[{"color":"#2c6675"}]},{"featureType":"road.highway","elementType":"geometry.stroke","stylers":[{"color":"#255763"}]},{"featureType":"road.highway","elementType":"labels.text.fill","stylers":[{"color":"#b0d5ce"}]},{"featureType":"road.highway","elementType":"labels.text.stroke","stylers":[{"color":"#023e58"}]},{"featureType":"transit","elementType":"labels.text.fill","stylers":[{"color":"#98a5be"}]},{"featureType":"transit","elementType":"labels.text.stroke","stylers":[{"color":"#1d2c4d"}]},{"featureType":"transit.line","elementType":"geometry.fill","stylers":[{"color":"#283d6a"}]},{"featureType":"transit.station","elementType":"geometry","stylers":[{"color":"#3a4762"}]},{"featureType":"water","elementType":"geometry","stylers":[{"color":"#0e1626"}]},{"featureType":"water","elementType":"labels.text.fill","stylers":[{"color":"#4e6d70"}]}]'
		);

		$snazzymaps = array(
			'simple'     => '[{"featureType":"administrative","elementType":"labels.text.fill","stylers":[{"color":"#6195a0"}]},{"featureType":"administrative.province","elementType":"geometry.stroke","stylers":[{"visibility":"off"}]},{"featureType":"landscape","elementType":"geometry","stylers":[{"lightness":"0"},{"saturation":"0"},{"color":"#f5f5f2"},{"gamma":"1"}]},{"featureType":"landscape.man_made","elementType":"all","stylers":[{"lightness":"-3"},{"gamma":"1.00"}]},{"featureType":"landscape.natural.terrain","elementType":"all","stylers":[{"visibility":"off"}]},{"featureType":"poi","elementType":"all","stylers":[{"visibility":"off"}]},{"featureType":"poi.park","elementType":"geometry.fill","stylers":[{"color":"#bae5ce"},{"visibility":"on"}]},{"featureType":"road","elementType":"all","stylers":[{"saturation":-100},{"lightness":45},{"visibility":"simplified"}]},{"featureType":"road.highway","elementType":"all","stylers":[{"visibility":"simplified"}]},{"featureType":"road.highway","elementType":"geometry.fill","stylers":[{"color":"#fac9a9"},{"visibility":"simplified"}]},{"featureType":"road.highway","elementType":"labels.text","stylers":[{"color":"#4e4e4e"}]},{"featureType":"road.arterial","elementType":"labels.text.fill","stylers":[{"color":"#787878"}]},{"featureType":"road.arterial","elementType":"labels.icon","stylers":[{"visibility":"off"}]},{"featureType":"transit","elementType":"all","stylers":[{"visibility":"simplified"}]},{"featureType":"transit.station.airport","elementType":"labels.icon","stylers":[{"hue":"#0a00ff"},{"saturation":"-77"},{"gamma":"0.57"},{"lightness":"0"}]},{"featureType":"transit.station.rail","elementType":"labels.text.fill","stylers":[{"color":"#43321e"}]},{"featureType":"transit.station.rail","elementType":"labels.icon","stylers":[{"hue":"#ff6c00"},{"lightness":"4"},{"gamma":"0.75"},{"saturation":"-68"}]},{"featureType":"water","elementType":"all","stylers":[{"color":"#eaf6f8"},{"visibility":"on"}]},{"featureType":"water","elementType":"geometry.fill","stylers":[{"color":"#c7eced"}]},{"featureType":"water","elementType":"labels.text.fill","stylers":[{"lightness":"-49"},{"saturation":"-53"},{"gamma":"0.79"}]}]',
			'colorful'   => '[{"featureType":"all","elementType":"all","stylers":[{"color":"#ff7000"},{"lightness":"69"},{"saturation":"100"},{"weight":"1.17"},{"gamma":"2.04"}]},{"featureType":"all","elementType":"geometry","stylers":[{"color":"#cb8536"}]},{"featureType":"all","elementType":"labels","stylers":[{"color":"#ffb471"},{"lightness":"66"},{"saturation":"100"}]},{"featureType":"all","elementType":"labels.text.fill","stylers":[{"gamma":0.01},{"lightness":20}]},{"featureType":"all","elementType":"labels.text.stroke","stylers":[{"saturation":-31},{"lightness":-33},{"weight":2},{"gamma":0.8}]},{"featureType":"all","elementType":"labels.icon","stylers":[{"visibility":"off"}]},{"featureType":"landscape","elementType":"all","stylers":[{"lightness":"-8"},{"gamma":"0.98"},{"weight":"2.45"},{"saturation":"26"}]},{"featureType":"landscape","elementType":"geometry","stylers":[{"lightness":30},{"saturation":30}]},{"featureType":"poi","elementType":"geometry","stylers":[{"saturation":20}]},{"featureType":"poi.park","elementType":"geometry","stylers":[{"lightness":20},{"saturation":-20}]},{"featureType":"road","elementType":"geometry","stylers":[{"lightness":10},{"saturation":-30}]},{"featureType":"road","elementType":"geometry.stroke","stylers":[{"saturation":25},{"lightness":25}]},{"featureType":"water","elementType":"all","stylers":[{"lightness":-20},{"color":"#ecc080"}]}]',
			'complex'    => '[{"elementType":"geometry","stylers":[{"hue":"#ff4400"},{"saturation":-68},{"lightness":-4},{"gamma":0.72}]},{"featureType":"road","elementType":"labels.icon"},{"featureType":"landscape.man_made","elementType":"geometry","stylers":[{"hue":"#0077ff"},{"gamma":3.1}]},{"featureType":"water","stylers":[{"hue":"#00ccff"},{"gamma":0.44},{"saturation":-33}]},{"featureType":"poi.park","stylers":[{"hue":"#44ff00"},{"saturation":-23}]},{"featureType":"water","elementType":"labels.text.fill","stylers":[{"hue":"#007fff"},{"gamma":0.77},{"saturation":65},{"lightness":99}]},{"featureType":"water","elementType":"labels.text.stroke","stylers":[{"gamma":0.11},{"weight":5.6},{"saturation":99},{"hue":"#0091ff"},{"lightness":-86}]},{"featureType":"transit.line","elementType":"geometry","stylers":[{"lightness":-48},{"hue":"#ff5e00"},{"gamma":1.2},{"saturation":-23}]},{"featureType":"transit","elementType":"labels.text.stroke","stylers":[{"saturation":-64},{"hue":"#ff9100"},{"lightness":16},{"gamma":0.47},{"weight":2.7}]}]',
			'dark'       => '[{"stylers":[{"hue":"#ff1a00"},{"invert_lightness":true},{"saturation":-100},{"lightness":33},{"gamma":0.5}]},{"featureType":"water","elementType":"geometry","stylers":[{"color":"#2D333C"}]}]',
			'greyscale'  => '[{"featureType":"administrative","elementType":"all","stylers":[{"saturation":"-100"}]},{"featureType":"administrative.province","elementType":"all","stylers":[{"visibility":"off"}]},{"featureType":"landscape","elementType":"all","stylers":[{"saturation":-100},{"lightness":65},{"visibility":"on"}]},{"featureType":"poi","elementType":"all","stylers":[{"saturation":-100},{"lightness":"50"},{"visibility":"simplified"}]},{"featureType":"road","elementType":"all","stylers":[{"saturation":"-100"}]},{"featureType":"road.highway","elementType":"all","stylers":[{"visibility":"simplified"}]},{"featureType":"road.arterial","elementType":"all","stylers":[{"lightness":"30"}]},{"featureType":"road.local","elementType":"all","stylers":[{"lightness":"40"}]},{"featureType":"transit","elementType":"all","stylers":[{"saturation":-100},{"visibility":"simplified"}]},{"featureType":"water","elementType":"geometry","stylers":[{"hue":"#ffff00"},{"lightness":-25},{"saturation":-97}]},{"featureType":"water","elementType":"labels","stylers":[{"lightness":-25},{"saturation":-100}]}]',
			'light'      => '[{"featureType":"administrative","elementType":"labels.text.fill","stylers":[{"color":"#6195a0"}]},{"featureType":"landscape","elementType":"all","stylers":[{"color":"#f2f2f2"}]},{"featureType":"landscape","elementType":"geometry.fill","stylers":[{"color":"#ffffff"}]},{"featureType":"poi","elementType":"all","stylers":[{"visibility":"off"}]},{"featureType":"poi.park","elementType":"geometry.fill","stylers":[{"color":"#e6f3d6"},{"visibility":"on"}]},{"featureType":"road","elementType":"all","stylers":[{"saturation":-100},{"lightness":45},{"visibility":"simplified"}]},{"featureType":"road.highway","elementType":"all","stylers":[{"visibility":"simplified"}]},{"featureType":"road.highway","elementType":"geometry.fill","stylers":[{"color":"#f4d2c5"},{"visibility":"simplified"}]},{"featureType":"road.highway","elementType":"labels.text","stylers":[{"color":"#4e4e4e"}]},{"featureType":"road.arterial","elementType":"geometry.fill","stylers":[{"color":"#f4f4f4"}]},{"featureType":"road.arterial","elementType":"labels.text.fill","stylers":[{"color":"#787878"}]},{"featureType":"road.arterial","elementType":"labels.icon","stylers":[{"visibility":"off"}]},{"featureType":"transit","elementType":"all","stylers":[{"visibility":"off"}]},{"featureType":"water","elementType":"all","stylers":[{"color":"#eaf6f8"},{"visibility":"on"}]},{"featureType":"water","elementType":"geometry.fill","stylers":[{"color":"#eaf6f8"}]}]',
			'monochrome' => '[{"featureType":"administrative.locality","elementType":"all","stylers":[{"hue":"#2c2e33"},{"saturation":7},{"lightness":19},{"visibility":"on"}]},{"featureType":"landscape","elementType":"all","stylers":[{"hue":"#ffffff"},{"saturation":-100},{"lightness":100},{"visibility":"simplified"}]},{"featureType":"poi","elementType":"all","stylers":[{"hue":"#ffffff"},{"saturation":-100},{"lightness":100},{"visibility":"off"}]},{"featureType":"road","elementType":"geometry","stylers":[{"hue":"#bbc0c4"},{"saturation":-93},{"lightness":31},{"visibility":"simplified"}]},{"featureType":"road","elementType":"labels","stylers":[{"hue":"#bbc0c4"},{"saturation":-93},{"lightness":31},{"visibility":"on"}]},{"featureType":"road.arterial","elementType":"labels","stylers":[{"hue":"#bbc0c4"},{"saturation":-93},{"lightness":-2},{"visibility":"simplified"}]},{"featureType":"road.local","elementType":"geometry","stylers":[{"hue":"#e9ebed"},{"saturation":-90},{"lightness":-8},{"visibility":"simplified"}]},{"featureType":"transit","elementType":"all","stylers":[{"hue":"#e9ebed"},{"saturation":10},{"lightness":69},{"visibility":"on"}]},{"featureType":"water","elementType":"all","stylers":[{"hue":"#e9ebed"},{"saturation":-78},{"lightness":67},{"visibility":"simplified"}]}]',
			'nolabels'   => '[{"elementType":"labels","stylers":[{"visibility":"off"},{"color":"#f49f53"}]},{"featureType":"landscape","stylers":[{"color":"#f9ddc5"},{"lightness":-7}]},{"featureType":"road","stylers":[{"color":"#813033"},{"lightness":43}]},{"featureType":"poi.business","stylers":[{"color":"#645c20"},{"lightness":38}]},{"featureType":"water","stylers":[{"color":"#1994bf"},{"saturation":-69},{"gamma":0.99},{"lightness":43}]},{"featureType":"road.local","elementType":"geometry.fill","stylers":[{"color":"#f19f53"},{"weight":1.3},{"visibility":"on"},{"lightness":16}]},{"featureType":"poi.business"},{"featureType":"poi.park","stylers":[{"color":"#645c20"},{"lightness":39}]},{"featureType":"poi.school","stylers":[{"color":"#a95521"},{"lightness":35}]},{},{"featureType":"poi.medical","elementType":"geometry.fill","stylers":[{"color":"#813033"},{"lightness":38},{"visibility":"off"}]},{},{},{},{},{},{},{},{},{},{},{},{"elementType":"labels"},{"featureType":"poi.sports_complex","stylers":[{"color":"#9e5916"},{"lightness":32}]},{},{"featureType":"poi.government","stylers":[{"color":"#9e5916"},{"lightness":46}]},{"featureType":"transit.station","stylers":[{"visibility":"off"}]},{"featureType":"transit.line","stylers":[{"color":"#813033"},{"lightness":22}]},{"featureType":"transit","stylers":[{"lightness":38}]},{"featureType":"road.local","elementType":"geometry.stroke","stylers":[{"color":"#f19f53"},{"lightness":-10}]},{},{},{}]',
			'twotone'    => '[{"stylers":[{"hue":"#007fff"},{"saturation":89}]},{"featureType":"water","stylers":[{"color":"#ffffff"}]},{"featureType":"administrative.country","elementType":"labels","stylers":[{"visibility":"off"}]}]',
		);

		$styles['gstandards'] = $gstandards;
		$styles['snazzymaps'] = $snazzymaps;

		return $styles;
	}

	protected function map_markers( $markers ) {

		$locations = array();

		foreach( $markers as $index => $marker ) {
			$obj = array(
				'key'       => $marker['_id'],
				'latitude'  => $marker['latitude'],
				'longitude' => $marker['longitude'],
				'title'     => $marker['title'],
				'desc'      => $marker['desc'],
				'show_info_window' => $marker['show_info_window'],
				'load_info_window' => $marker['load_info_window'],
			);


			if( $marker['icon'] == "custom" ) {

				$custom_icon = array_filter( $marker['custom_icon'] );

				if( isset( $custom_icon['url'] ) ) {
					$obj['icon'] = $custom_icon['url'];
					$obj['icon_size'] = isset( $marker['custom_icon_size']['size'] ) ? $marker['custom_icon_size']['size'] : 40;
				}
			}

			$locations[] = $obj;
		}

		return $locations;
	}

	protected function render() {

		$settings = $this->get_settings_for_display();

		$this->add_render_attribute( 'wrapper', array(
			'id'    => 'mfx-google-map-'.esc_attr( $this->get_id() ),
			'class' => 'mfx-google-map-wrapper'
		) );

		$centerlat  = !empty( $settings['latitude'] ) ? $settings['latitude'] : '-37.737707';
		$centerlong = !empty( $settings['longitude'] ) ? $settings['longitude'] : '504.991808';

		$streetViewControl = ( $settings['street_view_control'] == "yes" ) ? true : false;
		$mapTypeControl    = ( $settings['map_type_control'] == "yes" ) ? true : false;
		$zoomControl       = ( $settings['zoom_control'] == "yes" ) ? true : false;
		$scaleControl      = ( $settings['scale_control'] == "yes" ) ? true : false;
		$rotateControl     = ( $settings['rotate_control'] == "yes" ) ? true : false;
		$fullscreenControl = ( $settings['full_screen_control'] == "yes" ) ? true : false;
		$scrollwheel       = ( $settings['scroll_zoom_control'] == "yes" ) ? true : false;
		$draggable   = ( $settings['draggable_control'] == "yes" ) ? true : false;

		$styles = '[]';
		$map_styles = $this->map_styles();
		if( $settings['theme'] == "gstandard" ) {

			$styles = $map_styles['gstandards'][$settings['gstandards']];
		} elseif( $settings['theme'] == "snazzymaps" ) {

			$styles = $map_styles['snazzymaps'][$settings['snazzymaps']];
		} elseif( $settings['theme'] == "custom_theme" ) {

			$styles = strip_tags( $settings['custom_theme'] );
		}

		$this->add_render_attribute( 'map', array(
			'class'     => 'mfx-google-map',
			'style'     => 'width:100%;height:500px;background-color:#f0f0f0;',
			'data-init' => wp_json_encode( array(
				'mapTypeId'         => $settings['map_type'],
				'zoom'              => filter_var( $settings['map_zoom']['size'], FILTER_VALIDATE_INT ),
				'zoomControl'       => filter_var( $zoomControl, FILTER_VALIDATE_BOOLEAN ),
				'mapTypeControl'    => filter_var( $mapTypeControl, FILTER_VALIDATE_BOOLEAN ),
				'scaleControl'      => filter_var( $scaleControl, FILTER_VALIDATE_BOOLEAN ),
				'streetViewControl' => filter_var( $streetViewControl, FILTER_VALIDATE_BOOLEAN ),
				'rotateControl'     => filter_var( $rotateControl, FILTER_VALIDATE_BOOLEAN ),
				'fullscreenControl' => filter_var( $fullscreenControl, FILTER_VALIDATE_BOOLEAN ),
				'scrollwheel'       => filter_var( $scrollwheel, FILTER_VALIDATE_BOOLEAN ),
				'draggable'         => filter_var( $draggable, FILTER_VALIDATE_BOOLEAN ),
				'styles'            => $styles,
				'center'            => array(
					'lat' => filter_var( $centerlat, FILTER_VALIDATE_FLOAT ),
					'lng' => filter_var( $centerlong, FILTER_VALIDATE_FLOAT )
				),
			) ),
			'data-markers' => wp_json_encode( $this->map_markers( $settings['markers'] ) ),
			'data-marker-animation' => $settings['marker_animation'],
			'data-iw-max-width' => $settings['iw_max_width']['size']
		) );

		echo '<div '.multifox_html_output($this->get_render_attribute_string( 'wrapper' )).'>';
			echo '<div '.multifox_html_output($this->get_render_attribute_string( 'map' )).'></div>';
		echo '</div>';
	}
}