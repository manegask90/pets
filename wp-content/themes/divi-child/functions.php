<?php
function my_theme_enqueue_styles() {
    $templates = "'events.php', 'news.php'";
    wp_enqueue_style('bootstrap', get_stylesheet_directory_uri() .'/css/bootstrap.min.css');
    wp_enqueue_style('fontello-icons', get_stylesheet_directory_uri() .'/assets/icons/css/icons.css');
    wp_enqueue_style('fontawesome-icons', get_stylesheet_directory_uri() .'/assets/icons/fontawesome/css/all.css');
    wp_enqueue_style('default-search', get_stylesheet_directory_uri() .'/assets/search-bar/css/default.css');
    wp_enqueue_style('component-search', get_stylesheet_directory_uri() .'/assets/search-bar/css/component.css');
    wp_enqueue_style('bxslider', get_stylesheet_directory_uri() .'/assets/bxslider/jquery.bxslider.css');
    wp_enqueue_style( 'parent-style', get_template_directory_uri() . '/style.css' );
    wp_enqueue_style( 'nat-style', get_stylesheet_directory_uri() . '/style-nat.css' );
    wp_enqueue_style( 'custom', get_stylesheet_directory_uri() . '/css/custom.css' );
    wp_enqueue_style( 'respons', get_stylesheet_directory_uri() . '/css/respons.css' );
    wp_enqueue_script('popper', get_stylesheet_directory_uri().'/js/popper.min.js', array('jquery'), false, true);
    wp_enqueue_script('bootstrap', get_stylesheet_directory_uri().'/js/bootstrap.min.js', array('jquery'), false, true);
    wp_enqueue_script('modernizr.custom', get_stylesheet_directory_uri().'/assets/search-bar/js/modernizr.custom.js', array('jquery'), false, true);
    wp_enqueue_script('classie', get_stylesheet_directory_uri().'/assets/search-bar/js/classie.js', array('jquery'), false, true);
    wp_enqueue_script('uisearch', get_stylesheet_directory_uri().'/assets/search-bar/js/uisearch.js', array('jquery'), false, true);
    if( is_page_template( array($templates) ) ) {
        wp_enqueue_script('loadmore', get_stylesheet_directory_uri().'/assets/load-more/loadmore.js', array('jquery'), false, true);
    }
    wp_enqueue_script('bxslider', get_stylesheet_directory_uri().'/assets/bxslider/jquery.bxslider.js', array('jquery'), false, true);
//    wp_enqueue_script('validator', get_stylesheet_directory_uri().'/js/bootstrapvalidator.min.js', array('jquery'), false, true);
    wp_enqueue_script('validator', get_stylesheet_directory_uri().'/js/jquery.validate.min.js', array('jquery'), false, true);
    wp_localize_script( 'bootstrap', 'MyAjax', array( 'ajaxurl' => admin_url( 'admin-ajax.php' ) ) );
}
add_action( 'wp_enqueue_scripts', 'my_theme_enqueue_styles' );



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
                                                    <h5 class="news_time"><?php echo esc_html( get_the_date( $meta_date ) ) ?></h5>
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
            $iter = 0;
            while (have_posts()) : the_post();
                $iter++;
                $number_posts = $iter;
            ?>

                <?php if ($number_posts == 3) { ?>
                     <div <?php post_class('col-md-6 col-sm-12'); ?> >
                        <a href="" class="">
                             <div class="blog_item blog_item-main">
                                 <div class="date">
                                     <h5 class="date_txt"><span><?php echo get_field('date'); ?></span><?php echo get_field('city'); ?></h5>
                                 </div>
                                 <div class="img-wrapper">
                                     <?php the_post_thumbnail(); ?>
                                 </div>
                                 <div class="content">
                                     <div class="content-text">
                                         <h4 class="event_tittle"><?php the_title(); ?></h4>
                                         <div class="event_brief"><?php the_excerpt(); ?></div>
                                     </div>
                                     <div class="place">
                                         <h5 class="place_txt"><?php echo get_field('location'); ?></h5>
                                         <h5 class="place_txt">FREE entrance</h5>
                                     </div>
                                 </div>
                             </div>
                         </a>
                <?php } else { ?>
                    <div <?php post_class('col-md-3 col-sm-6'); ?> >
                        <a href="<?php the_permalink($post->ID); ?>" class="">
                            <div class="blog_item">
                                <div class="img-wrapper">
                                    <?php echo get_the_post_thumbnail($post); ?>
                                </div>
                                <div class="content">
                                    <div class="date">
                                        <h5 class="date_txt"><span><?php echo get_field('date', $post->ID ); ?></span><?php  echo get_field('city', $post->ID ); ?></h5>
                                    </div>
                                    <div class="content-text">
                                        <h4 class="event_tittle"><?php echo get_the_title($post); ?></h4>
                                        <div class="event_brief"><?php echo apply_filters( 'the_excerpt', get_the_excerpt($post) ); ?></div>
                                    </div>
                                </div>
                            </div>
                        </a>
                        <?php } ?>
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
            <div <?php post_class('col-md-3 col-sm-6'); ?> >
                <a href="<?php the_permalink(); ?>" class="">
                    <div class="blog_item">
                        <div class="img-wrapper">
                            <?php the_post_thumbnail(); ?>
                        </div>
                        <div class="content">
                            <div class="date">
                                <h5 class="date_txt"><span><?php echo get_field('date'); ?></span><?php echo get_field('city'); ?></h5>
                            </div>
                            <div class="content-text">
                                <h4 class="event_tittle"><?php the_title(); ?></h4>
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




//Limit words
function excerpt($limit) {
  $excerpt = explode(' ', get_the_excerpt(), $limit);
  if (count($excerpt)>=$limit) {
    array_pop($excerpt);
    $excerpt = implode(" ",$excerpt);
  } else {
    $excerpt = implode(" ",$excerpt);
  }
  $excerpt = preg_replace('`[[^]]*]`','',$excerpt);
  return $excerpt;
}

function content($limit) {
  $content = explode(' ', get_the_content(), $limit);
  if (count($content)>=$limit) {
    array_pop($content);
    $content = implode(" ",$content).'...';
  } else {
    $content = implode(" ",$content);
  }
  $content = preg_replace('/[.+]/','', $content);
  $content = apply_filters('the_content', $content);
  $content = str_replace(']]>', ']]&gt;', $content);
  return $content;
}

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