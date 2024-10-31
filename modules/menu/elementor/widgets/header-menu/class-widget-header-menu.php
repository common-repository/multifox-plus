<?php
use MultifoxElementor\Widgets\MultifoxElementorWidgetBase;
use Elementor\Group_Control_Typography;
use Elementor\Controls_Manager;
use Elementor\Repeater;
use Elementor\Utils;

class Elementor_Header_Menu extends MultifoxElementorWidgetBase {

    public function get_name() {
        return 'mfx-header-menu';
    }

    public function get_title() {
        return esc_html__('Header Menu', 'multifox-plus');
    }

    public function get_icon() {
		return 'eicon-header mfx-icon';
	}

    protected function _register_controls() {

		$nav_menus = array( 0 => esc_html__('Select Menu', 'multifox-plus')  );
		$menus     = wp_get_nav_menus();

		foreach ($menus as $menu ) {
			$nav_menus[$menu->term_id] = $menu->name;
		}

        $this->start_controls_section( 'mfx_section_general', array(
            'label' => esc_html__( 'General', 'multifox-plus'),
        ) );
            $this->add_control( 'nav_type', array(
				'type'    => Controls_Manager::SELECT,
				'label'   => esc_html__('Navigation Type', 'multifox-plus'),
				'default' => 'primary-nav',
				'options' => array(
                    'primary-nav' => esc_html__('Primary Nav','multifox-plus'),
                    'secondary-nav' => esc_html__('Secondary Nav','multifox-plus')
                )
            ) );

            $this->add_control( 'nav_id', array(
				'type'    => Controls_Manager::SELECT,
				'label'   => esc_html__('Choose Menu', 'multifox-plus'),
				'default' => '0',
				'options' => $nav_menus
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

        $this->start_controls_section( 'mfx_section_typography', array(
        	'label'      => esc_html__( 'Menu', 'multifox-plus' ),
			'tab'        => Controls_Manager::TAB_STYLE,
			'show_label' => false,
		) );

			$this->add_group_control( Group_Control_Typography::get_type(), array(
                'label'      => esc_html__( 'Menu Typography', 'multifox-plus' ),
				'name'     => 'menu_typography',
				'selector' => '{{WRAPPER}} .mfx-header-menu .menu-container .mfx-primary-nav > li > a',
				'separator' => 'before',
			) );

			$this->add_group_control( Group_Control_Typography::get_type(), array(
                'label'      => esc_html__( 'Sub Menu Typography', 'multifox-plus' ),
				'name'     => 'sub_menu_typography',
				'selector' => '{{WRAPPER}} .mfx-header-menu .menu-container .mfx-primary-nav li ul.sub-menu li > a',
				'separator' => 'before',
			) );

        $this->end_controls_section();

        $this->start_controls_section( 'mfx_section_color', array(
        	'label'      => esc_html__( 'Colors', 'multifox-plus' ),
			'tab'        => Controls_Manager::TAB_STYLE,
			'show_label' => false,
		) );

			$this->add_control( 'menu_color', array(
				'label'     => esc_html__( 'Menu Color', 'multifox-plus' ),
				'type'      => Controls_Manager::COLOR,
				'default' 	=> '',
				'selectors' => array( '{{WRAPPER}} .mfx-header-menu .menu-container .mfx-primary-nav > li > a' => 'color: {{VALUE}}' )
			) );

			$this->add_control( 'menu_hover_color', array(
				'label'     => esc_html__( 'Menu Hover Color', 'multifox-plus' ),
				'type'      => Controls_Manager::COLOR,
				'default' 	=> '',
				'selectors' => array( '
                {{WRAPPER}} .mfx-header-menu .menu-container .mfx-primary-nav > li.focus > a,
                {{WRAPPER}} .mfx-header-menu .menu-container .mfx-primary-nav > li:focus > a,
                {{WRAPPER}} .mfx-header-menu .menu-container .mfx-primary-nav > li:hover > a,
                {{WRAPPER}} .mfx-header-menu .menu-container .mfx-primary-nav > li > a.focus,
                {{WRAPPER}} .mfx-header-menu .menu-container .mfx-primary-nav > li > a:focus,
                {{WRAPPER}} .mfx-header-menu .menu-container .mfx-primary-nav > li > a:hover,
                {{WRAPPER}} .mfx-header-menu .menu-container .mfx-primary-nav > li.current-menu-item > a,
                {{WRAPPER}} .mfx-header-menu .menu-container .mfx-primary-nav > li.current-page-item > a,
                {{WRAPPER}} .mfx-header-menu .menu-container .mfx-primary-nav > li.current-menu-ancestor > a,
                {{WRAPPER}} .mfx-header-menu .menu-container .mfx-primary-nav > li.current-page-ancestor > a,
                {{WRAPPER}} .mfx-header-menu .menu-container .mfx-primary-nav > li.current_menu_item > a,
                {{WRAPPER}} .mfx-header-menu .menu-container .mfx-primary-nav > li.current_page_item > a,
                {{WRAPPER}} .mfx-header-menu .menu-container .mfx-primary-nav > li.current_menu_ancestor > a,
                {{WRAPPER}} .mfx-header-menu .menu-container .mfx-primary-nav > li.current_page_ancestor > a' => 'color: {{VALUE}}' )
			) );

			$this->add_control( 'sub_menu_color', array(
				'label'     => esc_html__( 'Sub Menu Color', 'multifox-plus' ),
				'type'      => Controls_Manager::COLOR,
				'default' 	=> '',
				'selectors' => array( '{{WRAPPER}} .mfx-header-menu .menu-container .mfx-primary-nav li ul.sub-menu li > a' => 'color: {{VALUE}}' )
			) );

			$this->add_control( 'sub_menu_hover_color', array(
				'label'     => esc_html__( 'Sub Menu Hover Color', 'multifox-plus' ),
				'type'      => Controls_Manager::COLOR,
				'default' 	=> '',
				'selectors' => array( '
                {{WRAPPER}} .mfx-header-menu .menu-container .mfx-primary-nav > li ul.sub-menu > li.focus > a,
                {{WRAPPER}} .mfx-header-menu .menu-container .mfx-primary-nav > li ul.sub-menu > li:focus > a,
                {{WRAPPER}} .mfx-header-menu .menu-container .mfx-primary-nav > li ul.sub-menu > li:hover > a,
                {{WRAPPER}} .mfx-header-menu .menu-container .mfx-primary-nav > li ul.sub-menu > li > a.focus,
                {{WRAPPER}} .mfx-header-menu .menu-container .mfx-primary-nav > li ul.sub-menu > li > a:focus,
                {{WRAPPER}} .mfx-header-menu .menu-container .mfx-primary-nav > li ul.sub-menu > li > a:hover,
                {{WRAPPER}} .mfx-header-menu .menu-container .mfx-primary-nav > li ul.sub-menu > li.current-menu-item > a,
                {{WRAPPER}} .mfx-header-menu .menu-container .mfx-primary-nav > li ul.sub-menu > li.current-page-item > a,
                {{WRAPPER}} .mfx-header-menu .menu-container .mfx-primary-nav > li ul.sub-menu > li.current-menu-ancestor > a,
                {{WRAPPER}} .mfx-header-menu .menu-container .mfx-primary-nav > li ul.sub-menu > li.current-page-ancestor > a,
                {{WRAPPER}} .mfx-header-menu .menu-container .mfx-primary-nav > li ul.sub-menu > li.current_menu_item > a,
                {{WRAPPER}} .mfx-header-menu .menu-container .mfx-primary-nav > li ul.sub-menu > li.current_page_item > a,
                {{WRAPPER}} .mfx-header-menu .menu-container .mfx-primary-nav > li ul.sub-menu > li.current_menu_ancestor > a,
                {{WRAPPER}} .mfx-header-menu .menu-container .mfx-primary-nav > li ul.sub-menu > li.current_page_ancestor > a' => 'color: {{VALUE}}' )
			) );

        $this->end_controls_section();

    }

    protected function render() {

        $settings = $this->get_settings_for_display();

        extract($settings);

        $nav_class = '';
        if($nav_type == 'secondary-nav') {
            $nav_class = 'mfx-secondary-nav';
        }

        $navigation = wp_nav_menu( array(
        	'menu'            => $nav_id,
			'container_class' => 'menu-container',
			'items_wrap'      => '<ul id="%1$s" class="%2$s" data-menu="'.esc_attr($nav_id).'"> <li class="close-nav"><a href="javascript:void(0);"></a></li> %3$s </ul> <div class="sub-menu-overlay"></div>',
			'menu_class'      => 'mfx-primary-nav '.$nav_class,
			'link_before'     => '<span>',
			'link_after'      => '</span>',
            'walker'          => new Multifox_Walker_Nav_Menu,
            'echo'            => false
        ) );

        $out = '<div class="mfx-header-menu" data-menu="'.esc_attr( $nav_id ).'">';

        	$out .= $navigation;

            if($nav_type == 'primary-nav') {
                $out .= '<div class="mobile-nav-container mobile-nav-offcanvas-right" data-menu="'.esc_attr( $nav_id ).'">';
                    $out .= '<a href="#" class="menu-trigger menu-trigger-icon" data-menu="'.esc_attr( $nav_id ).'">';
                        $out .= '<i></i>';
                        $out .= '<span>'.esc_html__('Menu', 'multifox-plus').'</span>';
                    $out .= '</a>';
                    $out .= '<div class="mobile-menu" data-menu="'.esc_attr( $nav_id ).'"></div>';
                    $out .= '<div class="overlay"></div>';
                $out .= '</div>';
            }

        $out .= '</div>';

        echo multifox_html_output($out);
    }

}