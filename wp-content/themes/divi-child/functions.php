<?php
function my_theme_enqueue_styles() {
    wp_enqueue_style('bootstrap', get_stylesheet_directory_uri() .'/css/bootstrap.min.css');
    wp_enqueue_style('fontello-icons', get_stylesheet_directory_uri() .'/assets/icons/css/icons.css');
    wp_enqueue_style('fontawesome-icons', get_stylesheet_directory_uri() .'/assets/icons/fontawesome/css/all.css');
    wp_enqueue_style('default-search', get_stylesheet_directory_uri() .'/assets/search-bar/css/default.css');
    wp_enqueue_style('component-search', get_stylesheet_directory_uri() .'/assets/search-bar/css/component.css');
    wp_enqueue_style('bxslider', get_stylesheet_directory_uri() .'/assets/bxslider/jquery.bxslider.css');
    wp_enqueue_style('select-cust', get_stylesheet_directory_uri() .'/assets/select/nice-select.css');
    wp_enqueue_style( 'parent-style', get_template_directory_uri() . '/style.css' );
    wp_enqueue_style( 'nat-style', get_stylesheet_directory_uri() . '/style-nat.css' );
    wp_enqueue_style( 'custom', get_stylesheet_directory_uri() . '/css/custom.css' );
    wp_enqueue_style( 'respons', get_stylesheet_directory_uri() . '/css/respons.css' );
    wp_enqueue_script('popper', get_stylesheet_directory_uri().'/js/popper.min.js', array('jquery'), false, true);
    wp_enqueue_script('bootstrap', get_stylesheet_directory_uri().'/js/bootstrap.min.js', array('jquery'), false, true);
    wp_enqueue_script('modernizr.custom', get_stylesheet_directory_uri().'/assets/search-bar/js/modernizr.custom.js', array('jquery'), false, true);
    wp_enqueue_script('classie', get_stylesheet_directory_uri().'/assets/search-bar/js/classie.js', array('jquery'), false, true);
    wp_enqueue_script('uisearch', get_stylesheet_directory_uri().'/assets/search-bar/js/uisearch.js', array('jquery'), false, true);
    wp_enqueue_script('select-cust', get_stylesheet_directory_uri().'/assets/select/jquery.nice-select.js', array('jquery'), false, true);
    if( is_page_template( array('events.php', 'news.php') ) ) {
        wp_enqueue_script('loadmore', get_stylesheet_directory_uri().'/assets/load-more/loadmore.js', array('jquery'), false, true);
    }
//    if( is_page_template( 'category-zoopeoples.php' ) ) {
        wp_enqueue_script('loadmore-zoo', get_stylesheet_directory_uri().'/assets/load-more/loadmore-zoo.js', array('jquery'), false, true);
//    }
    wp_enqueue_script('bxslider', get_stylesheet_directory_uri().'/assets/bxslider/jquery.bxslider.js', array('jquery'), false, true);
//    wp_enqueue_script('file-input', get_stylesheet_directory_uri().'/assets/file-input/jquery.nicefileinput.min.js', array('jquery'), false, true);
//    wp_enqueue_script('validator', get_stylesheet_directory_uri().'/js/bootstrapvalidator.min.js', array('jquery'), false, true);
//    wp_enqueue_script('validator', get_stylesheet_directory_uri().'/js/jquery.validate.min.js', array('jquery'), false, true);
    wp_localize_script( 'bootstrap', 'MyAjax', array( 'ajaxurl' => admin_url( 'admin-ajax.php' ) ) );
}
add_action( 'wp_enqueue_scripts', 'my_theme_enqueue_styles' );

register_sidebar( array(
    'id'          => 'share',
    'name'        => __( 'Share' ),
    'description' => '',
) );

/* include custom image module file*/
include(get_stylesheet_directory() . '/custom-pb-text-module.php');



// просмотры
function getPostViews($postID){
    $count_key = 'post_views_count';
    $count = get_post_meta($postID, $count_key, true);
    if($count==''){
        delete_post_meta($postID, $count_key);
        add_post_meta($postID, $count_key, '0');
        return "0";
    }
    return $count;
}
function setPostViews($postID) {
    $count_key = 'post_views_count';
    $count = get_post_meta($postID, $count_key, true);
    if($count==''){
        $count = 0;
        delete_post_meta($postID, $count_key);
        add_post_meta($postID, $count_key, '0');
    }else{
        $count++;
        update_post_meta($postID, $count_key, $count);
    }
}
add_filter('manage_posts_columns', 'posts_column_views');
add_action('manage_posts_custom_column', 'posts_custom_column_views',5,2);
function posts_column_views($defaults){
    $defaults['post_views'] = __('Просмотры');
    return $defaults;
}
function posts_custom_column_views($column_name, $id){
    if($column_name === 'post_views'){
        echo getPostViews(get_the_ID());
    }
}



//Filtr
add_action( 'wp_ajax_news_filtr', 'news_filtr_get_posts' );
add_action( 'wp_ajax_nopriv_news_filtr', 'news_filtr_get_posts' );

function news_filtr_get_posts()
{
    $data = $_POST;
    $resp = '';
    if (isset($data['type'])) {
        $type = $data['type'];

        if ($type == 'latest') {
            $args = array(
                'numberposts' => 6,
                'order'    => 'DESC',
                'category' => 6
            );
        } else {
            $args = array(
                'numberposts' => 6,
                'category' => 6,
                'meta_key' => 'post_views_count',
                'orderby'  => 'meta_value_num'
            );
        }

        if (isset($data['mainPostId'])) {
            $args['exclude'] = [$data['mainPostId']];
        }
        if (isset($data['catId'])) {
            $args['category'] = $data['catId'];
        }
        $posts = get_posts($args);
        ob_start();
        if (!empty($posts)) {
            foreach( $posts as $post ){ setup_postdata($post); ?>
                <div <?php post_class('col-xl-4 col-lg-6 col-md-6 col-sm-6'); ?>>
                    <a href="<?php the_permalink($post->ID); ?>" class="blog_news_link">
                        <div class="blog_item">
                            <div class="img-wrapper">
                                <?php echo get_the_post_thumbnail($post); ?>
                            </div>
                            <div class="blog_item-overlay-top">
                                <h5 class="post_date"><?php
                                    $d = '';
                                    if ( '' == $d ) {
                                        $the_date = mysql2date( get_option( 'date_format' ), $post->post_date );
                                    } else {
                                        $the_date = mysql2date( $d, $post->post_date );
                                    }
                                    echo esc_html( $the_date );
                                    ?></h5>
                                <div class="share_btn_wrap">
                                                <div class="dropdown dropleft show">
                                                    <a class="dropdown-toggle" href="#" role="button" id="dropdownMenuLink" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                                                        <i class="icon icon-union"></i>
                                                    </a>
                                                    <div class="dropdown-menu" aria-labelledby="dropdownMenuLink">
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
                            <div class="blog_item-overlay">
                                <div class="content_bottom">
                                    <h4 class="post_tittle"><?php echo get_the_title($post); ?></h4>
                                    <?php $excerpt = apply_filters( 'the_excerpt', get_the_excerpt($post) ); ?>
                                    <div class="post_brief"><?php echo mb_substr( strip_tags( $excerpt ), 0, 80 ); ?></div>
                                </div>
                            </div>
                        </div>
                    </a>
                </div>
            <?php }
            wp_reset_postdata(); // сброс
        }
        $resp = ob_get_contents();
        ob_clean();
    }
    wp_die($resp);
}


//Filtr stories
add_action( 'wp_ajax_stories_filtr', 'stories_filtr_get_posts' );
add_action( 'wp_ajax_nopriv_stories_filtr', 'stories_filtr_get_posts' );

function stories_filtr_get_posts()
{
    $data = $_POST;
    $resp = '';
    if (isset($data['type'])) {
        $type = $data['type'];

        if ($type == 'latest') {
            $args = array(
                'numberposts' => 6,
                'order'    => 'DESC',
                'category' => 23
            );
        } else {
            $args = array(
                'numberposts' => 6,
                'category' => 23,
                'meta_key' => 'post_views_count',
                'orderby'  => 'meta_value_num'
            );
        }

        if (isset($data['mainPostId'])) {
            $args['exclude'] = [$data['mainPostId']];
        }
        if (isset($data['catId'])) {
            $args['category'] = $data['catId'];
        }
        $posts = get_posts($args);
        ob_start();
        if (!empty($posts)) {
            foreach( $posts as $post ){ setup_postdata($post); ?>
                <div <?php post_class('col-md-4 col-sm-6'); ?>>
                    <a href="<?php the_permalink($post->ID); ?>" class="blog_news_link">
                        <div class="blog_item">
                            <div class="img-wrapper">
                                <?php echo get_the_post_thumbnail($post); ?>
                            </div>
                            <div class="blog_item-overlay-top">
                                <h5 class="post_date"><?php
                                    $d = '';
                                    if ( '' == $d ) {
                                        $the_date = mysql2date( get_option( 'date_format' ), $post->post_date );
                                    } else {
                                        $the_date = mysql2date( $d, $post->post_date );
                                    }
                                    echo esc_html( $the_date );
                                    ?></h5>
                                <div class="share_btn_wrap">
                                                <div class="dropdown dropleft show">
                                                    <h5 class="news_time"><?php echo get_the_date('j. m. Y'); ?></h5>
                                                    <a class="dropdown-toggle" href="#" role="button" id="dropdownMenuLink" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                                                        <i class="icon icon-union"></i>
                                                    </a>
                                                    <div class="dropdown-menu" aria-labelledby="dropdownMenuLink">
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
                            <div class="blog_item-overlay">
                                <div class="content_bottom">
                                    <h4 class="post_tittle"><?php echo get_the_title($post); ?></h4>
                                    <div class="post_brief"><?php echo apply_filters( 'the_excerpt', get_the_excerpt($post) ); ?></div>
                                </div>
                            </div>
                        </div>
                    </a>
                </div>
            <?php }
            wp_reset_postdata(); // сброс
        }
        $resp = ob_get_contents();
        ob_clean();
    }
    wp_die($resp);
}

//Filtr advices
add_action( 'wp_ajax_advices_filtr', 'advices_filtr_get_posts' );
add_action( 'wp_ajax_nopriv_advices_filtr', 'advices_filtr_get_posts' );

function advices_filtr_get_posts()
{
    $data = $_POST;
    $resp = '';
    if (isset($data['type'])) {
        $type = $data['type'];

        if ($type == 'latest') {
            $args = array(
                'numberposts' => 6,
                'order'    => 'DESC',
                'category' => 7
            );
        } else {
            $args = array(
                'numberposts' => 6,
                'category' => 7,
                'meta_key' => 'post_views_count',
                'orderby'  => 'meta_value_num'
            );
        }

        if (isset($data['mainPostId'])) {
            $args['exclude'] = [$data['mainPostId']];
        }
        if (isset($data['catId'])) {
            $args['category'] = $data['catId'];
        }
        $posts = get_posts($args);
        ob_start();
        if (!empty($posts)) {
            foreach( $posts as $post ){ setup_postdata($post); ?>
                <div <?php post_class('col-md-4 col-sm-6'); ?>>
                    <a href="<?php the_permalink($post->ID); ?>" class="blog_news_link">
                        <div class="blog_item">
                            <div class="img-wrapper">
                                <?php echo get_the_post_thumbnail($post); ?>
                            </div>
                            <div class="blog_item-overlay-top">
                                <h5 class="post_date"><?php
                                    $d = '';
                                    if ( '' == $d ) {
                                        $the_date = mysql2date( get_option( 'date_format' ), $post->post_date );
                                    } else {
                                        $the_date = mysql2date( $d, $post->post_date );
                                    }
                                    echo esc_html( $the_date );
                                    ?></h5>
                                <div class="share_btn_wrap">
                                                <div class="dropdown dropleft show">
                                                    <h5 class="news_time"><?php echo get_the_date('j. m. Y'); ?></h5>
                                                    <a class="dropdown-toggle" href="#" role="button" id="dropdownMenuLink" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                                                        <i class="icon icon-union"></i>
                                                    </a>
                                                    <div class="dropdown-menu" aria-labelledby="dropdownMenuLink">
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
                            <div class="blog_item-overlay">
                                <div class="content_bottom">
                                    <h4 class="post_tittle"><?php echo get_the_title($post); ?></h4>
                                    <div class="post_brief"><?php echo apply_filters( 'the_excerpt', get_the_excerpt($post) ); ?></div>
                                </div>
                            </div>
                        </div>
                    </a>
                </div>
            <?php }
            wp_reset_postdata(); // сброс
        }
        $resp = ob_get_contents();
        ob_clean();
    }
    wp_die($resp);
}

//Filtr events
add_action( 'wp_ajax_events_filtr', 'events_filtr_get_posts' );
add_action( 'wp_ajax_nopriv_events_filtr', 'events_filtr_get_posts' );

function events_filtr_get_posts()
{

    $data = $_POST;
    $resp = '';


    if (isset($data['select-month']) && isset($data['select-city'])) {
        $month = $data['select-month'];
        $city  = $data['select-city'];

        $args  = array(
            'posts_per_page' => 7,
            'category'       => 17,
            'orderby'        => 'meta_value_num',
            'order'          => 'ASC',
            'meta_query'     => array(
                'relation'		=> 'AND',
                array(
                    'key'		=> 'city',
                    'value'		=> $city,
                    'compare'	=> '='
                ),
                array(
                    'key'     => 'date',
                    'compare'  => 'REGEXP',
                    'value'    => '[0-9]{4}' . $month . '[0-9]{2}',
                )
            )
        );

        if ($city == 'all-city') {
            $args = array(
                'posts_per_page' => 7,
                'category'       => 17,
                'orderby'        => 'meta_value_num',
                'order'          => 'ASC',
                'meta_query'     => array(
                    array(
                        'key'     => 'date',
                        'compare'  => 'REGEXP',
                        'value'    => '[0-9]{4}' . $month . '[0-9]{2}',
                    )
                )
            );
        }

        query_posts($args);
        ob_start();
        if (have_posts()) :
//            $iter = 0;
            while (have_posts()) : the_post();
//                $iter++;
//                $number_posts = $iter;
            ?>

                    <div <?php post_class('col-md-4 col-sm-6'); ?> >
                        <a href="<?php the_permalink($post->ID); ?>" class="">
                            <div class="blog_item">
                                <div class="img-wrapper">
                                    <?php echo get_the_post_thumbnail($post); ?>
                                </div>
                                <div class="content">
                                    <div class="date">
                                        <h4 class="event_tittle"><?php the_title(); ?></h4>
<!--                                            <div class="share_btn_wrap">-->
<!--                                             <div class="dropdown dropleft show">-->
<!--                                                 <a class="dropdown-toggle" href="#" role="button" id="dropdownMenuLink" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">-->
<!--                                                     <i class="icon icon-union"></i>-->
<!--                                                 </a>-->
<!--                                                 <div class="dropdown-menu" aria-labelledby="dropdownMenuLink">-->
<!--                                                     <a class="dropdown-item fb-share-button" href="--><?php //esc_url( the_permalink() ); ?><!--" data-layout="button" data-size="large"></a>-->
<!--                                                     <a class="dropdown-item" id="viber_share">-->
<!--                                                         <img src="--><?php //echo get_stylesheet_directory_uri(); ?><!--/images/share_viber.png" alt="">-->
<!--                                                     </a>-->
<!--                                                     <a class="dropdown-item telegram-share" href="javascript:window.open('https://telegram.me/share/url?url='+encodeURIComponent(window.location.href), '_blank')">-->
<!--                                                         <div class="telegram_wrap">-->
<!--                                                             <img src="--><?php //echo get_stylesheet_directory_uri(); ?><!--/images/telegram-plane.png" alt="">-->
<!--                                                             <span>Share</span>-->
<!--                                                         </div>-->
<!--                                                     </a>-->
<!--                                                 </div>-->
<!--                                             </div>-->
<!--                                         </div>-->
                                    </div>
                                    <div class="content-text">
                                        <h5 class="date_txt">
                                            <div class="date_wrap">
                                                <?php
                                                $date_start = strtotime(get_field('date'));
                                                $date_end = get_field('date_end');
                                                ?>
                                                <span><?php echo date('d', $date_start); ?></span>
                                                <?php if (isset($date_end)) { ?>
                                                    <span>-</span>
                                                    <span><?php echo $date_end; ?></span>
                                                <?php } ?>
                                                <span class="month"><?php echo date('F', $date_start); ?></span>
                                                <span><?php echo date('Y', $date_start); ?></span>
                                            </div>

                                            <span class="city_name"><?php echo get_field('city'); ?></span>
                                        </h5>
                                        <div class="event_brief"><?php echo apply_filters( 'the_excerpt', get_the_excerpt($post) ); ?></div>
                                    </div>
                                </div>
                            </div>
                        </a>
                    </div>

            <?php endwhile; ?>

            <?php
//            if (  $post->max_num_pages > 1 ) : ?>
            <script id="true_loadmore">
                var ajaxurl = '<?php echo site_url() ?>/wp-admin/admin-ajax.php';
                var true_posts = '<?php echo serialize($args); ?>';
                var current_page = <?php echo (get_query_var('paged')) ? get_query_var('paged') : 1; ?>;
            </script>
            <div id="loader" class="col-md-12"></div>
            <?php else: ?>
                         <div class="col-md-12">
                             <p>Події не знайдені</p>
                         </div>
            <?php
        endif;
//        endif;
        $resp = ob_get_contents();
        ob_clean();
    }
    wp_die($resp);

}



//Load more
function true_load_posts(){

    $args = unserialize( stripslashes( $_POST['query'] ) );
    $args['paged'] = $_POST['page'] + 1; // следующая страница
    $args['post_status'] = 'publish';
    $args['cat'] = '17';



    query_posts($args);?>
    <?php if (have_posts()) : ?>
        <?php while (have_posts()) : the_post(); ?>
            <div <?php post_class('col-md-4 col-sm-6'); ?> >
                <a href="<?php the_permalink(); ?>" class="">
                    <div class="blog_item">
                        <div class="img-wrapper">
                            <?php the_post_thumbnail(); ?>
                        </div>
                        <div class="content">
                            <div class="date">
                                <h4 class="event_tittle"><?php the_title(); ?></h4>
<!--                                <div class="share_btn_wrap">-->
<!--                                                <div class="dropdown dropleft show">-->
<!--                                                    <a class="dropdown-toggle" href="#" role="button" id="dropdownMenuLink" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">-->
<!--                                                        <i class="icon icon-union"></i>-->
<!--                                                    </a>-->
<!--                                                    <div class="dropdown-menu" aria-labelledby="dropdownMenuLink">-->
<!--                                                        <a class="dropdown-item fb-share-button" href="--><?php //esc_url( the_permalink() ); ?><!--" data-layout="button" data-size="large"></a>-->
<!--                                                        <a class="dropdown-item" id="viber_share">-->
<!--                                                            <img src="--><?php //echo get_stylesheet_directory_uri(); ?><!--/images/share_viber.png" alt="">-->
<!--                                                        </a>-->
<!--                                                        <a class="dropdown-item telegram-share" href="javascript:window.open('https://telegram.me/share/url?url='+encodeURIComponent(window.location.href), '_blank')">-->
<!--                                                            <div class="telegram_wrap">-->
<!--                                                                <img src="--><?php //echo get_stylesheet_directory_uri(); ?><!--/images/telegram-plane.png" alt="">-->
<!--                                                                <span>Share</span>-->
<!--                                                            </div>-->
<!--                                                        </a>-->
<!--                                                    </div>-->
<!--                                                </div>-->
<!--                                            </div>-->
                            </div>
                            <div class="content-text">
                                <h5 class="date_txt">
                                    <div class="date_wrap">
                                        <?php
                                        $date_start = strtotime(get_field('date'));
                                        $date_end = get_field('date_end');
                                        ?>
                                        <span><?php echo date('d', $date_start); ?></span>
                                        <?php if (isset($date_end)) { ?>
                                            <span>-</span>
                                            <span><?php echo $date_end; ?></span>
                                        <?php } ?>
                                        <span class="month"><?php echo date('F', $date_start); ?></span>
                                        <span><?php echo date('Y', $date_start); ?></span>
                                    </div>

                                    <span class="city_name"><?php echo get_field('city'); ?></span>
                                </h5>
                                <div class="event_brief"><?php the_excerpt(); ?></div>
                            </div>
                        </div>
                    </div>
                </a>
            </div>
        <?php
        endwhile;

    endif;
    die();
}


add_action('wp_ajax_loadmore', 'true_load_posts');
add_action('wp_ajax_nopriv_loadmore', 'true_load_posts');


//Load more zoomans
function true_load_posts_zoo(){
//    ob_start();
//    $args = unserialize( stripslashes( $_POST['query'] ) );
//    $args['paged'] = $_POST['page'] + 1; // следующая страница
            $args = array(
                'posts_per_page' => 8,
                'cat'       => 3,
                'post_type'     => 'post',
                'post_status'   => 'publish',
                'offset'     => $_POST['posts_counter']
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

                <?php
                wp_reset_postdata();
            endif;
    die();
}


add_action('wp_ajax_loadmore-zoo', 'true_load_posts_zoo');
add_action('wp_ajax_nopriv_loadmore-zoo', 'true_load_posts_zoo');




//Limit words
//function excerpt($limit) {
//  $excerpt = explode(' ', get_the_excerpt(), $limit);
//  if (count($excerpt)>=$limit) {
//    array_pop($excerpt);
//    $excerpt = implode(" ",$excerpt);
//  } else {
//    $excerpt = implode(" ",$excerpt);
//  }
//  $excerpt = preg_replace('`[[^]]*]`','',$excerpt);
//  return $excerpt;
//}
//
//function content($limit) {
//  $content = explode(' ', get_the_content(), $limit);
//  if (count($content)>=$limit) {
//    array_pop($content);
//    $content = implode(" ",$content).'...';
//  } else {
//    $content = implode(" ",$content);
//  }
//  $content = preg_replace('/[.+]/','', $content);
//  $content = apply_filters('the_content', $content);
//  $content = str_replace(']]>', ']]&gt;', $content);
//  return $content;
//}

//Register menu
register_nav_menus(array(
	'lang'    => 'Lang menu',
));


add_filter('template_include','start_buffer_EN',1);
function start_buffer_EN($template) {
  ob_start('end_buffer_EN');
  return $template;
}
function end_buffer_EN($buffer) {
  return str_replace('<span>English</span>','<span>EN</span>',$buffer);
}

add_filter('template_include','start_buffer_FR',1);
function start_buffer_FR($template) {
  ob_start('end_buffer_FR');
  return $template;
}
function end_buffer_FR($buffer) {
  return str_replace('<span>Français</span>','<span>FR</span>',$buffer);
}


/**
 * Обрезка текста (excerpt). Шоткоды вырезаются. Минимальное значение maxchar может быть 22.
 *
 * @param string/array $args Параметры.
 *
 * @return string HTML
 *
 * @ver 2.6.3
 */
function kama_excerpt( $args = '' ){
	global $post;

	if( is_string($args) )
		parse_str( $args, $args );

	$rg = (object) array_merge( array(
		'maxchar'   => 350,   // Макс. количество символов.
		'text'      => '',    // Какой текст обрезать (по умолчанию post_excerpt, если нет post_content.
							  // Если в тексте есть `<!--more-->`, то `maxchar` игнорируется и берется все до <!--more--> вместе с HTML.
		'autop'     => true,  // Заменить переносы строк на <p> и <br> или нет?
		'save_tags' => '',    // Теги, которые нужно оставить в тексте, например '<strong><b><a>'.
		'more_text' => 'Читать дальше...', // Текст ссылки `Читать дальше`.
	), $args );

	$rg = apply_filters( 'kama_excerpt_args', $rg );

	if( ! $rg->text )
		$rg->text = $post->post_excerpt ?: $post->post_content;

	$text = $rg->text;
	$text = preg_replace( '~\[([a-z0-9_-]+)[^\]]*\](?!\().*?\[/\1\]~is', '', $text ); // убираем блочные шорткоды: [foo]some data[/foo]. Учитывает markdown
	$text = preg_replace( '~\[/?[^\]]*\](?!\()~', '', $text ); // убираем шоткоды: [singlepic id=3]. Учитывает markdown
	$text = trim( $text );

	// <!--more-->
	if( strpos( $text, '<!--more-->') ){
		preg_match('/(.*)<!--more-->/s', $text, $mm );

		$text = trim( $mm[1] );

		$text_append = ' <a href="'. get_permalink( $post ) .'#more-'. $post->ID .'">'. $rg->more_text .'</a>';
	}
	// text, excerpt, content
	else {
		$text = trim( strip_tags($text, $rg->save_tags) );

		// Обрезаем
		if( mb_strlen($text) > $rg->maxchar ){
			$text = mb_substr( $text, 0, $rg->maxchar );
			$text = preg_replace( '~(.*)\s[^\s]*$~s', '\\1 ...', $text ); // убираем последнее слово, оно 99% неполное
		}
	}

	// Сохраняем переносы строк. Упрощенный аналог wpautop()
	if( $rg->autop ){
		$text = preg_replace(
			array("/\r/", "/\n{2,}/", "/\n/",   '~</p><br ?/?>~'),
			array('',     '</p><p>',  '<br />', '</p>'),
			$text
		);
	}

	$text = apply_filters( 'kama_excerpt', $text, $rg );

	if( isset($text_append) )
		$text .= $text_append;

	return ( $rg->autop && $text ) ? "<p>$text</p>" : $text;
}

/**
 * Альтернатива wp_pagenavi. Создает ссылки пагинации на страницах архивов.
 *
 * @param array  $args      Аргументы функции
 * @param object $wp_query  Объект WP_Query на основе которого строится пагинация. По умолчанию глобальная переменная $wp_query
 *
 * @version 2.6
 * @author  Тимур Камаев
 * @link    Ссылка на страницу функции: http://wp-kama.ru/?p=8
 */
function kama_pagenavi( $args = array(), $wp_query = null ){

	if( ! $wp_query ){
		wp_reset_query();
		global $wp_query;
	}

	// параметры по умолчанию
	$default = array(
		'before'          => '',   // Текст до навигации.
		'after'           => '',   // Текст после навигации.
		'echo'            => true, // Возвращать или выводить результат.

		'text_num_page'   => '',           // Текст перед пагинацией.
										   // {current} - текущая.
										   // {last} - последняя (пр: 'Страница {current} из {last}' получим: "Страница 4 из 60").
		'num_pages'       => 10,           // Сколько ссылок показывать.
		'step_link'       => 10,           // Ссылки с шагом (если 10, то: 1,2,3...10,20,30. Ставим 0, если такие ссылки не нужны.
		'dotright_text'   => '…',          // Промежуточный текст "до".
		'dotright_text2'  => '…',          // Промежуточный текст "после".
		'back_text'       => '« назад',    // Текст "перейти на предыдущую страницу". Ставим 0, если эта ссылка не нужна.
		'next_text'       => 'вперед »',   // Текст "перейти на следующую страницу".  Ставим 0, если эта ссылка не нужна.
		'first_page_text' => '« к началу', // Текст "к первой странице".    Ставим 0, если вместо текста нужно показать номер страницы.
		'last_page_text'  => 'в конец »',  // Текст "к последней странице". Ставим 0, если вместо текста нужно показать номер страницы.
	);

	// Cовместимость с v2.5: kama_pagenavi( $before = '', $after = '', $echo = true, $args = array() )
	if( func_num_args() && is_string( func_get_arg(0) ) ){
		$default['before'] = func_get_arg(0);
		$default['after']  = func_get_arg(1);
		$default['echo']   = func_get_arg(2);
	}

	$default = apply_filters( 'kama_pagenavi_args', $default ); // чтобы можно было установить свои значения по умолчанию

	$rg = (object) array_merge( $default, $args );

	//$posts_per_page = (int) $wp_query->get('posts_per_page');
	$paged          = (int) $wp_query->get('paged');
	$max_page       = $wp_query->max_num_pages;

	// проверка на надобность в навигации
	if( $max_page <= 1 )
		return false;

	if( empty( $paged ) || $paged == 0 )
		$paged = 1;

	$pages_to_show = intval( $rg->num_pages );
	$pages_to_show_minus_1 = $pages_to_show-1;

	$half_page_start = floor( $pages_to_show_minus_1/2 ); // сколько ссылок до текущей страницы
	$half_page_end   = ceil(  $pages_to_show_minus_1/2 ); // сколько ссылок после текущей страницы

	$start_page = $paged - $half_page_start; // первая страница
	$end_page   = $paged + $half_page_end;   // последняя страница (условно)

	if( $start_page <= 0 )
		$start_page = 1;
	if( ($end_page - $start_page) != $pages_to_show_minus_1 )
		$end_page = $start_page + $pages_to_show_minus_1;
	if( $end_page > $max_page ) {
		$start_page = $max_page - $pages_to_show_minus_1;
		$end_page = (int) $max_page;
	}

	if( $start_page <= 0 )
		$start_page = 1;

	$out = '';

	// создаем базу чтобы вызвать get_pagenum_link один раз
	$link_base = str_replace( 99999999, '___', get_pagenum_link( 99999999 ) );
	$first_url = get_pagenum_link( 1 );
	if( false === strpos( $first_url, '?') )
		$first_url = user_trailingslashit( $first_url );

	$out .= '<div class="wp-pagenavi">'."\n";

		if( $rg->text_num_page ){
			$rg->text_num_page = preg_replace( '!{current}|{last}!', '%s', $rg->text_num_page );
			$out.= sprintf( "<span class='pages'>$rg->text_num_page</span> ", $paged, $max_page );
		}
		// назад
		if ( $rg->back_text && $paged != 1 )
			$out .= '<a class="prev" href="'. ( ($paged-1)==1 ? $first_url : str_replace( '___', ($paged-1), $link_base ) ) .'">'. $rg->back_text .'</a> ';
		// в начало
		if ( $start_page >= 2 && $pages_to_show < $max_page ) {
			$out.= '<a class="first" href="'. $first_url .'">'. ( $rg->first_page_text ?: 1 ) .'</a> ';
			if( $rg->dotright_text && $start_page != 2 ) $out .= '<span class="extend">'. $rg->dotright_text .'</span> ';
		}
		// пагинация
		for( $i = $start_page; $i <= $end_page; $i++ ) {
			if( $i == $paged )
				$out .= '<span class="current">'.$i.'</span> ';
			elseif( $i == 1 )
				$out .= '<a href="'. $first_url .'">1</a> ';
			else
				$out .= '<a href="'. str_replace( '___', $i, $link_base ) .'">'. $i .'</a> ';
		}

		// ссылки с шагом
		$dd = 0;
		if ( $rg->step_link && $end_page < $max_page ){
			for( $i = $end_page + 1; $i <= $max_page; $i++ ){
				if( $i % $rg->step_link == 0 && $i !== $rg->num_pages ) {
					if ( ++$dd == 1 )
						$out.= '<span class="extend">'. $rg->dotright_text2 .'</span> ';
					$out.= '<a href="'. str_replace( '___', $i, $link_base ) .'">'. $i .'</a> ';
				}
			}
		}
		// в конец
		if ( $end_page < $max_page ) {
			if( $rg->dotright_text && $end_page != ($max_page-1) )
				$out.= '<span class="extend">'. $rg->dotright_text2 .'</span> ';
			$out.= '<a class="last" href="'. str_replace( '___', $max_page, $link_base ) .'">'. ( $rg->last_page_text ?: $max_page ) .'</a> ';
		}
		// вперед
		if ( $rg->next_text && $paged != $end_page )
			$out.= '<a class="next" href="'. str_replace( '___', ($paged+1), $link_base ) .'">'. $rg->next_text .'</a> ';

	$out .= '</div>';

	$out = apply_filters( 'kama_pagenavi', $rg->before . $out . $rg->after );

	if( $rg->echo )
		echo $out;
	else
		return $out;
}