<?php
/**
 * Customizer Control: radio-image
 *
 */

// Exit if accessed directly.
if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

class Multifox_Customize_Control_Radio_Image extends WP_Customize_Control {

	// Control's Type.
	public $type       = 'mfx-radio-image';

	public $dependency = array();

	/**
	 * Enqueue control related scripts/styles.
	 *
	 */
	public function enqueue() {

		wp_enqueue_script( 'multifox-plus-radio-image-control', MULTIFOX_PLUS_DIR_URL . 'customizer/controls/radio-image/radio-image.js', array( 'jquery', 'customize-base' ), MULTIFOX_PLUS_VERSION, true );
		wp_enqueue_style( 'multifox-plus-radio-image-control',  MULTIFOX_PLUS_DIR_URL . 'customizer/controls/radio-image/radio-image.css', null, MULTIFOX_PLUS_VERSION );
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
		$this->json['value'] = $this->value();

		foreach ( $this->choices as $key => $value ) {
			$this->json['choices'][ $key ]        = esc_url( $value['path'] );
			$this->json['choices_titles'][ $key ] = $value['label'];
		}

		$this->json['link'] = $this->get_link();
		$this->json['id']   = $this->id;

		$this->json['dependID'] = preg_replace('/(.*)\[(.*)\](.*)/sm', '\2', $this->id );

		$this->json['inputAttrs'] = '';
		$this->json['labelStyle'] = '';
		foreach ( $this->input_attrs as $attr => $value ) {
			if ( 'style' !== $attr ) {
				$this->json['inputAttrs'] .= $attr . '="' . esc_attr( $value ) . '" ';
			} else {
				$this->json['labelStyle'] = 'style="' . esc_attr( $value ) . '" ';
			}
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
	 * Render a JS template for the content of the mfx-radio-image control
	 * Format : Underscore JS
	 */
	protected function content_template() {
		?>
		<label class="customizer-text">
			<# if ( data.label ) { #>
				<span class="customize-control-title">{{{ data.label }}}</span>
			<# } #>
			<# if ( data.description ) { #>
				<span class="description customize-control-description">{{{ data.description }}}</span>
			<# } #>
		</label>
		<div id="input_{{ data.id }}" class="image">
			<# for ( key in data.choices ) { #>
				<input {{{ data.inputAttrs }}} class="image-select" type="radio" value="{{ key }}" name="_customize-radio-{{ data.id }}"  id="{{ data.id }}-{{ key }}" {{{ data.link }}} data-depend-id="{{ data.dependID }}" <# if ( data.value === key ) { #> checked="checked"<# } #>>
					<label for="{{ data.id }}-{{ key }}" {{{ data.labelStyle }}}>
						<img class="wp-ui-highlight" src="{{ data.choices[ key ] }}">
						<span class="image-clickable" title="{{ data.choices_titles[ key ] }}" ></span>
					</label>
				</input>
			<# } #>
		</div>
		<?php
	}
}