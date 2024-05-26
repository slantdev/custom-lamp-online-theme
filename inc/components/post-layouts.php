<?php

//slant: this creates a class name based on the current post category. No category is set if the page is not currently on a post.
function get_page_category_as_class()
{
	$categories = get_the_category();
	$className = "";
	if ($categories) {
		foreach ($categories as $category) {
			$className = convert_category_name_to_class($category);
		}
		return $className;
	}
}

function get_category_as_class_by_id($category_id)
{
	// $category = get_the_category_by_ID($category_id);
	// $category = convert_to_classname($category);

	// return convert_category_name_to_class($category);

	// Check if category ID is false
	if ($category_id === false) {
		return;
	}

	// Retrieve the category name by ID
	$category = get_the_category_by_ID($category_id);

	// Check if the category retrieval was successful
	if (!$category) {
		return;
	}

	// Convert the category name to a class name format
	$category = convert_to_classname($category);

	// Further convert the category name to a class if needed
	return convert_category_name_to_class($category);
}

function convert_category_name_to_class($category)
{

	switch ($category) {
		case 'latestnews':
			return "latest_news";
			break;
		case 'professionalissues':
			return "professional_issues";
			break;
		case 'specialities':
			return "specialities";
			break;
		case 'workplaceissues':
			return "workplace_issues";
			break;
		case 'socialjusticeampaction':
			return 'social_justice_action';
			break;
		case 'life':
			return "life";
			break;
		case 'jobsevents':
			return "jobs-events";
			break;
		case 'editorial':
			return "editorial";
			break;
		default:
			return "";
	}
}

function convert_to_classname($string)
{
	//return preg_replace('/\W+/','',strtolower(strip_tags($string)));

	// Remove HTML tags
	$string = strip_tags($string);
	// Convert to lowercase
	$string = strtolower($string);
	// Replace non-word characters with hyphens
	$string = preg_replace('/\W+/', '-', $string);
	// Trim hyphens from the beginning and end
	$string = trim($string, '-');
	// Ensure the class name doesn't start with a digit
	if (preg_match('/^\d/', $string)) {
		$string = 'classname-' . $string;
	}
	return $string;
}

function get_post_excerpt()
{
	$excerpt = strip_tags(get_the_excerpt());

	if (!$excerpt) {
		$excerpt = preg_replace("~(?:\[/?)[^/\]]+/?\]~s", '', get_the_content());
		$excerpt = wp_trim_words($excerpt, 50);
	}

	return $excerpt;
}

function get_post_image($postID)
{
	$image = wp_get_attachment_url(get_post_thumbnail_id($postID));
	if (!$image) {
		$template_dir = get_stylesheet_directory_uri();
		$missing_images_dir = "/images/missing_images/";
		$missing_image_default_file = "missing_image.jpg";
		return '<div class = "imageWrapper"><div class = "imageBlock" style = "background-image: url(' . $template_dir . $missing_images_dir . $missing_image_default_file . ')"></div></div>';
	} else {
		return '<div class = "imageWrapper"><div class = "imageBlock" style = "background-image: url(' . $image . ')"></div></div>';
	}
}

function get_paginate_links($max_num_pages)
{
	$output = '<div class = "post-pagination-wrapper"><div class = "post-pagination-content">' . paginate_links(array('total' => $max_num_pages)) . '</div></div>';
	return $output;
}

function display_news_post($layoutSelection, $category_id)
{

	switch ($layoutSelection) {
		case "layout-1":
			return get_news_layout_1($category_id);
			break;
		case 'layout-2':
			return get_news_layout_2($category_id);
			break;
		case 'layout-3':
			return get_news_layout_3($category_id);
			break;
		case 'layout-4':
			return get_news_layout_4($category_id);
			break;
		case 'layout-5':
			return get_news_layout_5($category_id);
			break;
		case 'layout-6':
			return get_news_layout_6($category_id);
			break;
		default:
			return 'No posts to display.';
	}
}

function get_news_layout_1($category_id)
{

	$hasFeatured = true;
	$output = "";
	$gridPostCount = 0; //used to keep track of every third post to add line break

	if (!$category_id) {

		$posts = new WP_Query(array(
			//'category_name' => $category_name,
			//'cat' => $category_children,
			'posts_per_page' => '7',
			'order' => 'DESC',
			'orderby' => 'post_date',
			'no_found_rows' => true,
		));
	}

	if ($posts->have_posts()) :

		while ($posts->have_posts()) {

			$posts->the_post();

			$excerpt = get_post_excerpt();
			$postID = get_the_ID();
			$title = get_the_title($postID);
			$permalink = get_the_permalink($postID);
			$date = get_the_date('', $postID);
			$humanTiming = humanTiming(get_the_date('Y-m-d H:i:s', $postID));
			$categories = get_the_category();
			$category_name = $categories[0]->cat_name;

			if ($hasFeatured) :

				$output .= '<article class = "featured col-12 pb-3 mb-3">';
				$output .= '<div class = "container">';
				$output .= '<div class = "row">';

				$output .= '<div class = "col-md-8 pr-md-0 pl-md-3 pb-3 pb-md-0 order-md-last">';
				$output .= get_post_image($postID);
				$output .= '</div>';

				$output .= '<div class = "col-md-4 pl-md-0 pr-md-3">';
				//get post content
				$output .= get_post_text(array(
					"category_name"	=>	$category_name,
					'permalink'			=>	$permalink,
					'title'					=>	$title,
					'post_date'			=>	$date,
					'excerpt'				=>	$excerpt,
					'excerpt_length' =>	30,
					'humanTiming'		=>	$humanTiming
				));
				$output .= '</div>';

				$output .= '</div>'; //end row
				$output .= '</div>'; //end container

				$output .= '</article>';
				$hasFeatured = !$hasFeatured;

			else :

				$output .= '<article class = "col-md-4 pb-3 mb-3">';
				$output .= '<div class = "row">';

				//post image
				$output .= '<div class = "col-12 mb-3 d-none d-sm-block">';
				$output .= get_post_image($postID);
				$output .= '</div>';

				//post text content
				$output .= '<div class = "col-12">';
				$output .= get_post_text(array(
					"category_name"	=>	$category_name,
					'permalink'			=>	$permalink,
					'title'					=>	$title,
					'excerpt'				=>	$excerpt,
					'excerpt_length' =>	10,
					'humanTiming'		=>	$humanTiming
				));
				$output .= '</div>';

				$output .= '</div>'; //end row
				$output .= '</article>';

				$gridPostCount++;

			endif;

			if ($gridPostCount == 3) {
				$output .= '<div class = "line-break col-md-12"></div>';
			}
		} //loop
	endif;

	wp_reset_postdata();
	return '<div class = "newsList newsList-layout-1 row">' . $output . '</div>';
}

function get_children_category_by_id($category_id)
{

	$this_category = get_category($category_id);
	//echo $this_category->cat_ID;
	$parent_term_id = $this_category->cat_ID; // term id of parent term

	//$termchildren = get_terms('category',array('child_of' => $parent_id));
	$taxonomies = array(
		'taxonomy' => 'category'
	);

	$args = array(
		// 'parent'         => $parent_term_id,
		'child_of'      => $parent_term_id
	);

	$terms = get_terms($taxonomies, $args);
	if (sizeof($terms) > 0) {
		return $terms;
	}
}

function get_common_categories($categoryList_01, $categoryList_02)
{

	$active_category = '';
	foreach ($categoryList_01 as $categoryListItem_01) {
		foreach ($categoryList_02 as $categoryListItem_02) {
			if ($categoryListItem_01 == $categoryListItem_02->slug)
				$active_category = $categoryListItem_02;
		}
	}

	return $active_category;
}

function get_news_layout_2($category_id)
{

	$hasFeatured = true;
	$hasFeatured2 = true;

	$output = "";

	if ($category_id) {
		$category_name = get_the_category_by_ID($category_id);
		$parent_category = get_category($category_id);
		$category_children = get_term_children($category_id, "category");

		if (!empty($category_children)) {
			$category_id = $category_children;
		}

		$posts = new WP_Query(array(
			//'category_name' => $category_name,
			'cat' => $category_id,
			'posts_per_page' => '4',
			'order' => 'DESC',
			'orderby' => 'post_date',
			'no_found_rows' => true,
		));
	}

	if ($posts->have_posts()) :

		while ($posts->have_posts()) {

			$posts->the_post();

			$excerpt = get_post_excerpt();
			$postID = get_the_ID();
			$title = get_the_title($postID);
			$permalink = get_the_permalink($postID);
			$date = get_the_date('', $postID);
			$humanTiming = humanTiming(get_the_date('Y-m-d H:i:s', $postID));
			$alternate_option  = get_sub_field('alternate_option');
			$categories = get_the_category();

			$url = explode("/", $permalink);
			$post_link = $url[count($url) - 2];
			$child_category = "";

			foreach ($category_children as $category_child) {
				foreach ($categories as $category) {
					if (get_cat_name($category_child) == $category->cat_name) {
						$category_name = $category->cat_name;
						$child_category = $category;
					}
				}
			}


			if ($parent_category->parent) {
				$child_category = $parent_category;
				$parent_category = get_category($child_category->parent);
			}

			$permalink = get_site_url() . "/" . $parent_category->slug . "/";
			if ($child_category)
				$permalink .= $child_category->slug . "/";
			$permalink .= $post_link;


			if ($hasFeatured) :

				$output .= '<article class = "featured col-md-12 pb-3 mb-3">';
				$output .= '<div class = "row">';

				if (!$alternate_option)
					$output .= '<div class = "col-md-8 pl-md-0 pb-3 pb-md-0">';
				else
					$output .= '<div class = "col-md-8 pr-md-0 pb-3 pb-md-0">';

				$output .= get_post_image($postID);
				$output .= '</div>';

				//if alternate option isn't select text goes to the left
				if (!$alternate_option)
					$output .= '<div class = "col-md-4 pr-md-0 order-md-last">';
				else
					$output .= '<div class = "col-md-4 pl-md-0 order-md-first">';

				//get post content
				$output .= get_post_text(array(
					"category_name"	=>	$category_name,
					'permalink'			=>	$permalink,
					'title'					=>	$title,
					'post_date'			=>	$date,
					'excerpt'				=>	$excerpt,
					'excerpt_length' =>	30,
					'humanTiming'		=>	$humanTiming
				));

				$output .= '</div>';

				$output .= '</div>';
				$output .= '</article>';

				$hasFeatured = !$hasFeatured;

			elseif ($hasFeatured2) :

				$output .= '<article class = "featured2 col-md-8">';
				$output .= '<div class = "row">';

				$output .= '<div class = "col-md-8 pl-md-0 pr-md-3">';

				//get post content
				$output .= get_post_text(array(
					"category_name"	=>	$category_name,
					'permalink'			=>	$permalink,
					'title'					=>	$title,
					'post_date'			=>	$date,
					'excerpt'				=>	$excerpt,
					'excerpt_length' =>	25,
				));

				$output .= '</div>';

				$output .= '<div class = "col-md-4 pl-0 d-none d-sm-block">';
				$output .= get_post_image($postID);
				$output .= '</div>';

				$output .= '</div>';
				$output .= '</article>';

				$output .= '<div class = "post-column col-md-4 pl-md-4 pr-md-0 boop">';

				$hasFeatured2 = !$hasFeatured2;

			else :

				$output .= '<article>';

				//get post content
				$output .= get_post_text(array(
					"category_name"	=>	$category_name,
					'permalink'			=>	$permalink,
					'title'					=>	$title,
				));

				$output .= '</article>';

			endif;
		} //loop

		$output .= '</div>';

	endif;

	wp_reset_postdata();
	return '<div class = "newsList newsList-layout-2 container mb-4"><div class = "row">' . $output . '</div></div>';
}

function get_news_layout_3($category_id)
{

	$hasFeatured = true;
	$hasFeatured2 = true;

	$output = "";

	if ($category_id) {
		$category_name = get_the_category_by_ID($category_id);
		$parent_category = get_category($category_id);
		$category_children = get_term_children($category_id, "category");
		if (!empty($category_children)) {
			$category_id = $category_children;
		}

		$posts = new WP_Query(array(
			//'category_name' => $category_name,
			'cat' => $category_id,
			'posts_per_page' => '5',
			'order' => 'DESC',
			'orderby' => 'post_date',
			'no_found_rows' => true,
		));
	}

	if ($posts->have_posts()) :

		while ($posts->have_posts()) {

			$posts->the_post();

			$excerpt = get_post_excerpt();
			$postID = get_the_ID();
			$title = get_the_title($postID);
			$permalink = get_the_permalink($postID);
			$date = get_the_date('', $postID);
			$humanTiming = humanTiming(get_the_date('Y-m-d H:i:s', $postID));
			$categories = get_the_category();
			//$category_name = $categories[0]->cat_name;
			$child_category = "";

			$url = explode("/", $permalink);
			$post_link = $url[count($url) - 2];

			foreach ($category_children as $category_child) {
				foreach ($categories as $category) {
					if (get_cat_name($category_child) == $category->cat_name) {
						$category_name = $category->cat_name;
						$child_category = $category;
					}
				}
			}

			if ($parent_category->parent) {
				$child_category = $parent_category;
				$parent_category = get_category($child_category->parent);
			}

			$permalink = get_site_url() . "/" . $parent_category->slug . "/";
			if ($child_category)
				$permalink .= $child_category->slug . "/";
			$permalink .= $post_link;

			if ($hasFeatured) :

				$output .= '<article class = "featured col-md-4">';

				//$output .= '<div class = "news-column news-text"><div class = "news-column-content">';
				$output .= get_post_image($postID);

				//get post content
				$output .= get_post_text(array(
					"category_name"	=>	$category_name,
					'permalink'			=>	$permalink,
					'title'					=>	$title,
					'post_date'			=>	$date,
					'excerpt'				=>	$excerpt,
					'excerpt_length' =>	50,
					'humanTiming'		=>	$humanTiming
				));

				//$output .= '</div></div>';

				$output .= '</article>';
				$hasFeatured = !$hasFeatured;

			elseif ($hasFeatured2) :

				$output .= '<article class = "featured2 col-md-4">';

				//$output .= '<div class = "news-column news-text"><div class = "news-column-content">';

				$output .= get_post_image($postID);

				//get post content
				$output .= get_post_text(array(
					"category_name"	=>	$category_name,
					'permalink'			=>	$permalink,
					'title'					=>	$title,
					'post_date'			=>	$date,
					'excerpt'				=>	$excerpt,
					'excerpt_length' =>	50,
				));

				//$output .= '</div></div>';

				$output .= '</article>';

				$output .= '<div class = "newsList-column col-md-4">';
				$hasFeatured2 = !$hasFeatured2;

			else :

				$output .= '<article class = "mb-3 pb-md-3 mb-md-4">';
				//$output .= '<div class = "news-column-1"><div class = "news-column-content">';

				//get post content
				$output .= get_post_text(array(
					"category_name"	=>	$category_name,
					'permalink'			=>	$permalink,
					'title'					=>	$title,
					'excerpt'				=>	$excerpt,
					'excerpt_length' =>	15,
				));

				//$output .= '</div></div>';

				$output .= '</article>';

			endif;
		} //loop

		$output .= '</div>';

	endif;

	wp_reset_postdata();
	return '<div class = "newsList newsList-layout-3 row">' . $output . '</div>';
}

//news layout 4
function get_news_layout_4($category_id)
{

	$leftSide_complete = false;
	$rightSide_complete = false;
	$postCount = 0;
	$leftSide_postLimit = "3";
	$rightSide_postLimit = "3";
	$output = "";

	if ($category_id) {
		$category_name = get_the_category_by_ID($category_id);
		$parent_category = get_category($category_id);
		$category_children = get_term_children($category_id, "category");
		if (!empty($category_children)) {
			$category_id = $category_children;
		}

		$posts = new WP_Query(array(
			//'category_name' => $category_name,
			'cat' => $category_id,
			'posts_per_page' => '7',
			'order' => 'DESC',
			'orderby' => 'post_date',
			'no_found_rows' => true,
		));
	}

	if ($posts->have_posts()) :

		while ($posts->have_posts()) {

			$posts->the_post();

			$excerpt = get_post_excerpt();
			$postID = get_the_ID();
			$title = get_the_title($postID);
			$permalink = get_the_permalink($postID);
			$date = get_the_date('', $postID);
			$humanTiming = humanTiming(get_the_date('Y-m-d H:i:s', $postID));
			$categories = get_the_category();
			//$category_name = $categories[0]->cat_name;
			$child_category = "";

			$url = explode("/", $permalink);
			$post_link = $url[count($url) - 2];

			foreach ($category_children as $category_child) {
				foreach ($categories as $category) {
					if (get_cat_name($category_child) == $category->cat_name) {
						$category_name = $category->cat_name;
						$child_category = $category;
					}
				}
			}

			if ($parent_category->parent) {
				$child_category = $parent_category;
				$parent_category = get_category($child_category->parent);
			}

			$permalink = get_site_url() . "/" . $parent_category->slug . "/";
			if ($child_category)
				$permalink .= $child_category->slug . "/";
			$permalink .= $post_link;


			if (!$leftSide_complete) :

				//featured post
				if ($postCount == 0) :

					$output .= '<div class = "post-column col-md-8">'; //open column
					$output .= '<div class = "row">';

					$output .= '<article class = "featured container mb-3 pb-3">';
					$output .= '<div class = "row">';


					$output .= '<div class = "col-md-8 pr-md-0 pb-3">';
					$output .= get_post_image($postID);
					$output .= '</div>';

					$output .= '<div class = "col-md-4 order-md-first">';

					//get post content
					$output .= get_post_text(array(
						"category_name"	=>	$category_name,
						'permalink'			=>	$permalink,
						'title'					=>	$title,
						'post_date'			=>	$date,
						'excerpt'				=>	$excerpt,
						'excerpt_length' =>	40,
						'humanTiming'		=>	$humanTiming
					));

					$output .= '</div>'; //end row
					$output .= '</article>';

					$postCount++;

				elseif ($postCount < $leftSide_postLimit) :

					//posts below featured

					$image = wp_get_attachment_url(get_post_thumbnail_id($postID));
					$excerpt = get_post_excerpt();

					if ($postCount == 1) :
						//$output .= '<div class = "news-column-row">';

						$output .= '<article class = "container border-right pr-3 col-md-6">';
						$output .= '<div class = "row">';

						if ($postCount == $leftSide_postLimit - 1)
							$output .= '<div class = "col-md-4 pl-md-0 pb-3">';
						else
							$output .= '<div class = "col-md-4 pl-md-0 pb-3">';

						//$output .= '<div class = " col-md-4 px-md-0 pb-3">';
						$output .= get_post_image($postID);
						$output .= '</div>';

						$output .= '<div class = "col-md-8 order-md-first">';
						//get post content
						$output .= get_post_text(array(
							"category_name"	=>	$category_name,
							'permalink'			=>	$permalink,
							'title'					=>	$title,
							'excerpt'				=>	$excerpt,
							'excerpt_length' =>	15,
						));
						$output .= '</div>';

						$output .= '</div>'; //end row
						$output .= '</article>';

					else :

						$output .= '<article class = "container col-md-6">';
						$output .= '<div class = "row">';

						$output .= '<div class = "col-md-4 pr-md-0 pb-3">';
						$output .= get_post_image($postID);
						$output .= '</div>';

						$output .= '<div class = "col-md-8 order-md-first">';
						//get post content
						$output .= get_post_text(array(
							"category_name"	=>	$category_name,
							'permalink'			=>	$permalink,
							'title'					=>	$title,
							'excerpt'				=>	$excerpt,
							'excerpt_length' =>	15,
						));
						$output .= '</div>';

						$output .= '</div>'; //end row
						$output .= '</article>';

						$output .= '</div>'; //end row
						$output .= '</div>'; //end of news row

					endif;

					$postCount++;

				endif;

				//left side is complete - close column
				if ($postCount == $leftSide_postLimit) :
					$leftSide_complete = true;
					$postCount = 0;
				endif;

			elseif (!$rightSide_complete) :

				if ($postCount == 0) {
					$output .= '<div class = "post-column col-md-4 pr-0 pl-md-4">';
				}
				$output .= '<article class = "border-bottom container px-md-3 pb-3 mb-3">';
				$output .= '<div class = "row">';

				$output .= '<div class = "col-4 pr-0 d-none ">';
				$output .= get_post_image($postID);
				$output .= '</div>';

				$output .= '<div class = "pl-md-0 order-md-first">';
				//get post content
				$output .= get_post_text(array(
					"category_name"	=>	$category_name,
					'permalink'			=>	$permalink,
					'title'					=>	$title,
					'excerpt'				=>	$excerpt,
					'excerpt_length' =>	10,
				));
				$output .= '</div>';

				$output .= '</article>';
				$postCount++;

				//right side is complete - close column
				if ($postCount == $rightSide_postLimit) :
					$output .= '</div>';
					$rightSide_complete = true;
				endif;

			endif;
		}

	endif;

	wp_reset_postdata();
	return '<div class = "newsList newsList-layout-4 row">' . $output . '</div>';
}

//news layout 5
function get_news_layout_5($category_id)
{

	$output = "";

	if ($category_id) {
		$category_name = get_the_category_by_ID($category_id);
		$parent_category = get_category($category_id);
		$category_children = get_term_children($category_id, "category");
		if (!empty($category_children)) {
			$category_id = $category_children;
		}

		$posts = new WP_Query(array(
			//'category_name' => $category_name,
			'cat' => $category_id,
			'posts_per_page' => '1',
			'order' => 'DESC',
			'orderby' => 'post_date',
			'no_found_rows' => true,
		));
	} else {
		$posts = new WP_Query(array(
			'posts_per_page' => '1',
			'order' => 'DESC',
			'orderby' => 'post_date',
			'no_found_rows' => true,
		));
	}

	if ($posts->have_posts()) :

		while ($posts->have_posts()) {

			$posts->the_post();

			$excerpt = get_post_excerpt();
			$postID = get_the_ID();
			$title = get_the_title($postID);
			$permalink = get_the_permalink($postID);
			$date = get_the_date('', $postID);
			$humanTiming = humanTiming(get_the_date('Y-m-d H:i:s', $postID));

			$categories = get_the_category($postID);
			//$category_name = $categories[0]->name;
			$child_category = "";
			$category_name = "";

			$url = explode("/", $permalink);
			$post_link = $url[count($url) - 2];

			$permalink = get_site_url() . "/";

			if (isset($category_children)) {
				foreach ($category_children as $category_child) {
					foreach ($categories as $category) {
						if (get_cat_name($category_child) == $category->cat_name) {
							$category_name = $category->cat_name;
							$child_category = $category;
						}
					}
				}
			}

			if (isset($parent_category->parent)) {
				$child_category = $parent_category;
				$parent_category = get_category($child_category->parent);
				$permalink .= $parent_category->slug . "/";
			} else {
				$parent = $categories[0]->parent;
				$category_parent = get_category($parent);
				$permalink .= $category_parent->slug . "/";
			}

			if ($child_category)
				$permalink .= $child_category->slug . "/";

			$permalink .= $post_link;

			//get breadcrumbs
			$parent = $categories[0]->parent;
			$category_parent = get_category($parent);
			if (isset($category_parent->name)) {
				$category_parent_name = $category_parent->name;
				$parent_category_link = home_url() . "/" . $category_parent->slug;
			}

			if (isset($parent_category_link))
				$category_link = home_url() . "/" . $category_parent->slug . "/" . $categories[0]->slug;
			else
				$category_link = home_url() . "/" . $categories[0]->slug;

			$breadcrumb = '<div class = "breadcrumbs">';

			if (isset($category_parent_name))
				$breadcrumb .= '<a href = "' . $parent_category_link . '">' . $category_parent_name . '</a>';

			if (isset($category_name))
				$breadcrumb .= '<a href = "' . $category_link . '">' . $category_name . '</a>';

			$breadcrumb .= '</div>';


			$output .= '<article class = "featured pt-4 col-12 container">';
			$output .= '<div class = "row">';

			$output .= '<div class = "news-column col-md-6 pr-md-0 mb-3">';
			$output .= get_post_image($postID);
			$output .= '</div>';

			//get post content
			$output .= '<div class = "news-column col-md-6 pl-md-0 order-md-first">';
			$output .= get_post_text(array(
				"breadcrumbs"		=>	$breadcrumb,
				'category_name'	=>	$category_name,
				'permalink'			=>	$permalink,
				'title'					=>	$title,
				'post_date'			=>	$date,
				'excerpt'				=>	$excerpt,
				'excerpt_length' =>	55,
				'humanTiming'		=>	$humanTiming
			));
			$output .= '</div>';

			$output .= '</div>';
			$output .= '</article>';
		}
	endif;

	wp_reset_postdata();
	return '<div class = "newsList newsList-layout-5 row">' . $output . '</div>';
}

//news layout 6
function get_news_layout_6($category_id)
{

	$output = "";
	$ourCurrentPage = get_query_var('paged');
	$display_count = 9;

	if ($category_id) {
		$category_children = get_term_children($category_id, "category");
		$parent_category = get_category($category_id);
		if (!empty($category_children)) {
			$category_id = $category_children;
		}

		$category_name = get_the_category_by_ID($category_id);
		//$offset = ($ourCurrentPage - 1) * $display_count;
		$offset = 1;

		$posts = new WP_Query(array(
			//'category_name' => $category_name,
			'cat' => $category_id,
			'posts_per_page' => $display_count, //TODO: will need to make this dynamic
			'paged' => $ourCurrentPage,
			'order' => 'DESC',
			'order_by' => 'post_date',
			//'offset'	=>	$offset,
		));
	} else {

		$posts = new WP_Query(array(
			'posts_per_page' => $display_count, //TODO: will need to make this dynamic
			'paged' => $ourCurrentPage,
			'order' => 'DESC',
			'order_by' => 'post_date',
		));
	}

	if ($posts->have_posts()) :

		$output = "";

		while ($posts->have_posts()) :
			$posts->the_post();

			$excerpt = get_post_excerpt();
			$postID = get_the_ID();
			$title = get_the_title($postID);
			$permalink = get_the_permalink($postID);
			$date = get_the_date('', $postID);
			$humanTiming = humanTiming(get_the_date('Y-m-d H:i:s', $postID));
			if (!$category_id) {
				$categories = get_the_category($postID);
				$category_name = $categories[0]->name;
			}

			$child_category = "";

			$url = explode("/", $permalink);
			$post_link = $url[count($url) - 2];

			$permalink = get_site_url() . "/";

			if (isset($category_children)) {
				foreach ($category_children as $category_child) {
					foreach ($categories as $category) {
						if (get_cat_name($category_child) == $category->cat_name) {
							$category_name = $category->cat_name;
							$child_category = $category;
						}
					}
				}
			}

			//echo $parent_category->slug . " - " . $child_category->slug;
			if (isset($parent_category->parent)) {
				$child_category = $parent_category;
				$parent_category = get_category($child_category->parent);
			} else {
				$parent = isset($categories[0]) ? $categories[0]->parent : "";
				$category_parent = get_category($parent);
				if (isset($category_parent->slug))
					$permalink .= $category_parent->slug . "/";
				else
					$permalink .= strtolower($category_name) . "/"; //TODO: temp fix for editorial will need to get slug dynamically when category has no parent
			}

			if (isset($parent_category))
				$permalink .= isset($parent_category->slug) ? $parent_category->slug . "/" : "/";

			if ($child_category)
				$permalink .= $child_category->slug . "/";
			$permalink .= $post_link;

			$output .= '<article class = "col-md-4 px-3 mb-3">';

			$output .= '<div class = "mb-3">';
			$output .= get_post_image($postID);
			$output .= '</div>';

			//get post content
			$output .= get_post_text(array(
				"category_name"	=>	$category_name,
				'permalink'			=>	$permalink,
				'title'					=>	$title,
				'post_date'			=>	$date,
				'excerpt'				=>	$excerpt,
				'excerpt_length' =>	15,
			));

			$output .= '</article>';

		endwhile;

		$output .= get_paginate_links($posts->max_num_pages);
	/*$output .= paginate_links(array(
				'total' => $posts->max_num_pages
			));*/

	endif;

	wp_reset_postdata();

	return '<div class = "newsList newsList-layout-6 row">' . $output . '</div>';
}

//news layout 7
function get_news_layout_7()
{

	$output = "";

	$display_count = 1;
	$searchTag = 'featured';

	$posts = new WP_Query(array(
		'tag' => $searchTag,
		'posts_per_page' => $display_count, //TODO: will need to make this dynamic
		'order' => 'DESC',
		'order_by' => 'post_date',
	));

	if ($posts->have_posts()) :

		$output = "";

		while ($posts->have_posts()) :
			$posts->the_post();

			$excerpt = get_post_excerpt();
			$postID = get_the_ID();
			$title = get_the_title($postID);
			$permalink = get_the_permalink($postID);
			$date = get_the_date('', $postID);
			$humanTiming = humanTiming(get_the_date('Y-m-d H:i:s', $postID));

			$output .= '<div class = "imageBackground">';
			$output .= '<article class = "col-md-12">';

			$output .= '<div class = "mb-3">';
			$output .= get_post_image($postID);
			$output .= '</div>';

			//get post content
			$output .= get_post_text(array(
				//"category_name"	=>	$category_name,
				'permalink'			=>	$permalink,
				'title'					=>	$title,
				'post_date'			=>	$date,
				'excerpt'				=>	$excerpt,
				'excerpt_length' =>	15,
			));

			$output .= '</article>';
			$output .= '</div>';

		endwhile;

		$output .= get_paginate_links($posts->max_num_pages);
	/*$output .= paginate_links(array(
				'total' => $posts->max_num_pages
			));*/

	endif;

	wp_reset_postdata();

	return '<div class = "newsList newsList-layout-6 row">' . $output . '</div>';
}


add_shortcode('recent_posts', 'slant_recent_posts_shortcode');

//converts time since specified date
function humanTiming($timeStamp)
{

	$timeStamp = new DateTime($timeStamp);

	$now = new DateTime();

	$sinceThen = $timeStamp->diff($now);

	$years = $sinceThen->y;
	$months = $sinceThen->m;
	$days = $sinceThen->d;

	//Combined
	if ($years > 0) {
		if ($years == 1)
			return $years . ' year ago';
		return $years . ' years ago';
	} else if ($months >= 12) {
		if ($months == 1)
			return $months . ' month ago';
		return $months . ' months ago';
	} else if ($days > 0) {
		if ($days == 1)
			return 'Yesterday';
		return $days . ' days ago';
	} else {
		return 'Today';
	}
}

//get text content for post
function get_post_text($post_content)
{

	//check for excerpt length
	if (isset($post_content["excerpt_length"]))
		$excerpt_length = $post_content["excerpt_length"];
	else
		$excerpt_length = 30;

	$title_character_limit = 55;
	$end_of_line_character = '';

	$output = '<div class = "post_text_content">';

	if (isset($post_content["breadcrumbs"]))
		$output .= $post_content["breadcrumbs"];

	if (isset($post_content["category_name"]))
		$output .= '<div class = "category">' . $post_content["category_name"] . '</div>';

	if (isset($post_content["permalink"]) && isset($post_content["title"])) {
		if (strlen($post_content["title"]) > 55)
			$end_of_line_character = '...';
		$output .= '<h3 class = "title"><a href="' . $post_content["permalink"] . '">' . rtrim(substr($post_content["title"], 0, $title_character_limit)) . $end_of_line_character . '</a></h3>';
	}

	if (isset($post_content["post_date"]))
		$output .= '<div class = "date">' . $post_content["post_date"] . '</div>';

	if (isset($post_content["excerpt"]))
		$output .= '<div class = "content">' . wp_trim_words($post_content["excerpt"], $post_content["excerpt_length"]) . '</div>';

	if (isset($post_content["humanTiming"]))
		$output .= '<div class = "timeSince">' . $post_content["humanTiming"] . '</div>';

	$output .= '</div>';

	return $output;
}
