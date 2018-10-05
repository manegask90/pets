<?php
function my_theme_enqueue_styles() {
    wp_enqueue_style('bootstrap', get_stylesheet_directory_uri() .'/css/bootstrap.min.css');
    wp_enqueue_style('fontello-icons', get_stylesheet_directory_uri() .'/assets/icons/css/icons.css');
    wp_enqueue_style('default-search', get_stylesheet_directory_uri() .'/assets/search-bar/css/default.css');
    wp_enqueue_style('component-search', get_stylesheet_directory_uri() .'/assets/search-bar/css/component.css');
    wp_enqueue_style( 'parent-style', get_template_directory_uri() . '/style.css' );
    wp_enqueue_style( 'nat-style', get_stylesheet_directory_uri() . '/style-nat.css' );
    wp_enqueue_script('popper', get_stylesheet_directory_uri().'/js/popper.min.js', array('jquery'), false, true);
    wp_enqueue_script('bootstrap', get_stylesheet_directory_uri().'/js/bootstrap.min.js', array('jquery'), false, true);
    wp_enqueue_script('modernizr.custom', get_stylesheet_directory_uri().'/assets/search-bar/js/modernizr.custom.js', array('jquery'), false, true);
    wp_enqueue_script('classie', get_stylesheet_directory_uri().'/assets/search-bar/js/classie.js', array('jquery'), false, true);
    wp_enqueue_script('uisearch', get_stylesheet_directory_uri().'/assets/search-bar/js/uisearch.js', array('jquery'), false, true);
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
                                <object>
                                    <a href="#">
                                        <i class="icon demo-icon icon-union"></i>
                                    </a>
                                </object>
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
            'posts_per_page' => -1,
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
                'posts_per_page' => -1,
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

        $posts = get_posts($args);
        ob_start();
        if (!empty($posts)) {
            foreach( $posts as $post ){ setup_postdata($post); ?>
                <div <?php post_class('col-md-3 col-sm-6'); ?>>
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
                </div>
            <?php }
            wp_reset_postdata(); // сброс
        }
        $resp = ob_get_contents();
        ob_clean();
    }
    wp_die($resp);

}

