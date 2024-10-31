<?php
use MultifoxElementor\Widgets\MultifoxElementorWidgetBase;
use Elementor\Group_Control_Typography;
use Elementor\Controls_Manager;
use Elementor\Repeater;
use Elementor\Utils;

class Elementor_OrderedList extends MultifoxElementorWidgetBase {

    public function get_name() {
        return 'mfx-ordered-list';
    }

    public function get_title() {
        return esc_html__('Ordered List', 'multifox-plus');
    }

    public function get_icon() {
		return 'eicon-bullet-list mfx-icon';
	}

	public function get_style_depends() {
		return array( 'mfx-ordered-list' );
	}

    protected function _register_controls() {

		$this->start_controls_section( 'section_icon', array(
			'label' => esc_html__( 'Ordered List', 'multifox-plus' ),
		) );

			$this->add_control( 'view', array(
				'label'          => esc_html__( 'Layout', 'multifox-plus' ),
				'type'           => Controls_Manager::CHOOSE,
				'default'        => 'traditional',
				'render_type'    => 'template',
				'classes'        => 'elementor-control-start-end',
				'label_block'    => false,
				'style_transfer' => true,
				'prefix_class'   => 'elementor-icon-list--layout-',
				'options'        => array(
					'traditional' => array( 'title' => esc_html__( 'Default', 'multifox-plus' ), 'icon' => 'eicon-editor-list-ul' ),
					'inline'      => array( 'title' => esc_html__( 'Inline', 'multifox-plus' ), 'icon' => 'eicon-ellipsis-h' ),
				),
			) );

			$this->add_control( 'style', array(
				'label'        => esc_html__( 'Ordered Style', 'multifox-plus' ),
				'type'         => Controls_Manager::SELECT2,
				'default'      => 'decimal-leading-zero',
				'label_block'  => true,
				'options'      => array(
					'decimal'              => esc_html__( 'Decimal', 'multifox-plus' ),
					'decimal-leading-zero' => esc_html__( 'Decimal With Leading Zero', 'multifox-plus' ),
					'lower-alpha'          => esc_html__( 'Lower Alpha', 'multifox-plus' ),
					'lower-roman'          => esc_html__( 'Lower Roman', 'multifox-plus' ),
					'upper-alpha'          => esc_html__( 'Upper Alpha', 'multifox-plus' ),
					'upper-roman'          => esc_html__( 'Upper Roman', 'multifox-plus' ),
				),
			) );

			$repeater = new Repeater();

			$repeater->add_control( 'text', array(
				'label'       => esc_html__( 'Text', 'multifox-plus' ),
				'type'        => Controls_Manager::TEXT,
				'label_block' => true,
				'placeholder' => esc_html__( 'List Item', 'multifox-plus' ),
				'default'     => esc_html__( 'List Item', 'multifox-plus' ),
			) );

			$repeater->add_control( 'link', array(
				'label'       => esc_html__( 'Link', 'multifox-plus' ),
				'type'        => Controls_Manager::URL,
				'label_block' => true,
				'placeholder' => esc_html__( 'https://your-link.com', 'multifox-plus' ),
			) );

			$this->add_control( 'list', array(
				'label'   => '',
				'type'    => Controls_Manager::REPEATER,
				'fields'  => $repeater->get_controls(),
				'default' => array(
					array( 'text' => esc_html__( 'List Item #1', 'multifox-plus' ) ),
					array( 'text' => esc_html__( 'List Item #2', 'multifox-plus' ) ),
					array( 'text' => esc_html__( 'List Item #3', 'multifox-plus' ) ),
					array( 'text' => esc_html__( 'List Item #4', 'multifox-plus' ) ),
					array( 'text' => esc_html__( 'List Item #5', 'multifox-plus' ) ),
				)
			) );

		$this->end_controls_section();

		$this->start_controls_section( 'section_icon_list', array(
			'label' => esc_html__( 'List', 'multifox-plus' ),
			'tab'   => Controls_Manager::TAB_STYLE,
		) );

			$this->add_responsive_control( 'space_between', array(
				'label'     => esc_html__( 'Space Between', 'multifox-plus' ),
				'type'      => Controls_Manager::SLIDER,
				'range'     => array( 'px' => array( 'max' => 50 ) ),
				'selectors' => array(
					'{{WRAPPER}} .mfx-elementor-ordered-list-items:not(.elementor-inline-items) .mfx-elementor-ordered-list-item:not(:last-child)'  => 'padding-bottom: calc({{SIZE}}{{UNIT}}/2)',
					'{{WRAPPER}} .mfx-elementor-ordered-list-items:not(.elementor-inline-items) .mfx-elementor-ordered-list-item:not(:first-child)' => 'margin-top: calc({{SIZE}}{{UNIT}}/2)',
					'{{WRAPPER}} .mfx-elementor-ordered-list-items.elementor-inline-items .mfx-elementor-ordered-list-item'                         => 'margin-right: calc({{SIZE}}{{UNIT}}/2); margin-left: calc({{SIZE}}{{UNIT}}/2)',
					'{{WRAPPER}} .mfx-elementor-ordered-list-items.elementor-inline-items'                                                         => 'margin-right: calc(-{{SIZE}}{{UNIT}}/2); margin-left: calc(-{{SIZE}}{{UNIT}}/2)',
					'body.rtl {{WRAPPER}} .mfx-elementor-ordered-list-items.elementor-inline-items .elementor-ordered-list-item:after'             => 'left: calc(-{{SIZE}}{{UNIT}}/2)',
					'body:not(.rtl) {{WRAPPER}} .mfx-elementor-ordered-list-items.elementor-inline-items .mfx-elementor-ordered-list-item:after'    => 'right: calc(-{{SIZE}}{{UNIT}}/2)',
				)
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

		$this->start_controls_section( 'section_text_style', array(
			'label' => esc_html__( 'Text', 'multifox-plus' ),
			'tab'   => Controls_Manager::TAB_STYLE,
		) );

			$this->add_control( 'color', array(
				'label'     => esc_html__( 'Color', 'multifox-plus' ),
				'type'      => Controls_Manager::COLOR,
				'default'   => '',
				'selectors' => array( '{{WRAPPER}} .mfx-elementor-ordered-list-item span' => 'color: {{VALUE}};' ),
			) );

			$this->add_control( 'hover_color', array(
				'label'     => esc_html__( 'Hover Color', 'multifox-plus' ),
				'type'      => Controls_Manager::COLOR,
				'default'   => '',
				'selectors' => array( '{{WRAPPER}} .mfx-elementor-ordered-list-item:hover span' => 'color: {{VALUE}};' ),
			) );

			$this->add_group_control( Group_Control_Typography::get_type(), array(
				'name'     => 'typography',
				'selector' => '{{WRAPPER}} .mfx-elementor-ordered-list-item',
			) );

		$this->end_controls_section();

	}

    protected function render() {

    	$output = '';

		$settings = $this->get_settings_for_display();
		extract($settings);

		$this->add_render_attribute( 'list', 'class', 'mfx-elementor-ordered-list-items mfx-fancy-list' );
		$this->add_render_attribute( 'list', 'class', $style );

		$this->add_render_attribute( 'items', 'class', 'mfx-elementor-ordered-list-item' );
		if ( 'inline' === $settings['view'] ) {
			$this->add_render_attribute( 'list', 'class', 'elementor-inline-items' );
			$this->add_render_attribute( 'items', 'class', 'elementor-inline-item' );
		}

		$output .= '<ol '.multifox_html_output($this->get_render_attribute_string( 'list' )).'>';
			foreach( $list as $index => $item ) {
				$output .= '<li '.multifox_html_output($this->get_render_attribute_string( 'items' )).'>';
					$output .= '<span>';
						if ( ! empty( $item['link']['url'] ) ) {
							$link_key = 'link_' . esc_attr($index);

							$this->add_render_attribute( $link_key, 'href', $item['link']['url'] );

							if ( $item['link']['is_external'] ) {
								$this->add_render_attribute( $link_key, 'target', '_blank' );
							}

							if ( $item['link']['nofollow'] ) {
								$this->add_render_attribute( $link_key, 'rel', 'nofollow' );
							}

							$output .= '<a ' . multifox_html_output($this->get_render_attribute_string( $link_key )) . '>';
						}

						$output .= $item['text'];

						if ( ! empty( $item['link']['url'] ) ) {
							$output .= '</a>';
						}
					$output .= '</span>';
				$output .= '</li>';
			}
		$output .= '</ol>';

		echo multifox_html_output($output);
	}
}