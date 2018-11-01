<?php

get_header();

$show_default_title = get_post_meta( get_the_ID(), '_et_pb_show_title', true );

$is_page_builder_used = et_pb_is_pagebuilder_used( get_the_ID() );

$post_categories = wp_get_post_categories( $post->ID );
?>
    <div class="single-post advices-single">
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
            <div class="container">
                        <?php while ( have_posts() ) : the_post(); ?>
                            <?php setPostViews(get_the_ID()); ?>
                            <?php if (et_get_option('divi_integration_single_top') <> '' && et_get_option('divi_integrate_singletop_enable') == 'on') echo(et_get_option('divi_integration_single_top')); ?>
                            <div class="row">
                                <div class="col-md-12 col-sm-12 advices">
                                <div id="post-<?php the_ID(); ?>" <?php post_class(); ?>>

                                <div  class="blog_advices_link">
                                    <div class="advice_item">
                                        <div class="advice_item-header">
                                            <h4 class="header_tittle">
                                                <span>
                                                    <?php
                                                    foreach( get_the_category() as $category ){
                                                        echo $category->cat_name . ' ';
                                                    }
                                                    ?>
                                                </span>
                                            </h4>
                                            <h4 class="header_tittle"><a href="<?php esc_url( the_permalink() ); ?>"><?php the_title(); ?></a></h4>
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
                                            <?php the_excerpt(); ?>
                                        </div>
                                        <div class="share_btn_wrap">
                                            <div class="dropup">
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
                                </div>
                            </div>
                            </div>
                            </div>
                            <div class="row">
                            <div class="col-md-12">
                                <div class="single-content">
                                    <div class="social-box">
                                        <?php get_template_part( '/includes/social_icons' ); ?>
                                    </div>
                                    <div class="single-entry-content">
                                        <?php the_content(); ?>
                                    </div>
                                    <div class="social-box bottom-soc">
                                        <?php get_template_part( '/includes/social_icons' ); ?>
                                    </div>
                                </div>
                                <div class="sidebar_contact-box">
                                    <h4 class="cbox_txt">Маєш цікаву історію? Розкажи редактору</h4>
                                    <a href="#" class="cbox_btn" data-toggle="modal" data-target="#sidebarModal"> Написати</a>
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
                                                    <?php the_post_thumbnail(); ?>
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
                            </div>

                        <?php endwhile; ?>

                    <?php //get_sidebar(); ?>
                </div> <!-- #content-area -->
            </div> <!-- .container -->
        <?php endif; ?>
    </div> <!-- #main-content -->
<?php

get_footer();
