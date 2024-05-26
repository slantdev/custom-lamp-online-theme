<?php
/**
 * Genesis Sample.
 *
 * This file adds the landing page template to the Genesis Sample Theme.
 *
 * Template Name: Listicles Archive Page
 *
 * @package Genesis Sample
 * @author  StudioPress
 * @license GPL-2.0-or-later
 * @link    https://www.studiopress.com/
 */

add_filter( 'body_class', 'genesis_sample_landing_body_class' );
/**
 * Adds landing page body class.
 *
 * @since 1.0.0
 *
 * @param array $classes Original body classes.
 * @return array Modified body classes.
 */
function genesis_sample_landing_body_class( $classes ) {

	$classes[] = 'listicles ' . get_page_color();;
	return $classes;

}

// Removes Skip Links.
remove_action( 'genesis_before_header', 'genesis_skip_links', 5 );

add_action( 'wp_enqueue_scripts', 'genesis_sample_dequeue_skip_links' );
/**
 * Dequeues Skip Links Script.
 *
 * @since 1.0.0
 */
function genesis_sample_dequeue_skip_links() {

	wp_dequeue_script( 'skip-links' );

}

// Removes site header elements.
//remove_action( 'genesis_header', 'genesis_header_markup_open', 5 );
remove_action( 'genesis_header', 'genesis_do_header' );
//remove_action( 'genesis_header', 'genesis_header_markup_close', 15 );

// Removes navigation.
remove_theme_support( 'genesis-menus' );

// Removes site footer elements.
//remove_action( 'genesis_footer', 'genesis_footer_markup_open', 5 );
remove_action( 'genesis_footer', 'genesis_do_footer' );
//remove_action( 'genesis_footer', 'genesis_footer_markup_close', 15 );

remove_action( 'genesis_entry_header', 'genesis_do_post_title' );
remove_action( 'genesis_entry_content', 'genesis_do_post_content' );
add_action( 'genesis_before_entry_content', 'slant_before_content' );

function slant_before_content() { ?>
	<div class = "container">
		<div class = "row">
			<div class = "col-12 py-4 text-center">
				<?php genesis_widget_area( 'top-advertisement-area', array());	?> 
			</div>
		</div>
	</div>
<?php }

add_action( 'genesis_entry_content', 'slant_content' );

function slant_content() {

	$featured_news = 'featured_news';
	$post_grid = "post_grid";
	
	?>

			<section class = "container">
				<div class = "row">
					<div class = "col-md-12 px-0">
						<h1 class = "mb-0"><?php echo get_the_title(); ?></h1>
					</div>
				</div>
			</section>

			<section class = "container py-5">
				<div class = "row">
					<div class = "col-md-8 pl-md-0 pr-md-4">
						<?php display_section_content($post_grid);	?> 
					</div>
					<div class = "sidebar-widget-area col-md-4 pr-0 pl-md-4">
						<div class = "widget-wrapper position-sticky">
						<?php genesis_widget_area( 'side-widget-02', array());	?> 
						</div>
					</div>
				</div>
			</section> <?php
}

function get_page_color() {
	if(get_field('page_color')) {
		return get_field('page_color');
	} else
		return "default_color_theme";
}

function display_section_content($repeater_object) {
	$excerpt_limit = 25;

	$args = array(
		'post_type' => 'listicles',
	);
	
	$listicles = new WP_Query( $args );
	
		if ( $listicles->have_posts() ) {
			echo '<div class = "newsList-container"><div class = "newsList"><div class = "newsList newsList-layout-6 gx-3 row">';
			while ( $listicles->have_posts() ) {
				$listicles->the_post();
				?><article class = "col-lg-4 px-3 mb-4">
						<?= get_post_image($listicles->id) ?>
						<?= $listicles->id ?>
						<h3 class = "title mt-4"><a href="<?= get_permalink() ?>" title="Permanent Link to <?= get_the_title(); ?>"><?= get_the_title(); ?></a></h3>
						<div class = "timeSince mb-2"><?= humanTiming(get_the_date('Y-m-d H:i:s')); ?></div>
						<div class = "content"><?= wp_trim_words(get_post_excerpt(), $excerpt_limit); ?>
				</article><?php
		
				//$related .= '<li><b>'.$count++.'</b>. &nbsp<a href="' . get_permalink() . '" rel="bookmark" title="Permanent Link to' . get_the_title() . '">' . get_the_title() . '</a></li>';
			}
			echo '</div></div></div>';
		}
		
	// if ( $related ) {
	// printf( "%s", $related );
	wp_reset_query();
	
}

// Runs the Genesis loop.
genesis();
