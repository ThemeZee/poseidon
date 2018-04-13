<?php
/**
 * Theme Info
 *
 * Adds a simple Theme Info page to the Appearance section of the WordPress Dashboard.
 *
 * @package Poseidon
 */

/**
 * Add Theme Info page to admin menu
 */
function poseidon_theme_info_menu_link() {

	// Get theme details.
	$theme = wp_get_theme();

	add_theme_page(
		sprintf( esc_html__( 'Welcome to %1$s %2$s', 'poseidon' ), $theme->display( 'Name' ), $theme->display( 'Version' ) ),
		esc_html__( 'Theme Info', 'poseidon' ),
		'edit_theme_options',
		'poseidon',
		'poseidon_theme_info_page'
	);

}
add_action( 'admin_menu', 'poseidon_theme_info_menu_link' );

/**
 * Display Theme Info page
 */
function poseidon_theme_info_page() {

	// Get theme details.
	$theme = wp_get_theme();
	?>

	<div class="wrap theme-info-wrap">

		<h1><?php printf( esc_html__( 'Welcome to %1$s %2$s', 'poseidon' ), $theme->display( 'Name' ), $theme->display( 'Version' ) ); ?></h1>

		<div class="theme-description"><?php echo $theme->display( 'Description' ); ?></div>

		<hr>
		<div class="important-links clearfix">
			<p><strong><?php esc_html_e( 'Theme Links', 'poseidon' ); ?>:</strong>
				<a href="<?php echo esc_url( __( 'https://themezee.com/themes/poseidon/', 'poseidon' ) . '?utm_source=theme-info&utm_medium=textlink&utm_campaign=poseidon&utm_content=theme-page' ); ?>" target="_blank"><?php esc_html_e( 'Theme Page', 'poseidon' ); ?></a>
				<a href="http://preview.themezee.com/?demo=poseidon&utm_source=theme-info&utm_campaign=poseidon" target="_blank"><?php esc_html_e( 'Theme Demo', 'poseidon' ); ?></a>
				<a href="<?php echo esc_url( __( 'https://themezee.com/docs/poseidon-documentation/', 'poseidon' ) . '?utm_source=theme-info&utm_medium=textlink&utm_campaign=poseidon&utm_content=documentation' ); ?>" target="_blank"><?php esc_html_e( 'Theme Documentation', 'poseidon' ); ?></a>
				<a href="<?php echo esc_url( __( 'https://wordpress.org/support/theme/poseidon/reviews/?filter=5', 'poseidon' ) ); ?>" target="_blank"><?php esc_html_e( 'Rate this theme', 'poseidon' ); ?></a>
			</p>
		</div>
		<hr>

		<div id="getting-started">

			<h3><?php printf( esc_html__( 'Getting Started with %s', 'poseidon' ), $theme->display( 'Name' ) ); ?></h3>

			<div class="columns-wrapper clearfix">

				<div class="column column-half clearfix">

					<div class="section">
						<h4><?php esc_html_e( 'Theme Documentation', 'poseidon' ); ?></h4>

						<p class="about">
							<?php esc_html_e( 'You need help to setup and configure this theme? We got you covered with an extensive theme documentation on our website.', 'poseidon' ); ?>
						</p>
						<p>
							<a href="<?php echo esc_url( __( 'https://themezee.com/docs/poseidon-documentation/', 'poseidon' ) . '?utm_source=theme-info&utm_medium=button&utm_campaign=poseidon&utm_content=documentation' ); ?>" target="_blank" class="button button-secondary">
								<?php printf( esc_html__( 'View %s Documentation', 'poseidon' ), 'Poseidon' ); ?>
							</a>
						</p>
					</div>

					<div class="section">
						<h4><?php esc_html_e( 'Theme Options', 'poseidon' ); ?></h4>

						<p class="about">
							<?php printf( esc_html__( '%s makes use of the Customizer for all theme settings. Click on "Customize Theme" to open the Customizer now.', 'poseidon' ), $theme->display( 'Name' ) ); ?>
						</p>
						<p>
							<a href="<?php echo wp_customize_url(); ?>" class="button button-primary"><?php esc_html_e( 'Customize Theme', 'poseidon' ); ?></a>
						</p>
					</div>

				</div>

				<div class="column column-half clearfix">

					<img src="<?php echo get_template_directory_uri(); ?>/screenshot.jpg" />

				</div>

			</div>

		</div>

		<hr>

		<div id="more-features">

			<h3><?php esc_html_e( 'Get more features', 'poseidon' ); ?></h3>

			<div class="columns-wrapper clearfix">

				<div class="column column-half clearfix">

					<div class="section">
						<h4><?php esc_html_e( 'Pro Version Add-on', 'poseidon' ); ?></h4>

						<p class="about">
							<?php printf( esc_html__( 'Purchase the %s Pro Add-on and get additional features and advanced customization options.', 'poseidon' ), 'Poseidon' ); ?>
						</p>
						<p>
							<a href="<?php echo esc_url( __( 'https://themezee.com/addons/poseidon-pro/', 'poseidon' ) . '?utm_source=theme-info&utm_medium=button&utm_campaign=poseidon&utm_content=pro-version' ); ?>" target="_blank" class="button button-secondary">
								<?php printf( esc_html__( 'Learn more about %s Pro', 'poseidon' ), 'Poseidon' ); ?>
							</a>
						</p>
					</div>

				</div>

				<div class="column column-half clearfix">

					<div class="section">
						<h4><?php esc_html_e( 'Recommended Plugins', 'poseidon' ); ?></h4>

						<p class="about">
							<?php esc_html_e( 'Extend the functionality of your WordPress website with our free and easy to use plugins.', 'poseidon' ); ?>
						</p>
						<p>
							<a href="<?php echo esc_url( admin_url( 'plugin-install.php?tab=search&type=author&s=themezee' ) ); ?>" class="button button-secondary">
								<?php esc_html_e( 'Install Plugins', 'poseidon' ); ?>
							</a>
						</p>
					</div>

				</div>

			</div>

		</div>

		<hr>

		<div id="theme-author">

			<p>
				<?php printf( esc_html__( '%1$s is proudly brought to you by %2$s. If you like this theme, %3$s :)', 'poseidon' ),
					$theme->display( 'Name' ),
					'<a target="_blank" href="' . __( 'https://themezee.com/', 'poseidon' ) . '?utm_source=theme-info&utm_medium=footer&utm_campaign=poseidon" title="ThemeZee">ThemeZee</a>',
					'<a target="_blank" href="' . __( 'https://wordpress.org/support/theme/poseidon/reviews/?filter=5', 'poseidon' ) . '" title="' . esc_attr__( 'Review Poseidon', 'poseidon' ) . '">' . esc_html__( 'rate it', 'poseidon' ) . '</a>'
				); ?>
			</p>

		</div>

	</div>

	<?php
}

/**
 * Enqueues CSS for Theme Info page
 *
 * @param int $hook Hook suffix for the current admin page.
 */
function poseidon_theme_info_page_css( $hook ) {

	// Load styles and scripts only on theme info page.
	if ( 'appearance_page_poseidon' != $hook ) {
		return;
	}

	// Embed theme info css style.
	wp_enqueue_style( 'poseidon-theme-info-css', get_template_directory_uri() . '/assets/css/theme-info.css' );

}
add_action( 'admin_enqueue_scripts', 'poseidon_theme_info_page_css' );
