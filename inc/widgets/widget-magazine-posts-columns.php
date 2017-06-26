<?php
/**
 * Magazine Columns Widget
 *
 * Display the latest posts from two categories in a two column layout.
 * Intented to be used in the Magazine Homepage widget area to built a magazine layouted page.
 *
 * @package Poseidon
 */

/**
 * Magazine Widget Class
 */
class Poseidon_Magazine_Posts_Columns_Widget extends WP_Widget {

	/**
	 * Widget Constructor
	 */
	function __construct() {

		// Setup Widget.
		parent::__construct(
			'poseidon-magazine-posts-columns', // ID.
			esc_html__( 'Magazine (Columns)', 'poseidon' ), // Name.
			array(
				'classname' => 'poseidon-magazine-columns-widget',
				'description' => esc_html__( 'Displays your posts from two selected categories.', 'poseidon' ),
				'customize_selective_refresh' => true,
			) // Args.
		);
	}

	/**
	 * Set default settings of the widget
	 */
	private function default_settings() {

		$defaults = array(
			'category_one'       => 0,
			'category_two'       => 0,
			'category_one_title' => esc_html__( 'Left Category', 'poseidon' ),
			'category_two_title' => esc_html__( 'Right Category', 'poseidon' ),
			'number'             => 4,
			'highlight_post'     => true,
		);

		return $defaults;
	}

	/**
	 * Main Function to display the widget
	 *
	 * @uses this->render()
	 *
	 * @param array $args / Parameters from widget area created with register_sidebar().
	 * @param array $instance / Settings for this widget instance.
	 */
	function widget( $args, $instance ) {

		// Start Output Buffering.
		ob_start();

		// Get Widget Settings.
		$settings = wp_parse_args( $instance, $this->default_settings() );

		// Output.
		echo $args['before_widget'];
		?>

		<div class="widget-magazine-posts-columns widget-magazine-posts clearfix">

			<div class="widget-magazine-posts-content clearfix">

				<?php echo $this->render( $args, $settings ); ?>

			</div>

		</div>

		<?php
		echo $args['after_widget'];

		// End Output Buffering.
		ob_end_flush();
	}

	/**
	 * Renders the Widget Content
	 *
	 * Displays left and right column with posts
	 *
	 * @uses this->magazine_posts()
	 * @used-by this->widget()
	 *
	 * @param array $args / Parameters from widget area created with register_sidebar().
	 * @param array $settings / Settings for this widget instance.
	 */
	function render( $args, $settings ) {

		// Get cached post ids.
		$post_ids_category_one = poseidon_get_magazine_post_ids( $this->id . '-left-category', $settings['category_one'], $settings['number'] );
		$post_ids_category_two = poseidon_get_magazine_post_ids( $this->id . '-right-category', $settings['category_two'], $settings['number'] );
		?>

		<div class="magazine-posts-column-left magazine-posts-columns clearfix">

			<div class="magazine-posts-columns-content clearfix">

				<?php // Display Category Title.
					$this->category_title( $args, $settings, $settings['category_one'], $settings['category_one_title'] ); ?>

				<div class="magazine-posts-columns-post-list clearfix">
					<?php $this->magazine_posts( $settings, $post_ids_category_one, $settings['number'] ); ?>
				</div>

			</div>

		</div>

		<div class="magazine-posts-column-right magazine-posts-columns clearfix">

			<div class="magazine-posts-columns-content clearfix">

				<?php // Display Category Title.
					$this->category_title( $args, $settings, $settings['category_two'], $settings['category_two_title'] ); ?>

				<div class="magazine-posts-columns-post-list clearfix">
					<?php $this->magazine_posts( $settings, $post_ids_category_two, $settings['number'] ); ?>
				</div>

			</div>

		</div>

		<?php
	}

	/**
	 * Display Magazine Posts Loop
	 *
	 * @used-by this->render()
	 *
	 * @param array $settings / Settings for this widget instance.
	 * @param array $post_ids / Array with post ids.
	 */
	function magazine_posts( $settings, $post_ids, $number_of_posts ) {

		// Fetch posts from database.
		$query_arguments = array(
			'post__in'            => $post_ids,
			'posts_per_page'      => absint( $number_of_posts ),
			'ignore_sticky_posts' => true,
			'no_found_rows'       => true,
		);
		$posts_query = new WP_Query( $query_arguments );

		// Check if there are posts.
		if ( $posts_query->have_posts() ) :

			// Limit the number of words for the excerpt.
			add_filter( 'excerpt_length', 'poseidon_magazine_posts_excerpt_length' );

			// Display Posts.
			while ( $posts_query->have_posts() ) :

				$posts_query->the_post();

				// Display first post differently.
				if ( true === $settings['highlight_post'] and 0 === $posts_query->current_post ) :

					get_template_part( 'template-parts/widgets/magazine-large-post', 'columns' );

				else :

					get_template_part( 'template-parts/widgets/magazine-small-post', 'columns' );

				endif;

			endwhile;

			// Remove excerpt filter.
			remove_filter( 'excerpt_length', 'poseidon_magazine_posts_excerpt_length' );

		endif;

		// Reset Postdata.
		wp_reset_postdata();
	}

	/**
	 * Displays Category Widget Title
	 *
	 * @param array  $args / Parameters from widget area created with register_sidebar().
	 * @param array  $settings / Settings for this widget instance.
	 * @param int    $category_id / ID of the selected category.
	 * @param String $category_title / Category Title.
	 */
	function category_title( $args, $settings, $category_id, $category_title ) {

		// Add Widget Title Filter.
		$widget_title = apply_filters( 'widget_title', $category_title, $settings, $this->id_base );

		if ( ! empty( $widget_title ) ) :

			// Link Widget Title to category archive when possible.
			$widget_title = poseidon_magazine_widget_title( $widget_title, $category_id );

			// Display Widget Title.
			echo $args['before_title'] . $widget_title . $args['after_title'];

		endif;
	}

	/**
	 * Update Widget Settings
	 *
	 * @param array $new_instance / New Settings for this widget instance.
	 * @param array $old_instance / Old Settings for this widget instance.
	 * @return array $instance
	 */
	function update( $new_instance, $old_instance ) {

		$instance = $old_instance;
		$instance['category_one_title'] = sanitize_text_field( $new_instance['category_one_title'] );
		$instance['category_one'] = (int) $new_instance['category_one'];
		$instance['category_two_title'] = sanitize_text_field( $new_instance['category_two_title'] );
		$instance['category_two'] = (int) $new_instance['category_two'];
		$instance['number'] = (int) $new_instance['number'];
		$instance['highlight_post'] = ! empty( $new_instance['highlight_post'] );

		poseidon_flush_magazine_post_ids();

		return $instance;
	}

	/**
	 * Displays Widget Settings Form in the Backend
	 *
	 * @param array $instance / Settings for this widget instance.
	 */
	function form( $instance ) {

		// Get Widget Settings.
		$settings = wp_parse_args( $instance, $this->default_settings() );
		?>

		<p>
			<label for="<?php echo $this->get_field_id( 'category_one_title' ); ?>"><?php esc_html_e( 'Left Category Title:', 'poseidon' ); ?>
				<input class="widefat" id="<?php echo $this->get_field_id( 'category_one_title' ); ?>" name="<?php echo $this->get_field_name( 'category_one_title' ); ?>" type="text" value="<?php echo esc_attr( $settings['category_one_title'] ); ?>" />
			</label>
		</p>

		<p>
			<label for="<?php echo $this->get_field_id( 'category_one' ); ?>"><?php esc_html_e( 'Left Category:', 'poseidon' ); ?></label><br/>
			<?php // Display Category One Select.
				$args = array(
					'show_option_all'    => esc_html__( 'All Categories', 'poseidon' ),
					'show_count' 		 => true,
					'hide_empty'		 => false,
					'selected'           => $settings['category_one'],
					'name'               => $this->get_field_name( 'category_one' ),
					'id'                 => $this->get_field_id( 'category_one' ),
				);
				wp_dropdown_categories( $args );
			?>
		</p>

		<p>
			<label for="<?php echo $this->get_field_id( 'category_two_title' ); ?>"><?php esc_html_e( 'Right Category Title:', 'poseidon' ); ?>
				<input class="widefat" id="<?php echo $this->get_field_id( 'category_two_title' ); ?>" name="<?php echo $this->get_field_name( 'category_two_title' ); ?>" type="text" value="<?php echo esc_attr( $settings['category_two_title'] ); ?>" />
			</label>
		</p>

		<p>
			<label for="<?php echo $this->get_field_id( 'category_two' ); ?>"><?php esc_html_e( 'Right Category:', 'poseidon' ); ?></label><br/>
			<?php // Display Category One Select.
				$args = array(
					'show_option_all'    => esc_html__( 'All Categories', 'poseidon' ),
					'show_count' 		 => true,
					'hide_empty'		 => false,
					'selected'           => $settings['category_two'],
					'name'               => $this->get_field_name( 'category_two' ),
					'id'                 => $this->get_field_id( 'category_two' ),
				);
				wp_dropdown_categories( $args );
			?>
		</p>

		<p>
			<label for="<?php echo $this->get_field_id( 'number' ); ?>"><?php esc_html_e( 'Number of posts:', 'poseidon' ); ?>
				<input id="<?php echo $this->get_field_id( 'number' ); ?>" name="<?php echo $this->get_field_name( 'number' ); ?>" type="text" value="<?php echo absint( $settings['number'] ); ?>" size="3" />
			</label>
		</p>

		<p>
			<label for="<?php echo $this->get_field_id( 'highlight_post' ); ?>">
				<input class="checkbox" type="checkbox" <?php checked( $settings['highlight_post'] ); ?> id="<?php echo $this->get_field_id( 'highlight_post' ); ?>" name="<?php echo $this->get_field_name( 'highlight_post' ); ?>" />
				<?php esc_html_e( 'Highlight first post (big image + excerpt)', 'poseidon' ); ?>
			</label>
		</p>

		<?php
	}
}

/**
 * Register Widget
 */
function poseidon_register_magazine_posts_columns_widget() {

	register_widget( 'Poseidon_Magazine_Posts_Columns_Widget' );

}
add_action( 'widgets_init', 'poseidon_register_magazine_posts_columns_widget' );
