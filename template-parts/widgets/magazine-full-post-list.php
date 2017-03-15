<?php
/**
 * The template for displaying large posts in the Magazine List widget.
 *
 * @package Poseidon
 */

?>

<article id="post-<?php the_ID(); ?>" <?php post_class( 'clearfix' ); ?>>

	<?php poseidon_post_image(); ?>

	<header class="entry-header">

		<?php the_title( sprintf( '<h2 class="entry-title"><a href="%s" rel="bookmark">', esc_url( get_permalink() ) ), '</a></h2>' ); ?>

		<?php poseidon_magazine_entry_meta(); ?>

	</header><!-- .entry-header -->

	<div class="entry-content">

		<?php the_excerpt(); ?>
		<?php poseidon_more_link(); ?>

	</div><!-- .entry-content -->

</article>
