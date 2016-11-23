<?php
/**
 * The sidebar containing the main widget area.
 *
 * @package Poseidon
 */

// Check if Sidebar has widgets.
if ( is_active_sidebar( 'sidebar' ) ) : ?>

	<section id="secondary" class="sidebar widget-area clearfix" role="complementary">

		<?php dynamic_sidebar( 'sidebar' ); ?>

	</section><!-- #secondary -->

<?php
endif;
