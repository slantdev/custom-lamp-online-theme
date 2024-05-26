<?php
/**
 * Genesis Sample.
 *
 * This file adds the landing page template to the Genesis Sample Theme.
 *
 * Template Name: Single Post
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
	
	//$classes[] = 'custom-single theme_color-darkBlue' . get_single_page_color();
	$classes[] = 'error-page';
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

remove_action( 'genesis_entry_header', 'genesis_post_info', 12 );
remove_action( 'genesis_after_entry', 'genesis_get_comments_template' );

remove_action( 'genesis_loop_else', 'genesis_do_noposts' );
remove_action( 'genesis_entry_header', 'genesis_do_post_title' );
remove_action( 'genesis_entry_content', 'genesis_do_post_content' );
remove_action( 'genesis_header', 'slant_do_header' );
remove_action( 'genesis_after_header', 'slant_do_after_header' );
remove_action( 'genesis_footer', 'slant_do_footer' );

add_action( 'genesis_loop', 'slant_content' );
//add_action( 'genesis_entry_content', 'genesis_get_comments_template' );
//add_action( 'genesis_entry_content', 'slant_after_content' );

function slant_content() { 
	
?>
	<?php $imageLink = get_stylesheet_directory_uri() . "/images/404-image.jpg"; ?>
	<!--<section class = "px-5 py-5" style = "height: 800px; background-image: url(<?php //echo $imageLink ?>); background-size: cover;">-->
	<section class = "container py-5" style = "height: 100vh; background-color: #353232; color: #FFF;">
		<div class = "row align-items-center" style = "height: 100%;">
			<div class = "col">
				<div class = "content text-center">
					<?php $template_dir = get_stylesheet_directory_uri(); ?>
					<img src = "<?php echo $template_dir ?>/images/404-image.png" style = "margin-bottom: 48px;"/>
					<p class = "h2">Oops... You have broken The Lamp</p>
					<p>The page you're looking for isn't here.</p>
					<a href = "<?php echo get_home_url(); ?>" style = "color: #FFF" />Go back home</a>
				</div>
			</div>
		</div>
	</section>
<?php }

function slant_after_content() { ?>
		

<?php }


// Runs the Genesis loop.
genesis();
