<?php
/**
 * Customizer Control: description
 *
 */

// Exit if accessed directly.
if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

class Multifox_Customize_Control_Description extends WP_Customize_Control {

	public $type       = 'mfx-description';
	public $help       = '';
	public $dependency = array();

	/**
	 * Enqueue control related scripts/styles.
	 *
	 */
	public function enqueue() {

		wp_enqueue_style( 'multifox-plus-description-control',  MULTIFOX_PLUS_DIR_URL.'customizer/controls/description/description.css', null, MULTIFOX_PLUS_VERSION );
	}

	/**
	 * Get the data to export to the client via JSON.
	 *
	 */
	public function to_json() {
		parent::to_json();

		$this->json['help'] = $this->help;
	}

	/**
	 * Renders the control wrapper and calls $this->render_content() for the internals.
	 *
	 * @since 3.4.0
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
	 * Render a JS template for the content of the mfx-description control
	 *
	 */
	protected function content_template() {
		?>
		<label class="customizer-text">
			<# if ( data.label ) { #>
				<span class="customize-control-title">{{{ data.label }}}</span>
			<# } #>
			<# if ( data.help ) { #>
				<span class="mfx-description">{{{ data.help }}}</span>
			<# } #>
			<# if ( data.description ) { #>
				<span class="description customize-control-description">{{{ data.description }}}</span>
			<# } #>
		</label>
		<?php
	}
}