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
            <li>
                <a href="#" class="event_url">
                    <span class="event_time">14.04.2017</span>
                    <span class="event_tittle">Змагання службових вівчарок з усіх регіонів України</span>
                    <i class="demo-icon icon-arrow-right"></i>
                </a>
            </li>
            <li>
                <a href="#" class="event_url">
                    <span class="event_time">14.04.2017</span>
                    <span class="event_tittle">Виставка котів України та Европи</span>
                    <i class="demo-icon icon-arrow-right"></i>
                </a>
            </li>
            <li>
                <a href="#" class="event_url">
                    <span class="event_time">14.04.2017</span>
                    <span class="event_tittle">Змагання службових вівчарок з усіх регіонів України</span>
                    <i class="demo-icon icon-arrow-right"></i>
                </a>
            </li>
            <li>
                <a href="#" class="event_url">
                    <span class="event_time">14.04.2017</span>
                    <span class="event_tittle">Змагання службових вівчарок з усіх регіонів України</span>
                    <i class="demo-icon icon-arrow-right"></i>
                </a>
            </li>

        </ul>
    </div>
</div>