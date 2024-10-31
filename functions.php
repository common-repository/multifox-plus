<?php

if( !function_exists('multifox_plus_get_template_plugin_part') ) {
    function multifox_plus_get_template_plugin_part( $file_path, $module, $template, $slug ) {

        $html             = '';
        $template_path    = MULTIFOX_PLUS_DIR_PATH . 'modules/' . esc_attr($module);
        $temp_path        = $template_path . '/' . esc_attr($template);
        $plugin_file_path = '';

        if ( ! empty( $temp_path ) ) {
            if ( ! empty( $slug ) ) {
                $plugin_file_path = "{$temp_path}-{$slug}.php";
                if ( ! file_exists( $plugin_file_path ) ) {
                    $plugin_file_path = $temp_path . '.php';
                }
            } else {
                $plugin_file_path = $temp_path . '.php';
            }
        }

        if ( $plugin_file_path && file_exists( $plugin_file_path ) ) {
            return $plugin_file_path;
        }

        return $file_path;

    }
    add_filter( 'multifox_get_template_plugin_part', 'multifox_plus_get_template_plugin_part', 20, 4 );
}

if( !function_exists( 'multifox_customizer_panel_priority' ) ) {
    /**
     *  Get : Customizer Panel Priority based on panel name.
     */
    function multifox_customizer_panel_priority( $panel ) {
        $priority = 10;

        switch( $panel ) {

            case 'general':
                $priority = 10;
            break;

            case 'idenity':
                $priority = 15;
            break;

            case 'breadcrumb':
                $priority = 20;
                break;

            case 'header':
                $priority = 40;
            break;

            case 'typography':
                $priority = 50;
            break;

            case 'blog':
                $priority = 52;
            break;

            case 'hooks':
                $priority = 55;
            break;

            case 'layout':
                $priority = 65;
            break;

            case '404':
                $priority = 60;
            break;

            case 'skin':
                $priority = 70;
            break;

            case 'sidebar':
                $priority = 100;
            break;

            case 'standard-footer':
                $priority = 130;
            break;

            case 'js':
                $priority = 150;
            break;

            case 'woocommerce':
                $priority = 160;
            break;


        }

        return apply_filters( 'multifox_customizer_panel_priority', $priority, $panel );
    }
}

if( !function_exists( 'multifox_customizer_settings' ) ) {
    /**
     * Get : Customizer settings value
     */
    function multifox_customizer_settings( $option ) {
        $settings = get_option( MULTIFOX_CUSTOMISER_VAL, array() );
        $settings = isset( $settings[ $option ] ) ? $settings[ $option ] : false;
        return $settings;
    }
}

if( !function_exists( 'multifox_customizer_dynamic_style') ) {
    /**
     * Get : Generate style based on selector and property
     */
    function multifox_customizer_dynamic_style( $selectors, $properties ) {
        $output = '';
        if( !empty( $selectors ) && !empty( $properties ) ) {
            if( is_array( $selectors ) ) {
                $output .= implode( ', ', $selectors );
            }else {
                $output .= $selectors;
            }

            $output .= ' { ' . multifox_html_output($properties) . ' } ' . "\n";
        }
        return $output;
    }
}


if( !function_exists( 'multifox_customizer_responsive_typography_settings' ) ) {

    /**
     * Get : Typography Responsive CSS based on option and responsive mode.
     */
    function multifox_customizer_responsive_typography_settings( $option, $mode = 'tablet' ) {
        $css = '';

        $font_size      = 'fs-'.esc_attr($mode);
        $line_height    = 'lh-'.esc_attr($mode);
        $letter_spacing = 'ls-'.esc_attr($mode);

        if( isset( $option[ $font_size ] ) && !empty( $option[ $font_size ] ) ) {
            $css .= 'font-size:'.esc_attr($option[$font_size].$option[$font_size.'-unit']).';';
        }

        if( isset( $option[ $line_height ] ) && !empty( $option[ $line_height ] ) ) {
            $css .= 'line-height:'.esc_attr($option[$line_height].$option[$line_height.'-unit']).';';
        }

        if( isset( $option[ $letter_spacing ] ) && !empty( $option[ $letter_spacing ] ) ) {
            $css .= 'letter-spacing:'.esc_attr($option[$letter_spacing].$option[$letter_spacing.'-unit']).';';
        }

        return $css;
    }
}


if( !function_exists( 'multifox_customizer_typography_settings' ) ) {
    /**
     * Get : Typography CSS based on option.
     */
    function multifox_customizer_typography_settings( $option ) {
        $option = is_array( $option ) ? array_filter( $option ) : array();

        $css = '';

        if( isset( $option['font-fallback'] ) && !empty( $option['font-fallback'] ) ) {
            $css .= 'font-family: '.$option['font-fallback'].';';
        } else if( isset( $option['font-family'] ) && !empty( $option['font-family'] ) ) {
            $css .= 'font-family:"'.esc_attr($option['font-family']).'"';
            if( isset( $option['font-family-fallback'] ) && !empty( $option['font-family-fallback'] ) ) {
                $css .= ','.esc_attr($option['font-family-fallback']).';';
            }
        }

        if( isset( $option['font-weight'] ) && !empty( $option['font-weight'] ) ) {
            $css .= 'font-weight:'.esc_attr($option['font-weight']).';';
        }

        if( isset( $option['font-style'] ) && !empty( $option['font-style'] ) ) {
            $css .= 'font-style:'.esc_attr($option['font-style']).';';
        }

        if( isset( $option['text-transform'] ) && !empty( $option['text-transform'] ) ) {
            $css .= 'text-transform:'.esc_attr($option['text-transform']).';';
        }

        if( isset( $option['text-align'] ) && !empty( $option['text-align'] ) ) {
            $css .= 'text-align:'.esc_attr($option['text-align']).';';
        }

        if( isset( $option['text-decoration'] ) && !empty( $option['text-decoration'] ) ) {
            $css .= 'text-decoration:'.esc_attr($option['text-decoration']).';';
        }

        if( isset( $option['fs-desktop'] ) && !empty( $option['fs-desktop'] ) ) {
            $css .= 'font-size:'.esc_attr($option['fs-desktop'].$option['fs-desktop-unit']).';';
        }

        if( isset( $option['lh-desktop'] ) && !empty( $option['lh-desktop'] ) ) {
            $css .= 'line-height:'.esc_attr($option['lh-desktop']);
            if(isset($option['lh-desktop-unit'])) {
                $css .= $option['lh-desktop-unit'];
            }
            $css .= ';';
        }

        if( isset( $option['ls-desktop'] ) && !empty( $option['ls-desktop'] ) ) {
            $css .= 'letter-spacing:'.esc_attr($option['ls-desktop'].$option['ls-desktop-unit']).';';
        }

        return $css;
    }
}

if( !function_exists( 'multifox_customizer_frontend_font' ) ) {
    /**
     * Load fonts in frontend
     */
    function multifox_customizer_frontend_font( $settings, $fonts ) {
        $font = '';

        if( isset( $settings['font-family'] ) ){
            $font = $settings['font-family'];
            $font .= isset( $settings['font-weight'] ) && ( $settings['font-weight'] !== 'inherit' )  ? ':'.esc_attr($settings['font-weight']) : '';
        }

        if( !empty( $font ) ) {
            array_push( $fonts, $font );
        }

        return $fonts;
    }
}

if( !function_exists( 'multifox_customizer_color_settings' ) ) {
    function multifox_customizer_color_settings( $color ) {
        $css = '';

        if( !empty( $color ) ) {
            $css .= 'color:'.esc_attr($color).';';
        }

        return $css;
    }
}

if( !function_exists( 'multifox_customizer_bg_color_settings' ) ) {
    function multifox_customizer_bg_color_settings( $color ) {
        $css = '';

        if( !empty( $color ) ) {
            $css .= 'background-color:'.esc_attr($color).';';
        }

        return $css;
    }
}

if( !function_exists( 'multifox_customizer_bg_settings' ) ) {
    function multifox_customizer_bg_settings( $bg ) {
        $css = '';

        $css .= !empty( $bg['background-image'] ) ? 'background-image: url("'.esc_attr($bg['background-image']).'");':'';
        $css .= !empty( $bg['background-attachment'] ) ? 'background-attachment:'.esc_attr($bg['background-attachment']).';':'';
        $css .= !empty( $bg['background-position'] ) ? 'background-position:'.esc_attr($bg['background-position']).';':'';
        $css .= !empty( $bg['background-size'] ) ? 'background-size:'.esc_attr($bg['background-size']).';':'';
        $css .= !empty( $bg['background-repeat'] ) ? 'background-repeat:'.esc_attr($bg['background-repeat']).';':'';
        $css .= !empty( $bg['background-color'] ) ? 'background-color:'.esc_attr($bg['background-color']).';':'';

        return $css;
    }
}

# Field Sanitization
if(!function_exists('multifox_sanitization')) {
	function multifox_sanitization($data) {
		if ( is_array( $data ) && !empty( $data ) ) {
			foreach ( $data as $key => &$value ) {
				if ( is_array( $value ) ) {
					$data[$key] = multifox_sanitization($value);
				} else {
					$data[$key] = sanitize_text_field( $value );
				}
			}
		}
		else {
			$data = sanitize_text_field( $data );
		}
    	return $data;
    }
}

# Filter HTML Output
if(!function_exists('multifox_html_output')) {
	function multifox_html_output( $html ) {
		return apply_filters( 'multifox_html_output', $html );
	}
}

# SVG file upload compatability
if(!function_exists('add_fonts_to_allowed_mimes')) {
    function add_fonts_to_allowed_mimes($mimes) {
        $mimes['svg'] = 'image/svg+xml';
        return $mimes;
    }
    add_filter( 'upload_mimes', 'add_fonts_to_allowed_mimes' );
}

# Demo button valid password shortcode
add_shortcode( 'view_demo_btn', 'dt_sc_view_demo_btn' );
if( ! function_exists( 'dt_sc_view_demo_btn' ) ) {
	function dt_sc_view_demo_btn($attrs, $content = null) {
		extract ( shortcode_atts ( array (
			'demo_name' => '',
			'password' => '',
			'text' => esc_html__('View Demo', 'multifox'),
			'class' => ''
		), $attrs ) );

		$out = '';

		$out .= '<div class="elementor-6">';
		$out .= '<div class="elementor-element elementor-element-13325f82">';

			$out .= '<form method="post" action="https://'.$demo_name.'.myshopify.com/password" id="login_form" accept-charset="UTF-8" class="storefront-password-form dt-custom-button" target="_blank">';
				$out .= '<input type="hidden" name="form_type" value="storefront_password"><input type="hidden" name="utf8" value="✓">';
				$out .= '<div class="input-group password__input-group">';
					$out .= '<input type="password" name="password" id="Password" value="'.$password.'" class="input-group__field input--content-color" placeholder="Your password" style="display: none">';
					$out .= '<span class="input-group__btn">';
						$out .= '<button type="submit" name="commit" class="btn btn--narrow elementor-button '.$class.'">'.$text.'</button>';
					$out .= '</span>';
				$out .= '</div>';
			$out .= '</form>';

		$out .= '</div>';
		$out .= '</div>';

		return $out;
	}
}