<?php

get_header();

$show_default_title = get_post_meta( get_the_ID(), '_et_pb_show_title', true );

$is_page_builder_used = et_pb_is_pagebuilder_used( get_the_ID() );

?>
    <div class="single-post">
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
                <div class="row">
                        <?php while ( have_posts() ) : the_post(); ?>
                            <?php setPostViews(get_the_ID()); ?>
                            <?php if (et_get_option('divi_integration_single_top') <> '' && et_get_option('divi_integrate_singletop_enable') == 'on') echo(et_get_option('divi_integration_single_top')); ?>

                            <div class="col-md-12 header-block-wrap">
                                <div class="post-thumb">
                                    <?php //the_post_thumbnail(); ?>
                                    <img src="<?php echo get_field('img'); ?>" alt="">
                                </div>
                                <div class="post-header-block">
                                    <div class="post-header-block-wrap">
                                        <div class="title-block">
                                            <h2 class="entry-title"><?php the_title(); ?></h2>
                                        </div>
                                        <div class="text-block">
                                            <?php echo excerpt(11); ?>
                                            <div class="meta-box">
                                                <div class="date">
                                                    <?php the_date(); ?>
                                                </div>
                                                <div class="view">
                                                    <i class="icon icon-eye"></i>
                                                    <?php  echo getPostViews(get_the_ID()); ?>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
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
                                <div class="read-next">
                                    <div class="border-box"></div>
                                    <div class="text">читати більше</div>
                                </div>


                                <div class="slider news">
                                    <?php

                                $related = get_posts( array( 'category__in' => wp_get_post_categories($post->ID), 'numberposts' => -1, 'post__not_in' => array($post->ID) ) );
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
                                                        <h5 class="news_time"> 1. 10. 2018</h5>
                                                        <i class="icon demo-icon icon-union"></i>
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
