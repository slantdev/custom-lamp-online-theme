<?php

// Repositions primary navigation menu.
//remove_action( 'genesis_after_header', 'genesis_do_nav' );
//add_action( 'genesis_header', 'genesis_do_nav', 12 );

// Repositions the secondary navigation menu.
//remove_action( 'genesis_after_header', 'genesis_do_subnav' );
//add_action( 'genesis_footer', 'genesis_do_subnav', 10 );

include_once dirname(__FILE__) . '/frontend/header-template.php';
include_once dirname(__FILE__) . '/frontend/footer-template.php';

?>