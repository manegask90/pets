<div class="sidebar_events_box">
    <h3 class="sidebar_header">Найближчі події</h3>
    <ul class="sidebar_events-list">
        <?php
        $args = array(
            'posts_per_page' => 4,
            'category' => 17,
            'orderby' => 'meta_value_num',
            'order' => 'ASC',
            'meta_query' => array(
                array(
                    'key' => 'date',
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