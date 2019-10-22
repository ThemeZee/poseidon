<?php
/**
 * Theme Links Control for the Customizer
 *
 * @package Poseidon
 */

/**
 * Make sure that custom controls are only defined in the Customizer
 */
if ( class_exists( 'WP_Customize_Control' ) ) :

	/**
	 * Displays the theme links in the Customizer.
	 */
	class Poseidon_Customize_Links_Control extends WP_Customize_Control {
		/**
		 * Render Control
		 */
		public function render_content() {
			?>

			<div class="theme-links">

				<span class="customize-control-title"><?php esc_html_e( 'Theme Links', 'poseidon' ); ?></span>

				<p>
					<a href="<?php echo esc_url( __( 'https://themezee.com/themes/poseidon/', 'poseidon' ) ); ?>?utm_source=customizer&utm_medium=textlink&utm_campaign=poseidon&utm_content=theme-page" target="_blank">
						<?php esc_html_e( 'Theme Page', 'poseidon' ); ?>
					</a>
				</p>

				<p>
					<a href="http://preview.themezee.com/?demo=poseidon&utm_source=customizer&utm_campaign=poseidon" target="_blank">
						<?php esc_html_e( 'Theme Demo', 'poseidon' ); ?>
					</a>
				</p>

				<p>
					<a href="<?php echo esc_url( __( 'https://themezee.com/docs/poseidon-documentation/', 'poseidon' ) ); ?>?utm_source=customizer&utm_medium=textlink&utm_campaign=poseidon&utm_content=documentation" target="_blank">
						<?php esc_html_e( 'Theme Documentation', 'poseidon' ); ?>
					</a>
				</p>

				<p>
					<a href="<?php echo esc_url( __( 'https://themezee.com/changelogs/?action=themezee-changelog&type=theme&slug=poseidon/', 'poseidon' ) ); ?>" target="_blank">
						<?php esc_html_e( 'Theme Changelog', 'poseidon' ); ?>
					</a>
				</p>

				<p>
					<a href="<?php echo esc_url( __( 'https://wordpress.org/support/theme/poseidon/reviews/', 'poseidon' ) ); ?>" target="_blank">
						<?php esc_html_e( 'Rate this theme', 'poseidon' ); ?>
					</a>
				</p>

			</div>

			<?php
		}
	}

endif;
