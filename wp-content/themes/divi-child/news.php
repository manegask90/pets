<?php
/**
 * Template Name: News
 *
 */
get_header();

$is_page_builder_used = et_pb_is_pagebuilder_used( get_the_ID() );

?>
        <?php if ( ! $is_page_builder_used ) : ?>

        <div class="container">
            <div class="row">
                <div class="col-md-9">

                    <?php endif; ?>

                    <?php while ( have_posts() ) : the_post(); ?>

                            <?php if ( ! $is_page_builder_used ) : ?>

                                <?php
                                $thumb = '';
                                $width = (int) apply_filters( 'et_pb_index_blog_image_width', 1080 );
                                $height = (int) apply_filters( 'et_pb_index_blog_image_height', 675 );
                                $classtext = 'et_featured_image';
                                $titletext = get_the_title();
                                $thumbnail = get_thumbnail( $width, $height, $classtext, $titletext, $titletext, false, 'Blogimage' );
                                $thumb = $thumbnail["thumb"];

                                if ( 'on' === et_get_option( 'divi_page_thumbnails', 'false' ) && '' !== $thumb )
                                    print_thumbnail( $thumb, $thumbnail["use_timthumb"], $titletext, $width, $height );
                                ?>

                            <?php endif; ?>

                            <div class="entry-content">
                                <?php
                                the_content();

                                if ( ! $is_page_builder_used )
                                    wp_link_pages( array( 'before' => '<div class="page-links">' . esc_html__( 'Pages:', 'Divi' ), 'after' => '</div>' ) );
                                ?>
                            </div> <!-- .entry-content -->

                            <?php
                            if ( ! $is_page_builder_used && comments_open() && 'on' === et_get_option( 'divi_show_pagescomments', 'false' ) ) comments_template( '', true );
                            ?>

                    <?php endwhile; ?>

                    <?php if ( ! $is_page_builder_used ) : ?>

                </div> <!-- #left-area -->

                <div class="col-md-3">
                    <?php get_sidebar(); ?>
                </div>
            </div> <!-- #content-area -->
        </div> <!-- .container -->

    <?php endif; ?>

<?php

get_footer();
