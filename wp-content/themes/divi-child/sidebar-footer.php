<?php
if ( ! is_active_sidebar( 'sidebar-2' ) && ! is_active_sidebar( 'sidebar-3' ) && ! is_active_sidebar( 'sidebar-4' ) && ! is_active_sidebar( 'sidebar-5' ) )
    return;
?>

<div class="container">
    <div class="row">
        <?php
        $footer_sidebars = array('sidebar-2', 'sidebar-3', 'sidebar-4', 'sidebar-5');
        $date = date("Y");

        foreach ($footer_sidebars as $key => $footer_sidebar) :
            if ($key == '0') :
                echo '<div class="col-md-6 col-sm-12 footer_info">';
                dynamic_sidebar($footer_sidebar);
                echo '</div>';
            elseif ($key == '1') :
                echo '<div class="col-md-3 offset-md-3 footer_cont">';
                dynamic_sidebar($footer_sidebar);
                get_template_part( '/includes/social_icons' );
                echo do_shortcode( ' [newsletter_form button_label="G"][newsletter_field name="email"][/newsletter_form] ' );
                echo '</div>';
            elseif ($key == '2') :
                echo '<div class="col-md-6 col-sm-12">';
                echo '<div class="footer_bottom">';
                echo '<div class="footer_copyright">© ' . $date . ' PetsUkraine. Всі права захищені</div>';
                if (has_nav_menu('footer-menu')) : ?>

                    <div id="et-footer-nav">
                        <?php
                        wp_nav_menu(array(
                            'theme_location' => 'footer-menu',
                            'depth' => '1',
                            'menu_class' => 'bottom-nav',
                            'container' => '',
                            'fallback_cb' => '',
                        ));
                        ?>
                    </div> <!-- #et-footer-nav -->

                <?php endif;
                echo '</div>';
                echo '</div>';
            endif;
        endforeach;
        ?>
    </div>
</div>    <!-- .container -->