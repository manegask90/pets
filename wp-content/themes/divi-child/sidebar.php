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
</div>