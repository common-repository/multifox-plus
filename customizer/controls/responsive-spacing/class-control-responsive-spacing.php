<?php
/**
 * Customizer Control: Responsive Spacing Field
 *
 */

// Exit if accessed directly.
if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

class Multifox_Customize_Control_Responsive_Spacing extends WP_Customize_Control {

	public $type           = 'mfx-responsive-spacing';
	public $linked_choices = '';
	public $units          = array();
	public $dependency     = array();

	/**
	 * Enqueue control related scripts/styles.
	 *
	 */
	public function enqueue() {
		wp_enqueue_script( 'multifox-plus-responsive-spacing-control', MULTIFOX_PLUS_DIR_URL.'customizer/controls/responsive-spacing/responsive-spacing.js', array( 'jquery', 'customize-base' ), MULTIFOX_PLUS_VERSION, true );
		wp_enqueue_style( 'multifox-plus-responsive-spacing-control',  MULTIFOX_PLUS_DIR_URL.'customizer/controls/responsive-spacing/responsive-spacing.css', null, MULTIFOX_PLUS_VERSION );
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
				'desktop'      => array(
					'top'    => $val,
					'right'  => '',
					'bottom' => $val,
					'left'   => '',
				),
				'tablet'       => array(
					'top'    => $val,
					'right'  => '',
					'bottom' => $val,
					'left'   => '',
				),
				'tablet-landscape' => array(
					'top'    => $val,
					'right'  => '',
					'bottom' => $val,
					'left'   => '',
				),
				'mobile'       => array(
					'top'    => $val,
					'right'  => '',
					'bottom' => $val,
					'left'   => '',
				),
				'desktop-unit'   => 'px',
				'tablet-unit'    => 'px',
				'tablet-ls-unit' => 'px',
				'mobile-unit'    => 'px',
			);
		}

		/* Control Units */
		$units = array(
			'desktop-unit'   => 'px',
			'tablet-unit'    => 'px',
			'tablet-ls-unit' => 'px',
			'mobile-unit'    => 'px',
		);

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
			<ul class="mfx-responsive-spacing-switcher mfx-responsive-switchers">
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

			<div class="desktop control-wrap active">
				<ul>
					<# _.each( data.choices, function( choiceLabel, choiceID){ #>
						<li class="mfx-spacing-input">
							<span class="mfx-spacing-title">{{{ data.choices[ choiceID ] }}}</span>
							<input type="number" {{{ data.inputAttrs }}} data-id="{{ choiceID }}" value='{{ value_desktop[ choiceID ] }}'/>
						</li>
					<# }); #>

					<# if ( data.linked_choices ) { #>
						<li class="mfx-spacing-link">
							<span class="dashicons dashicons-admin-links mfx-spacing-connected wp-ui-highlight" data-element-connect="{{ data.id }}"></span>
							<span class="dashicons dashicons-editor-unlink mfx-spacing-disconnected" data-element-connect="{{ data.id }}"></span>
						</li>
					<# } #>

					<# if( _.size( data.units ) > 0 ) { #>
					<li>
						<select class="mfx-responsive-select" data-id='desktop-unit'>
							<# _.each( data.units, function( element, index){ #>
								<option value="{{{ element }}}" <# if ( data.value['desktop-unit'] === element ) { #> selected="selected" <# } #> >{{{element}}}</option>
							<# }); #>
						</select>
					</li>
					<# } #>

				</ul>
			</div>

			<div class="tablet control-wrap">
				<ul>
					<# _.each( data.choices, function( choiceLabel, choiceID){ #>
						<li class="mfx-spacing-input">
							<span class="mfx-spacing-title">{{{ data.choices[ choiceID ] }}}</span>
							<input type="number" {{{ data.inputAttrs }}} data-id="{{ choiceID }}" value='{{ value_tablet[ choiceID ] }}'/>
						</li>
					<# }); #>

					<# if ( data.linked_choices ) { #>
						<li class="mfx-spacing-link">
							<span class="dashicons dashicons-admin-links mfx-spacing-connected wp-ui-highlight" data-element-connect="{{ data.id }}"></span>
							<span class="dashicons dashicons-editor-unlink mfx-spacing-disconnected" data-element-connect="{{ data.id }}"></span>
						</li>
					<# } #>

					<# if( _.size( data.units ) > 0 ) { #>
						<li>
							<select class="mfx-responsive-select" data-id='tablet-unit'>
								<# _.each( data.units, function( element, index){ #>
									<option value="{{{ element }}}" <# if ( data.value['tablet-unit'] === element ) { #> selected="selected" <# } #> >{{{element}}}</option>
								<# }); #>
							</select>
						</li>
					<# } #>
				</ul>
			</div>

			<div class="tablet-landscape control-wrap">
				<ul>
					<# _.each( data.choices, function( choiceLabel, choiceID){ #>
						<li class="mfx-spacing-input">
							<span class="mfx-spacing-title">{{{ data.choices[ choiceID ] }}}</span>
							<input type="number" {{{ data.inputAttrs }}} data-id="{{ choiceID }}" value='{{ value_tablet_landscape[ choiceID ] }}'/>
						</li>
					<# }); #>

					<# if ( data.linked_choices ) { #>
						<li class="mfx-spacing-link">
							<span class="dashicons dashicons-admin-links mfx-spacing-connected wp-ui-highlight" data-element-connect="{{ data.id }}"></span>
							<span class="dashicons dashicons-editor-unlink mfx-spacing-disconnected" data-element-connect="{{ data.id }}"></span>
						</li>
					<# } #>

					<# if( _.size( data.units ) > 0 ) { #>
						<li>
							<select class="mfx-responsive-select" data-id='tablet-ls-unit'>
								<# _.each( data.units, function( element, index){ #>
									<option value="{{{ element }}}" <# if ( data.value['tablet-ls-unit'] === element ) { #> selected="selected" <# } #> >{{{element}}}</option>
								<# }); #>
							</select>
						</li>
					<# } #>
				</ul>
			</div>

			<div class="mobile control-wrap">
				<ul>
					<# _.each( data.choices, function( choiceLabel, choiceID){ #>
						<li class="mfx-spacing-input">
							<span class="mfx-spacing-title">{{{ data.choices[ choiceID ] }}}</span>
							<input type="number" {{{ data.inputAttrs }}} data-id="{{ choiceID }}" value='{{ value_mobile[ choiceID ] }}' />
						</li>
					<# }); #>

					<# if ( data.linked_choices ) { #>
						<li class="mfx-spacing-link">
							<span class="dashicons dashicons-admin-links mfx-spacing-connected wp-ui-highlight" data-element-connect="{{ data.id }}"></span>
							<span class="dashicons dashicons-editor-unlink mfx-spacing-disconnected" data-element-connect="{{ data.id }}"></span>
						</li>
					<# } #>

					<# if( _.size( data.units ) > 0 ) { #>
						<li>
							<select class="mfx-responsive-select" data-id='mobile-unit'>
								<# _.each( data.units, function( element, index){ #>
									<option value="{{{ element }}}" <# if ( data.value['mobile-unit'] === element ) { #> selected="selected" <# } #> 	>{{{element}}}</option>
								<# }); #>
							</select>
						</li>
					<# } #>
				</ul>
			</div>
		</div>
		<?php
	}
}