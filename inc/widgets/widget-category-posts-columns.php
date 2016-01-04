<?php
/***
 * Category Posts Columns Widget
 *
 * Display the latest posts from two categories in a 2-column layout. 
 * Intented to be used in the Magazine Homepage widget area to built a magazine layouted page.
 *
 * @package Poseidon
 */

class Poseidon_Category_Posts_Columns_Widget extends WP_Widget {

	/**
	 * Widget Constructor
	 */
	function __construct() {
		
		// Setup Widget
		parent::__construct(
			'poseidon_category_posts_columns', // ID
			sprintf( esc_html__( 'Category Posts: 2 Columns (%s)', 'poseidon' ), wp_get_theme()->Name ), // Name
			array( 
				'classname' => 'poseidon_category_posts_columns', 
				'description' => esc_html__( 'Displays your posts from two selected categories. Please use this widget ONLY in the Magazine Homepage widget area.', 'poseidon' ) 
			) // Args
		);

		// Delete Widget Cache on certain actions
		add_action( 'save_post', array( $this, 'delete_widget_cache' ) );
		add_action( 'deleted_post', array( $this, 'delete_widget_cache' ) );
		add_action( 'switch_theme', array( $this, 'delete_widget_cache' ) );
		
	}
	
	
	/**
	 * Set default settings of the widget
	 */
	private function default_settings() {
	
		$defaults = array(
			'category_one'			=> 0,
			'category_two'			=> 0,
			'category_one_title'	=> '',
			'category_two_title'	=> '',
			'number'				=> 4,
			'highlight_post'		=> true,
			'category_link'		=> false,
			'postmeta'			=> true
		);
		
		return $defaults;
		
	}
	
	
	/**
	 * Main Function to display the widget
	 * 
	 * @uses this->render()
	 * 
	 * @param array $args / Parameters from widget area created with register_sidebar()
	 * @param array $instance / Settings for this widget instance
	 */
	function widget( $args, $instance ) {

		$cache = array();
				
		// Get Widget Object Cache
		if ( ! $this->is_preview() ) {
			$cache = wp_cache_get( 'widget_poseidon_category_posts_columns', 'widget' );
		}
		if ( ! is_array( $cache ) ) {
			$cache = array();
		}

		// Display Widget from Cache if exists
		if ( isset( $cache[ $this->id ] ) ) {
			echo $cache[ $this->id ];
			return;
		}
		
		// Start Output Buffering
		ob_start();
		
		// Get Widget Settings
		$settings = wp_parse_args( $instance, $this->default_settings() );

		// Output
		echo $args['before_widget'];
	?>
		<div class="widget-category-posts-columns widget-category-posts clearfix">
			
			<div class="widget-category-posts-content clearfix">
			
				<?php echo $this->render( $args, $settings ); ?>
				
			</div>

		</div>
	<?php
		echo $args['after_widget'];
		
		// Set Cache
		if ( ! $this->is_preview() ) {
			$cache[ $this->id ] = ob_get_flush();
			wp_cache_set( 'widget_poseidon_category_posts_columns', $cache, 'widget' );
		} else {
			ob_end_flush();
		}
	
	} // widget()
	
	
	/**
	 * Renders the Widget Content
	 *
	 * Displays left and right column with posts
	 * 
	 * @uses this->category_posts()
	 * @used-by this->widget()
	 *
	 * @param array $args / Parameters from widget area created with register_sidebar()
	 * @param array $settings / Settings for this widget instance
	 */
	function render( $args, $settings ) { ?>
		
		<div class="category-posts-column-left category-posts-columns clearfix">
				
			<div class="category-posts-columns-content clearfix">
			
				<?php //Display Category Title
					$this->category_title( $args, $settings, $settings['category_one'], $settings['category_one_title'] ); ?>
					
				<div class="category-posts-columns-post-list clearfix">
					<?php $this->category_posts( $settings, $settings['category_one'] ); ?>
				</div>
				
			</div>
			
		</div>
		
		<div class="category-posts-column-right category-posts-columns clearfix">
		
			<div class="category-posts-columns-content clearfix">
			
				<?php //Display Category Title
					$this->category_title( $args, $settings, $settings['category_two'], $settings['category_two_title'] ); ?>
					
				<div class="category-posts-columns-post-list clearfix">
					<?php $this->category_posts( $settings, $settings['category_two'] ); ?>
				</div>
				
			</div>
			
		</div>
		
	<?php
	} // render()
	
	
	/**
	 * Display Category Posts Loop
	 *
	 * @used-by this->render()
	 *
	 * @param array $settings / Settings for this widget instance
	 * @param int $category_id / ID of the selected category
	 */
	function category_posts( $settings, $category_id ) {
	
		// Get latest posts from database
		$query_arguments = array(
			'posts_per_page' => (int)$settings['number'],
			'ignore_sticky_posts' => true,
			'cat' => (int)$category_id
		);
		$posts_query = new WP_Query( $query_arguments );
		$i = 0;
		
		// Check if there are posts
		if( $posts_query->have_posts() ) :
		
			// Limit the number of words for the excerpt
			add_filter('excerpt_length', 'poseidon_category_posts_excerpt_length');
		
			// Display Posts
			while( $posts_query->have_posts() ) :
				
				$posts_query->the_post(); 
				
				if( true == $settings['highlight_post'] and ( isset($i) and $i == 0 ) ) : ?>

					<article id="post-<?php the_ID(); ?>" <?php post_class( 'large-post clearfix' ); ?>>

						<header class="entry-header">
			
							<a href="<?php the_permalink() ?>" rel="bookmark"><?php the_post_thumbnail( 'poseidon-category-posts-widget-large' ); ?></a>

							<?php the_title( sprintf( '<h1 class="entry-title"><a href="%s" rel="bookmark">', esc_url( get_permalink() ) ), '</a></h1>' ); ?>
						
							<div class="entry-meta">
								<?php $this->entry_meta( $settings ); ?>
							</div><!-- .entry-meta -->
					
						</header><!-- .entry-header -->
							
						<div class="entry-content">
							<?php the_excerpt(); ?>
							<?php poseidon_more_link(); ?>
						</div><!-- .entry-content -->

					</article>

				<?php else: ?>

					<article id="post-<?php the_ID(); ?>" <?php post_class( 'small-post clearfix' ); ?>>

						<?php if ( has_post_thumbnail() ) : ?>
							<a href="<?php the_permalink() ?>" rel="bookmark"><?php the_post_thumbnail( 'poseidon-category-posts-widget-small' ); ?></a>
						<?php endif; ?>
						
						<div class="small-post-content">
							
							<?php the_title( sprintf( '<h1 class="entry-title"><a href="%s" rel="bookmark">', esc_url( get_permalink() ) ), '</a></h1>' ); ?>						
							
							<div class="entry-meta">
								<?php $this->entry_date( $settings ); ?>
							</div><!-- .entry-meta -->
							
						</div>

					</article>

				<?php
				endif; $i++;
				
			endwhile;
			
			// Remove excerpt filter
			remove_filter( 'excerpt_length', 'poseidon_category_posts_excerpt_length' );

		endif;
		
		// Reset Postdata
		wp_reset_postdata();
		
	} // category_posts()
	
	
	/**
	 * Displays Entry Meta of Posts
	 */
	function entry_meta( $settings ) { 

		if( true == $settings['postmeta'] ) :
		
			poseidon_meta_date();
			poseidon_meta_author();
			
		endif;
	

	} // entry_meta()
	
	
	/**
	 * Displays Entry Date of Posts
	 */
	function entry_date( $settings ) { 

		if( true == $settings['postmeta'] ) :
		
			poseidon_meta_date();
			
		endif;

	} // entry_date()
	
	
	/**
	 * Displays Category Widget Title
	 */
	function category_title( $args, $settings, $category_id, $category_title ) {
		
		// Add Widget Title Filter
		$widget_title = apply_filters( 'widget_title', $category_title, $settings, $this->id_base );
		
		if( !empty( $widget_title ) ) :

			// Link Category Title
			if( true == $settings['category_link'] and $category_id > 0 ) : 
			
				// Set Link URL and Title for Category
				$link_title = sprintf( esc_html__( 'View all posts from category %s', 'poseidon' ), get_cat_name( $category_id ) );
				$link_url = esc_url( get_category_link( $category_id ) );
				
				// Display Widget Title with link to category archive
				echo '<div class="widget-header">';
				echo '<a class="category-archive-link" href="'. $link_url .'" title="'. $link_title . '"><h3 class="widget-title">'. $widget_title . '</h3></a>';
				echo '<a class="category-archive-link" href="'. $link_url .'" title="'. $link_title . '"><span class="category-archive-icon"></span></a>';
				echo '</div>';
			
			else:
				
				// Display default Widget Title without link
				echo $args['before_title'] . $widget_title . $args['after_title']; 
			
			endif;
			
		endif;

	} // category_title()

	
	/**
	 * Update Widget Settings
	 *
	 * @param array $new_instance / New Settings for this widget instance
	 * @param array $old_instance / Old Settings for this widget instance
	 * @return array $instance
	 */
	function update( $new_instance, $old_instance ) {

		$instance = $old_instance;
		$instance['category_one_title'] = sanitize_text_field($new_instance['category_one_title']);
		$instance['category_one'] = (int)$new_instance['category_one'];
		$instance['category_two_title'] = sanitize_text_field($new_instance['category_two_title']);
		$instance['category_two'] = (int)$new_instance['category_two'];
		$instance['number'] = (int)$new_instance['number'];
		$instance['highlight_post'] = !empty($new_instance['highlight_post']);
		$instance['category_link'] = !empty($new_instance['category_link']);
		$instance['postmeta'] = !empty($new_instance['postmeta']);
		
		$this->delete_widget_cache();
		
		return $instance;
	}
	
	
	/**
	 * Displays Widget Settings Form in the Backend
	 *
	 * @param array $instance / Settings for this widget instance
	 */
	function form( $instance ) {
		
		// Get Widget Settings
		$settings = wp_parse_args( $instance, $this->default_settings() );
		?>
		
		<p>
			<label for="<?php echo $this->get_field_id('category_one_title'); ?>"><?php esc_html_e( 'Left Category Title:', 'poseidon' ); ?>
				<input class="widefat" id="<?php echo $this->get_field_id('category_one_title'); ?>" name="<?php echo $this->get_field_name('category_one_title'); ?>" type="text" value="<?php echo $settings['category_one_title']; ?>" />
			</label>
		</p>

		<p>
			<label for="<?php echo $this->get_field_id('category_one'); ?>"><?php esc_html_e( 'Left Category:', 'poseidon' ); ?></label><br/>
			<?php // Display Category One Select
				$args = array(
					'show_option_all'    => esc_html__( 'All Categories', 'poseidon' ),
					'show_count' 		 => true,
					'hide_empty'		 => false,
					'selected'           => $settings['category_one'],
					'name'               => $this->get_field_name('category_one'),
					'id'                 => $this->get_field_id('category_one')
				);
				wp_dropdown_categories( $args ); 
			?>
		</p>
		
				<p>
			<label for="<?php echo $this->get_field_id('category_two_title'); ?>"><?php esc_html_e( 'Right Category Title:', 'poseidon' ); ?>
				<input class="widefat" id="<?php echo $this->get_field_id('category_two_title'); ?>" name="<?php echo $this->get_field_name('category_two_title'); ?>" type="text" value="<?php echo $settings['category_two_title']; ?>" />
			</label>
		</p>
		
		<p>
			<label for="<?php echo $this->get_field_id('category_two'); ?>"><?php esc_html_e( 'Right Category:', 'poseidon' ); ?></label><br/>
			<?php // Display Category One Select
				$args = array(
					'show_option_all'    => esc_html__( 'All Categories', 'poseidon' ),
					'show_count' 		 => true,
					'hide_empty'		 => false,
					'selected'           => $settings['category_two'],
					'name'               => $this->get_field_name('category_two'),
					'id'                 => $this->get_field_id('category_two')
				);
				wp_dropdown_categories( $args ); 
			?>
		</p>
		
		<p>
			<label for="<?php echo $this->get_field_id('number'); ?>"><?php esc_html_e( 'Number of posts:', 'poseidon' ); ?>
				<input id="<?php echo $this->get_field_id('number'); ?>" name="<?php echo $this->get_field_name('number'); ?>" type="text" value="<?php echo (int)$settings['number']; ?>" size="3" />
			</label>
		</p>
		
		<p>
			<label for="<?php echo $this->get_field_id('highlight_post'); ?>">
				<input class="checkbox" type="checkbox" <?php checked( $settings['highlight_post'] ) ; ?> id="<?php echo $this->get_field_id('highlight_post'); ?>" name="<?php echo $this->get_field_name('highlight_post'); ?>" />
				<?php esc_html_e( 'Highlight first post (big image + excerpt)', 'poseidon' ); ?>
			</label>
		</p>
		
		<p>
			<label for="<?php echo $this->get_field_id('category_link'); ?>">
				<input class="checkbox" type="checkbox" <?php checked( $settings['category_link'] ) ; ?> id="<?php echo $this->get_field_id('category_link'); ?>" name="<?php echo $this->get_field_name('category_link'); ?>" />
				<?php esc_html_e( 'Link Category Titles to Category Archive pages', 'poseidon' ); ?>
			</label>
		</p>
		
		<p>
			<label for="<?php echo $this->get_field_id('postmeta'); ?>">
				<input class="checkbox" type="checkbox" <?php checked( $settings['postmeta'] ) ; ?> id="<?php echo $this->get_field_id('postmeta'); ?>" name="<?php echo $this->get_field_name('postmeta'); ?>" />
				<?php esc_html_e( 'Display post date and author', 'poseidon' ); ?>
			</label>
		</p>
		
<?php
	} // form()
	
	
	/**
	 * Delete Widget Cache
	 */
	public function delete_widget_cache() {
		
		wp_cache_delete( 'widget_poseidon_category_posts_columns', 'widget' );
		
	}
	
}

// Register Widget
add_action( 'widgets_init', 'poseidon_register_category_posts_columns_widget' );

function poseidon_register_category_posts_columns_widget() {

	register_widget( 'Poseidon_Category_Posts_Columns_Widget' );
	
}