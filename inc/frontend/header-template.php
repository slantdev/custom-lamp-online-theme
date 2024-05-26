<?php

remove_action('genesis_header', 'genesis_do_header');
add_filter('genesis_attr_site-header', 'slant_add_header_class');

function slant_add_header_class($attributes)
{
    $attributes['class'] .= ' sticky-top';
    return $attributes;
}

add_action('genesis_header', 'slant_do_header');
add_action('genesis_after_header', 'slant_do_after_header');

function slant_do_header()
{ ?>

    <!-- secondary header content -->
    <div class="secondary-header-wrapper">
        <div class="secondary-header-content container">
            <div class="row justify-content-between">
                <div class="col-auto">
                    <?php
                    $time = new DateTime('now', new DateTimezone('Australia/Sydney'));
                    echo $time->format("F j, Y");
                    ?>
                </div>
                <div class="col-auto header-social-media">
                    <a href="https://www.facebook.com/nswnma/" target="_blank" rel="noopener noreferrer"><i class="fab fa-facebook" aria-hidden="true"></i></a>
                    <a href="https://twitter.com/nswnma" target="_blank" rel="noopener noreferrer"><i class="fab fa-twitter" aria-hidden="true"></i></a>
                    <a href="https://www.instagram.com/nswnma/" target="_blank" rel="noopener noreferrer"><i class="fab fa-instagram" aria-hidden="true"></i></a>
                    <a href="https://www.youtube.com/user/SupportNurses" target="_blank" rel="noopener noreferrer"><i class="fab fa-youtube" aria-hidden="true"></i></a>
                    <a href="https://www.flickr.com/photos/69006307@N07/" target="_blank" rel="noopener noreferrer"><i class="fab fa-flickr" aria-hidden="true"></i></a>
                </div>
            </div>
        </div>
    </div>

    <!-- main header content -->
    <div class="main-header-wrapper container py-3">
        <div class="main-header-content row">

            <!-- hamburger menu -->
            <div class="col-2 col-md-5">
                <button class="hamburger-menu" type="button" data-toggle="collapse" data-target="#navbarToggleExternalContent" aria-controls="navbarToggleExternalContent" aria-expanded="false" aria-label="Toggle navigation">
                    <div class="hamburger-menu-label mb-2">Menu</div>
                    <div class="menuIcon-wrapper">
                        <div class="menuIcon-line"></div>
                        <div class="menuIcon-line"></div>
                        <div class="menuIcon-line"></div>
                    </div>
                </button>
            </div>

            <!-- logo -->
            <div class="col-8 col-md-2 text-center">
                <div class="logo-box">
                    <?php $template_dir = get_stylesheet_directory_uri(); ?>
                    <a href="<?php echo home_url(); ?>"><img src="<?php echo $template_dir ?>/images/logo-r.png" /></a>
                </div>
            </div>

            <!-- search bar -->
            <div class="col-2 col-md-5 order-last text-right">
                <a href="#" class="button-search align-middle" data-toggle="collapse" data-target="#search-box" aria-expanded="false" aria-controls="collapseExample"><i class="fa fa-search"></i></a>
                <div class="searchform-box collapse" id="search-box">
                    <?php get_search_form(); ?>
                </div>
            </div>
        </div>
    </div>

    <!-- tagline / secondary menu area -->
    <div class="tagline-wrapper">
        <div class="container">
            <div class="tagline-content row">
                <div class="col-12">
                    <div class="secondary-menu-wrapper text-center">
                        <?php get_tagline_content(); ?>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- main menu area -->
    <nav id="navbarToggleExternalContent" class="collapse main-menu-wrapper">
        <div class="main-menu-content container py-3">
            <div class="row">
                <div class="col-12">
                    <?php wp_nav_menu(array(
                        "menu"        =>    'Main Menu'
                    )); ?>
                </div>
            </div>
        </div>
    </nav>

<?php }

function get_tagline_content()
{
    $tagline = "The magazine of the NSW nurses and midwives’ association";
    $post_title = get_field('show_tagline');
    $output = "";
    if (is_front_page() || $post_title || get_post_type() == 'job_listing') {
        echo '<div class = "tagline">' . $tagline . '</div';
    } else if (is_single()) {
        $menu_name = get_single_page_color();
        wp_nav_menu(array('theme_location' => $menu_name, 'container_class' => 'desktop-submenu secondary-menu'));
    } else {
        wp_nav_menu(array('theme_location' => 'secondary_menu', 'container_class' => 'desktop-submenu secondary-menu'));
        //wp_nav_menu( array( 'theme_location' => 'secondary_menu', 'container_class' => 'mobile-submenu secondary-menu') );
    }
}

function slant_do_after_header()
{ ?>



<?php }
?>