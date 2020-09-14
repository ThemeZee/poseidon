<?php
/**
 * Main Navigation
 *
 * @version 1.1
 * @package Poseidon
 */
?>

<?php if ( has_nav_menu( 'primary' ) ) : ?>

	<button class="primary-menu-toggle menu-toggle" aria-controls="primary-menu" aria-expanded="false" <?php poseidon_amp_menu_toggle(); ?>>
		<?php
		echo poseidon_get_svg( 'menu' );
		echo poseidon_get_svg( 'close' );
		?>
		<span class="menu-toggle-text screen-reader-text"><?php esc_html_e( 'Menu', 'poseidon' ); ?></span>
	</button>

	<div class="primary-navigation">

		<nav id="site-navigation" class="main-navigation" role="navigation" <?php poseidon_amp_menu_is_toggled(); ?> aria-label="<?php esc_attr_e( 'Primary Menu', 'poseidon' ); ?>">

			<?php
			wp_nav_menu(
				array(
					'theme_location' => 'primary',
					'menu_id'        => 'primary-menu',
					'container'      => false,
				)
			);
			?>
		</nav><!-- #site-navigation -->

	</div><!-- .primary-navigation -->

<?php endif; ?>

<?php do_action( 'poseidon_after_navigation' ); ?>
