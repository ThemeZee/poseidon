<?php
/**
 * The template for displaying articles in the loop with full content
 *
 * @package Poseidon
 */
?>

	<article id="post-<?php the_ID(); ?>" <?php post_class(); ?>>

		<header class="entry-header">
			
			<?php poseidon_post_image_archives(); ?>
		
			<?php the_title( sprintf( '<h1 class="entry-title"><a href="%s" rel="bookmark">', esc_url( get_permalink() ) ), '</a></h1>' ); ?>

		</header><!-- .entry-header -->

		<div class="entry-content clearfix">
			
			<?php the_content( esc_html__( 'Continue reading &raquo;', 'poseidon' ) ); ?>
		
		</div><!-- .entry-content -->
		
		<footer class="entry-footer">
			
			<?php poseidon_entry_meta(); ?>
			
		</footer><!-- .entry-footer -->


	</article>