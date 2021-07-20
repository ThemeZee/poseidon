<?php
/**
 * The template for displaying the blog index (latest posts)
 *
 * Learn more: http://codex.wordpress.org/Template_Hierarchy
 *
 * @package Poseidon
 */

get_header();

// Get Theme Options from Database.
$theme_options = poseidon_theme_options();
?>

	<section id="primary" class="content-area">
		<main id="main" class="site-main" role="main">

		<?php
		// Display Magazine Homepage Widgets.
		poseidon_magazine_widgets();

		do_action( 'poseidon_before_blog' );

		// Display Latest Posts.
		if ( have_posts() ) :

			// Display Blog Title.
			poseidon_blog_title();
			?>

			<div id="post-wrapper" class="post-wrapper clearfix">

				<?php
				while ( have_posts() ) : the_post();

					get_template_part( 'template-parts/content', esc_attr( $theme_options['post_content'] ) );

				endwhile; ?>

			</div>

			<?php poseidon_pagination();

		else :

			get_template_part( 'template-parts/content', 'none' );

		endif; ?>

		</main><!-- #main -->
	</section><!-- #primary -->

	<?php get_sidebar(); ?>

<?php get_footer(); ?>
