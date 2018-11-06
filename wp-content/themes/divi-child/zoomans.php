<?php
/**
 * Template Name: Zoomans
 *
 */
get_header();

$is_page_builder_used = et_pb_is_pagebuilder_used( get_the_ID() );

?>

<section class="zoopeople">
<div id="main-content">
	<div class="container">
        <div class="row">
            <div class="col-md-12 col-sm-12">

                <?php
                $posts = get_posts( array(
                    'numberposts' => 1,
                    'tag' => 'main',
                    'post_type'   => 'post',
                    'category'    => 3,
                    'suppress_filters' => true, // подавление работы фильтров изменения SQL запроса
                ) ); ?>

                <?php
                foreach( $posts as $post ){ ?>
                    <?php setup_postdata($post); ?>
                    <div class="blog_item blog_item_main">
                        <img src="<?php the_field('main_img'); ?>" alt="" />
                        <div class="blog_item-overlay">
                            <div class="content">
                                <h2 class="entry-title"><a href="<?php esc_url( the_permalink() ); ?>"><?php the_title(); ?></a></h2>
                                <div class="text-wrap">
                                    <p><span>Зоопсихолог</span></p>
                                    <?php the_excerpt(); ?>
                                    <div class="share_btn_wrap">
                                        <div class="dropdown show">
                                            <span class="meta-date"><?php echo get_the_date(); ?></span>
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
                            </div>
                        </div>
                    </div>
                <?php }

                wp_reset_postdata(); // сброс ?>
            </div>
        </div>
		<div class="row">

            <?php
            $args = array(
                'posts_per_page' => 4,
                'cat'       => 3,
                'post_type'     => 'post'
            );
            $query = new WP_Query($args);
            if ($query->have_posts()) :
                    while ( $query->have_posts() ) :
                        $query->the_post(); ?>

                <?php $date = get_the_date('j. m. Y'); ?>
            <div id="post-<?php the_ID(); ?>" <?php post_class('et_pb_post col-lg-3 col-md-6 col-sm-6 col-6'); ?>>

                <a href="<?php esc_url(the_permalink()); ?>">
                    <div class="blog_item">
                        <?php //print_thumbnail(); ?>
                        <?php the_post_thumbnail(); ?>
                        <div class="blog_item-overlay">
                            <div class="content_top">
                                <h2 class="entry-title"><?php the_title(); ?></h2>
                                <p><span>Зоопсихолог</span></p>
                            </div>
                        <div class="content_bottom">
                            <h4><?php the_excerpt(); ?></h4>
                            <p><span><?php echo $date ?></span></p>
                        </div>
                    </div>
            </div>
            </a>
        </div>
                <?php endwhile; ?>
                    <script id="true_loadmore_zoo">
                        var ajaxurl = '<?php echo site_url() ?>/wp-admin/admin-ajax.php';
                        var true_posts_zoo = '<?php echo serialize($wp_query->query_vars); ?>';
                        var current_page = <?php echo (get_query_var('paged')) ? get_query_var('paged') : 1; ?>;
                    </script>
                    <div id="loader" class="col-md-12"></div>
                <?php
                    wp_reset_postdata();
                    endif;
                ?>


			<?php //get_sidebar(); ?>
		</div> <!-- #content-area -->
	</div> <!-- .container -->


</div> <!-- #main-content -->
</section>
<?php

get_footer();
