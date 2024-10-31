<?php
use MultifoxElementor\Widgets\MultifoxElementorWidgetBase;
use Elementor\Group_Control_Typography;
use Elementor\Controls_Manager;
use Elementor\Icons_Manager;
use Elementor\Utils;

class Elementor_Button extends MultifoxElementorWidgetBase {
    public function get_name() {
        return 'mfx-button';
    }

    public function get_title() {
        return esc_html__('Button', 'multifox-plus');
    }

    public function get_icon() {
		return 'eicon-button mfx-icon';
	}

	public function get_style_depends() {
		return array( 'mfx-button' );
	}

    protected function _register_controls() {
        $this->start_controls_section( 'mfx_section_general', array(
            'label' => esc_html__( 'Button', 'multifox-plus'),
        ) );
			$this->add_control( 'text', array(
				'label'       => esc_html__( 'Text', 'multifox-plus' ),
				'type'        => Controls_Manager::TEXT,
				'default'     => esc_html__( 'Click here', 'multifox-plus' ),
				'placeholder' => esc_html__( 'Click here', 'multifox-plus' ),
			) );
			$this->add_control( 'link',array(
				'label'       => esc_html__( 'Link', 'multifox-plus' ),
				'type'        => Controls_Manager::URL,
				'placeholder' => esc_html__( 'https://your-link.com', 'multifox-plus' ),
				'default'     => array( 'url' => '#' ),
			) );
			$this->add_responsive_control( 'align', array(
				'label'   => esc_html__( 'Alignment', 'multifox-plus' ),
				'type'    => Controls_Manager::CHOOSE,
				'options' => array(
					'left'    => array( 'title' => esc_html__( 'Left', 'multifox-plus' ), 'icon' => 'eicon-text-align-left', ),
					'center'  => array( 'title' => esc_html__( 'Center', 'multifox-plus' ), 'icon' => 'eicon-text-align-center', ),
					'right'   => array( 'title' => esc_html__( 'Right', 'multifox-plus' ), 'icon' => 'eicon-text-align-right', ),
					'justify' => array( 'title' => esc_html__( 'Justified', 'multifox-plus' ), 'icon' => 'eicon-text-align-justify', ),
				),
				'prefix_class' => 'elementor%s-align-',
				'default'      => '',
			) );
			$this->add_control( 'size', array(
				'label'          => esc_html__( 'Size', 'multifox-plus' ),
				'type'           => Controls_Manager::SELECT,
				'default'        => 'sm',
				'options'        => array(
					'xs' => esc_html__( 'Extra Small', 'multifox-plus' ),
					'sm' => esc_html__( 'Small', 'multifox-plus' ),
					'md' => esc_html__( 'Medium', 'multifox-plus' ),
					'lg' => esc_html__( 'Large', 'multifox-plus' ),
					'xl' => esc_html__( 'Extra Large', 'multifox-plus' ),
				),
				'style_transfer' => true,
			) );
			$this->add_control( 'style', array(
				'label'          => esc_html__( 'Style', 'multifox-plus' ),
				'type'           => Controls_Manager::SELECT,
				'default'        => '',
				'options'        => array(
					''            => esc_html__( 'Default', 'multifox-plus' ),
					'mfx-bordered' => esc_html__( 'Bordered', 'multifox-plus' ),
				),
				'style_transfer' => true,
			) );
			$this->add_control( 'corner', array(
				'label'          => esc_html__( 'Corner Style', 'multifox-plus' ),
				'type'           => Controls_Manager::SELECT,
				'default'        => '',
				'options'        => array(
					''                  => esc_html__( 'Default', 'multifox-plus' ),
					'mfx-curve-cornered' => esc_html__( 'Curve', 'multifox-plus' ),
					'mfx-round-cornered' => esc_html__( 'Rounded', 'multifox-plus' ),
				),
				'style_transfer' => true,
			) );
			$this->add_control( 'selected_icon', array(
				'label'            => esc_html__( 'Icon', 'multifox-plus' ),
				'type'             => Controls_Manager::ICONS,
				'label_block'      => true,
				'fa4compatibility' => 'icon',
			) );
			$this->add_control( 'icon_align', array(
				'label'     => esc_html__( 'Icon Position', 'multifox-plus' ),
				'type'      => Controls_Manager::SELECT,
				'default'   => 'left',
				'options'   => array(
					'left'  => esc_html__( 'Before', 'multifox-plus' ),
					'right' => esc_html__( 'After', 'multifox-plus' ),
				),
				'condition' => array(
					'selected_icon[value]!' => '',
				),
			) );
			$this->add_control( 'icon_indent', array(
				'label'     => esc_html__( 'Icon Spacing', 'multifox-plus' ),
				'type'      => Controls_Manager::SLIDER,
				'range'     => array( 'px' => array( 'max' => 50, ), ),
				'selectors' => array(
					'{{WRAPPER}} .elementor-button .elementor-align-icon-right' => 'margin-left: {{SIZE}}{{UNIT}};',
					'{{WRAPPER}} .elementor-button .elementor-align-icon-left' => 'margin-right: {{SIZE}}{{UNIT}};',
				),
			) );
        $this->end_controls_section();
    }

    protected function render() {
		$settings = $this->get_settings_for_display();

		$this->add_render_attribute( 'wrapper', 'class', 'elementor-button-wrapper mfx-elementor-button-wrapper' );

		if ( ! empty( $settings['link']['url'] ) ) {
			$this->add_link_attributes( 'button', $settings['link'] );
			$this->add_render_attribute( 'button', 'class', 'elementor-button-link mfx-elementor-button-link' );
		}

		$this->add_render_attribute( 'button', 'class', 'elementor-button mfx-elementor-button' );
		$this->add_render_attribute( 'button', 'role', 'button' );

		if ( ! empty( $settings['size'] ) ) {
			$this->add_render_attribute( 'button', 'class', 'elementor-size-' . esc_attr($settings['size']) );
		}

		if ( ! empty( $settings['style'] ) ) {
			$this->add_render_attribute( 'button', 'class', $settings['style'] );
		}

		if ( ! empty( $settings['corner'] ) ) {
			$this->add_render_attribute( 'button', 'class', $settings['corner'] );
		}

		if ( isset($settings['hover_animation'] ) ) {
			$this->add_render_attribute( 'button', 'class', 'elementor-animation-' . esc_attr($settings['hover_animation']) );
		}
		?>
		<div <?php echo multifox_html_output($this->get_render_attribute_string( 'wrapper' )); ?>>
			<a <?php echo multifox_html_output($this->get_render_attribute_string( 'button' )); ?>>
				<?php multifox_html_output($this->render_text()); ?>
			</a>
		</div><?php
    }

	protected function render_text() {
		$settings = $this->get_settings_for_display();

		$migrated = isset( $settings['__fa4_migrated']['selected_icon'] );
		$is_new = empty( $settings['icon'] ) && Icons_Manager::is_migration_allowed();

		if ( ! $is_new && empty( $settings['icon_align'] ) ) {
			$settings['icon_align'] = $this->get_settings( 'icon_align' );
		}

		$this->add_render_attribute( [
			'content-wrapper' => [
				'class' => 'elementor-button-content-wrapper mfx-elementor-button-content-wrapper',
			],
			'icon-align' => [
				'class' => [
					'elementor-button-icon',
					'elementor-align-icon-' . esc_attr($settings['icon_align']),
				],
			],
			'text' => [
				'class' => 'elementor-button-text mfx-elementor-button-text',
			],
		] );

		$this->add_inline_editing_attributes( 'text', 'none' );
		?>
		<span <?php echo multifox_html_output($this->get_render_attribute_string( 'content-wrapper' )); ?>>
			<?php if ( ! empty( $settings['icon'] ) || ! empty( $settings['selected_icon']['value'] ) ) : ?>
			<span <?php echo multifox_html_output($this->get_render_attribute_string( 'icon-align' )); ?>>
				<?php if ( $is_new || $migrated ) :
					Icons_Manager::render_icon( $settings['selected_icon'], [ 'aria-hidden' => 'true' ] );
				else : ?>
					<i class="<?php echo esc_attr( $settings['icon'] ); ?>" aria-hidden="true"></i>
				<?php endif; ?>
			</span>
			<?php endif; ?>
			<span <?php echo multifox_html_output($this->get_render_attribute_string( 'text' )); ?>><?php echo multifox_html_output($settings['text']); ?></span>
		</span>
		<?php
	}

	public function on_import( $element ) {
		return Icons_Manager::on_import_migration( $element, 'icon', 'selected_icon' );
	}
}