<?php
get_header();

$is_page_builder_used = et_pb_is_pagebuilder_used( get_the_ID() );
$cat_id = get_query_var('cat');
?>
<?php //if ( ! $is_page_builder_used ) : ?>


    <?php
    $posts = get_posts(array(
        'numberposts' => 1,
        'tag' => 'main',
        'post_type' => 'post',
        'category' => $cat_id,
        'suppress_filters' => true
    ));
    $main_post = null;
    foreach ($posts as $post) { ?>
        <?php setup_postdata($post); $main_post = $post->ID; ?>


        <section class="top_news_wrap">
        <div class="container-fluid container-1">
            <div class="row">
                <div class="col-lg-8 col-md-12 block_1">
                    <a href="<?php esc_url( the_permalink() ); ?>">
                        <img src="<?php the_field('main_img'); ?>" alt=""/>
                    </a>
                </div>
                <div class="col-md-4 block_2"></div>
            </div>
        </div>
        <div class="container container-2">
        <div class="row main-news-row">
        <div class="col-lg-6 col-md-12 block_1_1">
        <div class="block-wrap">
            <a href="<?php esc_url( the_permalink() ); ?>">
                <h2 class="entry-title"><?php the_title(); ?>
                    <div class="share_btn_wrap">
                        <div class="dropdown show">
                            <a class="dropdown-toggle" href="#" role="button" id="dropdownMenuLink" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                                <i class="icon icon-union"></i>
                            </a>
                            <div class="dropdown-menu" aria-labelledby="dropdownMenuLink">
                                <a class="dropdown-item fb-share-button" href="<?php esc_url( the_permalink() ); ?>" data-layout="button" data-size="large"></a>
                                <a class="dropdown-item" id="viber_share">
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
                </h2>
                <div class="mob-img">
                    <img src="<?php the_field('main_img'); ?>"  alt="" />
                </div>
                <div class="entry-content">
                    <?php //the_excerpt(); ?>
                    <?php echo kama_excerpt(array('maxchar'=>100)); ?>
                    <div class="date-box">
                        <?php echo get_the_date('j. m. Y'); ?>
                    </div>
                </div>
            </a>
        </div>
    <?php } wp_reset_postdata(); // сброс ?>
    </div>
    <div class="col-lg-3 offset-lg-3 col-md-3 offset-md-4 block_2_2">
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
            <div class="row">
                <div class="col-md-9 posts_filter">
                    <ul class="posts_filter-list">
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
            <div class="row news_posts_wrap" data-main-post="<?php echo $main_post; ?>" data-cat="<?php echo $cat_id ?>">
                <?php

                if ($type == 'latest') {
                    $args = array(
                        'numberposts' => 6,
                        'order'    => 'DESC',
                        'category'    => $cat
                    );
                } else {
                    $args = array(
                        'numberposts' => 6,
                        'category'    => $cat,
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
                        <div <?php post_class('col-xl-4 col-lg-6 col-md-6 col-sm-6'); ?>>
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
                                                    <a class="dropdown-item" id="viber_share">
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
                                            <a href="<?php the_permalink(); ?>">
                                                <h4 class="post_tittle"><?php the_title(); ?></h4>
                                            </a>
                                            <div class="post_brief"><?php echo kama_excerpt(array('maxchar'=>100)); ?></div>
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



<?php

get_footer();
