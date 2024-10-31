<?php
/**
 * Customizer Control: Base
 */

// Exit if accessed directly.
if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

class Multifox_Customize_Control extends WP_Customize_Control {

	public $type = '';

	public $dependency = array();

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

	protected function render_content() {
		$input_id         = '_customize-input-' . esc_attr($this->id);
		$description_id   = '_customize-description-' . esc_attr($this->id);
		$describedby_attr = ( ! empty( $this->description ) ) ? esc_attr( $description_id ) : '';
		$depend_id        = preg_replace('/(.*)\[(.*)\](.*)/sm', '\2', $this->id );

		switch ( $this->type ) {
			case 'checkbox':
				?>
				<span class="customize-inside-control-row">
					<input
						data-depend-id="<?php echo esc_attr( $depend_id ); ?>"
						id="<?php echo esc_attr( $input_id ); ?>"
						aria-describedby="<?php echo esc_attr($describedby_attr); ?>"
						type="checkbox"
						value="<?php echo esc_attr( $this->value() ); ?>"
						<?php $this->link(); ?>
						<?php checked( $this->value() ); ?>
					/>
					<label for="<?php echo esc_attr( $input_id ); ?>"><?php echo esc_html( $this->label ); ?></label>
					<?php if ( ! empty( $this->description ) ) : ?>
						<span id="<?php echo esc_attr( $description_id ); ?>" class="description customize-control-description"><?php echo esc_html( $this->description ); ?></span>
					<?php endif; ?>
				</span>
				<?php
				break;
			case 'radio':
				if ( empty( $this->choices ) ) {
					return;
				}

				$name = '_customize-radio-' . esc_attr($this->id);
				?>
				<?php if ( ! empty( $this->label ) ) : ?>
					<span class="customize-control-title"><?php echo esc_html( $this->label ); ?></span>
				<?php endif; ?>
				<?php if ( ! empty( $this->description ) ) : ?>
					<span id="<?php echo esc_attr( $description_id ); ?>" class="description customize-control-description"><?php echo esc_html( $this->description ); ?></span>
				<?php endif; ?>

				<?php foreach ( $this->choices as $value => $label ) : ?>
					<span class="customize-inside-control-row">
						<input
							data-depend-id="<?php echo esc_attr( $depend_id ); ?>"
							id="<?php echo esc_attr( $input_id . '-radio-' . esc_attr($value) ); ?>"
							type="radio"
							aria-describedby="<?php echo esc_attr($describedby_attr); ?>"
							value="<?php echo esc_attr( $value ); ?>"
							name="<?php echo esc_attr( $name ); ?>"
							<?php $this->link(); ?>
							<?php checked( $this->value(), $value ); ?>
							/>
						<label for="<?php echo esc_attr( $input_id . '-radio-' . esc_attr($value) ); ?>"><?php echo esc_html( $label ); ?></label>
					</span>
				<?php endforeach; ?>
				<?php
				break;
			case 'select':
				if ( empty( $this->choices ) ) {
					return;
				}

				?>
				<?php if ( ! empty( $this->label ) ) : ?>
					<label for="<?php echo esc_attr( $input_id ); ?>" class="customize-control-title"><?php echo esc_html( $this->label ); ?></label>
				<?php endif; ?>
				<?php if ( ! empty( $this->description ) ) : ?>
					<span id="<?php echo esc_attr( $description_id ); ?>" class="description customize-control-description"><?php echo esc_html( $this->description ); ?></span>
				<?php endif; ?>

				<select data-depend-id="<?php echo esc_attr( $depend_id ); ?>" id="<?php echo esc_attr( $input_id ); ?>" aria-describedby="<?php echo esc_attr($describedby_attr); ?>" <?php $this->link(); ?>>
					<?php
					foreach ( $this->choices as $value => $label ) {
						echo '<option value="' . esc_attr( $value ) . '"' . selected( $this->value(), $value, false ) . '>' . esc_html($label) . '</option>';
					}
					?>
				</select>
				<?php
				break;
			case 'multiselect':
				if ( empty( $this->choices ) ) {
					return;
				}

				?>
				<?php if ( ! empty( $this->label ) ) : ?>
					<label for="<?php echo esc_attr( $input_id ); ?>" class="customize-control-title"><?php echo esc_html( $this->label ); ?></label>
				<?php endif; ?>
				<?php if ( ! empty( $this->description ) ) : ?>
					<span id="<?php echo esc_attr( $description_id ); ?>" class="description customize-control-description"><?php echo esc_html( $this->description ); ?></span>
				<?php endif; ?>

				<select data-depend-id="<?php echo esc_attr( $depend_id ); ?>" id="<?php echo esc_attr( $input_id.'[]' ); ?>" aria-describedby="<?php echo esc_attr($describedby_attr); ?>" <?php $this->link(); ?> multiple>
					<?php
					foreach ( $this->choices as $value => $label ) {
						$selected_attr = '';
						if(in_array($value, $this->value())) {
							$selected_attr = 'selected';
						}
						echo '<option value="' . esc_attr( $value ) . '"' . esc_attr($selected_attr) . '>' . esc_html($label) . '</option>';
					}
					?>
				</select>
				<?php
				break;

			case 'textarea':
				?>
				<?php if ( ! empty( $this->label ) ) : ?>
					<label for="<?php echo esc_attr( $input_id ); ?>" class="customize-control-title"><?php echo esc_html( $this->label ); ?></label>
				<?php endif; ?>
				<?php if ( ! empty( $this->description ) ) : ?>
					<span id="<?php echo esc_attr( $description_id ); ?>" class="description customize-control-description"><?php echo esc_html( $this->description ); ?></span>
				<?php endif; ?>
				<textarea
					id="<?php echo esc_attr( $input_id ); ?>"
                    data-depend-id="<?php echo esc_attr( $depend_id ); ?>"
					rows="5"
					aria-describedby="<?php echo esc_attr($describedby_attr); ?>"
					<?php $this->input_attrs(); ?>
					<?php $this->link(); ?>>
					<?php echo esc_textarea( $this->value() ); ?>
				</textarea>
				<?php
				break;
			default:
				?>
				<?php if ( ! empty( $this->label ) ) : ?>
					<label for="<?php echo esc_attr( $input_id ); ?>" class="customize-control-title"><?php echo esc_html( $this->label ); ?></label>
				<?php endif; ?>
				<?php if ( ! empty( $this->description ) ) : ?>
					<span id="<?php echo esc_attr( $description_id ); ?>" class="description customize-control-description"><?php echo esc_html( $this->description ); ?></span>
				<?php endif; ?>
				<input
					id="<?php echo esc_attr( $input_id ); ?>"
                    data-depend-id="<?php echo esc_attr( $depend_id ); ?>"
					type="<?php echo esc_attr( $this->type ); ?>"
					aria-describedby="<?php echo esc_attr($describedby_attr); ?>"
					<?php $this->input_attrs(); ?>
					<?php if ( ! isset( $this->input_attrs['value'] ) ) : ?>
						value="<?php echo esc_attr( $this->value() ); ?>"
					<?php endif; ?>
					<?php $this->link(); ?>
					/>
				<?php
				break;
		}
	}

}