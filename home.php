<?php
/**
 * The template for displaying the blog index (latest posts)
 *
 * Learn more: http://codex.wordpress.org/Template_Hierarchy
 *
 * @package Poseidon
 */
 
get_header(); 

// Get Theme Options from Database
$theme_options = poseidon_theme_options();
?>
		
	<section id="primary" class="content-area">
		<main id="main" class="site-main" role="main">
					
			<?php
			// Display Latest Posts Title
			if ( isset( $theme_options['latest_posts_title'] ) and $theme_options['latest_posts_title'] <> '' ) : ?>
						
				<header class="page-header">
					
					<h1 class="archive-title"><?php echo wp_kses_post($theme_options['latest_posts_title']); ?></h1>

				</header><!-- .page-header -->
		
			<?php endif; ?>
			
		 
			<?php if (have_posts()) : while (have_posts()) : the_post();
		
				get_template_part( 'template-parts/content', $theme_options['post_content'] );
		
				endwhile;

				// Display Pagination	
				poseidon_pagination();

			endif; ?>
			
		</main><!-- #main -->
	</section><!-- #primary -->
	
	<?php get_sidebar(); ?>

<?php get_footer(); ?>