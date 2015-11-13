<?php
/**
 * Neptune back compat functionality
 *
 * Prevents Neptune from running on WordPress versions prior to 4.2,
 * since this theme is not meant to be backward compatible beyond that and
 * relies on many newer functions and markup changes introduced in 4.2.
 *
 * @package Neptune
 *
 * Original Code: Twenty Fifteen http://wordpress.org/themes/twentyfifteen
 * Original Copyright: the WordPress team and contributors.
 * 
 * The following code is a derivative work of the code from the Twenty Fifteen theme, 
 * which is licensed GPLv2 or later. This code therefore is also licensed under the terms 
 * of the GNU Public License, version 2.
 */

 
/**
 * Prevent switching to Neptune on old versions of WordPress. Switches to the default theme.
 *
 */
function neptune_compat_switch_theme() {
	switch_theme( WP_DEFAULT_THEME, WP_DEFAULT_THEME );
	unset( $_GET['activated'] );
	add_action( 'admin_notices', 'neptune_compat_upgrade_notice' );
}
add_action( 'after_switch_theme', 'neptune_compat_switch_theme' );


/**
 * Add message for unsuccessful theme switch.
 *
 * Prints an update nag after an unsuccessful attempt to switch to
 * Neptune on WordPress versions prior to 4.2.
 *
 */
function neptune_compat_upgrade_notice() {
	$message = sprintf( esc_html__( '%$1s requires at least WordPress version 4.2. You are running version %$2s. Please upgrade and try again.', 'neptune' ), 'Neptune', $GLOBALS['wp_version'] );
	printf( '<div class="error"><p>%s</p></div>', $message );
}


/**
 * Prevent the Customizer from being loaded on WordPress versions prior to 4.2.
 */
function neptune_compat_customize() {
	wp_die( sprintf( esc_html__( 'Neptune requires at least WordPress version 4.2. You are running version %s. Please upgrade and try again.', 'neptune' ), $GLOBALS['wp_version'] ), '', array(
		'back_link' => true,
	) );
}
add_action( 'load-customize.php', 'neptune_compat_customize' );


/**
 * Prevent the Theme Preview from being loaded on WordPress versions prior to 4.2.
 */
function neptune_compat_preview() {
	if ( isset( $_GET['preview'] ) ) {
		wp_die( sprintf( esc_html__( 'Neptune requires at least WordPress version 4.2. You are running version %s. Please upgrade and try again.', 'neptune' ), $GLOBALS['wp_version'] ) );
	}
}
add_action( 'template_redirect', 'neptune_compat_preview' );
