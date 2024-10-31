<?php
/**
 * Customizer Control: Responsive Number Field
 *
 */

// Exit if accessed directly.
if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

class Multifox_Customize_Control_Responsive_Number extends WP_Customize_Control {

	// Control's Type.
	public $type       = 'mfx-responsive-number';

	public $dependency = array();

	/**
	 * The control type.
	 *
	 * @access public
	 * @var string
	 */
	public $units = array();

	/**
	 * Enqueue control related scripts/styles.
	 *
	 */
	public function enqueue() {

		wp_enqueue_script( 'multifox-plus-responsive-number-control', MULTIFOX_PLUS_DIR_URL . 'customizer/controls/responsive-number/responsive-number.js', array( 'jquery', 'customize-base' ), MULTIFOX_PLUS_VERSION, true );
		wp_enqueue_style( 'multifox-plus-responsive-number-control',  MULTIFOX_PLUS_DIR_URL . 'customizer/controls/responsive-number/responsive-number.css', null, MULTIFOX_PLUS_VERSION );
	}

	/**
	 * Get the data to export to the client via JSON.
	 *
	 */
	public function to_json() {
		parent::to_json();

		$this->json['default'] = $this->setting->default;
		if ( isset( $this->default ) ) {
			$this->json['default'] = $this->default;
		}

		$val = maybe_unserialize( $this->value() );

		if ( ! is_array( $val ) || is_numeric( $val ) ) {

			$val = array(
				'desktop'          => $val,
				'tablet'           => '',
				'tablet-landscape' => '',
				'mobile'           => '',
				'desktop-unit'     => '',
				'tablet-unit'      => '',
				'tablet-ls-unit'   => '',
				'mobile-unit'      => '',
			);
		}

		$this->json['value']  = $val;
		$this->json['id']     = $this->id;
		$this->json['link']   = $this->get_link();
		$this->json['label']  = esc_html( $this->label );
		$this->json['units']  = $this->units;

		$this->json['inputAttrs'] = '';
		foreach ( $this->input_attrs as $attr => $value ) {
			$this->json['inputAttrs'] .= $attr . '="' . esc_attr( $value ) . '" ';
		}
	}

	/**
	 * Renders the control wrapper and calls $this->render_content() for the internals.
	 *
	 * @since 3.4.0
	 */
	protected function render() {
		$id    = 'customize-control-' . str_replace( array( '[', ']' ), array( '-', '' ), $this->id );
		$class = 'customize-control has-responsive-switchers customize-control-' . esc_attr($this->type);

		$d_controller = $d_condition = $d_value = '';
		$dependency   = $this->dependency;
		if( !empty( $dependency ) ) {
			$d_controller = "data-controller='" . esc_attr( $dependency[0] )."'";
			$d_condition  = "data-condition='" . esc_attr( $dependency[1] )."'";
			$d_value      = "data-value='". esc_attr( $dependency[2] )."'";
		}

		printf( '<li id="%s" class="%s" %s %s %s>', esc_attr( $id ), esc_attr( $class ), $d_controller, $d_condition, $d_value );
		$this->render_content();
		echo '</li>';
	}


	/**
	 * An Underscore (JS) template for this control's content (but not its container).
	 *
	 * Class variables for this control class are available in the `data` JS object;
	 * export custom variables by overriding {@see WP_Customize_Control::to_json()}.
	 *
	 * @see WP_Customize_Control::print_template()
	 *
	 * @access protected
	 */
	protected function content_template() {
		?>
		<label>
			<span class="customize-control-title">
				<#  if ( data.label ) { #>
					<span>{{{ data.label }}}</span>
				<# } #>
				<ul class="mfx-responsive-number-switcher mfx-responsive-switchers">
					<li class="desktop active">
						<button type="button" class="preview-desktop active" data-device="desktop">
							<i class="dashicons dashicons-desktop"></i>
						</button>
					</li>
					<li class="tablet">
						<button type="button" class="preview-tablet" data-device="tablet">
							<i class="dashicons dashicons-tablet"></i>
						</button>
					</li>
					<li class="tablet-landscape">
						<button type="button" class="preview-tablet-landscape" data-device="tablet-landscape">
							<i class="dashicons dashicons-tablet"></i>
						</button>
					</li>
					<li class="mobile">
						<button type="button" class="preview-mobile" data-device="mobile">
							<i class="dashicons dashicons-smartphone"></i>
						</button>
					</li>
				</ul>
				<span class="item-reset desktop-reset dashicons dashicons-image-rotate"></span>
			</span>

			<# if ( data.description ) { #>
				<span class="description customize-control-description">{{{ data.description }}}</span>
			<# }

			value_desktop   = '';
			value_tablet    = '';
			value_tablet_ls = '';
			value_mobile    = '';

			if ( data.value['desktop'] ) {
				value_desktop = data.value['desktop'];
			}

			if ( data.value['tablet'] ) {
				value_tablet = data.value['tablet'];
			}

			if ( data.value['tablet-landscape'] ) {
				value_tablet_ls = data.value['tablet-landscape'];
			}

			if ( data.value['mobile'] ) {
				value_mobile = data.value['mobile'];
			}#>

			<div class="wrapper">
				<div class="desktop control-wrap active">
					<input {{{ data.inputAttrs }}} type="number" data-id='desktop' class="mfx-responsive-input" value="{{value_desktop}}"/>
					<select class="mfx-responsive-select" data-id='desktop-unit'>
						<# _.each( data.units, function( element, index){ #>
							<option value="{{{ index }}}" <# if ( data.value['desktop-unit'] === index ) { #> selected="selected" <# } #> >{{{element}}}</option>
						<# }); #>
					</select>
				</div>

				<div class="tablet control-wrap">
					<input {{{ data.inputAttrs }}} type="number" data-id='tablet' class="mfx-responsive-input" value="{{value_tablet}}"/>
					<select class="mfx-responsive-select" data-id='tablet-unit'>
						<# _.each( data.units, function( element, index){ #>
							<option value="{{{ index }}}" <# if ( data.value['tablet-unit'] === index ) { #> selected="selected" <# } #> >{{{element}}}</option>
						<# }); #>
					</select>
				</div>

				<div class="tablet-landscape control-wrap">
					<input {{{ data.inputAttrs }}} type="number" data-id='tablet-landscape' class="mfx-responsive-input" value="{{value_tablet_ls}}"/>
					<select class="mfx-responsive-select" data-id='tablet-ls-unit'>
						<# _.each( data.units, function( element, index){ #>
							<option value="{{{ index }}}" <# if ( data.value['tablet-ls-unit'] === index ) { #> selected="selected" <# } #> >{{{element}}}</option>
						<# }); #>
					</select>
				</div>

				<div class="mobile control-wrap">
					<input {{{ data.inputAttrs }}} type="number" data-id='mobile' class="mfx-responsive-input" value="{{value_mobile}}"/>
					<select class="mfx-responsive-select" data-id='mobile-unit'>
						<# _.each( data.units, function( element, index){ #>
							<option value="{{{ index }}}" <# if ( data.value['mobile-unit'] === index ) { #> selected="selected" <# } #> >{{{element}}}</option>
						<# }); #>
					</select>
				</div>
			</div>
		</label>
		<?php
	}
}