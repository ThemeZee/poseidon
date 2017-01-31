<?php
/**
 * The template for displaying search results pages.
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
		if ( have_posts() ) : ?>

			<header class="page-header">

				<h1 class="archive-title"><?php printf( esc_html__( 'Search Results for: %s', 'poseidon' ), '<span>' . esc_html( get_search_query() ) . '</span>' ); ?></h1>

			</header><!-- .page-header -->

			<div id="post-wrapper" class="post-wrapper clearfix">

				<?php while ( have_posts() ) : the_post();

					if ( 'post' === get_post_type() ) :

						get_template_part( 'template-parts/content', esc_attr( $theme_options['post_content'] ) );

					else :

						get_template_part( 'template-parts/content', 'search' );

					endif;

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
