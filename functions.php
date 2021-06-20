<?php
/**
 * betteryogalife Theme functions and definitions
 *
 * @link https://developer.wordpress.org/themes/basics/theme-functions/
 *
 * @package betteryogalife
 * @since 1.0.0
 */

/**
 * Define Constants
 */
define( 'CHILD_THEME_BETTERYOGALIFE_VERSION', '1.0.0' );

/**
 * Enqueue styles
 */
function child_enqueue_styles() {

	wp_enqueue_style( 'betteryogalife-theme-css', get_stylesheet_directory_uri() . '/style.css', array('astra-theme-css'), CHILD_THEME_BETTERYOGALIFE_VERSION, 'all' );

}

add_action( 'wp_enqueue_scripts', 'child_enqueue_styles', 15 );


 
function byl_register_widgets() {
	register_sidebar( array(
		'name'          => esc_html__( 'Home Content', 'astra' ),
		'id'            => 'byl-home-content',
		'before_widget' => '<div id="%1$s" class="widget %2$s">',
		'after_widget'  => '</div>',
		'before_title'  => '<h2 class="widget-title">',
		'after_title'   => '</h2>',
    ) );
}
add_action( 'widgets_init', 'byl_register_widgets' );


// Resigter shortcode for display post

function byl_shortcode_register( $atts ) {
	
	$atts_value = shortcode_atts( array(
		'category' => '',
	), $atts );
	$category_name = $atts_value['category'];
	ob_start();
	?>
			<div class="three-posts-section">
		<div class="byl-post-items">
		<?php 

		$query_posts = new WP_Query(array(
			'category_name' => $category_name,
			'posts_per_page' => 3
		));
			if( $query_posts->have_posts()) :
				while( $query_posts->have_posts()) : $query_posts->the_post();
				?>
		<div class="byl-item">
			<a href="<?php the_permalink() ?>"><?php the_post_thumbnail('thumbnail') ?></a>
			<h2 class="entry-title"><a href="<?php the_permalink() ?>"><?php the_title() ?></a></h2>
		</div>
				<?php
			endwhile;
		endif;
		?>
		</div>
		<?php
		// Get the ID of a given category
		$category_id = get_cat_ID( $category_name );
		// Get the URL of this category
		$category_link = get_category_link( $category_id );
		if(!empty($category_name)) {

			?><a href="<?php echo esc_url( $category_link ); ?>" class="btn byl-btn">See All</a><?php
		}?>
	
		</div>


<?php		
	return ob_get_clean();
}
add_shortcode( 'byl_posts', 'byl_shortcode_register');



