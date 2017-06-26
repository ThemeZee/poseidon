<?php
/**
 * Template Name: Magazine Homepage
 *
 * Description: A custom page template for displaying the magazine homepage widgets.
 *
 * @package Poseidon
 */

get_header(); ?>

	<section id="primary" class="content-area">
		<main id="main" class="site-main" role="main">

		<?php // Display Magazine Homepage Widgets.
		if ( is_active_sidebar( 'magazine-homepage' ) ) : ?>

			<div id="magazine-homepage-widgets" class="widget-area clearfix">

				<?php dynamic_sidebar( 'magazine-homepage' ); ?>

			</div><!-- #magazine-homepage-widgets -->

		<?php
		else :
			// Display Magazine Widget Placeholder in Customizer.
			poseidon_customize_magazine_placeholder();
		endif;
		?>

		</main><!-- #main -->
	</section><!-- #primary -->

	<?php get_sidebar(); ?>

<?php get_footer(); ?>
