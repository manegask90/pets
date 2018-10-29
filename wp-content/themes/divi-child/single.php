<?php

get_header();

$show_default_title = get_post_meta( get_the_ID(), '_et_pb_show_title', true );

$is_page_builder_used = et_pb_is_pagebuilder_used( get_the_ID() );

?>

<?php
$post = $wp_query->post;
$post_categories = wp_get_post_categories( $post->ID );
if ( in_array(3, $post_categories)) {
    include(get_stylesheet_directory() . '/single-zoo.php');
} elseif (in_array(7, $post_categories)) {
    include(get_stylesheet_directory() . '/single-advices.php');
} else {
    include(get_stylesheet_directory() . '/single-all.php');
}
?>

<?php
get_footer();
