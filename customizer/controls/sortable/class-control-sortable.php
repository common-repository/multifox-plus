<?php
/**
 * Customizer Control: sortable
 *
 */

// Exit if accessed directly.
if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

class Multifox_Customize_Control_Sortable extends WP_Customize_Control {

	public $type = 'mfx-sortable';
	public $dependency = array();

	/**
	 * Enqueue control related scripts/styles.
	 *
	 */
	public function enqueue() {

		wp_enqueue_script( 'multifox-plus-sortable-control', MULTIFOX_PLUS_DIR_URL.'customizer/controls/sortable/sortable.js', array( 'jquery', 'customize-base' ), MULTIFOX_PLUS_VERSION, true );
		wp_enqueue_style( 'multifox-plus-sortable-control',  MULTIFOX_PLUS_DIR_URL.'customizer/controls/sortable/sortable.css', null, MULTIFOX_PLUS_VERSION );
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

		$this->json['id']      = $this->id;
		$this->json['link']    = $this->get_link();
		$this->json['value']   = maybe_unserialize( $this->value() );
		$this->json['choices'] = $this->choices;
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
		<label class="customizer-text">
			<# if ( data.label ) { #>
				<span class="customize-control-title">{{{ data.label }}}</span>
			<# } #>
			<# if ( data.description ) { #>
				<span class="description customize-control-description">{{{ data.description }}}</span>
			<# } #>
		</label>
		<ul class="sortable">
			<# _.each( data.value, function( choiceID ) { #>
				<li class='ast-sortable-item' data-value='{{ choiceID }}'>
					<i class='dashicons dashicons-menu'></i>
					<i class="dashicons dashicons-visibility visibility"></i>
					{{{ data.choices[ choiceID ] }}}
				</li>
			<# }); #>
			<# _.each( data.choices, function( choiceLabel, choiceID ) { #>
				<# if ( -1 === data.value.indexOf( choiceID ) ) { #>
					<li class="sortable-item invisible" data-value="{{ choiceID }}">
						<i class='dashicons dashicons-menu'></i>
						<i class="dashicons dashicons-visibility visibility"></i>
						{{{ data.choices[ choiceID ] }}}
					</li>
				<# } #>
			<# }); #>
		</ul>
		<?php
	}
}