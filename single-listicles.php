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
	$classes[] = 'listicle custom-single ' . get_single_page_color();
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
	
remove_action( 'genesis_entry_header', 'genesis_do_post_title' );
remove_action( 'genesis_entry_content', 'genesis_do_post_content' );
add_action( 'genesis_entry_content', 'slant_content' );
add_action( 'genesis_entry_content', 'genesis_get_comments_template' );
add_action( 'genesis_entry_content', 'slant_after_content' );

function slant_content() { 
	
	//get parent category name
	$category = get_categories_by_url($_SERVER['REQUEST_URI'], get_the_category());
	$category_name = $category->name;
	$parent = $category->parent;
	$parent_category_link = "";
	$category_link = home_url() . "/" . $category->slug;
	
	if($parent) {
		$category_parent = get_category($parent);
		$category_parent_name = $category_parent->name;
		$parent_category_link = home_url() . "/" . $category_parent->slug;
		$category_link = home_url() . "/" . $category_parent->slug . "/" .$category->slug;
	}
	
?>
	<!-- top ad -->
	<div class = "container">
		<div class = "row">
			<div class = "col-12 pt-4 text-center">
				<?php genesis_widget_area( 'top-advertisement-area', array());	?> 
			</div>
		</div>
	</div>

	<section id="single-post-content" class = "container">
		<div class = "row">
			<div class = "col-12">
				<h2 class = "category"><?php echo $category_name; ?></h2>
			</div>
		</div>
		<div class = "row">
			<div class = "col-md-8 pr-md-4">
				
				<div class = "breadcrumbs pb-3">
				<?php
					//get singular post name for breadcrumbs
					$post_type_obj = get_post_type_object( get_post_type( $post->ID ) );
					$post_type = $post_type_obj->labels->singular_name;
					$breadcrumb_text = "Go Back";
					
				?>
					<?= sprintf('<a href = "%s/%s">%s</a>', get_home_url(), strtolower($post_type), $breadcrumb_text); ?>
				</div>
				
				<h3 class = "pb-2"><?php the_title(); ?></h3>
				<?php echo get_post_image(get_the_ID()); ?>
				<!-- post metadata -->
				<div class = "post-meta">
					<div class = "post-author">Lamp Editorial Team</div>	| <div class = "post-date"><?php echo the_date(); ?></div>
				</div>

				<div class = "post-text-box py-3">
					<?php the_content(); ?>
				</div>

				<div class = "listicle-container py-3">
					
					
					<?php 
					
					//listicle repeater
					$listicles = 'listicles';
					// Check rows exists.
					if( have_rows($listicles) ):

						$listicle_count = 1;

						// Loop through rows.
						while( have_rows($listicles) ) : the_row();

							//add number to list item if numbered list checkbox is active
							if(get_field('numbered_list')) {
								$title = sprintf('<div class = "title_wrapper mb-3"><h4>%s. %s</h4></div>', $listicle_count, get_sub_field('listicle_title'));
								$listicle_count++;
							} else {
								$title = sprintf('<div class = "title_wrapper mb-3"><h4>%s</h4></div>', get_sub_field('listicle_title'));
							}

							$content = sprintf('<div class = "content_wrapper">%s</div>', get_sub_field('listicle_content'));

							$listicle =  $title . $content;
							$listicle = sprintf('<div class = "article-content p-5">%s</div>', $listicle);
							$listicle = sprintf('<article class = "shadow mb-5">%s</article>', $listicle);

							echo $listicle;

						// End loop.
						endwhile;

					endif;
					?>
				</div>

				<!-- related posts -->
				<div class = "post-related my-4">
					<h2>Related Posts</h2>
					<div class = "related-posts-wrapper row">
						<?php wpt_related_posts_cat(); ?>
					</div>
					
				</div>
				
			<!-- middle advertisement section -->
			<section class = "container-fluid">
				<div class = "row">
					<div class = "col-12 py-2 px-0 text-center">
						<?php genesis_widget_area( 'middle-advertisement-area', array());	?> 
					</div>
				</div>
			</section>
				
				<section class = "container">
					<?php echo do_shortcode('[social]'); ?>	
				</section>
<?php }

function wpt_related_posts_cat() {
	if ( is_single ( ) ) {
		global $post;
		$count = 1;
		$postIDs = array( $post->ID );
		$related = '';
		$cats = wp_get_post_categories($post->ID );
		$catIDs = array( );{
			
			foreach ( $cats as $cat ) {
			$catIDs[] = $cat;
			}
			$args = array(
			'post_type'				=> 'listicles',
			'category__in'          => $catIDs,
			'post__not_in'          => $postIDs,
			'showposts'             => 3,
			'ignore_sticky_posts'   => 0,
			'orderby'               => 'rand',
			'tax_query'             => array(
			array(
			'taxonomy'  => 'post_format',
			'field'     => 'slug',
			'terms'     => array(
			'post-format-link',
			'post-format-status',
			'post-format-aside',
			'post-format-quote' ),
			'operator' => 'NOT IN'
			)
			)
			);
			$cat_query = new WP_Query( $args );

			if ( $cat_query->have_posts() ) {
				while ( $cat_query->have_posts() ) {
					$cat_query->the_post();
					?><article class = "col-lg-4">
							<?php echo get_post_image($cat_query->id) ?>
							<?php echo $cat_query->id ?>
							<h3><a href="<?php echo get_permalink() ?>" title="Permanent Link to <?php echo get_the_title(); ?>"><?php echo get_the_title(); ?></a></h3>
							<div class = "timeSince"><?php echo humanTiming(get_the_date('Y-m-d H:i:s')); ?></div>
					</article><?php
			
					//$related .= '<li><b>'.$count++.'</b>. &nbsp<a href="' . get_permalink() . '" rel="bookmark" title="Permanent Link to' . get_the_title() . '">' . get_the_title() . '</a></li>';
				}
			}
			
		}
		if ( $related ) {
		printf( "%s", $related );
		}
		wp_reset_query();
	}
}

function slant_after_content() { ?>
				
				</div><!-- end col-8 -->
			
			<div class = "sidebar-widget-area col-md-4 pl-md-4">
				<div class = "widget-wrapper position-sticky">
					<?php genesis_widget_area( 'article-side-widget', array());	?> 
				</div>
			</div><!-- end col-4 -->
			
		</div>
		
	</section>

<?php }

//Adding the Open Graph in the Language Attributes
function add_opengraph_doctype( $output ) {
        return $output . ' xmlns:og="http://opengraphprotocol.org/schema/" xmlns:fb="http://www.facebook.com/2008/fbml"';
    }
add_filter('language_attributes', 'add_opengraph_doctype');
 
//Lets add Open Graph Meta Info
 
function insert_fb_in_head() {
    global $post;
    if ( !is_singular()) //if it is not a post or a page
        return;
        //echo '<meta property="fb:admins" content="YOUR USER ID"/>';
        echo '<meta property="og:title" content="' . get_the_title() . '"/>';
        echo '<meta property="og:type" content="article"/>';
        echo '<meta property="og:url" content="' . get_permalink() . '"/>';
        echo '<meta property="og:site_name" content="The Lamp Online"/>';
        echo '<meta property="og:description" content="' . wp_trim_words(get_the_excerpt(), 50) . '"/>';
    if(!has_post_thumbnail( $post->ID )) { //the post does not have featured image, use a default image
        $default_image="http://example.com/image.jpg"; //replace this with a default image on your server or an image in your media library
        echo '<meta property="og:image" content="' . $default_image . '"/>';
    }
    else{
        $thumbnail_src = wp_get_attachment_image_src( get_post_thumbnail_id( $post->ID ), '200,200' );
        echo '<meta property="og:image" content="' . esc_attr( $thumbnail_src[0] ) . '"/>';
        echo '<meta property="og:image:width" content="200"/>';
        echo '<meta property="og:image:height" content="200"/>';
    }
    echo "
";
}
add_action( 'wp_head', 'insert_fb_in_head', 5 );

function get_single_page_color() {
	
	$categories = get_categories_by_url($_SERVER['REQUEST_URI'], get_the_category());
	$category_name = $categories->name;
	$parent = $categories->parent;
	
	if($parent) {
		$category_parent_id = get_category($parent);
		$category_name = $category_parent_id->name;
	}
	
	$className = convert_category_name_to_class($category_name);
	
	if($parent)
		return $category_parent_id->slug;
	else
		return $categories->slug;
}

//TODO: should compare two arrays
function get_categories_by_url($url, $current_post_categories) {
	
  $url_array = explode('/',$url); 
	$active_category = '';
	
	foreach($url_array as $url_piece) {
		foreach($current_post_categories as $current_post_category) {
			//echo $url_piece . " - " . $current_post_category->slug . "<br />";
			if($url_piece == $current_post_category->slug)
				$active_category = $current_post_category;
		}
	}
	
	return $active_category;
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
						$post_link = get_sub_field('subcategory_page');
	
						// display a sub field value
						?>
						<div class = " <?php echo get_category_as_class_by_id($post_cat); ?>">
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
					</div> <?php
	
	else :

	?>
		<div class = "container">
			<div class = "alert alert-secondary" role="alert">No Posts found</div>
		</div>
	
	<?php endif;
}

// Runs the Genesis loop.
genesis();