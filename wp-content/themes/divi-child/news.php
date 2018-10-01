<?php
/**
 * Template Name: News
 *
 */
get_header();

$is_page_builder_used = et_pb_is_pagebuilder_used( get_the_ID() );

?>
        <?php if ( ! $is_page_builder_used ) : ?>



    <?php

    $posts = get_posts(array(
        'numberposts' => 1,
        'tag' => 'main',
        'post_type' => 'post',
        'category' => 6,
        'suppress_filters' => true
    ));

    foreach ($posts as $post) { ?>
        <?php //setup_postdata($post); ?>


        <section class="top_news_wrap">
            <div class="container-fluid">
                <div class="row">
                    <div class="col-md-8 block_1">
                        <a href="<?php esc_url( the_permalink() ); ?>">
                            <img src="<?php the_field('main_img'); ?>" alt=""/>
                        </a>
                    </div>
                    <div class="col-md-4 block_2"></div>
                </div>
            </div>
            <div class="container container-2">
                <div class="row align-items-center">
                    <div class="col-md-3 block_1_1">
                        <a href="<?php esc_url( the_permalink() ); ?>">
                            <h2 class="entry-title"><?php the_title(); ?></h2>
                            <div class="entry-content">
                                <?php the_excerpt(); ?>
                            </div>
                        </a>
                    <?php } wp_reset_postdata(); // сброс ?>
                    </div>
                    <div class="col-md-3 offset-md-6 block_2_2">
                        <?php get_sidebar(); ?>
                    </div>
                </div>
            </div>
        </section>




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
