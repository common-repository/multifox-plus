<?php
use MultifoxElementor\Widgets\MultifoxElementorWidgetBase;
use Elementor\Controls_Manager;
use Elementor\Icons_Manager;
use Elementor\Repeater;
use Elementor\Utils;

class Elementor_Tabs extends MultifoxElementorWidgetBase {

    public function get_name() {
        return 'mfx-tabs';
    }

    public function get_title() {
        return esc_html__('Tabs', 'multifox-plus');
    }

    public function get_icon() {
		return 'eicon-number-field mfx-icon';
	}

	public function get_style_depends() {
		return array( 'mfx-tabs' );
	}

	public function get_script_depends() {
		return array( 'multifox-flowplayer-tabs', 'mfx-tabs' );
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
			$repeater->add_control( 'item_title', array(
				'label'       => esc_html__( 'Title', 'multifox-plus' ),
				'type'        => Controls_Manager::TEXT,
				'label_block' => true,
				'placeholder' => esc_html__( 'Tab Title', 'multifox-plus' ),
				'default'     => esc_html__( 'Tab Title', 'multifox-plus' )
			) );
			$repeater->add_control( 'icon_src', array(
				'label'        => esc_html__( 'Icon', 'multifox-plus' ),
				'type'         => Controls_Manager::ICONS,
				'default' => array(
					'value' => 'fas fa-search',
					'library' => 'fa-solid',
				)
			) );
			$repeater->add_control( 'item_content', array(
				'label'       => esc_html__( 'Content', 'multifox-plus' ),
				'type'        => Controls_Manager::TEXTAREA,
				'label_block' => true,
				'placeholder' => esc_html__( 'Tab Content', 'multifox-plus' ),
				'default'     => 'Sed ut perspiciatis unde omnis iste natus error sit, eaque ipsa quae ab illo inventore veritatis et quasi architecto beatae.',
				'condition'   => array( 'item_type' => 'default' )
			) );
			$repeater->add_control('item_template', array(
				'label'     => esc_html__( 'Select Template', 'multifox-plus' ),
				'type'      => Controls_Manager::SELECT,
				'label_block' => true,
				'options'   => $this->multifox_get_elementor_page_list(),
				'condition' => array( 'item_type' => 'template' )
			) );
			$this->add_control( 'tab_contents', array(
				'type'        => Controls_Manager::REPEATER,
				'label'       => esc_html__('Tab Contents', 'multifox-plus'),
				'description' => esc_html__('Tab contents is a template which you can choose from Elementor library. Each template will be a carousel content', 'multifox-plus' ),
				'fields'      => $repeater->get_controls(),
			) );
			$this->add_control( 'tab_style', array(
				'label'              => esc_html__( 'Tab Style', 'multifox-plus' ),
				'type'               => Controls_Manager::SELECT,
				'default'            => 'horizontal',
				'frontend_available' => true,
				'options'            => array(
					'horizontal' => esc_html__( 'Horizontal', 'multifox-plus' ),
					'vertical'   => esc_html__( 'Vertical', 'multifox-plus' ),
				),
			) );
        $this->end_controls_section();

    }

    protected function render() {

		$settings = $this->get_settings();
		extract($settings);

		$output = '';

		if( count( $tab_contents ) > 0 ) {
			$output .= '<div class="mfx-tab-container '.esc_attr($tab_style).'">';

				$output .= '<ul class="mfx-tab-titles">';
					foreach( $tab_contents as $key => $tab_content ) {
						$output .= '<li>';
							$output .= '<a href="javascript:void(0);">';
								ob_start();
								Icons_Manager::render_icon( $tab_content['icon_src'], [ 'aria-hidden' => 'true' ] );
								$icon = ob_get_clean();
								if($tab_content['icon_src']['library'] == 'svg') {
									$output .= '<i>'.$icon.'</i>';
								} else {
									$output .= $icon;
								}
								$output .= esc_html($tab_content['item_title']);
							$output .= '</a>';
						$output .= '</li>';
					}
				$output .= '</ul>';

				$i = 0;
				foreach( $tab_contents as $key => $tab_content ) {
					$style_attr = 'style="display: none;"';
					if($i == 0) {
						$style_attr = 'style="display: block;"';
						$i++;
					}
					$output .= '<div class="mfx-tab-content" '.multifox_html_output($style_attr).'>';
						if( $tab_content['item_type'] == 'default' ) {
							$output .= esc_html( $tab_content['item_content'] );
						}
						if( $tab_content['item_type'] == 'template' ) {
							$frontend = Elementor\Frontend::instance();
							$output .= $frontend->get_builder_content( $tab_content['item_template'], true );
						}
					$output .= '</div>';
				}

			$output .= '</div>';

			wp_enqueue_style( 'elementor-icons-fa-regular' );
			wp_enqueue_style( 'elementor-icons-fa-solid' );
			wp_enqueue_style( 'elementor-icons-fa-brands' );
		}

		echo multifox_html_output($output);

	}

}