<?php
/**
 * Customizer Control: Spacing Field
 *
 */

// Exit if accessed directly.
if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

class Multifox_Customize_Control_Spacing extends WP_Customize_Control {

	public $type           = 'mfx-spacing';
	public $linked_choices = '';
	public $units          = array();
	public $dependency     = array();

	/**
	 * Enqueue control related scripts/styles.
	 *
	 */
	public function enqueue() {
		wp_enqueue_script( 'multifox-plus-spacing-control', MULTIFOX_PLUS_DIR_URL.'customizer/controls/spacing/spacing.js', array( 'jquery', 'customize-base' ), MULTIFOX_PLUS_VERSION, true );
		wp_enqueue_style( 'multifox-plus-spacing-control',  MULTIFOX_PLUS_DIR_URL.'customizer/controls/spacing/spacing.css', null, MULTIFOX_PLUS_VERSION );
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
				'top'    => $val,
				'right'  => '',
				'bottom' => $val,
				'left'   => '',
				'unit'   => 'px',
			);
		}

		$this->json['value']          = $val;
		$this->json['id']             = $this->id;
		$this->json['label']          = esc_html( $this->label );
		$this->json['choices']        = $this->choices;
		$this->json['linked_choices'] = $this->linked_choices;
		$this->json['units']          = $this->units;

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
		<span class="customize-control-title">
			<#  if ( data.label ) { #>
				<label> <span>{{{ data.label }}}</span> </label>
			<# } #>
			<span class="item-reset desktop-reset dashicons dashicons-image-rotate"></span>
		</span>

		<# if ( data.description ) { #>
			<span class="description customize-control-description">{{{ data.description }}}</span>
		<# } #>
		<div class="wrapper">
			<div class="control-wrap active">
				<ul>
					<# _.each( data.choices, function( choiceLabel, choiceID){ #>
						<li class="mfx-spacing-input">
							<span class="mfx-spacing-title">{{{ data.choices[ choiceID ] }}}</span>
							<input type="number" {{{ data.inputAttrs }}} data-id="{{ choiceID }}" value='{{{ data.value[ choiceID ] }}}'/>
						</li>
					<# }); #>

					<# if ( data.linked_choices ) { #>
						<li class="mfx-spacing-link">
							<span class="dashicons dashicons-admin-links mfx-spacing-connected wp-ui-highlight" data-element-connect="{{ data.id }}"></span>
							<span class="dashicons dashicons-editor-unlink mfx-spacing-disconnected" data-element-connect="{{ data.id }}"></span>
						</li>
					<# } #>

					<li>
						<select class="mfx-responsive-select">
							<# _.each( data.units, function( element, index){ #>
								<option value="{{{ element }}}" <# if ( data.value['unit'] === element ) { #> selected="selected" <# } #> >{{{element}}}</option>
							<# }); #>
						</select>
					</li>
				</ul>
			</div>
		</div>
		<?php
	}
}