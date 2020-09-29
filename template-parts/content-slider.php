<?php
/**
 * The template for displaying articles in the slideshow loop
 *
 * @package Poseidon
 */

?>

<li id="slide-<?php the_ID(); ?>" class="zeeslide clearfix">

	<?php poseidon_slider_image( 'poseidon-header-image', array( 'class' => 'slide-image', 'loading' => false ) ); ?>

	<div class="slide-post clearfix">

		<div class="slide-content container clearfix">

			<?php the_title( sprintf( '<h2 class="entry-title"><a href="%s" rel="bookmark">', esc_url( get_permalink() ) ), '</a></h2>' ); ?>

			<?php poseidon_entry_meta(); ?>

		</div>

	</div>

</li>
