<?php
/**
 * Magazine Widget Area Control for the Customizer
 *
 * @package Poseidon
 */

/**
 * Make sure that custom controls are only defined in the Customizer
 */
if ( class_exists( 'WP_Customize_Control' ) ) :

	/**
	 * Magazine Widget Area Customize Control class.
	 *
	 * @see WP_Customize_Control
	 */
	class Poseidon_Magazine_Widget_Area_Customize_Control extends WP_Widget_Area_Customize_Control {
		/**
		 * Enqueue Magazine Widgets Control Scripts.
		 */
		function enqueue() {
			wp_enqueue_script( 'poseidon-customizer-magazine-widgets', get_template_directory_uri() . '/js/customizer-magazine-widgets.js', array( 'jquery' ), '20170627', true );
		}

		/**
		 * Renders the control's content.
		 */
		public function render_content() {
			$id = 'reorder-widgets-desc-' . str_replace( array( '[', ']' ), array( '-', '' ), $this->id );
			?>
			<div id="magazine-widgets-buttons">
				<button type="button" class="button-secondary add-new-magazine-section add-new-widget" aria-expanded="false" aria-controls="available-widgets">
					<?php _e( 'Add Magazine Section' ); ?>
				</button>
				<button type="button" class="button-secondary add-new-default-widget add-new-widget" aria-expanded="false" aria-controls="available-widgets">
					<?php _e( 'Add a Widget' ); ?>
				</button>
				<button type="button" class="button-link reorder-toggle" aria-label="<?php esc_attr_e( 'Reorder widgets' ); ?>" aria-describedby="<?php echo esc_attr( $id ); ?>">
					<span class="reorder"><?php _ex( 'Reorder', 'Reorder widgets in Customizer' ); ?></span>
					<span class="reorder-done"><?php _ex( 'Done', 'Cancel reordering widgets in Customizer' ); ?></span>
				</button>
				<p class="screen-reader-text" id="<?php echo esc_attr( $id ); ?>"><?php _e( 'When in reorder mode, additional controls to reorder widgets will be available in the widgets list above.' ); ?></p>
			</div>
			<?php
		}
	}

endif;
