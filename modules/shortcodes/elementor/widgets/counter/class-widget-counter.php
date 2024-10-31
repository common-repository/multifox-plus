<?php
use MultifoxElementor\Widgets\MultifoxElementorWidgetBase;
use Elementor\Controls_Manager;
use Elementor\Repeater;
use Elementor\Utils;
use Elementor\Group_Control_Typography;

class Elementor_Counter extends MultifoxElementorWidgetBase {

    public function get_name() {
        return 'mfx-counter';
    }

    public function get_title() {
        return esc_html__('Counter', 'multifox-plus');
    }

    public function get_icon() {
		return 'eicon-number-field mfx-icon';
	}

	public function get_style_depends() {
		return array( 'mfx-counter' );
	}

	public function get_script_depends() {
		return array( 'jquery-animateNumber', 'jquery-inview', 'mfx-counter' );
	}

    protected function register_controls() {

        $this->start_controls_section( 'mfx_section_general', array(
            'label' => esc_html__( 'General', 'multifox-plus'),
        ) );

			$this->add_control(
				'type',
				[
					'label' => esc_html__( 'Type', 'multifox-plus' ),
					'type' => Controls_Manager::SELECT,
					'default' => 'type1',
					'options' => array(
						'type1' => esc_html__( 'Default', 'multifox-plus' ),
						'type2' => esc_html__( 'Type 2', 'multifox-plus' )
					),
				]
			);

			$this->add_control(
				'title',
				[
					'label' => esc_html__( 'Title', 'multifox-plus' ),
					'type' => Controls_Manager::TEXT
				]
			);

			$this->add_control(
				'subtitle',
				[
					'label' => esc_html__( 'Sub Title', 'multifox-plus' ),
					'type' => Controls_Manager::TEXT
				]
			);

			$this->add_control(
				'selected_icon',
				[
					'label' => esc_html__( 'Icon', 'multifox-plus' ),
					'type' => Controls_Manager::ICONS,
					'default' => [
						'value' => 'fas fa-star',
						'library' => 'fa-solid',
					],
				]
			);

			$this->add_control(
				'num_prefix',
				[
					'label' => esc_html__( 'Number Prefix', 'multifox-plus' ),
					'type' => Controls_Manager::TEXT
				]
			);

			$this->add_control(
				'num_suffix',
				[
					'label' => esc_html__( 'Number Suffix', 'multifox-plus' ),
					'type' => Controls_Manager::TEXT
				]
			);

			$this->add_control(
				'number',
				[
					'label' => esc_html__( 'Number', 'multifox-plus' ),
					'type' => Controls_Manager::NUMBER
				]
			);

		$this->end_controls_section();

		$this->start_controls_section(
			'section_title',
			[
				'label' => esc_html__( 'Title', 'multifox-plus' ),
				'tab' => Controls_Manager::TAB_STYLE,
			]
		);

			$this->add_control(
				'title_color',
				[
					'label' => esc_html__( 'Text Color', 'multifox-plus' ),
					'type' => Controls_Manager::COLOR,
					'selectors' => [
						'{{WRAPPER}} h4' => 'color: {{VALUE}};',
					],
				]
			);

			$this->add_group_control(
				Group_Control_Typography::get_type(),
				[
					'name' => 'typography_title',
					'selector' => '{{WRAPPER}} h4',
				]
			);

		$this->end_controls_section();

		$this->start_controls_section(
			'section_subtitle',
			[
				'label' => esc_html__( 'Sub Title', 'multifox-plus' ),
				'tab' => Controls_Manager::TAB_STYLE,
			]
		);

			$this->add_control(
				'subtitle_color',
				[
					'label' => esc_html__( 'Text Color', 'multifox-plus' ),
					'type' => Controls_Manager::COLOR,
					'selectors' => [
						'{{WRAPPER}} .mfx-counter-subtitle' => 'color: {{VALUE}};',
					],
				]
			);

			$this->add_group_control(
				Group_Control_Typography::get_type(),
				[
					'name' => 'typography_subtitle',
					'selector' => '{{WRAPPER}} .mfx-counter-subtitle',
				]
			);

		$this->end_controls_section();


		$this->start_controls_section(
			'section_icon',
			[
				'label' => esc_html__( 'Icon', 'multifox-plus' ),
				'tab' => Controls_Manager::TAB_STYLE,
			]
		);

			$this->add_control(
				'icon_color',
				[
					'label' => esc_html__( 'Text Color', 'multifox-plus' ),
					'type' => Controls_Manager::COLOR,
					'selectors' => [
						'{{WRAPPER}} .mfx-counter-icon-wrapper span' => 'color: {{VALUE}};',
					],
				]
			);

			$this->add_group_control(
				Group_Control_Typography::get_type(),
				[
					'name' => 'typography_icon',
					'selector' => '{{WRAPPER}} .mfx-counter-icon-wrapper',
				]
			);

		$this->end_controls_section();

		$this->start_controls_section(
			'section_number',
			[
				'label' => esc_html__( 'Number', 'multifox-plus' ),
				'tab' => Controls_Manager::TAB_STYLE,
			]
		);

			$this->add_control(
				'number_color',
				[
					'label' => esc_html__( 'Text Color', 'multifox-plus' ),
					'type' => Controls_Manager::COLOR,
					'selectors' => [
						'{{WRAPPER}} .mfx-counter-number' => 'color: {{VALUE}};',
					],
				]
			);

			$this->add_group_control(
				Group_Control_Typography::get_type(),
				[
					'name' => 'typography_number',
					'selector' => '{{WRAPPER}} .mfx-counter-number',
				]
			);

		$this->end_controls_section();
    }

    protected function render() {

		$settings = $this->get_settings();
		extract($settings);

		$icon_wrap = '';
		if($selected_icon['library'] == 'svg' && !empty( $selected_icon['value']['url'] ) ) {
			$icon_wrap = '<span><img src="'.esc_attr($selected_icon['value']['url']).'"></span>';
		} elseif( !empty( $selected_icon['value'] ) ) {
			$icon_wrap = '<span class="'.esc_attr($selected_icon['value']).'"></span>';
		}

		$output = '<div class="mfx-counter-wrapper '.esc_attr($type).'">';
			$output .= '<div class="mfx-counter-inner">';

				$output .= ( $type == 'type1' ) ? '<div class="mfx-couter-icon-holder">' : '';

				if( !empty( $icon_wrap ) ) {
					$output .= '<div class="mfx-counter-icon-wrapper">';
						$output .= $icon_wrap;
					$output .= '</div>';
				}

				$output .= '<div class="mfx-counter-number" data-value="'.esc_attr($number).'">';

					$output .= '<div class="mfx-prefix">'.esc_html($num_prefix).'</div>';

					$output .= '<div class="mfx-number">'.esc_html($number).'</div>';

					$output .= '<div class="mfx-suffix">'.esc_html($num_suffix).'</div>';

				$output .= '</div>';

				$output .= ( $type == 'type1' ) ? '</div>' : '';

				$output .= '<div class="mfx-counter-content-wrapper">';
					if(!empty($title)) {
						$output .= '<h4 class="mfx-counter-title">'.esc_attr($title).'</h4>';
					}
					if(!empty($subtitle)) {
						$output .= '<div class="mfx-counter-subtitle">'.esc_attr($subtitle).'</div>';
					}
				$output .= '</div>';
			$output .= '</div>';
		$output .= '</div>';

		echo multifox_html_output($output);

	}

}