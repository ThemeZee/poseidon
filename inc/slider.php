<?php
/**
 * Post Slider Setup
 *
 * Enqueues scripts and styles for the slideshow
 * Sets slideshow excerpt length and slider animation parameter
 *
 * The template for displaying the slideshow can be found under /template-parts/post-slider.php
 *
 * @package Poseidon
 */

/**
 * Enqueue slider scripts and styles.
 */
function poseidon_slider_scripts() {

	// Get theme options from database.
	$theme_options = poseidon_theme_options();

	// Register and enqueue FlexSlider JS and CSS if necessary.
	if ( ( true === $theme_options['slider_blog'] or true === $theme_options['slider_magazine'] or is_page_template( 'template-slider.php' ) ) && ! poseidon_is_amp() ) :

		// FlexSlider JS.
		wp_enqueue_script( 'jquery-flexslider', get_template_directory_uri() . '/assets/js/jquery.flexslider-min.js', array( 'jquery' ), '2.6.0' );

		// Register and enqueue slider setup.
		wp_enqueue_script( 'poseidon-slider', get_template_directory_uri() . '/assets/js/slider.js', array( 'jquery-flexslider' ), '20170421' );

	endif;
}
add_action( 'wp_enqueue_scripts', 'poseidon_slider_scripts' );


/**
 * Sets slider animation effect
 *
 * Passes parameters from theme options to the javascript files (js/slider.js)
 */
function poseidon_slider_options() {

	// Get theme options from database.
	$theme_options = poseidon_theme_options();

	// Set parameters array.
	$params = array();

	// Set slider animation.
	$params['animation'] = ( 'fade' === $theme_options['slider_animation'] ) ? 'fade' : 'slide';

	// Set slider speed.
	$params['speed'] = absint( $theme_options['slider_speed'] );

	// Passing parameters to Flexslider.
	wp_localize_script( 'poseidon-slider', 'poseidon_slider_params', $params );

}
add_action( 'wp_enqueue_scripts', 'poseidon_slider_options' );


/**
 * Display Post Slider
 */
function poseidon_slider() {

	// Get theme options from database.
	$theme_options = poseidon_theme_options();

	// Display post slider only if activated.
	if ( ( is_page_template( 'template-slider.php' )
		or ( true === $theme_options['slider_blog'] and is_home() )
		or ( true === $theme_options['slider_magazine'] and is_page_template( 'template-magazine.php' ) )
		) && ! poseidon_is_amp()
	) {

		get_template_part( 'template-parts/post-slider' );

	}
}



if ( ! function_exists( 'poseidon_slider_excerpt_length' ) ) :
	/**
	 * Function to change excerpt length for post slider
	 *
	 * @param int $length Length of excerpt in number of words.
	 * @return int
	 */
	function poseidon_slider_excerpt_length( $length ) {
		return 25;
	}
endif;


if ( ! function_exists( 'poseidon_slider_image' ) ) :
	/**
	 * Displays the featured image of the post as slider image
	 *
	 * @param string $size Post thumbnail size.
	 * @param array  $attr Post thumbnail attributes.
	 */
	function poseidon_slider_image( $size = 'post-thumbnail', $attr = array() ) {

		// Display Post Thumbnail.
		if ( has_post_thumbnail() ) : ?>

			<a class="slide-image-link" href="<?php the_permalink(); ?>" rel="bookmark">
				<figure class="slide-image-wrap">
					<?php the_post_thumbnail( $size, $attr ); ?>
				</figure>
			</a>

		<?php else : ?>

			<a class="slide-image-link" href="<?php the_permalink(); ?>" rel="bookmark">
				<figure class="slide-image-wrap">
					<img src="<?php echo esc_url( get_template_directory_uri() ); ?>/assets/images/default-slider-image.png" class="slide-image default-slide-image wp-post-image" />
				</figure>
			</a>

			<?php
		endif;
	}
endif;
