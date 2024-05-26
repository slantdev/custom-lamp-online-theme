<?php
// Starts the engine.
require_once get_template_directory() . '/lib/init.php';

// Sets up the Theme.
require_once get_stylesheet_directory() . '/lib/theme-defaults.php';

add_action('after_setup_theme', 'genesis_sample_localization_setup');
/**
 * Sets localization (do not remove).
 *
 * @since 1.0.0
 */
function genesis_sample_localization_setup()
{

  load_child_theme_textdomain(genesis_get_theme_handle(), get_stylesheet_directory() . '/languages');
}

// Adds helper functions.
require_once get_stylesheet_directory() . '/lib/helper-functions.php';

// Adds image upload and color select to Customizer.
require_once get_stylesheet_directory() . '/lib/customize.php';

// Includes Customizer CSS.
require_once get_stylesheet_directory() . '/lib/output.php';

// Adds WooCommerce support.
require_once get_stylesheet_directory() . '/lib/woocommerce/woocommerce-setup.php';

// Adds the required WooCommerce styles and Customizer CSS.
require_once get_stylesheet_directory() . '/lib/woocommerce/woocommerce-output.php';

// Adds the Genesis Connect WooCommerce notice.
require_once get_stylesheet_directory() . '/lib/woocommerce/woocommerce-notice.php';

add_action('after_setup_theme', 'genesis_child_gutenberg_support');
/**
 * Adds Gutenberg opt-in features and styling.
 *
 * @since 2.7.0
 */
function genesis_child_gutenberg_support()
{ // phpcs:ignore WordPress.NamingConventions.PrefixAllGlobals.NonPrefixedFunctionFound -- using same in all child themes to allow action to be unhooked.
  require_once get_stylesheet_directory() . '/lib/gutenberg/init.php';
}

// Registers the responsive menus.
if (function_exists('genesis_register_responsive_menus')) {
  genesis_register_responsive_menus(genesis_get_config('responsive-menus'));
}

add_action('wp_enqueue_scripts', 'genesis_sample_enqueue_scripts_styles');
/**
 * Enqueues scripts and styles.
 *
 * @since 1.0.0
 */
function genesis_sample_enqueue_scripts_styles()
{

  //	<!-- Place your kit's code here -->
  //    <script src="https://kit.fontawesome.com/22f1f483a4.js" crossorigin="anonymous"></script>
  //bootstrap
  //<link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.3.1/css/bootstrap.min.css" integrity="sha384-ggOyR0iXCbMQv3Xipma34MD+dH/1fQ784/j6cY/iJTQUOhcWr7x9JvoRxT2MZw1T" crossorigin="anonymous">
  wp_enqueue_style('bootstrap_css', 'https://stackpath.bootstrapcdn.com/bootstrap/4.3.1/css/bootstrap.min.css');
  //wp_enqueue_style( 'fontawesome_css' , 'https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.11.2/css/all.css' ); 
  wp_enqueue_script('fontawesome', 'https://kit.fontawesome.com/c0d0607004.js');
  $appearance = genesis_get_config('appearance');

  wp_enqueue_style(
    genesis_get_theme_handle() . '-fonts',
    $appearance['fonts-url'],
    [],
    genesis_get_theme_version()
  );

  wp_enqueue_style('dashicons');

  if (genesis_is_amp()) {
    wp_enqueue_style(
      genesis_get_theme_handle() . '-amp',
      get_stylesheet_directory_uri() . '/lib/amp/amp.css',
      [genesis_get_theme_handle()],
      genesis_get_theme_version()
    );
  }
}


add_action('after_setup_theme', 'genesis_sample_theme_support', 9);
/**
 * Add desired theme supports.
 *
 * See config file at `config/theme-supports.php`.
 *
 * @since 3.0.0
 */
function genesis_sample_theme_support()
{

  $theme_supports = genesis_get_config('theme-supports');

  foreach ($theme_supports as $feature => $args) {
    add_theme_support($feature, $args);
  }
}

//* Add class to .site-inner
/*add_filter('genesis_attr_site-inner', 'slant_attributes_site_inner');
function slant_attributes_site_inner($attributes) {
	$attributes['class'] .= ' container';
	return $attributes;
}*/

add_action('after_setup_theme', 'genesis_sample_post_type_support', 9);
/**
 * Add desired post type supports.
 *
 * See config file at `config/post-type-supports.php`.
 *
 * @since 3.0.0
 */
function genesis_sample_post_type_support()
{

  $post_type_supports = genesis_get_config('post-type-supports');

  foreach ($post_type_supports as $post_type => $args) {
    add_post_type_support($post_type, $args);
  }
}

// Add featured image support 
add_theme_support('post-thumbnails');

// Adds image sizes.
add_image_size('sidebar-featured', 75, 75, true);
add_image_size('genesis-singular-images', 702, 526, true);

// Removes header right widget area.
unregister_sidebar('header-right');

// Removes secondary sidebar.
unregister_sidebar('sidebar');
unregister_sidebar('sidebar-alt');

// Removes site layouts.
genesis_unregister_layout('content-sidebar-sidebar');
genesis_unregister_layout('sidebar-content-sidebar');
genesis_unregister_layout('sidebar-sidebar-content');
genesis_unregister_layout('sidebar-content');
genesis_unregister_layout('content-sidebar');

// Remove layout metaboxes
remove_theme_support('genesis-inpost-layouts');
remove_theme_support('genesis-archive-layouts');

// Remove the entry meta in the entry footer (requires HTML5 theme support)
remove_action('genesis_entry_footer', 'genesis_post_meta');

// Use full width layout 
add_filter('genesis_pre_get_option_site_layout', '__genesis_return_full_width_content');

add_filter('wp_nav_menu_args', 'genesis_sample_secondary_menu_args');
/**
 * Reduces secondary navigation menu to one level depth.
 *
 * @since 2.2.3
 *
 * @param array $args Original menu options.
 * @return array Menu options with depth set to 1.
 */
function genesis_sample_secondary_menu_args($args)
{

  if ('secondary' === $args['theme_location']) {
    $args['depth'] = 1;
  }

  return $args;
}

add_filter('genesis_author_box_gravatar_size', 'genesis_sample_author_box_gravatar');
/**
 * Modifies size of the Gravatar in the author box.
 *
 * @since 2.2.3
 *
 * @param int $size Original icon size.
 * @return int Modified icon size.
 */
function genesis_sample_author_box_gravatar($size)
{

  return 90;
}

add_filter('genesis_comment_list_args', 'genesis_sample_comments_gravatar');
/**
 * Modifies size of the Gravatar in the entry comments.
 *
 * @since 2.2.3
 *
 * @param array $args Gravatar settings.
 * @return array Gravatar settings with modified size.
 */
function genesis_sample_comments_gravatar($args)
{

  $args['avatar_size'] = 60;
  return $args;
}

add_action('wp_enqueue_scripts', 'slant_enqueue_bootstrap_scripts');
/**
 * Add Bootstrap scripts
 */
function slant_enqueue_bootstrap_scripts()
{
  //wp_enqueue_script( 'boot1','https://code.jquery.com/jquery-3.3.1.slim.min.js', array( 'jquery' ),'',true );
  wp_enqueue_script('boot2', 'https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.14.7/umd/popper.min.js', array('jquery'), '', true);
  wp_enqueue_script('boot3', 'https://stackpath.bootstrapcdn.com/bootstrap/4.3.1/js/bootstrap.min.js', array('jquery'), '', true);
}

/**
 * Add JS Scripts
 */
add_action('wp_enqueue_scripts', 'slant_enqueue_js_scripts');

function slant_enqueue_js_scripts()
{
  wp_enqueue_script('mainJS', get_stylesheet_directory_uri() . '/js/mainJS.js', array(), false, true);
}

//***Customize The Comment Form**/
function add_class_to_comment_form($defaults)
{
  $defaults['class_form'] = 'row';
  return $defaults;
};

add_filter('comment_form_defaults', 'add_class_to_comment_form');

add_filter('comment_form_defaults', 'crunchify_custom_comment_form');
function crunchify_custom_comment_form($defaults)
{
  $defaults['comment_notes_before'] = ''; //Removes Email Privacy Notice
  $defaults['title_reply'] = __(''); //Changes The Form Headline
  $defaults['label_submit'] = __('Post Comment', 'customtheme'); //Changes The Submit Button Text
  //$defaults['label_author'] = __( '', 'customtheme' ); //Changes The Submit Button Text
  //$defaults['comment_notes_after'] = '<code>To post `any code` in comment, uses < pre> source code < /pre></code>'; 
  return $defaults;
}

function my_update_comment_fields($fields)
{

  $commenter = wp_get_current_commenter();
  $req       = get_option('require_name_email');
  $label     = $req ? '*' : ' ' . __('(optional)', 'text-domain');
  $aria_req  = $req ? "aria-required='true'" : '';

  $fields['author'] =
    '<p class="comment-form-author col-md-4">
			<input id="author" name="author" type="text" placeholder="' . esc_attr__("Name (Required)", "text-domain") . '" value="' . esc_attr($commenter['comment_author']) .
    '" size="30" ' . $aria_req . ' />
		</p>';

  $fields['email'] =
    '<p class="comment-form-email col-md-4">
			<input id="email" name="email" type="email" placeholder="' . esc_attr__("Email (Required)", "text-domain") . '" value="' . esc_attr($commenter['comment_author_email']) .
    '" size="30" ' . $aria_req . ' />
		</p>';

  $fields['url'] =
    '<p class="comment-form-url col-md-4">
			<input id="url" name="url" type="url"  placeholder="' . esc_attr__("Website", "text-domain") . '" value="' . esc_attr($commenter['comment_author_url']) .
    '" size="30" />
			</p>';


  return $fields;
}
add_filter('comment_form_default_fields', 'my_update_comment_fields');

function my_update_comment_field($comment_field)
{

  $comment_field =
    '<p class="comment-form-comment col-12">
            <label for="comment">' . __("Leave a comment", "text-domain") . '</label>
            <textarea required id="comment" name="comment" placeholder="' . esc_attr__("Enter comment here...", "text-domain") . '" cols="45" rows="8" aria-required="true"></textarea>
        </p>';

  return $comment_field;
}
add_filter('comment_form_field_comment', 'my_update_comment_field');

/* share to social media */
// Function to handle the thumbnail request
function get_the_post_thumbnail_src($img)
{
  return (preg_match('~\bsrc="([^"]++)"~', $img, $matches)) ? $matches[1] : '';
}
function wpvkp_social_buttons($content)
{
  global $post;
  if (is_singular() || is_home()) {

    // Get current page URL 
    $sb_url = urlencode(get_permalink());

    // Get current page title
    $sb_title = str_replace(' ', '%20', get_the_title());

    // Get Post Thumbnail for pinterest
    $sb_thumb = get_the_post_thumbnail_src(get_the_post_thumbnail());

    //social media share prompt
    $social_share_message = "Share This Story, Choose Your Platform!";

    // Construct sharing URL without using any script
    $twitterURL = 'https://twitter.com/intent/tweet?text=' . $sb_title . '&amp;url=' . $sb_url . '&amp;via=wpvkp';
    $facebookURL = 'https://www.facebook.com/sharer/sharer.php?u=' . $sb_url;
    $bufferURL = 'https://bufferapp.com/add?url=' . $sb_url . '&amp;text=' . $sb_title;
    $whatsappURL = 'whatsapp://send?text=' . $sb_title . ' ' . $sb_url;
    $linkedInURL = 'https://www.linkedin.com/shareArticle?mini=true&url=' . $sb_url . '&amp;title=' . $sb_title;

    if (!empty($sb_thumb)) {
      $pinterestURL = 'https://pinterest.com/pin/create/button/?url=' . $sb_url . '&amp;media=' . $sb_thumb[0] . '&amp;description=' . $sb_title;
    } else {
      $pinterestURL = 'https://pinterest.com/pin/create/button/?url=' . $sb_url . '&amp;description=' . $sb_title;
    }

    // Based on popular demand added Pinterest too
    $pinterestURL = 'https://pinterest.com/pin/create/button/?url=' . $sb_url . '&amp;media=' . $sb_thumb[0] . '&amp;description=' . $sb_title;
    $gplusURL = 'https://plus.google.com/share?url=' . $sb_title . '';

    // Add sharing button at the end of page/page content
    $content = '<div class="social-box py-4 mb-3 align-justify row">';
    $content .= '<div class = "social-text col-8 pl-md-0 text-left">';
    $content .= $social_share_message;
    $content .= '</div>';
    $content .= '<div class="social-btn col-4">';
    $content .= '<a class="col-1 sbtn s-twitter" href="' . $twitterURL . '" target="_blank" rel="nofollow"><span><i class = "fab fa-twitter-square"></i></span></a>';
    $content .= '<a class="col-1 sbtn s-facebook" href="' . $facebookURL . '" target="_blank" rel="nofollow"><span><i class = "fab fa-facebook-square"></i></span></a>';
    //$content .= '<a class="col-2 sbtn s-whatsapp" href="'.$whatsappURL.'" target="_blank" rel="nofollow"><span>WhatsApp</span></a>';
    //$content .= '<a class="col-2 sbtn s-googleplus" href="'.$googleURL.'" target="_blank" rel="nofollow"><span>Google+</span></a>';
    //$content .= '<a class="col-2 sbtn s-pinterest" href="'.$pinterestURL.'" data-pin-custom="true" target="_blank" rel="nofollow"><span>Pin It</span></a>';
    $content .= '<a class="col-2 sbtn s-linkedin" href="' . $linkedInURL . '" target="_blank" rel="nofollow"><span><i class="fab fa-linkedin"></i></span></a>';
    //$content .= '<a class="col-2 sbtn s-buffer" href="'.$bufferURL.'" target="_blank" rel="nofollow"><span>Buffer</span></a>';
    $content .= '</div></div>';

    return $content;
  } else {
    // if not a post/page then don't include sharing button
    return $content;
  }
};

// This will create a wordpress shortcode [social].
// Please it in any widget and social buttons appear their.
// You will need to enabled shortcode execution in widgets.
add_shortcode('social', 'wpvkp_social_buttons');

add_shortcode('time_based_greeting', 'display_greeting_message');

function display_greeting_message()
{

  $tz = 'Australia/Sydney';
  $timestamp = time();
  $time = new DateTime("now", new DateTimeZone($tz)); //first argument "must" be a string
  $time->setTimestamp($timestamp); //adjust the object to correct timestamp
  $currentHour = $time->format('H');
  $message = $currentHour;

  /* If the time is less than 1200 hours, show good morning */
  if ($currentHour < "12") {
    $message = "Good morning";
  } else
    /* If the time is grater than or equal to 1200 hours, but less than 1700 hours, so good afternoon */
    if ($currentHour >= "12" && $currentHour < "17") {
      $message = "Good afternoon";
    } else
      /* Should the time be between or equal to 1700 and 1900 hours, show good evening */
      if ($currentHour >= "17" && $currentHour < "19") {
        $message = "Good evening";
      } else
        /* Finally, show good night if the time is greater than or equal to 1900 hours */
        if ($currentHour >= "19") {
          $message = "Good night";
        }
  echo '<div class = "custom_greeting"><h2>' . $message . '</h2></div>';
}

/* remove genesis wraps */
add_theme_support('genesis-structural-wraps', array());

/* create main page widget areas */
genesis_register_sidebar(array(
  'id'            => 'top-advertisement-area',
  'name'          => __('Top Advertisment', 'top-advertisement-area'),
  'description'   => __('Advertisment Area for the top of the page', 'top-advertisement-area'),
));

genesis_register_sidebar(array(
  'id'            => 'middle-advertisement-area',
  'name'          => __('Middle Advertisment', 'middle-advertisement-area'),
  'description'   => __('Advertisment Area for the middle of the page', 'middle-advertisement-area'),
));

genesis_register_sidebar(array(
  'id'            => 'side-widget-01',
  'name'          => __('Side Advertisement Area 01', 'side-widget-01'),
  'description'   => __('First Advertisment Area for the side of the page', 'side-widget-01'),
));

genesis_register_sidebar(array(
  'id'            => 'side-widget-02',
  'name'          => __('Side Advertisement Area 02', 'side-widget-02'),
  'description'   => __('Second Advertisment Area for the side of the page', 'side-widget-02'),
));

genesis_register_sidebar(array(
  'id'            => 'side-widget-03',
  'name'          => __('Side Advertisement Area 03', 'side-widget-03'),
  'description'   => __('Third Advertisment Area for the side of the page', 'side-widget-03'),
));

/* single post side bar */
genesis_register_sidebar(array(
  'id'            => 'article-side-widget',
  'name'          => __('Advertisement Area Single Article', 'article-side-widget'),
  'description'   => __('Advertisment area for a single article page', 'article-side-widget'),
));

/* create footer widget areas */
genesis_register_sidebar(array(
  'id'            => 'footer-content-01',
  'name'          => __('Footer Content 01', 'footer-content-01'),
  'description'   => __('Content for section 1 of the footer', 'footer-content-01'),
));

genesis_register_sidebar(array(
  'id'            => 'footer-content-02',
  'name'          => __('Footer Content 02', 'footer-content-02'),
  'description'   => __('Content for section 2 of the footer', 'footer-content-02'),
));

genesis_register_sidebar(array(
  'id'            => 'footer-menu-01',
  'name'          => __('Footer Menu 01', 'footer-menu-01'),
  'description'   => __('First Footer Menu', 'footer-menu-01'),
));

genesis_register_sidebar(array(
  'id'            => 'footer-menu-02',
  'name'          => __('Footer Menu 02', 'footer-menu-02'),
  'description'   => __('Second Footer Menu', 'footer-menu-02'),
));

genesis_register_sidebar(array(
  'id'            => 'footer-menu-03',
  'name'          => __('Footer Menu 03', 'footer-menu-03'),
  'description'   => __('Third Footer Menu', 'footer-menu-03'),
));

genesis_register_sidebar(array(
  'id'            => 'our-story',
  'name'          => __('Our Story', 'our-story'),
  'description'   => __('Our Story Widget', 'our-story'),
));

/* custom menu */
function register_additional_menu()
{
  register_nav_menu('secondary_menu', __('Secondary Navigation Menu'));

  //category menus
  register_nav_menu('professional-issues', __('Professional Issues Menu'));
  register_nav_menu('specialities', __('Specialities Menu'));
  register_nav_menu('workplace-issues', __('Workplace Issues Menu'));
  register_nav_menu('social-justice-action', __('Social Justice & Action Menu'));
  register_nav_menu('life', __('Life Menu'));
  register_nav_menu('editorial', __('Editorial Menu'));
  register_nav_menu('jobs', __('Jobs Menu'));
  register_nav_menu('lamp-archive', __('Archive Menu'));
}
add_action('init', 'register_additional_menu');

/* register new post types */
function create_posttype()
{

  register_post_type(
    'listicles',
    array(
      'labels' => array(
        'name' => __('Listicles'),
        'singular_name' => __('Listicle')
      ),
      'public' => true,
      'has_archive' => false,
      'rewrite' => array('slug' => 'listicle'),
      'show_in_rest' => true,
      'supports' => array('title', 'editor', 'thumbnail', 'excerpt'),

    ),
  );
  register_post_type(
    'our-stories',
    array(
      'labels' => array(
        'name' => __('Our Stories'),
        'singular_name' => __('My Story')
      ),
      'public' => true,
      'has_archive' => false,
      'rewrite' => array('slug' => 'our-stories'),
      'taxonomies' => array('campaign'),
      'show_in_rest' => true,
      'supports' => array('title', 'editor', 'thumbnail', 'excerpt'),

    )
  );
}
// Hooking up our function to theme setup
add_action('init', 'create_posttype');

//add_action('init', 'create_topics_nonhierarchical_taxonomy', 0);
// This creates so many warnings 
// PHP Warning:  Array to string conversion in /PATH/wp-includes/taxonomy.php on line 307

function create_topics_nonhierarchical_taxonomy()
{

  // Labels part for the GUI
  $labels = array(
    'name' => _x('Testimonial Campaign', 'taxonomy general name'),
    'singular_name' => _x('Topic', 'taxonomy singular name'),
    'search_items' =>  __('Search Campaign'),
    'popular_items' => __('Popular Campaigns'),
    'all_items' => __('All Campaigns'),
    'parent_item' => null,
    'parent_item_colon' => null,
    'edit_item' => __('Edit Campaign'),
    'update_item' => __('Update Campaign'),
    'add_new_item' => __('Add New Campaign'),
    'new_item_name' => __('New Campaign Name'),
    'separate_items_with_commas' => __('Separate Campaigns with commas'),
    'add_or_remove_items' => __('Add or remove Campaigns'),
    'choose_from_most_used' => __('Choose from the most used Campaigns'),
    'menu_name' => __('Campaigns'),
  );

  // Now register the non-hierarchical taxonomy like tag
  register_taxonomy('campaign', array(
    'hierarchical' => false,
    'labels' => $labels,
    'show_ui' => true,
    'show_in_rest' => true,
    'show_admin_column' => true,
    'update_count_callback' => '_update_post_term_count',
    'query_var' => true,
    'rewrite' => array('slug' => 'campaign'),
  ));
}
