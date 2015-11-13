<?php
/**
 * Custom Controls for the Customizer
 *
 * @package Neptune
 */


/**
 * Make sure that custom controls are only defined in the Customizer
 */
if ( class_exists( 'WP_Customize_Control' ) ) :


	/**
	 * Displays a bold label text. Used to create headlines for radio buttons and description sections.
	 *
	 */
	class Neptune_Customize_Header_Control extends WP_Customize_Control {

		public function render_content() {  ?>
			
			<label>
				<span class="customize-control-title"><?php echo wp_kses_post( $this->label ); ?></span>
			</label>
			
			<?php
		}
	}
	
	
endif;