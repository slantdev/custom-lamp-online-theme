<?php
/**
 * Genesis Sample.
 *
 * This file adds the Guest Post Archive Page template to the Genesis Sample Theme.
 *
 * Template Name: Guest Post Archive Page
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

	$classes[] = 'archive-our-stories our-stories ' . get_page_color();;
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

// Removes site elements.
remove_action( 'genesis_header', 'genesis_do_header' );
remove_theme_support( 'genesis-menus' );
remove_action( 'genesis_footer', 'genesis_do_footer' );
remove_action( 'genesis_entry_header', 'genesis_do_post_title' );
remove_action( 'genesis_entry_content', 'genesis_do_post_content' );

add_action( 'genesis_entry_content', 'slant_content' );

//send mail to registered email
add_action('acf/save_post', 'my_save_post');

function slant_before_content() { ?>
	<div class = "container">
		<div class = "row">
			<div class = "col-12 py-4 text-center">
				<?php genesis_widget_area( 'top-advertisement-area', array());	?> 
			</div>
		</div>
	</div>
<?php }


function slant_content() {

	$featured_news = 'featured_news';
	$post_grid = "post_grid";
	
	?>

			<section class = "container py-5">
				<div class = "row">
					<div class = "col-md-8 pl-md-0 pr-md-4">
						<?php display_section_content($post_grid);	?> 
					</div>
					<div id = "share-your-story-form" class = "sidebar-widget-area col-md-4 pr-0 pl-md-4 px-3">
						<div class = "widget-wrapper position-sticky">
						<?php genesis_widget_area( 'our-story', array());	?> 
						</div>
					</div>
				</div>
			</section> <?php
}

function get_page_color() {
	if(get_field('our_story_page_color','options')) {
		return get_field('our_story_page_color','options');
	} else
		return "default_color_theme";
}

function display_section_content($repeater_object) {
	$excerpt_limit = 15;

	$args = array(
		'post_type' => 'our-stories',
	);
	
	$listicles = new WP_Query( $args );
	
		if ( $listicles->have_posts() ) {
			echo '<div class = "newsList-container"><div class = "newsList">';

			//display page banner
			$banner_image = get_field('campaign_banner','options')[url];
			$banner_image_description = get_the_title();
			echo sprintf(
				'<div class = "page-image pb-4"><img src = "%s" alt = "%s" /></div>',
				$banner_image,
				$banner_image_description
			);

			echo sprintf('<div class = "pb-2">%s</div>', get_field('campaign_content','options'));
			echo sprintf('<div class = "pb-4"><a href = "%s#share-your-story-form" class = "btn">Share Your Story</a></div>', get_field('share_your_story_link','options')[url]);

			echo '<div class = "accordion newsList newsList-layout-6 gx-3 row">';
			while ( $listicles->have_posts() ) {
				$listicles->the_post();
				?><article class = "accordion-article px-3 mb-4">
						<button class="accordion-btn">
							<div>
							<h3 class = "title mt-2"><?= get_the_title(); ?></h3>
							<div class = "post-meta">
								<?php 
									$display_name = "Anonymous";
									if(get_field('first_name') && !get_field('do_you_wish_to_remain_anonymous')) {
										$display_name = sprintf('%s', get_field('first_name'));
									} 
								?>

								<div class = "post-author"><?php echo $display_name; ?></div>	| <div class = "timeSince post-date mb-2"><?= humanTiming(get_the_date('Y-m-d H:i:s')); ?></div>
							</div>
						
							</div>
						</button>
						<div class="accordion-panel">
							<p><?= apply_filters('the_content', get_the_content()); ?></p>
						</div>
						
				</article><?php

			}
			
			echo '</div></div></div>';
		}
	wp_reset_query();
}


// Runs the Genesis loop.
genesis();
