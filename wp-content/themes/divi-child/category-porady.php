<?php
get_header();

$is_page_builder_used = et_pb_is_pagebuilder_used( get_the_ID() );
$cat_id = get_query_var('cat');

$category = get_the_category();
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
            <a href="<?php esc_url( the_permalink() ); ?>" class="blog_news_link">
                <h2 class="entry-title"><?php the_title(); ?>
                    <div class="share_btn_wrap">
                        <div class="dropdown dropleft show">
                            <a class="dropdown-toggle" href="#" role="button" id="dropdownMenuLink" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                                <i class="icon icon-union"></i>
                            </a>
                            <div class="dropdown-menu" aria-labelledby="dropdownMenuLink">
                                <a href="<?php the_permalink(); ?>" class="permalink" style="display: none"></a>
                                <?php dynamic_sidebar('share'); ?>
                                <a class="dropdown-item viber_share">
                                    <img src="<?php echo get_stylesheet_directory_uri(); ?>/images/viber.png" alt="">
                                </a>
                                <a class="dropdown-item telegram-share" href="">
                                    <img src="<?php echo get_stylesheet_directory_uri(); ?>/images/telegram.png" alt="">
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
                    <ul class="posts_filter-list advice-list">
                        <li>Показувати спочатку:</li>
                        <li class="filter">
                            <a href="#" class="<?php echo ($type == 'latest' ? 'active' : '' ); ?>" data-type="latest">Останні</a>
                        </li>
                        <li class="filter">
                            <a href="#" class="<?php echo ($type == 'popular' ? 'active' : '' ); ?>" data-type="popular">Популярні</a>
                        </li>
                    </ul>
                </div>
                <div class="col-md-3 sidebar-bot-wrap">
                    <?php get_sidebar('bottom'); ?>
                </div>
            </div>
            <div class="row news_posts_wrap advices" data-main-post="<?php echo $main_post; ?>" data-cat="<?php echo $cat_id ?>">
                <?php

                if ($type == 'latest') {
                    $args = array(
                        'numberposts' => 10,
                        'order'    => 'DESC',
                        'category'    => 7
                    );
                } else {
                    $args = array(
                        'numberposts' => 10,
                        'category'    => 7,
                        'meta_key' => 'post_views_count',
                        'orderby'  => 'meta_value_num',
                    );
                }
                if ($main_post) {
                    $args['exclude'] = [$main_post];
                }

                $posts = get_posts( $args );
                $bootstrap_col = ' col-lg-4 col-md-6 col-sm-6 col-6';
//                $post_categories = wp_get_post_categories( $post->ID );
                if (!empty($posts)) {
                    foreach( $posts as $post ){
                        $post_categories = wp_get_post_categories( $post->ID );
                        $post_categories_all = wp_get_post_categories( $post->ID, array('fields' => 'all')  );
                        ?>
                        <div id="post-<?php the_ID(); ?>"  <?php post_class( 'et_pb_post clearfix' . $bootstrap_col  ); ?>>

                            <div class="blog_advices_link">
                                <div class="advice_item">
                                    <div class="advice_item-header">
                                        <h4 class="header_tittle">
                                            <span>
                                                <?php
                                                foreach( $post_categories_all as $cat ){
                                                    echo $cat->name .' ';
                                                }
                                                ?>
                                            </span>
                                        </h4>
                                        <h4 class="header_tittle"><a href="<?php the_permalink(); ?>"><?php the_title(); ?></a></h4>
                                        <?php
                                        if (in_array(9, $post_categories)) {
                                            echo '<i class="icon demo-icon icon-cat"></i>';
                                        } elseif (in_array(8, $post_categories)) {
                                            echo '<i class="icon demo-icon icon-dog"></i>';
                                        }
                                        elseif (in_array(10, $post_categories)) {
                                            echo '<i class="icon demo-icon icon-laps"></i>';
                                        }
                                        ?>
                                    </div>
                                    <div class="advice_item-content">
                                        <p>Зі своїм улюбленцем варто проводити якомога більше вільного часу, і відпустка не має стати цьому на заваді.</p>
                                    </div>
                                    <div class="share_btn_wrap">
                                        <div class="dropdown dropleft">
                                            <a class="dropdown-toggle" href="#" role="button" id="dropdownMenuLink" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                                                <i class="icon icon-union"></i>
                                            </a>
                                            <div class="dropdown-menu" aria-labelledby="dropdownMenuLink">
                                                <a href="<?php the_permalink(); ?>" class="permalink" style="display: none"></a>
                                                <?php dynamic_sidebar('share'); ?>
                                                <a class="dropdown-item viber_share">
                                                    <img src="<?php echo get_stylesheet_directory_uri(); ?>/images/viber.png" alt="">
                                                </a>
                                                <a class="dropdown-item telegram-share" href="">
                                                    <img src="<?php echo get_stylesheet_directory_uri(); ?>/images/telegram.png" alt="">
                                                </a>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    <?php }
                } ?>
            </div>
        </div>
    </section>



<?php

get_footer();
