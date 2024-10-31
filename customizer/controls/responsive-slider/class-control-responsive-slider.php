<?php
/**
 * Customizer Control: Responsive slider
 *
 */

// Exit if accessed directly.
if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

class Multifox_Customize_Control_Responsive_Slider extends WP_Customize_Control {

	// Control's Type.
	public $type           = 'mfx-responsive-slider';
	public $dependency     = array();
	public $suffix         = '';
	public $linked_choices = '';

	/**
	 * Enqueue control related scripts/styles.
	 *
	 */
	public function enqueue() {

		wp_enqueue_script( 'multifox-plus-responsive-slider-control', MULTIFOX_PLUS_DIR_URL . 'customizer/controls/responsive-slider/responsive-slider.js', array( 'jquery', 'customize-base' ), MULTIFOX_PLUS_VERSION, true );
		wp_enqueue_style( 'multifox-plus-responsive-slider-control',  MULTIFOX_PLUS_DIR_URL . 'customizer/controls/responsive-slider/responsive-slider.css', null, MULTIFOX_PLUS_VERSION );
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
			);
		}

		$this->json['value']  = $val;
		$this->json['id']     = $this->id;
		$this->json['link']   = $this->get_link();
		$this->json['label']  = esc_html( $this->label );
		$this->json['suffix'] = $this->suffix;

		$this->json['linked_choices'] = $this->linked_choices;


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
		$id             = 'customize-control-' . str_replace( array( '[', ']' ), array( '-', '' ), $this->id );
		$linked_choices = ( $this->linked_choices == true ) ? 'allow' : 'deny';
		$class          = 'customize-control has-responsive-switchers customize-control-' . esc_attr($this->type) .' linked-choice-'.esc_attr($linked_choices);

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
	 * Render a JS template for the content of the mfx-sortable control
	 * Format : Underscore JS
	 */
	protected function content_template() {
		?>
		<label>
			<span class="customize-control-title">
				<#  if ( data.label ) { #>
					<span>{{{ data.label }}}</span>
				<# } #>
				<ul class="mfx-responsive-slider-switcher mfx-responsive-switchers">
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
				<span class="slider-reset desktop-reset dashicons dashicons-image-rotate"></span>
			</span>

			<# if ( data.description ) { #>
				<span class="description customize-control-description">{{{ data.description }}}</span>
			<# } #>
			<#
				value_desktop          = '';
				value_tablet           = '';
				value_tablet_landscape = '';
				value_mobile           = '';

				if ( data.value['desktop'] ) {
					value_desktop = data.value['desktop'];
				}

				if ( data.value['tablet'] ) {
					value_tablet = data.value['tablet'];
				}

				if ( data.value['tablet-landscape'] ) {
					value_tablet_landscape = data.value['tablet-landscape'];
				}

				if ( data.value['mobile'] ) {
					value_mobile = data.value['mobile'];
				}
			#>
			<div class="wrapper">

				<div class="desktop control-wrap active" data-device="desktop">
					<div class="input-field-range">
						<input {{{ data.inputAttrs }}} type="range"  value="{{ value_desktop }}"/>
					</div>
					<div class="mfx-slider-range-value">
						<input {{{ data.inputAttrs }}} type="number" value="{{ value_desktop }}"/>
						<# if( data.suffix ) { #>
							<span class="mfx-slider-range-unit">{{ data.suffix }}</span>
						<# } #>
					</div>
				</div>

				<div class="tablet control-wrap" data-device="tablet">
					<input {{{ data.inputAttrs }}} type="range"  value="{{ value_tablet }}"/>
					<div class="mfx-slider-range-value">
						<input {{{ data.inputAttrs }}} type="number" value="{{ value_tablet }}"/>
						<# if( data.suffix ) { #>
							<span class="mfx-slider-range-unit">{{ data.suffix }}</span>
						<# } #>
					</div>
				</div>

				<div class="tablet-landscape control-wrap" data-device="tablet-landscape">
					<input {{{ data.inputAttrs }}} type="range"  value="{{ value_tablet_landscape }}"/>
					<div class="mfx-slider-range-value">
						<input {{{ data.inputAttrs }}} type="number" value="{{ value_tablet_landscape }}"/>
						<# if( data.suffix ) { #>
							<span class="mfx-slider-range-unit">{{ data.suffix }}</span>
						<# } #>
					</div>
				</div>

				<div class="mobile control-wrap" data-device="mobile">
					<input {{{ data.inputAttrs }}} type="range" value="{{ value_mobile }}"/>
					<div class="mfx-slider-range-value">
						<input {{{ data.inputAttrs }}} type="number" value="{{ value_mobile }}"/>
						<# if( data.suffix ) { #>
							<span class="mfx-slider-range-unit">{{ data.suffix }}</span>
						<# } #>
					</div>
				</div>

				<input class="responsive-slider-hidden-value" type="hidden" {{{ data.link }}}>
			</div>
		</label>
		<?php
	}
}