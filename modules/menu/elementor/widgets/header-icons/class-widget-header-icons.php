<?php
use MultifoxElementor\Widgets\MultifoxElementorWidgetBase;
use Elementor\Controls_Manager;
use Elementor\Icons_Manager;

class Elementor_Header_Icons extends MultifoxElementorWidgetBase {

	public function get_name() {
		return 'mfx-header-icons';
	}

	public function get_title() {
		return esc_html__( 'Header Icons', 'multifox-plus' );
	}

	public function get_icon() {
		return 'eicon-menu-bar mfx-icon';
	}

	public function get_style_depends() {
		return array( 'mfx-header-icons', 'mfx-header-carticons' );
	}

	public function get_script_depends() {
		return array( 'jquery-nicescroll', 'mfx-header-icons' );
	}

	protected function _register_controls() {

		$this->start_controls_section( 'header_icons_general_section', array(
			'label' => esc_html__( 'General', 'multifox-plus' ),
		) );

			$this->add_control( 'show_search_icon', array(
				'label'        => esc_html__( 'Show Search Icon', 'multifox-plus' ),
				'type'         => Controls_Manager::SWITCHER,
				'return_value' => 'yes',
				'default'      => 'yes',
			) );

			$this->add_control( 'search_icon_src', array(
				'label'        => esc_html__( 'Search Icon', 'multifox-plus' ),
				'type'         => Controls_Manager::ICONS,
				'default' => array(
					'value' => 'fas fa-search',
					'library' => 'fa-solid',
				),
			) );

			$this->add_control( 'search_type', array(
				'label'       => esc_html__( 'Search Type', 'multifox-plus' ),
				'type'        => Controls_Manager::SELECT,
				'description' => esc_html__( 'Choose type of search form to use.', 'multifox-plus'),
				'default'     => '',
				'options'     => array(
					''      => esc_html__( 'Default', 'multifox-plus'),
					'expand' => esc_html__( 'Expand', 'multifox-plus' ),
					'overlay' => esc_html__( 'Overlay', 'multifox-plus' )
				),
				'condition' => array( 'show_search_icon' => 'yes' )
			) );

			$this->add_control( 'show_userauthlink_icon', array(
				'label'        => esc_html__( 'Show Login / Logout Icon', 'multifox-plus' ),
				'type'         => Controls_Manager::SWITCHER,
				'return_value' => 'yes',
				'default'      => 'yes',
			) );

			$this->add_control( 'userauthlink_icon_src', array(
				'label'        => esc_html__( 'User Icon', 'multifox-plus' ),
				'type'         => Controls_Manager::ICONS,
				'default' => array(
					'value' => 'far fa-user',
					'library' => 'fa-regular',
				),
			) );

			$this->add_control( 'show_cart_icon', array(
				'label'        => esc_html__( 'Show Cart Icon', 'multifox-plus' ),
				'type'         => Controls_Manager::SWITCHER,
				'return_value' => 'yes',
				'default'      => 'yes',
			) );

			$this->add_control( 'cart_icon_src', array(
				'label'        => esc_html__( 'Cart Icon', 'multifox-plus' ),
				'type'         => Controls_Manager::ICONS,
				'default' => array(
					'value' => 'fas fa-shopping-cart',
					'library' => 'fa-solid',
				),
			) );

			$this->add_control( 'cart_action', array(
				'label'       => esc_html__( 'Cart Action', 'multifox-plus' ),
				'type'        => Controls_Manager::SELECT,
				'description' => esc_html__( 'Choose how you want to display the cart content.', 'multifox-plus'),
				'default'     => '',
				'options'     => array(
					''                    => esc_html__( 'None', 'multifox-plus'),
					'notification_widget' => esc_html__( 'Notification Widget', 'multifox-plus' ),
					'sidebar_widget'      => esc_html__( 'Sidebar Widget', 'multifox-plus' ),
				),
				'condition' => array( 'show_cart_icon' => 'yes' )
	        ) );

			$this->add_control( 'show_wishlist_icon', array(
				'label'        => esc_html__( 'Show Wishlist Icon', 'multifox-plus' ),
				'type'         => Controls_Manager::SWITCHER,
				'return_value' => 'yes',
				'default'      => 'yes',
			) );

			$this->add_control( 'wishlist_icon_src', array(
				'label'        => esc_html__( 'Wishlist Icon', 'multifox-plus' ),
				'type'         => Controls_Manager::ICONS,
				'default' => array(
					'value' => 'far fa-heart',
					'library' => 'fa-regular',
				),
			) );

            $this->add_responsive_control( 'align', array(
                'label'        => esc_html__( 'Alignment', 'multifox-plus' ),
                'type'         => Controls_Manager::CHOOSE,
                'prefix_class' => 'elementor%s-align-',
                'options'      => array(
                    'left'   => array( 'title' => esc_html__('Left','multifox-plus'), 'icon' => 'eicon-h-align-left' ),
                    'center' => array( 'title' => esc_html__('Center','multifox-plus'), 'icon' => 'eicon-h-align-center' ),
                    'right'  => array( 'title' => esc_html__('Right','multifox-plus'), 'icon' => 'eicon-h-align-right' ),
                ),
            ) );

		$this->end_controls_section();


        $this->start_controls_section( 'mfx_section_color', array(
        	'label'      => esc_html__( 'Colors', 'multifox-plus' ),
			'tab'        => Controls_Manager::TAB_STYLE,
			'show_label' => false,
		) );

			$this->add_control( 'icons_color', array(
				'label'     => esc_html__( 'Icons Color', 'multifox-plus' ),
				'type'      => Controls_Manager::COLOR,
				'default' 	=> '',
				'selectors' => array( '{{WRAPPER}} .mfx-header-icons-list > div.search-item a.mfx-search-icon, {{WRAPPER}} .mfx-header-icons-list > div.search-item a.mfx-search-icon > *, {{WRAPPER}} .mfx-header-icons-list-item div[class*="menu-icon"] i, {{WRAPPER}} .mfx-header-icons-list > div.mfx-header-icons-list-item .mfx-shop-menu-cart-icon' => 'color: {{VALUE}}' )
			) );

			$this->add_control( 'icons_hover_color', array(
				'label'     => esc_html__( 'Icons Hover Color', 'multifox-plus' ),
				'type'      => Controls_Manager::COLOR,
				'default' 	=> '',
				'selectors' => array( '{{WRAPPER}} .mfx-header-icons-list-item a:hover i, {{WRAPPER}} .mfx-header-icons-list > div.search-item a.mfx-search-icon:hover > *, {{WRAPPER}} .mfx-header-icons-list > div.mfx-header-icons-list-item .mfx-shop-menu-icon:hover .mfx-shop-menu-cart-icon' => 'color: {{VALUE}}' )
			) );

        $this->end_controls_section();

	}

	protected function render() {

		$settings = $this->get_settings();

		$output = '';

		if( ( function_exists( 'is_woocommerce' ) && $settings['show_cart_icon'] == 'yes' ) || $settings['show_userauthlink_icon'] == 'yes' || $settings['show_search_icon'] == 'yes' ) {

			if(is_page()) {
				$output .= '<div class="woocommerce">';
			}

				$output .= '<div class="mfx-header-icons-list">';

				if( $settings['show_search_icon'] == 'yes' ) {

					if( $settings['search_type'] == 'expand' ) {
						$output .= '<div class="mfx-header-icons-list-item search-item search-expand">';
					}elseif( $settings['search_type'] == 'overlay' ) {
						$output .= '<div class="mfx-header-icons-list-item search-item search-overlay">';
					} else {
						$output .= '<div class="mfx-header-icons-list-item search-item search-default">';
					}

						$output .= '<div class="mfx-search-menu-icon">';

							$output .= '<a href="javascript:void(0)" class="mfx-search-icon"><span>';
								ob_start();
								Icons_Manager::render_icon( $settings['search_icon_src'], [ 'aria-hidden' => 'true' ] );
								$icon = ob_get_clean();
								if($settings['search_icon_src']['library'] == 'svg') {
									$output .= '<i>'.$icon.'</i>';
								} else {
									$output .= $icon;
								}
							$output .= '</span></a>';

							if( $settings['search_type'] == 'expand' || $settings['search_type'] == 'overlay' ) {

								$output .= '<div class="mfx-search-form-container">';

									ob_start();
									get_search_form();
									$output .= ob_get_clean();

									$output .= '<div class="mfx-search-form-close"></div>';

								$output .= '</div>';

							} else {

								$output .= '<div class="mfx-search-form-container">';

									ob_start();
									get_search_form();
									$output .= ob_get_clean();

								$output .= '</div>';

							}

						$output .= '</div>';

					$output .= '</div>';

				}

				if( $settings['show_userauthlink_icon'] == 'yes' ) {

					$output .= '<div class="mfx-header-icons-list-item user-authlink-item">';

						if (is_user_logged_in()) {

							$current_user = wp_get_current_user();
							$user_info = get_userdata($current_user->ID);

							$output .= '<div class="mfx-user-authlink-menu-icon">';
								$output .= '<a href="'.wp_logout_url().'"><span>'.get_avatar( $current_user->ID, 150).'<span class="icotype-label">'.esc_html__('Log Out', 'multifox-plus').'</span></span></a>';
							$output .= '</div>';

						} else {
							$output .= '<div class="mfx-user-authlink-menu-icon">';
								$output .= '<a href="'.wp_login_url(get_permalink()).'"><span>';
									ob_start();
									Icons_Manager::render_icon( $settings['userauthlink_icon_src'], [ 'aria-hidden' => 'true' ] );
									$icon = ob_get_clean();
									if($settings['userauthlink_icon_src']['library'] == 'svg') {
										$output .= '<i>'.$icon.'</i>';
									} else {
										$output .= $icon;
									}
									$output .= '<span class="icotype-label">'.esc_html__('Log In', 'multifox-plus').'</span></span></a>';
							$output .= '</div>';
						}

					$output .= '</div>';

				}

				if( function_exists( 'is_woocommerce' ) && $settings['show_cart_icon'] == 'yes' ) {

					$output .= '<div class="mfx-header-icons-list-item cart-item">';

						$output .= '<div class="mfx-shop-menu-icon">';

							$output .= '<a href="'.esc_url( wc_get_cart_url() ).'">';
								$output .= '<span class="mfx-shop-menu-icon-wrapper">';
									$output .= '<span class="mfx-shop-menu-cart-inner">';
										$output .= '<span class="mfx-shop-menu-cart-icon">';
											ob_start();
											Icons_Manager::render_icon( $settings['cart_icon_src'], [ 'aria-hidden' => 'true' ] );
											$icon = ob_get_clean();
											if($settings['cart_icon_src']['library'] == 'svg') {
												$output .= '<i>'.$icon.'</i>';
											} else {
												$output .= $icon;
											}
										$output .= '</span>';
										if (class_exists ( 'MultifoxPro' )) {
											$output .= '<span class="mfx-shop-menu-cart-number">0</span>';
										}
									$output .= '</span>';
									$output .= '<span class="mfx-shop-menu-cart-totals"></span>';
								$output .= '</span>';
							$output .= '</a>';

							if($settings['cart_action'] == 'notification_widget') {

								$output .= '<div class="mfx-shop-menu-cart-content-wrapper">';
									$output .= '<div class="mfx-shop-menu-cart-content">'.esc_html__('No products added!', 'multifox-plus').'</div>';
								$output .= '</div>';

								set_site_transient( 'cart_action', 'notification_widget', 12 * HOUR_IN_SECONDS );

							} else if($settings['cart_action'] == 'sidebar_widget') {

								set_site_transient( 'cart_action', 'sidebar_widget', 12 * HOUR_IN_SECONDS );

							} else {

								set_site_transient( 'cart_action', 'none', 12 * HOUR_IN_SECONDS );

							}

						$output .= '</div>';

					$output .= '</div>';

				}

				if( $settings['show_wishlist_icon'] == 'yes' ) {

					if(class_exists('YITH_WCWL')) {

						$count = YITH_WCWL()->count_products();

						$wishlist_page_id = get_option( 'yith_wcwl_wishlist_page_id' );

						$output .= '<div class="mfx-header-icons-list-item wishlist-item">';

							$output .= '<div class="mfx-wishlist-menu-icon">';
								$output .= '<a href="'.get_permalink($wishlist_page_id).'">';
									$output .= '<span>';
										ob_start();
										Icons_Manager::render_icon( $settings['wishlist_icon_src'], [ 'aria-hidden' => 'true' ] );
										$icon = ob_get_clean();
										if($settings['wishlist_icon_src']['library'] == 'svg') {
											$output .= '<i>'.$icon.'</i>';
										} else {
											$output .= $icon;
										}
										$output .= '<span class="icotype-label">'.esc_html__('Wishlist', 'multifox-plus').'</span>';
										$output .= '<span class="mfx-wishlist-count"> '.esc_html($count).'</span>';
									$output .= '</span>';
								$output .= '</a>';
							$output .= '</div>';

						$output .= '</div>';

					}

				}

				$output .= '</div>';

			if(is_page()) {
				$output .= '</div>';
			}

			global $post;
			if( get_option( 'yith_wcwl_wishlist_page_id' ) != $post->ID ) {
				wp_enqueue_style( 'elementor-icons-fa-regular' );
				wp_enqueue_style( 'elementor-icons-fa-solid' );
				wp_enqueue_style( 'elementor-icons-fa-brands' );
			}

		}

		echo multifox_html_output($output);

	}

}
