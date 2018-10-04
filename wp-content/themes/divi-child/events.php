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
                    <ul class="events_filter-list">
                        <li>Показувати спочатку:</li>
                        <li class="dropdown">
                            <a href="#" class="dropdown-toggle dropdown-toggle_cust" data-toggle="dropdown" aria-expanded="false">Серпень<span class="caret"></span></a>
                            <ul class="dropdown-menu dropdown-menu_cust" x-placement="top-start" style="position: absolute; will-change: transform; top: 0px; left: 0px; transform: translate3d(0px, -170px, 0px);">
                                <li><a href="#">Вересень</a></li>
                                <li><a href="#">Жовтень</a></li>
                                <li><a href="#">Листопад</a></li>
                            </ul>
                        </li>
                        <li class="dropdown dropdown_cust">
                            <span class="dropdown-toggle dropdown-toggle_cust">Всі міста<span class="caret"></span></span>
                            <ul class="dropdown-menu dropdown-menu_cust">
                                <li><a href="#" data-type="lviv">Львів</a></li>
                                <li><a href="#" data-type="kyiv">Київ</a></li>
                                <li><a href="#" data-type="dnipro">Дніпро</a></li>
                            </ul>
                        </li>
                    </ul>

                    <?php
                    $city = '';

                    ?>

                    <form action="" method="get">
                        <select name="date" onchange="this.form.submit()">
                            <option value="all-date" selected >Всі місяці</option>
                            <option value="01">Січень</option>
                            <option value="02">Лютий</option>
                            <option value="03">Березень</option>
                            <option value="04">Квітень</option>
                            <option value="05">Травень</option>
                            <option value="06">Червень</option>
                            <option value="07">Липень</option>
                            <option value="08">Серпень</option>
                            <option value="09">Вересень</option>
                            <option value="10">Жовтень</option>
                            <option value="11">Листопад</option>
                            <option value="12">Грудень</option>
                        </select>
                        <select name="city" onchange="this.form.submit()">
                            <option value="all-city" selected >Всі міста</option>
                            <option value="lviv">Львів</option>
                            <option value="kyiv">Київ</option>
                            <option value="dnipro">Дніпро</option>
                        </select>
                    </form>

                </div>
            </div>
        </div>
        <div class="row">
        <?php if ( have_posts() ) : while ( have_posts() ) : the_post();

    $date = get_field('date');
    $month = explode("/", $date)[0];
    $year = explode("/", $date)[2];
    var_dump($year);
        ?>


            <?php



            $city = $_GET['city'];
            $date = $_GET['date'];

            $posts = get_posts(array(
                'posts_per_page'	=> -1,
//                'meta_key'			=> 'date',
//                'mate_value'        => $date,
                'orderby'			=> 'meta_value',
                'order'				=> 'ASC',
                'category'          => 17,
//                'meta_query'	=> array(
//                    'relation'		=> 'AND',
//                    array(
//                        'key'		=> 'city',
//                        'value'		=> $city,
//                        'compare'	=> '='
//                    ),
//                    array(
//                        'key'		=> 'date',
//                        'value'		=> $month . '',
//                        'compare'	=> '>'
//                    )
//                )
            ));

            if( $posts ):
                ?>

                <ul>

                    <?php foreach( $posts as $post ):

                        setup_postdata( $post );

//                    $date = get_field('date');
//                    $month = explode("/", $date)[0];
//                    $year = explode("/", $date)[2];
//                    var_dump($year);

                        ?>
                        <li>
                            <span><?php the_title(); ?> (date: <?php the_field('date'); ?>)</span>
                        </li>

                    <?php endforeach; ?>

                </ul>

                <?php wp_reset_postdata(); ?>

            <?php endif; ?>


<?php
//
//            $args = array(
//                'numberposts' => 0,
//                'order'    => 'DESC',
//                'category'    => 17
//            );
//
//            $posts = get_posts( $args );
//
//            if (!empty($posts)) {
//                foreach ($posts as $post) {
//                    $events_date = $post;
//                    ?>
<!--                    <div --><?php //post_class('col-md-3 col-sm-6'); ?><!-- >-->
<!--                        <a href="--><?php //the_permalink(); ?><!--" class="">-->
<!--                            <div class="blog_item">-->
<!--                                <div class="img-wrapper">-->
<!--                                    --><?php //the_post_thumbnail(); ?>
<!--                                </div>-->
<!--                                <div class="content">-->
<!--                                    <div class="date">-->
<!--                                        <h5 class="date_txt"><span>29.07.2017</span>Lviv</h5>-->
<!--                                    </div>-->
<!--                                    <div class="content-text">-->
<!--                                        <h4 class="event_tittle">Vestibulum dapibus elit sollicitudin</h4>-->
<!--                                        <p class="event_brief">Phasellus tincidunt dictum ligula et auctor. Sed dapibus justo tortor, ut ultricies felis convallis luctus. Sed at arcu viverra, maximus dui ultrices, porttitor nisi.</p>-->
<!--                                    </div>-->
<!--                                </div>-->
<!--                            </div>-->
<!--                        </a>-->
<!--                    </div>-->
<!--                --><?php //}
//            }
//            ?>
        </div>
    </div>
</section>


<?php endwhile; else: ?>
    <p><?php _e('Sorry, no posts matched your criteria.'); ?></p>
<?php endif; ?>
<?php
    get_footer();
