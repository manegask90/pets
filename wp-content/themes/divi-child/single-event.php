<?php

get_header();

$show_default_title = get_post_meta( get_the_ID(), '_et_pb_show_title', true );

$is_page_builder_used = et_pb_is_pagebuilder_used( get_the_ID() );
?>


<?php
if ( et_builder_is_product_tour_enabled() ):
    // load fullwidth page in Product Tour mode
    while ( have_posts() ): the_post(); ?>

        <?php setPostViews(get_the_ID()); ?>
        <article id="post-<?php the_ID(); ?>" <?php post_class( 'et_pb_post' ); ?>>
            <div class="entry-content">
                <?php
                the_content();
                ?>
            </div> <!-- .entry-content -->

        </article> <!-- .et_pb_post -->

    <?php endwhile;
else:
    ?>
    <?php while ( have_posts() ) : the_post(); ?>
    <?php setPostViews(get_the_ID()); ?>
    <?php if (et_get_option('divi_integration_single_top') <> '' && et_get_option('divi_integrate_singletop_enable') == 'on') echo(et_get_option('divi_integration_single_top')); ?>

    <section class="event_single_wrap">
        <div class="container-fluid container-1">
            <div class="row">
                <div class="col-md-5 block_1">
                        <?php
                        $single_img = get_field('img');
                        $test_url   = get_stylesheet_directory_uri();
                        if ( !empty($single_img)) { ?>
                            <img src="<?php echo get_field('img'); ?>" alt="">
                        <?php } else {?>
                            <img class="test" src="<?php echo get_stylesheet_directory_uri(); ?>/images/bottom_large_pic.jpg" alt="">
                        <?php } ?>
                </div>
                <div class="col-md-7 block_2"></div>
            </div>
        </div>

        <div class="container container-2">
            <div class="row">
                <div class="col-md-5 block_1_1">
                </div>
                <div class="col-md-7 block_2_2">
                    <div class="block-wrap">
                        <h2 class="entry-title">
                            <?php the_title(); ?>
                        </h2>
                        <div class="entry-content">
                            <div class="date-box">
                                <div class="date_txt">
                                    <div class="date_wrap">
                                        <div class="box">
                                            <?php
                                            $date_start = strtotime(get_field('date'));
                                            $date_end = get_field('date_end');
                                            ?>
                                            <i class="icon event-date"></i>
                                            <span><?php echo date('d', $date_start); ?></span>
                                            <?php if (isset($date_end)) { ?>
                                                <span>-</span>
                                                <span><?php echo $date_end; ?></span>
                                            <?php } ?>
                                            <span class="month"><?php echo date('F', $date_start); ?></span>
                                            <span><?php echo date('Y', $date_start); ?></span>
                                        </div>
                                        <div class="box">
                                            <i class="icon event-time"></i>
                                            <span class="time"><?php echo get_field('time'); ?></span>
                                        </div>
                                        <div class="box">
                                            <i class="icon event-loc"></i>
                                            <span class="city_name"><?php echo get_field('city'); ?></span>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="social-box">
                                <?php get_template_part( '/includes/social_icons' ); ?>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>
    <div class="single-post">
            <div class="container">
                <div class="row">
                            <div class="col-md-12">
                                <div class="single-content">
                                    <div class="single-entry-content">
                                        <?php the_content(); ?>
                                    </div>
                                    <div class="social-box bottom-soc">
                                        <?php get_template_part( '/includes/social_icons' ); ?>
                                    </div>
                                </div>
                                <div class="sidebar_contact-box">
                                    <h4 class="cbox_txt">Розкажи нам про подію!</h4>
                                    <a href="#" class="cbox_btn" data-toggle="modal" data-target="#sidebarModal">Надіслати анонс</a>
                                </div>
                                <div class="read-next">
                                    <div class="border-box"></div>
                                    <div class="text">читати більше</div>
                                </div>


                                <div class="slider news">
                                    <?php

                                $related = get_posts( array( 'category__in' => wp_get_post_categories($post->ID), 'numberposts' => 12, 'post__not_in' => array($post->ID) ) );
                                if( $related ) foreach( $related as $post ) {
                                    setup_postdata($post); ?>

                                    <div  <?php post_class( 'col-md-3' ) ?>>

                                        <a href="<?php the_permalink() ?>" class="blog_news_link">
                                            <div class="blog_item">
                                                <div class="img-wrapper">
                                                    <?php
                                                    if( has_post_thumbnail() ) {
                                                    the_post_thumbnail();
                                                    }
                                                    else { ?>
                                                        <img class="test" src="<?php echo get_stylesheet_directory_uri(); ?>/images/sm_bottom_photo.jpg" alt="">
                                                   <?php } ?>
                                                </div>
                                                <div class="content">
                                                    <div class="content_wrapper">
                                                        <h5 class="news_time"><?php echo get_the_date('j. m. Y'); ?></h5>
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
                                                        <h2 class="news_tittle"><?php the_title(); ?></h2>
                                                    </div>
                                                </div>
                                            </div>
                                        </a>


                                        <div class="post-content"></div>
                                    </div>
                                <?php }
                                wp_reset_postdata(); ?>

                                </div>


                            </div>

                        <?php endwhile; ?>

                    <?php //get_sidebar(); ?>
                </div> <!-- #content-area -->
            </div> <!-- .container -->
        <?php endif; ?>
    </div> <!-- #main-content -->
<?php

get_footer();
