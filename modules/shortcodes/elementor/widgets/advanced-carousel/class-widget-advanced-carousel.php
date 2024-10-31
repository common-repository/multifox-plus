<?php
use MultifoxElementor\Widgets\MultifoxElementorWidgetBase;
use Elementor\Group_Control_Typography;
use Elementor\Group_Control_Border;
use Elementor\Group_Control_Image_Size;
use Elementor\Controls_Manager;
use Elementor\Repeater;
use Elementor\Utils;

use Elementor\Icons_Manager;

class Elementor_Advanced_Carousel extends MultifoxElementorWidgetBase {
    public function get_name() {
        return 'mfx-advanced-carousel';
    }

    public function get_title() {
        return esc_html__('Advanced Carousel', 'multifox-plus');
    }

    public function get_icon() {
		return 'eicon-slider-push mfx-icon';
	}

	public function get_style_depends() {
		return array( 'jquery-slick', 'mfx-advanced-carousel' );
	}

	public function get_script_depends() {
		return array( 'jquery-slick', 'mfx-advanced-carousel' );
	}

    protected function _register_controls() {
        $this->start_controls_section( 'mfx_section_general', array(
            'label' => esc_html__( 'General', 'multifox-plus'),
        ) );
			$repeater = new Repeater();
			$repeater->add_control( 'item_type', array(
				'label'   => esc_html__( 'Content Type', 'multifox-plus' ),
				'type'    => Controls_Manager::SELECT2,
				'default' => 'default',
				'options' => array(
					'default'  => esc_html__( 'Default', 'multifox-plus' ),
					'template' => esc_html__( 'Template', 'multifox-plus' ),
				)
			) );
			$repeater->add_control(
				'graphic_element_front',
				array (
					'label' => esc_html__( 'Graphic Element', 'multifox-plus' ),
					'type' => Controls_Manager::CHOOSE,
					'label_block' => false,
					'options' => array (
						'none' => array (
							'title' => esc_html__( 'None', 'multifox-plus' ),
							'icon' => 'fa fa-ban',
						),
						'image' => array (
							'title' => esc_html__( 'Image', 'multifox-plus' ),
							'icon' => 'fa fa-picture-o',
						),
						'icon' => array (
							'title' => esc_html__( 'Icon', 'multifox-plus' ),
							'icon' => 'fa fa-star',
						),
					),
					'default' => 'icon',
					'condition' => array( 'item_type' => 'default' )
				)
			);
			$repeater->add_control(
				'image_front',
				array (
					'label' => esc_html__( 'Choose Image', 'multifox-plus' ),
					'type' => Controls_Manager::MEDIA,
					'default' => array (
						'url' => Utils::get_placeholder_image_src(),
					),
					'condition' => array (
						'graphic_element_front' => 'image',
					),
				)
			);
			$repeater->add_group_control(
				Group_Control_Image_Size::get_type(),
				array (
					'name' => 'image_front', // Actually its `image_size`
					'default' => 'thumbnail',
					'condition' => array (
						'graphic_element_front' => 'image',
					),
				)
			);
			$repeater->add_control(
				'icon_front',
				array (
					'label' => esc_html__( 'Icon', 'multifox-plus' ),
					'type' => Controls_Manager::ICONS,
					'default' => array( 'value' => 'fas fa-star', 'library' => 'fa-solid', ),
					'condition' => array (
						'graphic_element_front' => 'icon',
					),
				)
			);
			$repeater->add_control(
				'icon_view_front',
				array (
					'label' => esc_html__( 'View', 'multifox-plus' ),
					'type' => Controls_Manager::SELECT,
					'options' => array (
						'default' => esc_html__( 'Default', 'multifox-plus' ),
						'stacked' => esc_html__( 'Stacked', 'multifox-plus' ),
						'framed' => esc_html__( 'Framed', 'multifox-plus' ),
					),
					'default' => 'default',
					'condition' => array (
						'graphic_element_front' => 'icon',
					),
				)
			);
			$repeater->add_control(
				'icon_shape_front',
				array (
					'label' => esc_html__( 'Shape', 'multifox-plus' ),
					'type' => Controls_Manager::SELECT,
					'options' => array (
						'circle' => esc_html__( 'Circle', 'multifox-plus' ),
						'square' => esc_html__( 'Square', 'multifox-plus' ),
					),
					'default' => 'circle',
					'condition' => array (
						'icon_view_front!' => 'default',
						'graphic_element_front' => 'icon',
					),
				)
			);
			$repeater->add_control( 'item_title', array(
				'label'       => esc_html__( 'Title', 'multifox-plus' ),
				'type'        => Controls_Manager::TEXT,
				'label_block' => true,
				'placeholder' => esc_html__( 'Item Title', 'multifox-plus' ),
				'default'     => esc_html__( 'Item Title', 'multifox-plus' ),
				'condition'   => array( 'item_type' => 'default' )
			) );
			$repeater->add_control( 'item_text', array(
				'label'       => esc_html__( 'Description', 'multifox-plus' ),
				'type'        => Controls_Manager::TEXTAREA,
				'label_block' => true,
				'placeholder' => esc_html__( 'Item Description', 'multifox-plus' ),
				'default'     => 'Sed ut perspiciatis unde omnis iste natus error sit, eaque ipsa quae ab illo inventore veritatis et quasi architecto beatae.',
				'condition'   => array( 'item_type' => 'default' )
			) );
			$repeater->add_control( 'item_link', array(
				'label'       => esc_html__( 'Link', 'multifox-plus' ),
				'type'        => Controls_Manager::URL,
				'label_block' => true,
				'placeholder' => esc_html__( 'https://your-link.com', 'multifox-plus' ),
				'condition'   => array( 'item_type' => 'default' )
			) );
			$repeater->add_control( 'item_button_text', array(
				'label'     => esc_html__( 'Item Button Text', 'multifox-plus' ),
				'type'      => Controls_Manager::TEXT,
				'default'   => '',
				'condition' => array( 'item_type' => 'default', ),
			) );
			$repeater->add_control('item_template', array(
				'label'     => esc_html__( 'Select Template', 'multifox-plus' ),
				'type'      => Controls_Manager::SELECT,
				'options'   => $this->multifox_get_elementor_page_list(),
				'condition' => array( 'item_type' => 'template' )
			) );
			$this->add_control( 'multifox_carousel_slider_content', array(
				'type'        => Controls_Manager::REPEATER,
				'label'       => esc_html__('Carousel Items', 'multifox-plus'),
				'description' => esc_html__('Carousel items is a template which you can choose from Elementor library. Each template will be a carousel content', 'multifox-plus' ),
				'fields'      => $repeater->get_controls(),
			) );
			$this->add_responsive_control( 'align', array(
                'label'        => esc_html__( 'Alignment', 'multifox-plus' ),
                'type'         => Controls_Manager::CHOOSE,
                'prefix_class' => 'elementor%s-align-',
                'options'      => array(
                    'left'   => array( 'title' => esc_html__('Left','multifox-plus'), 'icon' => 'eicon-h-align-left' ),
                    'center' => array( 'title' => esc_html__('Center','multifox-plus'), 'icon' => 'eicon-h-align-center' ),
                    'right'  => array( 'title' => esc_html__('Right','multifox-plus'), 'icon' => 'eicon-h-align-right' ),
                )
            ) );
        $this->end_controls_section();

		$this->start_controls_section( 'mfx_section_additional', array(
			'label' => esc_html__( 'Carousel Options', 'multifox-plus'),
		) );
			$this->add_control( 'slider_type', array(
				'label'              => esc_html__( 'Slider Type', 'multifox-plus' ),
				'type'               => Controls_Manager::SELECT,
				'default'            => 'horizontal',
				'frontend_available' => true,
				'options'            => array(
					'horizontal' => esc_html__( 'Horizontal', 'multifox-plus' ),
					'vertical'   => esc_html__( 'Vertical', 'multifox-plus' ),
				),
			) );
			$this->add_control( 'slide_to_scroll', array(
				'label'              => esc_html__( 'Slider Type', 'multifox-plus' ),
				'type'               => Controls_Manager::SELECT,
				'default'            => 'single',
				'frontend_available' => true,
				'options'            => array(
					'all'    => esc_html__( 'All visible', 'multifox-plus' ),
					'single' => esc_html__( 'One at a Time', 'multifox-plus' ),
				),
			) );
			$this->add_responsive_control( 'item_to_show', array(
				'label'                => esc_html__( 'Items To Show', 'multifox-plus' ),
				'type'                 => Controls_Manager::NUMBER,
				'min'                  => 1,
				'max'                  => 8,
				'step'                 => 1,
				'desktop_default'      => 4,
				'laptop_default'       => 4,
				'tablet_default'       => 2,
				'tablet_extra_default' => 2,
				'mobile_default'       => 1,
				'mobile_extra_default' => 1,
				'frontend_available'   => true
			) );
			$this->add_control( 'infinite_loop', array(
				'label'              => esc_html__( 'Infinite loop', 'multifox-plus' ),
				'type'               => Controls_Manager::SWITCHER,
				'return_value'       => 'yes',
				'default'            => 'yes',
				'frontend_available' => true
			) );
			$this->add_control( 'speed', array(
				'label'       => esc_html__( 'Transition speed', 'multifox-plus' ),
				'type'        => Controls_Manager::NUMBER,
				'min'         => 0,
				'max'         => 10000,
				'step'        => 1,
				'default'     => 300,
				'description' => esc_html__( "Speed at which next slide comes.(ms)", "mfx-elementor" ),
			) );
			$this->add_control( 'autoplay', array(
				'label'              => esc_html__( 'Autoplay Slides?', 'multifox-plus' ),
				'type'               => Controls_Manager::SWITCHER,
				'return_value'       => 'yes',
				'default'            => 'yes',
				'frontend_available' => true
			) );
			$this->add_control( 'autoplay_speed', array(
				'label'       => esc_html__( 'Autoplay speed', 'multifox-plus' ),
				'type'        => Controls_Manager::NUMBER,
				'min'         => 0,
				'max'         => 10000,
				'step'        => 1,
				'default'     => 5000,
				'condition'   => array( 'autoplay' => 'yes' ),
				'description' => esc_html__( "Speed at which next slide comes.(ms)", "mfx-elementor" ),
			) );
			$this->add_control( 'draggable', array(
				'label'              => esc_html__( 'Draggable Effect?', 'multifox-plus' ),
				'type'               => Controls_Manager::SWITCHER,
				'return_value'       => 'yes',
				'default'            => 'yes',
				'frontend_available' => true,
				'description'        => esc_html__( "Allow slides to be draggable", "mfx-elementor" ),
			) );
			$this->add_control( 'touch_move', array(
				'label'              => esc_html__( 'Touch Move Effect?', 'multifox-plus' ),
				'type'               => Controls_Manager::SWITCHER,
				'return_value'       => 'yes',
				'default'            => 'yes',
				'frontend_available' => true,
				'description'        => esc_html__( "Enable slide moving with touch", "mfx-elementor" ),
				'condition'          => array( 'draggable' => 'yes' ),
			) );
			$this->add_control( 'adaptive_height', array(
				'label'              => esc_html__( 'Adaptive Height', 'multifox-plus' ),
				'type'               => Controls_Manager::SWITCHER,
				'return_value'       => 'yes',
				'default'            => 'yes',
				'frontend_available' => true,
				'description'        => esc_html__( "Turn on Adaptive Height", "mfx-elementor" ),
			) );
			$this->add_control( 'pauseohover', array(
				'label'              => esc_html__( 'Pause on hover', 'multifox-plus' ),
				'type'               => Controls_Manager::SWITCHER,
				'return_value'       => 'yes',
				'default'            => 'yes',
				'frontend_available' => true,
				'condition'          => array( 'autoplay' => 'yes' ),
				'description'        => esc_html__( "Pause the slider on hover", "mfx-elementor" ),
			) );
		$this->end_controls_section();

		$this->start_controls_section( 'multifox_arrow_section', array(
			'label' => esc_html__( 'Arrow', 'multifox-plus' ),
			'tab'   => Controls_Manager::TAB_STYLE,
		) );
			$this->add_control( 'arrows', array(
				'label'              => esc_html__( 'Navigation Arrows', 'multifox-plus' ),
				'type'               => Controls_Manager::SWITCHER,
				'return_value'       => 'yes',
				'default'            => 'yes',
				'frontend_available' => true,
				'description'        => esc_html__( "Display next / previous navigation arrows", "mfx-elementor" ),
			) );
			$this->add_control( 'arrow_style', array(
				'label'              => esc_html__( 'Arrow Style', 'multifox-plus' ),
				'type'               => Controls_Manager::SELECT,
				'default'            => 'default',
				'frontend_available' => true,
				'condition'          => array( 'arrows' => 'yes' ),
				'options'            => array(
					'default'       => esc_html__('Default', 'multifox-plus' ),
					'circle-bg'     => esc_html__('Circle Background', 'multifox-plus' ),
					'square-bg'     => esc_html__('Square Background','multifox-plus'),
					'circle-border' => esc_html__('Circle Border','multifox-plus'),
					'square-border' => esc_html__('Square Border','multifox-plus'),
				),
			) );
			$this->add_control( 'prev_arrow', array(
				'label'     => esc_html__('Prev Arrow','multifox-plus'),
				'type'      => Controls_Manager::ICON,
				'condition' => array( 'arrows' => 'yes' ),
				'include'   => array(
					'eicon-chevron-double-left',
					'eicon-arrow-left',
					'eicon-long-arrow-left',
					'eicon-chevron-left',
					'eicon-caret-left',
					'eicon-angle-left',
				),
				'default' => 'eicon-arrow-left',
				'skin' => 'inline',
				'label_block' => true,
			) );
			$this->add_control( 'next_arrow', array(
				'label'     => esc_html__('Next Arrow','multifox-plus'),
				'type'      => Controls_Manager::ICON,
				'condition' => array( 'arrows' => 'yes' ),
				'include'   => array(
					'eicon-chevron-double-right',
					'eicon-arrow-right',
					'eicon-long-arrow-right',
					'eicon-chevron-right',
					'eicon-caret-right',
					'eicon-angle-right',
				),
				'default' => 'eicon-arrow-right',
				'skin' => 'inline',
				'label_block' => true,
			) );
		$this->end_controls_section();

		$this->start_controls_section( 'multifox_navigation_section', array(
			'label' => esc_html__( 'Navigation', 'multifox-plus' ),
			'tab'   => Controls_Manager::TAB_STYLE,
		) );
			$this->add_control( 'navigation', array(
				'label'              => esc_html__( 'Dot Navigation', 'multifox-plus' ),
				'type'               => Controls_Manager::SWITCHER,
				'return_value'       => 'yes',
				'default'            => 'yes',
				'frontend_available' => true,
				'description'        => esc_html__( "Display dot navigation", "mfx-elementor" ),
			) );
			$this->add_control( 'dot_style', array(
				'label'              => esc_html__( 'Dot Style', 'multifox-plus' ),
				'type'               => Controls_Manager::SELECT,
				'default'            => 'slick-dots style-1',
				'frontend_available' => true,
				'condition'          => array( 'navigation' => 'yes' ),
				'options'            => array(
					'slick-dots style-1' 	=> esc_html__('Style 1', 'multifox-plus' ),
					'slick-dots style-2'    => esc_html__('Style 2', 'multifox-plus' ),
					'slick-dots style-3'    => esc_html__('Style 3', 'multifox-plus' ),
					'slick-dots style-4'    => esc_html__('Style 4', 'multifox-plus' ),
					'slick-dots style-5'    => esc_html__('Style 5', 'multifox-plus' ),
					'slick-dots style-6'    => esc_html__('Style 6', 'multifox-plus' ),
					'slick-dots style-7'    => esc_html__('Style 7', 'multifox-plus' ),
					'slick-dots style-8'    => esc_html__('Style 8', 'multifox-plus' ),
				),
			) );
		$this->end_controls_section();

		$this->start_controls_section( 'section_item_title_style', array(
        	'label'      => esc_html__( 'Item Title', 'multifox-plus' ),
			'tab'        => Controls_Manager::TAB_STYLE,
			'show_label' => false,
		) );

			$this->add_group_control( Group_Control_Typography::get_type(), array(
				'name'     => 'items_title_typography',
				'selector' => '{{WRAPPER}} .mfx-slick-content-title',
				'separator' => 'before',
			) );

        $this->end_controls_section();

        $this->start_controls_section( 'section_item_description_style', array(
        	'label'      => esc_html__( 'Item Content', 'multifox-plus' ),
			'tab'        => Controls_Manager::TAB_STYLE,
			'show_label' => false,
		) );

			$this->add_group_control( Group_Control_Typography::get_type(), array(
				'name'     => 'items_description_typography',
				'selector' => '{{WRAPPER}} .mfx-slick-content-text',
				'separator' => 'before',
			) );

        $this->end_controls_section();

    }

    protected function render() {

    	$out = '';
        $settings = $this->get_settings_for_display();
        extract($settings);

        if( $slide_to_scroll == 'all' ) {
			$slide_to_scroll = $item_to_show;
        } else {
			$slide_to_scroll = 1;
		}

        $carousel_settings = array(
			'adaptiveHeight'        => ( $adaptive_height == 'yes' ) ? true : false,
			'arrows'                => ( $arrows == 'yes' ) ? true : false,
			'arrows'                => ( $arrows == 'yes' ) ? true : false,
			'autoplay'              => ( $autoplay == 'yes' ) ? true : false,
			'dots'                  => ( $navigation == 'yes' ) ? true : false,
			'dotsClass'             => ( $navigation == 'yes' ) ? $dot_style : 'slick-dots',
			'draggable'             => ( $draggable == 'yes' ) ? true : false,
			'swipe'                 => ( $draggable == 'yes' ) ? true : false,
			'infinite'              => ( $infinite_loop == 'yes' ) ? true : false,
			'pauseOnDotsHover'      => true,
			'pauseOnFocus'          => false,
			'pauseOnHover'          => ( $pauseohover == 'yes' ) ? true : false,
			'slidesToScroll'        => $slide_to_scroll,
			'slidesToShow'          => $item_to_show,
			'speed'                 => $speed,
			'touchMove'             => ( $touch_move == 'yes' ) ? true : false,
			'vertical'              => ( $slider_type == 'vertical' ) ? true : false
        );

		$active_breakpoints = \Elementor\Plugin::$instance->breakpoints->get_active_breakpoints();
		$breakpoint_keys = array_keys($active_breakpoints);
		$breakpoint_keys= array_reverse($breakpoint_keys);
		foreach($breakpoint_keys as $breakpoint) {
			$breakpointstr = 'item_to_show_'.$breakpoint;
			$toshowscroll = $$breakpointstr;
			if($toshowscroll == '') {
				if($breakpoint == 'mobile') {
					$toshowscroll = 1;
				} else if($breakpoint == 'mobile_extra') {
					$toshowscroll = 1;
				} else if($breakpoint == 'tablet') {
					$toshowscroll = 2;
				} else if($breakpoint == 'tablet_extra') {
					$toshowscroll = 2;
				} else if($breakpoint == 'laptop') {
					$toshowscroll = 4;
				} else {
					$toshowscroll = 4;
				}
			}
			$carousel_settings['responsive'][$breakpoint]['breakpoint'] = $active_breakpoints[$breakpoint]->get_value();
			$carousel_settings['responsive'][$breakpoint]['toshow'] = $toshowscroll;
			if( $slide_to_scroll == 'all' ) {
				$carousel_settings['responsive'][$breakpoint]['toscroll'] = $toshowscroll;
			} else {
				$carousel_settings['responsive'][$breakpoint]['toscroll'] = 1;
			}
		}

        if( $arrows == 'yes' ) {
			$carousel_settings['arrowStyle'] = $arrow_style;
			$carousel_settings['nextArrowLabel'] = $next_arrow;
			$carousel_settings['prevArrowLabel'] = $prev_arrow;
        }

        if(  $autoplay == 'yes' && !empty( $$autoplay_speed ) ) {
        	$carousel_settings['autoplaySpeed'] = $autoplay_speed;
        }

		$carousel_settings_json = htmlspecialchars(json_encode($carousel_settings, JSON_HEX_APOS));

        $out .= '<div class="mfx-advanced-carousel-wrapper" data-settings="'.esc_js($carousel_settings_json).'">';

			if( count( $multifox_carousel_slider_content ) > 0 ) {
				foreach( $multifox_carousel_slider_content as $key => $item ) {

					if ( 'icon' === $item['graphic_element_front'] ) {
						$this->add_render_attribute( 'icon-wrapper-front-'.esc_attr($key), 'class', 'mfx-slick-content-icon-wrapper' );
						$this->add_render_attribute( 'icon-wrapper-front-'.esc_attr($key), 'class', 'mfx-slick-content-icon-view-' . esc_attr($item['icon_view_front']) );
						if ( 'default' != $item['icon_view_front'] ) {
							$this->add_render_attribute( 'icon-wrapper-front-'.esc_attr($key), 'class', 'mfx-slick-content-icon-shape-' . esc_attr($item['icon_shape_front']) );
						}
					}

					$out .= '<div class="mfx-advanced-carousel-item-wrapper">';
						if( $item['item_type'] == 'default' ) {

							$link = $link_close = '';
							if( !empty( $item['item_link']['url'] ) ){

								$target = ( $item['item_link']['is_external'] == 'on' ) ? ' target="_blank" ' : '';
								$target = ( $item['item_link']['nofollow'] == 'on' ) ? 'rel="nofollow" ' : '';

								$link = '<a href="'.esc_url( $item['item_link']['url'] ).'"'. $target . $nofollow.'>';
								$link_close = '</a>';
							}

							$out .= '<div class="mfx-slick-content-wrapper">';

								if ( 'image' === $item['graphic_element_front'] && ! empty( $item['image_front']['url'] ) ) :
									$out .= '<div class="mfx-slick-content-image">';
										$image_front_setting = array ();
										$image_front_setting['image'] = $item['image_front'];
										$image_front_setting['image_size'] = $item['image_front_size'];
										$image_front_setting['image_custom_dimension'] = isset($item['image_front_custom_dimension']) ? $item['image_front_custom_dimension'] : array ();

										$out .= $link;
											$out .= Group_Control_Image_Size::get_attachment_image_html( $image_front_setting );
										$out .= $link_close;
									$out .= '</div>';

								elseif ( 'icon' === $item['graphic_element_front'] && ! empty( $item['icon_front'] ) ) :
									$out .= '<div '.$this->get_render_attribute_string( 'icon-wrapper-front-'.esc_attr($key) ).'>';
										$out .= '<div class="mfx-slick-content-icon">';
											ob_start();
												Icons_Manager::render_icon( $item['icon_front'], [ 'aria-hidden' => 'true' ] );
											$out .= ob_get_clean();
										$out .= '</div>';
									$out .= '</div>';
								endif;

								if( !empty( $item['item_title'] ) || !empty( $item['item_text'] ) || !empty( $item['item_button_text'] ) ) {
									$out .= '<div class="mfx-slick-content">';
										if( !empty( $item['item_title'] ) ) {
											$out .= '<div class="mfx-slick-content-title">';
												$out .= $link;
													$out .= esc_html( $item['item_title'] );
												$out .= $link_close;
											$out .= '</div>';
										}
										$out .= !empty( $item['item_text'] ) ? '<div class="mfx-slick-content-text">'. esc_html( $item['item_text'] ) . '</div>' : '';

										if( !empty( $link ) ){
											$out .= !empty( $item['item_button_text'] ) ? '<div class="mfx-slick-content-btn">'. $link . $item['item_button_text'] .'</a> </div>' : '';
										}

									$out .= '</div>';
								}

							$out .= '</div>';
						}

						if( $item['item_type'] == 'template' ) {

							//$out .='Lorem ipsum dolor sit amet, consectetur adipiscing elit, sed do eiusmod tempor incididunt ut labore.';

							if( class_exists( '\Elementor\Plugin' ) ) {

								$elementor_instance = Elementor\Plugin::instance();

								if( class_exists( '\Elementor\Core\Files\CSS\Post' ) ) {
									$css_file = new \Elementor\Core\Files\CSS\Post( $item['item_template'] );
									$css_file->enqueue();
								}

								if( !empty( $elementor_instance ) ) {
									$out .= multifox_html_output($elementor_instance->frontend->get_builder_content_for_display( $item['item_template'] ));
								}

							}

						}
					$out .= '</div>';
				}
			}

        $out .= '</div>';

        echo multifox_html_output($out);
    }
}