<?php

class ET_Builder_Module_SocIcon extends ET_Builder_Module_Type_PostBased {
    function init() {
        $this->name       = 'Soc Icons';
        $this->slug       = 'et_pb_soc_icon';
        $this->vb_support = 'on';
        $this->main_css_element = '%%order_class%% .et_pb_post';

        $this->settings_modal_toggles = array(
            'general'  => array(
                'toggles' => array(
                    'main_content' => esc_html__( 'Content', 'et_builder' ),
                    'elements'     => esc_html__( 'Elements', 'et_builder' ),
                    'background'   => esc_html__( 'Background', 'et_builder' ),
                ),
            ),
            'advanced' => array(
                'toggles' => array(
                    'layout'  => esc_html__( 'Layout', 'et_builder' ),
                    'overlay' => esc_html__( 'Overlay', 'et_builder' ),
                    'image' => array(
                        'title' => esc_html__( 'Image', 'et_builder' ),
                        'priority' => 51,
                    ),
                    'text'    => array(
                        'title'    => esc_html__( 'Text', 'et_builder' ),
                        'priority' => 49,
                    ),
                ),
            ),
        );
    }

    function render( $attrs, $content = null, $render_slug ) {

        ob_start();

        query_posts( $args );
        ?>

        <?php

        get_template_part( '/includes/social_icons' );


        wp_reset_query();

        $posts = ob_get_contents();

        ob_end_clean();

        // Remove automatically added classnames
        $this->remove_classname( array(
            $render_slug,
        ) );

            // Module classname
            $this->add_classname( array(
                'et_pb_blog_grid_wrapper',
            ) );

            // Remove auto-added classname for module wrapper because on grid mode these classnames
            // are placed one level below module wrapper
            $this->remove_classname( array(
                'et_pb_section_video',
                'et_pb_preload',
                'et_pb_section_parallax',
            ) );

            // Inner module wrapper classname
            $inner_wrap_classname = array(
                'et_pb_blog_grid',
                'clearfix',
                "et_pb_bg_layout_{$background_layout}",
                $this->get_text_orientation_classname(),
            );


            $output = sprintf(
                '<div%4$s class="%5$s">
					<div class="%1$s">
					    %2$s
				    </div>
				    </div>',
                esc_attr( implode( ' ', $inner_wrap_classname ) ),
                $posts,
                ( ! $container_is_closed ? '</div> <!-- .et_pb_posts -->' : '' ),
                $this->module_id(),
                $this->module_classname( $render_slug ),
                $this->drop_shadow_back_compatibility( $render_slug )
            );


        // Restore $wp_filter
        $wp_filter = $wp_filter_cache;
        unset($wp_filter_cache);

        // Restore global $post into its original state when et_pb_blog shortcode ends to avoid
        // the rest of the page uses incorrect global $post variable
        $post = $post_cache;

        return $output;
    }

    public function process_box_shadow( $function_name ) {
        /**
         * @var ET_Builder_Module_Field_BoxShadow $boxShadow
         */
        $boxShadow = ET_Builder_Module_Fields_Factory::get( 'BoxShadow' );
        $selector = '.' . self::get_module_order_class( $function_name );

        if ( isset( $this->props['fullwidth'] ) && $this->props['fullwidth'] === 'off' ) {
            $selector .= ' article.et_pb_post';
        }

        self::set_style( $function_name, $boxShadow->get_style( $selector, $this->props ) );
    }

    /**
     * Since the styling file is not updated until the author updates the page/post,
     * we should keep the drop shadow visible.
     *
     * @param string $functions_name
     *
     * @return string
     */
    private function drop_shadow_back_compatibility( $functions_name ) {
        $utils = ET_Core_Data_Utils::instance();
        $atts  = $this->props;

        if (
            version_compare( $utils->array_get( $atts, '_builder_version', '3.0.93' ), '3.0.94', 'lt' )
            &&
            'on' !== $utils->array_get( $atts, 'fullwidth' )
            &&
            'on' === $utils->array_get( $atts, 'use_dropshadow' )
        ) {
            $class = self::get_module_order_class( $functions_name );

            return sprintf(
                '<style>%1$s</style>',
                sprintf( '.%1$s  article.et_pb_post { box-shadow: 0 1px 5px rgba(0,0,0,.1) }', esc_html( $class ) )
            );
        }

        return '';
    }
}

new ET_Builder_Module_SocIcon;
