<?php
/**
 * Template Name: Events
 *
 */
get_header();

$is_page_builder_used = et_pb_is_pagebuilder_used( get_the_ID() );

?>
<?php if ( ! $is_page_builder_used ) : ?>


<?php endif; ?>

<section class="events">
    <div class="container">
        <div class="row">
            <div class="col-md-12">
                <h2 class="evens_tittle">Події на <span><?php echo date('Y'); ?></span> рік в місті:
                    <span class="span-city">
                        <?php if (isset($_COOKIE['select-city']) && $_COOKIE['select-city'] == 'dnipro'){
                            echo 'Дніпро';
                        } elseif (isset($_COOKIE['select-city']) && $_COOKIE['select-city'] == 'lviv'){
                            echo 'Львів';
                        } elseif (isset($_COOKIE['select-city']) && $_COOKIE['select-city'] == 'kyiv'){
                            echo 'Київ';
                        } elseif (isset($_COOKIE['select-city']) && $_COOKIE['select-city'] == 'all-city'){
                            echo 'Всі міста';
                        } else {
                            echo 'Всі міста';
                        }
                        ?>
                    </span>
                </h2>
            </div>
            <div class="col-md-12">
                <div class="events_filter">
                    <?php


                    if (qtranxf_getLanguage() == 'ua') {
                        $field_key = "field_5bb5c1873312c";
                    } elseif (qtranxf_getLanguage() == 'ru') {
                        $field_key = "field_5bd99df06edb2";
                    }

                    $post_id = $post->ID;
                    $field = get_field_object($field_key, $post_id);
                    $field = get_field_object($field_key);
                    $field_ch = $field['choices'];





                    $curent_month = date("m");
                    $selectMonth = $_COOKIE['select-month'];
                    $selectCity  = $_COOKIE['select-city'];

                        $allMons = array(
                                '01' => 'Січень',
                                '02' => 'Лютий',
                                '03' => 'Березень',
                                '04' => 'Квітень',
                                '05' => 'Травень',
                                '06' => 'Червень',
                                '07' => 'Липень',
                                '08' => 'Серпень',
                                '09' => 'Вересень',
                                '10' => 'Жовтень',
                                '11' => 'Листопад',
                                '12' => 'Грудень'
                        );
//                        $allCity = array(
//                          'all-city' => 'Всі міста',
//                          'lviv'     => 'Львів',
//                          'kyiv'     => 'Київ',
//                          'dnipro'   => 'Дніпро'
//                        )


                    ?>

                    <span>Показувати спочатку:</span>
                    <form action="" method="post" class="event-filtr">
                        <div class="select-box">
                            <select name="date" class="filtr-select-month">
                            <?php
                                if (isset($_COOKIE['select-month'])) {
                                    foreach ($allMons as $numberMon => $mon) {
                                        $option = '<option value="' . $numberMon . '"';
                                        if ($numberMon == $_COOKIE['select-month']) {
                                            $option .= ' selected="selected"';
                                        }
                                        $option .= '>' . $mon . '</option>';
                                        echo $option;
                                    }
                                } else {
                                    foreach ($allMons as $numberMon => $mon) {
                                        $option = '<option value="' . $numberMon . '"';
                                        if ($numberMon == $curent_month) {
                                            $option .= ' selected="selected"';
                                        }
                                        $option .= '>' . $mon . '</option>';
                                        echo $option;
                                    }
                                }
                                ?>
                            </select>
                        </div>
                        <div class="select-box">
                            <select name="city" class="filtr-select-city">
                                <?php
                                foreach ($field_ch as $numberCity => $city) {
                                    $option = '<option value="' . $numberCity . '"';
                                    if ($numberCity == $_COOKIE['select-city']) {
                                        $option .= ' selected="selected"';
                                    }
                                    $option .= '>' . $city . '</option>';
                                    echo $option;
                                }
                                ?>
                            </select>
                        </div>
                    </form>

                </div>
            </div>
        </div>
        <div class="events_wrap">
        <div class="row events_posts_wrap">
        <?php

            if( !empty($posts) ):

                $city = $_GET['city'];
                $date_filtr = $_GET['date'];


//                if (isset($selectMonth)){
//                    $args = array(
//                        'posts_per_page' => 4,
//                        'category' => 17,
//                        'orderby' => 'meta_value_num',
//                        'order' => 'DESC',
//                        'meta_query' => array(
//                            'relation' => 'AND',
//                            array(
//                                'key' => 'date',
//                                'compare' => 'REGEXP',
//                                'value' => '[0-9]{4}' . $selectMonth . '[0-9]{2}',
//                            )
//                        )
//                    );
//                } elseif (isset($selectCity)) {
//                    $args = array(
//                        'posts_per_page' => 4,
//                        'category' => 17,
//                        'orderby' => 'meta_value_num',
//                        'order' => 'DESC',
//                        'meta_query' => array(
//                            'relation' => 'AND',
//                            array(
//                                'key' => 'city',
//                                'value' => $selectCity,
//                                'compare' => '='
//                            ),
//                        )
//                    );
//                }
                if (isset($selectMonth) && isset($selectCity)) {
                    $args = array(
                        'posts_per_page' => 4,
                        'category' => 17,
                        'orderby' => 'meta_value_num',
                        'order' => 'DESC',
                        'meta_query' => array(
                            'relation' => 'AND',
                            array(
                                'key' => 'city',
                                'value' => $selectCity,
                                'compare' => '='
                            ),
                            array(
                                'key' => 'date',
                                'compare' => 'REGEXP',
                                'value' => '[0-9]{4}' . $selectMonth . '[0-9]{2}',
                            )
                        )
                    );
                } else {
                    $args  = array(
                        'posts_per_page' => 4,
                        'category'       => 17,
                        'orderby'        => 'meta_value_num',
                        'order'          => 'DESC',
                        'meta_query' => array(
                            array(
                                'key' => 'date',
                                'compare' => 'REGEXP',
                                'value' => '[0-9]{4}' . $curent_month . '[0-9]{2}',
                            )
                        )
                    );
                }
//                else {
//                    $args  = array(
//                        'posts_per_page' => 4,
//                        'category'       => 17,
//                        'orderby'        => 'meta_value_num',
//                        'order'          => 'DESC',
//                        'meta_query' => array(
//                            array(
//                                'key' => 'date',
//                                'compare' => 'REGEXP',
//                                'value' => '[0-9]{4}' . $curent_month . '[0-9]{2}',
//                            )
//                        )
//                    );
//                }

//        if (isset($selectMonth) and isset($selectCity)) {
//            $args = array(
//                'posts_per_page' => 7,
//                'category' => 17,
//                'orderby' => 'meta_value_num',
//                'order' => 'ASC',
//                'meta_query' => array(
//                    'relation' => 'AND',
//                    array(
//                        'key' => 'city',
//                        'value' => $selectCity,
//                        'compare' => '='
//                    ),
//                    array(
//                        'key' => 'date',
//                        'compare' => 'REGEXP',
//                        'value' => '[0-9]{4}' . $selectMonth . '[0-9]{2}',
//                    )
//                )
//            );
//        } else {
//            $args = array(
//                'posts_per_page' => 7,
//                'category' => 17,
//                'orderby' => 'meta_value_num',
//                'order' => 'ASC',
//                'meta_query' => array(
//                    'relation' => 'AND',
//                    array(
//                        'key' => 'city',
//                        'value' => $city,
//                        'compare' => '='
//                    ),
//                    array(
//                        'key' => 'date',
//                        'compare' => 'REGEXP',
//                        'value' => '[0-9]{4}' . $selectMonth . '[0-9]{2}',
//                    )
//                )
//            );
//        }

        if ($selectCity == 'all-city') {
            $args = array(
                'posts_per_page' => 7,
                'category'       => 17,
                'orderby'        => 'meta_value_num',
                'order'          => 'ASC',
                'meta_query'     => array(
                    array(
                        'key'     => 'date',
                        'compare'  => 'REGEXP',
                        'value'    => '[0-9]{4}' . $selectMonth . '[0-9]{2}',
                    )
                )
            );
        }

                query_posts($args);
                if (have_posts()) :
//                    $iter = 0;
                while (have_posts()) : the_post();
//                    $iter++;
//                    $number_posts = $iter;
                    $cost = get_field('cost');
                ?>
                    <div <?php post_class('col-md-4 col-sm-6'); ?> >
                        <a href="<?php the_permalink(); ?>" class="">
                            <div class="blog_item">
                                <div class="img-wrapper">
                                    <?php the_post_thumbnail(); ?>
                                </div>
                                <div class="content">
                                    <div class="date">
                                        <h4 class="event_tittle"><?php the_title(); ?></h4>
<!--                                        <h5 class="date_txt">-->
<!--                                            <span>--><?php //echo get_field('date'); ?><!--</span>--><?php //echo get_field('city'); ?>
<!--                                            <div class="share_btn_wrap">-->
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
<!--                                        </h5>-->
                                    </div>
                                    <div class="content-text">
                                        <h5 class="date_txt">
                                            <div class="date_wrap">
                                                <?php
                                                    $date_start = strtotime(get_field('date'));
                                                    $date_end = get_field('date_end');
                                                ?>
                                                <span><?php echo date_i18n('d', $date_start); ?></span>
                                                <?php if (isset($date_end)) { ?>
                                                    <span>-</span>
                                                    <span><?php echo $date_end; ?></span>
                                                <?php } ?>
                                                <span class="month"><?php echo date_i18n('F', $date_start); ?></span>
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
                         endwhile; ?>


                <?php //if (  $wp_query->max_num_pages > 1 ) : ?>
                    <script id="true_loadmore">
                        var ajaxurl = '<?php echo site_url() ?>/wp-admin/admin-ajax.php';
                        var true_posts = '<?php echo serialize($wp_query->query_vars); ?>';
                        var current_page = <?php echo (get_query_var('paged')) ? get_query_var('paged') : 1; ?>;
                    </script>
                    <div id="loader" class="col-md-12"></div>
                <?php //endif; ?>


            <?php wp_reset_postdata(); ?>

            <?php endif; ?>
            <?php endif; ?>
        </div>

        <div class="col-md-12 sidebar_wrap_events">
            <?php get_sidebar('events'); ?>
        </div>

        </div>
    </div>
    </div>
</section>


<?php
    get_footer();
