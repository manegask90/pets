<?php
function my_theme_enqueue_styles() {
    wp_enqueue_style('bootstrap', get_stylesheet_directory_uri() .'/css/bootstrap.min.css');
    wp_enqueue_style('default-search', get_stylesheet_directory_uri() .'/assets/search-bar/css/default.css');
    wp_enqueue_style('component-search', get_stylesheet_directory_uri() .'/assets/search-bar/css/component.css');
    wp_enqueue_style( 'parent-style', get_template_directory_uri() . '/style.css' );
    wp_enqueue_script('popper', get_stylesheet_directory_uri().'/js/popper.min.js', array('jquery'), false, true);
    wp_enqueue_script('bootstrap', get_stylesheet_directory_uri().'/js/bootstrap.min.js', array('jquery'), false, true);
    wp_enqueue_script('modernizr.custom', get_stylesheet_directory_uri().'/assets/search-bar/js/modernizr.custom.js', array('jquery'), false, true);
    wp_enqueue_script('classie', get_stylesheet_directory_uri().'/assets/search-bar/js/classie.js', array('jquery'), false, true);
    wp_enqueue_script('uisearch', get_stylesheet_directory_uri().'/assets/search-bar/js/uisearch.js', array('jquery'), false, true);
}
add_action( 'wp_enqueue_scripts', 'my_theme_enqueue_styles' );


