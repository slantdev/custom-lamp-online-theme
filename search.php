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
	$classes[] = 'search-results-page';
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
//remove_action( 'genesis_header', 'genesis_do_header' );
//remove_action( 'genesis_header', 'genesis_header_markup_close', 15 );

// Removes navigation.
remove_theme_support( 'genesis-menus' );

// Removes site footer elements.
//remove_action( 'genesis_footer', 'genesis_footer_markup_open', 5 );
remove_action( 'genesis_footer', 'genesis_do_footer' );
//remove_action( 'genesis_footer', 'genesis_footer_markup_close', 15 );

//remove_action( 'genesis_entry_header', 'genesis_post_info', 12 );
//remove_action( 'genesis_after_entry', 'genesis_get_comments_template' );
	
//remove_action( 'genesis_entry_header', 'genesis_do_post_title' );
//remove_action( 'genesis_entry_content', 'genesis_do_post_content' );
//add_action( 'genesis_entry_content', 'slant_content' );
//add_action( 'genesis_entry_content', 'genesis_get_comments_template' );
//add_action( 'genesis_entry_content', 'slant_after_content' );

/*
function slant_content() { 
	
	//get parent category name
	$category = get_the_category();
	$category_name = $category[0]->name;
	$parent = $category[0]->parent;
	$category_parent = get_category($parent);
	$category_parent_name = $category_parent->name;
	
	$parent_category_link = home_url() . "/" . $category_parent->slug;
	if($parent_category_link)
		$category_link = home_url() . "/" . $category_parent->slug . "/" .$category[0]->slug;
	
	
?>
	<section id="single-post-content" class = "container">
		<div class = "row">
			<div class = "col-12">
				<h2 class = "category"><?php echo $category_name; ?></h2>
			</div>
		</div>
		<div class = "row">
			<div class = "col-md-8 pr-md-4">
				
				<div class = "breadcrumbs pb-3">
					<a href = "<?php echo $parent_category_link; ?>"><?php echo $category_parent_name; ?></a><?php if($category_parent_name) echo " / " ?><a href = "<?php echo $category_link;?>"><?php echo $category_name; ?></a>
				</div>
				
				<h3 class = "pb-2"><?php the_title(); ?></h3>
				<?php echo get_post_image(get_the_ID()); ?>
				<!-- post metadata -->
				<div class = "post-meta">
					<div class = "post-author"><?php the_author_posts_link(); ?></div>	| <div class = "post-date"><?php echo the_date(); ?></div>
				</div>

				<div class = "post-text-box py-3">
					<?php the_content(); ?>
				</div>

				<!-- related posts -->
				<div class = "post-related my-4">
					<h2>Related Posts</h2>
					<div class = "related-posts-wrapper row">
						<?php wpt_related_posts_cat(); ?>
					</div>
					
				</div>
				
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
					?><article class = "col-4">
							<?php echo get_post_image($post->id) ?>
							<h3><a href="<?php get_permalink(); ?>" title="Permanent Link to <?php echo get_the_title(); ?>"><?php echo get_the_title(); ?></a></h3>
							<div class = "timeSince"><?php echo humanTiming(get_the_date('Y-m-d H:i:s')); ?> ago </div>
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

<?php }*/

function get_single_page_color() {
	
	$category = get_the_category();
	$category_name = $category[0]->name;
	$parent = $category[0]->parent;
	$category_parent_id = get_category($parent);
	$category_parent_name = $category_parent_id->name;
	
	$className = convert_category_name_to_class($category_parent_name);

	return $category_parent_id->slug;
}

/*function display_section_content($repeater_object) {
	
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
*/

remove_action( 'genesis_loop', 'genesis_do_loop' );
add_action( 'genesis_loop', 'sk_do_search_loop' );
/**
 * Outputs a custom loop.
 *
 * @global mixed $paged current page number if paginated.
 * @return void
 */
function sk_do_search_loop() {
	// create an array variable with specific post types in your desired order.
	//$post_types = array( 'recipe', 'page', 'post' );
	$post_types = array( 'post' );
	echo '<div class="search-content">';
	foreach ( $post_types as $post_type ) {
		// get the search term entered by user.
		$s = isset( $_GET["s"] ) ? $_GET["s"] : "";
		
		//search variables
		//$ourCurrentPage = get_query_var('paged');
		//Protect against arbitrary paged values
		$paged = ( get_query_var( 'paged' ) ) ? absint( get_query_var( 'paged' ) ) : 1;
		
		$display_count = 10;
		
		// accepts any wp_query args.
		$args = (array(
			's' => $s,
			'post_type' => $post_type,
			'posts_per_page' => $ourCurrentPage,
			'order' => 'DESC',
			'orderby' => 'date',
			'paged' => $paged,
		));
		
		$query = new WP_Query( $args );
		if ( $query->have_posts() ) {
			echo '<div class = "searchResults container py-5">';
			echo '<div class="post-type '. $post_type .' row">
							<div class="post-type-heading col-12">
								<div class = "newsList-container pb-0">
									<div class="newsList-title-wrapper">
										<h2>Search Results for <strong>' . $s .'</strong></h2>
									</div>
								</div>
							</div>
						</div>';
			
				//display search results
				echo '<div class = "row">';
			
				// remove post info.
				remove_action( 'genesis_entry_header', 'genesis_post_info', 12 );
				// remove post image (from theme settings).
				remove_action( 'genesis_entry_content', 'genesis_do_post_image', 8 );
				// remove entry content.
				// remove_action( 'genesis_entry_content', 'genesis_do_post_content' );
				// remove post content nav.
				remove_action( 'genesis_entry_content', 'genesis_do_post_content_nav', 12 );
				remove_action( 'genesis_entry_content', 'genesis_do_post_permalink', 14 );
				// force content limit.
				add_filter( 'genesis_pre_get_option_content_archive_limit', 'sk_content_limit' );
				// modify the Content Limit read more link.
				add_filter( 'get_the_content_more_link', 'sp_read_more_link' );
				// force excerpts.
				// add_filter( 'genesis_pre_get_option_content_archive', 'sk_show_excerpts' );
				// modify the Excerpt read more link.
				add_filter( 'excerpt_more', 'new_excerpt_more' );
				// modify the length of post excerpts.
				add_filter( 'excerpt_length', 'sp_excerpt_length' );
				// remove entry footer.
				remove_action( 'genesis_entry_footer', 'genesis_entry_footer_markup_open', 5 );
				remove_action( 'genesis_entry_footer', 'genesis_entry_footer_markup_close', 15 );
				remove_action( 'genesis_entry_footer', 'genesis_post_meta' );
				// remove archive pagination.
				remove_action( 'genesis_after_endwhile', 'genesis_posts_nav' );
				// custom genesis loop with the above query parameters and hooks.
				genesis_custom_loop( $args );
			
				if($query->max_num_pages > 1)
					echo get_paginate_links($query->max_num_pages);


			?>
			<?php
			echo '</div>';
			echo '</div>';
		}
		else {
			echo '<div class = "searchResults container py-5">';
			echo '<div class="post-type '. $post_type .' row">
							<div class="post-type-heading col-12">
								<div class = "newsList-container pb-0">
									<div class="newsList-title-wrapper">
										<h2>Sorry. Nothing found for ' . $s . '</h2>
									</div>
								</div>
							</div>
						</div>';
	
			echo '<div class = "row">
							<div class = "col-12">
								<p>Try searching again for something else</p>
							</div>
						</div>';
		}
	}
	echo '</div>'; // .search-content
	wp_reset_postdata();
}
function sk_content_limit() {
	return '150'; // number of characters.
}
function sp_read_more_link() {
	return '... <a class="more-link" href="' . get_permalink() . '">Continue Reading</a>';
}
function sk_show_excerpts() {
	return 'excerpts';
}
function new_excerpt_more( $more ) {
    return '... <a class="more-link" href="' . get_permalink() . '">Continue Reading</a>';
}
function sp_excerpt_length( $length ) {
	return 20; // pull first 20 words.
}

genesis();