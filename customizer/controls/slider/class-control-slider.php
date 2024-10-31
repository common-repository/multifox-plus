<?php
/**
 * Customizer Control: slider
 *
 */

// Exit if accessed directly.
if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

class Multifox_Customize_Control_Slider extends WP_Customize_Control {

	public $type       = 'mfx-slider';
	public $dependency = array();

	/**
	* The control type.
	*
	* @access public
	* @var string
	*/
	public $suffix     = '';

	/**
	 * Enqueue control related scripts/styles.
	 *
	 */
	public function enqueue() {

		wp_enqueue_script( 'multifox-plus-slider-control', MULTIFOX_PLUS_DIR_URL.'customizer/controls/slider/slider.js', array( 'jquery', 'customize-base' ), MULTIFOX_PLUS_VERSION, true );
		wp_enqueue_style( 'multifox-plus-slider-control',  MULTIFOX_PLUS_DIR_URL.'customizer/controls/slider/slider.css', null, MULTIFOX_PLUS_VERSION );
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

		$this->json['value']  = $this->value();
		$this->json['id']     = $this->id;
		$this->json['link']   = $this->get_link();
		$this->json['label']  = esc_html( $this->label );
		$this->json['suffix'] = $this->suffix;

		$this->json['inputAttrs'] = '';
		foreach ( $this->input_attrs as $attr => $value ) {
			$this->json['inputAttrs'] .= $attr . '="' . esc_attr( $value ) . '" ';
		}
	}

	/**
	 * Renders the control wrapper and calls $this->render_content() for the internals.
	 */
	protected function render() {

		$id    = 'customize-control-' . str_replace( array( '[', ']' ), array( '-', '' ), $this->id );
		$class = 'customize-control customize-control-' . esc_attr($this->type);

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
			<# if ( data.label ) { #>
				<span class="customize-control-title">{{{ data.label }}}</span>
			<# } #>

			<# if ( data.description ) { #>
				<span class="description customize-control-description">{{{ data.description }}}</span>
			<# } #>

			<div class="wrapper">
				<input {{{ data.inputAttrs }}} type="range" value="{{ data.value }}"/>
				<div class="mfx-slider-range-value">
					<input {{{ data.inputAttrs }}} type="number"/>
					<# if( data.suffix ) { #>
						<span class="mfx-slider-range-unit">{{ data.suffix }}</span>
					<# } #>
				</div>
				<span class="slider-reset dashicons dashicons-image-rotate"></span>
			</div>
		</label>
		<?php
	}
}