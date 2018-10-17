<div class="sidebar">
    <div class="sidebar_top">
        <h3 class="sidebar_header">Зараз читають</h3>
    <?php
    $categories = get_categories( array(
        'type'         => 'post',
        'child_of'     => 6,
        'parent'       => '',
        'orderby'      => 'id',
        'order'        => 'ASC',
        'hide_empty'   => 1,
        'hierarchical' => 1,
        'exclude'      => '',
        'include'      => '',
        'number'       => 0,
        'taxonomy'     => 'category',
        'pad_counts'   => false,
    ) );
    ?>

        <ul class="sidebar_top-list">
            <?php
            if ($categories) {
                foreach ($categories as $cat) {

                    $cat_id = $cat->cat_ID;
                    $cat_name = $cat->name;
                    $category_link = get_category_link($cat_id);

                    echo "<li><a href=" . $category_link . ">$cat_name<i class=\"demo-icon icon-arrow-right\"></i></a></li>";
                }
            }
            ?>
        </ul>
    </div>

    <div class="sidebar_contact-box">
        <h4 class="cbox_txt">Маєш цікаву історію? Розкажи редактору</h4>
        <a href="#" class="cbox_btn" data-toggle="modal" data-target="#sidebarModal"> Написати</a>
    </div>

    <div class="sidebar_events_box">
        <h3 class="sidebar_header">Найближчі події</h3>
        <ul class="sidebar_events-list">
            <?php
            $args = array(
                'posts_per_page' => 4,
                'category'       => 17,
                'orderby'        => 'meta_value_num',
                'order'          => 'ASC',
                'meta_query'     => array(
                    array(
                        'key'     => 'date',
//                        'compare'  => 'REGEXP',
//                        'value'    => '[0-9]{4}' . $month . '[0-9]{2}',
                    )
                )
            );
            query_posts($args);
            if (have_posts()) :
            while (have_posts()) : the_post();
            $date = get_field('date');
            ?>
                <li>
                    <a href="<?php the_permalink(); ?>" class="event_url">
                        <span class="event_time"><?php echo $date; ?></span>
                        <span class="event_tittle"><?php the_title(); ?></span>
                        <i class="demo-icon icon-arrow-right"></i>
                    </a>
                </li>
            <?php
            endwhile;
            endif;
            ?>
        </ul>
    </div>
</div>