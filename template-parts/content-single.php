<?php
/**
 * The template for displaying single posts
 *
 * @package Poseidon
 */
?>

	<article id="post-<?php the_ID(); ?>" <?php post_class(); ?>>
		
		<?php poseidon_post_image_single(); ?>
		
		<header class="entry-header">
			
			<?php the_title( '<h1 class="entry-title">', '</h1>' ); ?>
			
			<?php poseidon_entry_meta(); ?>

		</header><!-- .entry-header -->

		<div class="entry-content clearfix">
			<?php the_content(); ?>
			<!-- <?php trackback_rdf(); ?> -->
			<div class="page-links"><?php wp_link_pages(); ?></div>
		</div><!-- .entry-content -->
		
		<footer class="entry-footer">
			
			<?php poseidon_entry_tags(); ?>
			<?php poseidon_post_navigation(); ?>
			
		</footer><!-- .entry-footer -->

	</article>