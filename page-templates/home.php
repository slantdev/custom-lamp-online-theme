<?php
/**
 * Genesis Sample.
 *
 * This file adds the landing page template to the Genesis Sample Theme.
 *
 * Template Name: Home
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

	$classes[] = 'landing-page';
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
	$section_01 = "category_section_01";
	$section_02 = "category_section_02";
	$editorial = "editorial_section";
	
	?>

			<!-- latest news -->
			<section class = "container">
				<div class = "row">
					<div class = "col-md-8 pr-md-4">
						<?php display_section_content($featured_news);	?> 
					</div>
					<div class = "sidebar-widget-area col-md-4 pl-md-4">
						<div class = "widget-wrapper position-sticky">
							<?php genesis_widget_area( 'side-widget-01', array());	?> 
						</div>
					</div>
				</div>
			</section>

			<!-- revolution slider: featured news section -->
			<section class = "container-fluid">
				<div class = "row">
					<div class = "col revolution_slider_container">
						<?php add_revslider('clean-news-post-based1'); ?>
					</div>
				</div>
			</section>

			<!-- news content: section 01 -->
			<section class ="container pt-5">
				<div class = "row">
					<div class = "col-md-8 pr-md-4">
						<?php display_section_content($section_01);	?> 
					</div>
					<div class = "sidebar-widget-area col-md-4 pl-md-4">
						<div class = "widget-wrapper position-sticky">
							<?php genesis_widget_area( 'side-widget-02', array());	?> 
						</div>
					</div>
				</div>
			</section>

			<!-- middle advertisement section -->
			<section class = "container-fluid bg-grey">
				<div class = "row">
					<div class = "col-12 py-5 text-center">
						<?php genesis_widget_area( 'middle-advertisement-area', array());	?> 
					</div>
				</div>
			</section>

			<!-- news content: section 02 -->
			<section class = "container pt-5">
				<div class = "row">
					<div class = "col-md-8 pr-md-4">
						<?php display_section_content($section_02);	?> 
					</div>
					<div class = "sidebar-widget-area col-md-4 pl-md-4">
						<div class = "widget-wrapper position-sticky">
							<?php genesis_widget_area( 'side-widget-03', array());	?> 
						</div>
					</div>
				</div>
			</section>

			<!-- editorial section -->
			<section class = "bg-grey">
				<div class = "container pt-5">
					<div class = "row">
						<div class = "col">
							<?php display_section_content($editorial); ?> 
						</div>
					</div>
				</div>
			</section> 

			<?php add_newsletter_modal(); ?>

<?php
}

function display_section_content($repeater_object) {
	
		// check if the repeater field has rows of data
	if( have_rows($repeater_object) ):
		
		?><div class = "newsList-container">
		<?php 
				
		// loop through the rows of data
			while ( have_rows($repeater_object) ) : the_row();
				
						$post_title = get_sub_field('category_title');
						$post_cat = get_sub_field('post_category_selection');
						$layout_selection  = get_sub_field('layout_type');
						$post_link = get_sub_field('category_page');
	
						// display a sub field value
						?>
						<div class = "<?php echo get_category_as_class_by_id($post_cat); ?>">
							<?php if($post_title && $post_link) { ?>
								<div class="newsList-title-wrapper">
									<h2><?php echo $post_title; ?></h2>
									<div class="seeMore-wrapper"><a href="<?php echo $post_link; ?>">See More</a></div>
								</div>
							<?php } ?>

							<div class = "newsList"><?php echo display_news_post($layout_selection, $post_cat); ?></div>
						</div>
			<?php
					endwhile;
			?>
			</div><?php
	
	else :

	?>
		<div class = "container">
			<div class = "alert alert-secondary" role="alert">No Posts found</div>
		</div>
	
	<?php endif;
}

// Runs the Genesis loop.
genesis();
