<?php
/**
 * Customizer Control: Upload
 *
 */

// Exit if accessed directly.
if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

class Multifox_Customize_Control_Upload extends WP_Customize_Control {

	public $type       = 'mfx-upload';
	public $dependency = array();

	/**
	 * Enqueue control related scripts/styles.
	 *
	 */
	public function enqueue() {
		wp_enqueue_style( 'multifox-plus-upload-control',  MULTIFOX_PLUS_DIR_URL.'customizer/controls/upload/upload.css', null, MULTIFOX_PLUS_VERSION );
		wp_enqueue_script( 'multifox-plus-upload-control', MULTIFOX_PLUS_DIR_URL.'customizer/controls/upload/upload.js', array( 'jquery', 'customize-base' ), MULTIFOX_PLUS_VERSION, true );
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

		$this->json['link'] = $this->get_link();
		$this->json['id']    = $this->id;
		$this->json['label'] = esc_html( $this->label );
		$this->json['value'] = $this->value();
		$this->json['depend_id'] = preg_replace('/(.*)\[(.*)\](.*)/sm', '\2', $this->id );

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
			$d_controller = 'data-controller="' . esc_attr( $dependency[0] ).'"';
			$d_condition  = 'data-condition="' . esc_attr( $dependency[1] ).'"';
			$d_value      = 'data-value="'. esc_attr( $dependency[2] ).'"';
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
	protected function content_template() {?>
		<label>
			<# if ( data.label ) { #>
				<span class="customize-control-title">{{{ data.label }}}</span>
			<# } #>

			<# if ( data.description ) { #>
				<span class="description customize-control-description">{{{ data.description }}}</span>
			<# } #>

			<div class="wrapper">
                <div class="upload-file">
                    <div class="attachment-file-view upload-file">
						<div class="attachment-file upload-file">
                        	<input type="text" {{{ data.inputAttrs }}} name="{{ data.id }}" id="{{ data.id }}" {{{ data.link }}} data-depend-id="{{ data.depend_id }}" value="{{ data.value }}" />
                        </div>
                        <div class="actions">
                            <button class="button upload-file-remove-button<# if ( ! data.value ) { #> hidden <# } #>">
                                <?php esc_attr_e( 'Remove', 'multifox-plus' ); ?>
                            </button>
                            <button type="button" class="button upload-file-button"><?php esc_attr_e( 'Select File', 'multifox-plus' ); ?></button>
                        </div>
                    </div>
                </div>
			</div>
		</label>
		<?php
	}
}