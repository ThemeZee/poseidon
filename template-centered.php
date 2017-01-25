<?php
/**
 * Template Name: Centered Layout
 * Template Post Type: post, page
 *
 * Description: A custom template for displaying a centered layout with no sidebar.
 *
 * @package Poseidon
 */

get_header(); ?>

	<section id="primary" class="centered-content-area content-area">
		<main id="main" class="site-main" role="main">

			<?php while ( have_posts() ) : the_post();

				if ( 'post' === get_post_type() ) :

					get_template_part( 'template-parts/content', 'single' );

				else :

					get_template_part( 'template-parts/content', 'page' );

				endif;

				comments_template();

			endwhile; ?>

		</main><!-- #main -->
	</section><!-- #primary -->

<?php get_footer(); ?>
