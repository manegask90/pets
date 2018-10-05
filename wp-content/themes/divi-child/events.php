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
                <h2 class="evens_tittle">Події на <span><?php echo date('Y'); ?></span> рік в місті: <span>ЛЬВІВ</span></h2>
            </div>
            <div class="col-md-12">
                <div class="events_filter">
                    <?php

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
                        $allCity = array(
                          'all-city' => 'Всі міста',
                          'lviv'     => 'Львів',
                          'kyiv'     => 'Київ',
                          'dnipro'   => 'Дніпро'
                        )

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
                                foreach ($allCity as $numberCity => $city) {
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
        <div class="row events_posts_wrap">
        <?php

            if( !empty($posts) ):

                $city = $_GET['city'];
                $date_filtr = $_GET['date'];


                if (isset($selectMonth)){
                    $args = array(
                        'posts_per_page' => -1,
                        'category' => 17,
                        'orderby' => 'meta_value_num',
                        'order' => 'DESC',
                        'meta_query' => array(
                            'relation' => 'AND',
                            array(
                                'key' => 'date',
                                'compare' => 'REGEXP',
                                'value' => '[0-9]{4}' . $selectMonth . '[0-9]{2}',
                            )
                        )
                    );
                } elseif (isset($selectCity)) {
                    $args = array(
                        'posts_per_page' => -1,
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
                        )
                    );
                } elseif (isset($selectMonth) && isset($selectCity)) {
                    $args = array(
                        'posts_per_page' => -1,
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
                        'posts_per_page' => -1,
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


                $posts = get_posts( $args );

                foreach ($posts as $post) {
                    $events_date = $post;
                    ?>
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
                <?php } ?>
            <?php wp_reset_postdata(); ?>

            <?php endif; ?>
        </div>
    </div>
</section>


<?php
    get_footer();
