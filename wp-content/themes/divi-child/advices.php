<?php
/**
 * Template Name: Advices
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
        'category' => 7,
        'suppress_filters' => true
    ));
    $main_post = null;
    foreach ($posts as $post) { ?>
        <?php setup_postdata($post); $main_post = $post->ID; ?>


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
                <div class="row main-news-row">
                    <div class="col-md-5 block_1_1">
                        <a href="<?php esc_url( the_permalink() ); ?>">
                            <h2 class="entry-title"><?php the_title(); ?></h2>
                            <div class="entry-content">
                                <?php the_excerpt(); ?>
                                <div class="date-box">
                                    <?php echo get_the_date('j. m. Y'); ?>
                                </div>
                            </div>
                        </a>
                    <?php } wp_reset_postdata(); // сброс ?>
                    </div>
                    <div class="col-md-3 offset-md-4 block_2_2">
                        <?php get_sidebar(); ?>
                    </div>
                </div>

            </div>
        </section>

        <section class="posts">
            <div class="container">
                <?php
                    $type = 'latest';
                    if (isset($_COOKIE['type']) && !empty($_COOKIE['type']) && $_COOKIE['type'] == 'popular') {
                        $type = 'popular';
                    } ?>
                <div class="row ">
                    <div class="col-md-9 posts_filter">
                        <ul id="filter-list-advices" class="posts_filter-list">
                            <li>Показувати спочатку:</li>
                            <li class="filter">
                                <a href="#" class="<?php echo ($type == 'latest' ? 'active' : '' ); ?>" data-type="latest">Останні</a>
                            </li>
                            <li class="filter">
                                <a href="#" class="<?php echo ($type == 'popular' ? 'active' : '' ); ?>" data-type="popular">Популярні</a>
                            </li>
                        </ul>
                    </div>
                </div>
                <div class="row news_posts_wrap" data-main-post="<?php echo $main_post; ?>">
                    <?php

                    if ($type == 'latest') {
                        $args = array(
                            'numberposts' => 6,
                            'order'    => 'DESC',
                            'category'    => 7
                        );
                    } else {
                        $args = array(
                            'numberposts' => 6,
                            'category'    => 7,
                            'meta_key' => 'post_views_count',
                            'orderby'  => 'meta_value_num',
                        );
                    }
                    if ($main_post) {
                        $args['exclude'] = [$main_post];
                    }

                    $posts = get_posts( $args );
                    if (!empty($posts)) {
                        foreach( $posts as $post ){ ?>
                            <div <?php post_class('col-md-4 col-sm-6'); ?>>
                                <a href="<?php the_permalink(); ?>" class="blog_news_link">
                                    <div class="blog_item">
                                        <div class="img-wrapper">
                                            <?php the_post_thumbnail(); ?>
                                        </div>
                                        <div class="blog_item-overlay-top">
                                            <h5 class="post_date"><?php echo get_the_date('j. m. Y'); ?></h5>
                                            <div class="share_btn_wrap">
                                                <div class="dropdown dropleft show">
                                                    <a class="dropdown-toggle" href="#" role="button" id="dropdownMenuLink" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                                                        <i class="icon icon-union"></i>
                                                    </a>
                                                    <div class="dropdown-menu" aria-labelledby="dropdownMenuLink">
                                                        <a class="dropdown-item fb-share-button" href="<?php esc_url( the_permalink() ); ?>" data-layout="button" data-size="large"></a>
                                                        <a class="dropdown-item viber_share">
                                                            <img src="<?php echo get_stylesheet_directory_uri(); ?>/images/share_viber.png" alt="">
                                                        </a>
                                                        <a class="dropdown-item telegram-share" href="javascript:window.open('https://telegram.me/share/url?url='+encodeURIComponent(window.location.href), '_blank')">
                                                            <div class="telegram_wrap">
                                                                <img src="<?php echo get_stylesheet_directory_uri(); ?>/images/telegram-plane.png" alt="">
                                                                <span>Share</span>
                                                            </div>
                                                        </a>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="blog_item-overlay">
                                            <div class="content_bottom">
                                                <h4 class="post_tittle"><?php the_title(); ?></h4>
                                                <div class="post_brief"><?php the_excerpt(); ?></div>
                                            </div>
                                        </div>
                                    </div>
                                </a>
                            </div>
                        <?php }
                    } ?>
                </div>
            </div>
        </section>




        <div class="container">
            <div class="row">
<!--                <div class="col-md-9">-->
<!---->
<!--                    --><?php //endif; ?>
<!---->
<!--                    --><?php //while ( have_posts() ) : the_post(); ?>
<!---->
<!--                            --><?php //if ( ! $is_page_builder_used ) : ?>
<!---->
<!--                                --><?php
//                                $thumb = '';
//                                $width = (int) apply_filters( 'et_pb_index_blog_image_width', 1080 );
//                                $height = (int) apply_filters( 'et_pb_index_blog_image_height', 675 );
//                                $classtext = 'et_featured_image';
//                                $titletext = get_the_title();
//                                $thumbnail = get_thumbnail( $width, $height, $classtext, $titletext, $titletext, false, 'Blogimage' );
//                                $thumb = $thumbnail["thumb"];
//
//                                if ( 'on' === et_get_option( 'divi_page_thumbnails', 'false' ) && '' !== $thumb )
//                                    print_thumbnail( $thumb, $thumbnail["use_timthumb"], $titletext, $width, $height );
//                                ?>
<!---->
<!--                            --><?php //endif; ?>
<!---->
<!--                    --><?php //endwhile; ?>
<!---->
<!--                    --><?php //if ( ! $is_page_builder_used ) : ?>
<!---->
<!--                </div>-->

                <div class="col-md-3">
                    <?php get_sidebar(); ?>
                </div>
            </div> <!-- #content-area -->
        </div> <!-- .container -->

    <?php endif; ?>

<?php

get_footer();
