<?php

class SIMP_SimpleHeader extends ET_Builder_Module
{
    public $slug = 'simp_simple_header';
    public $vb_support = 'on';

    public function init()
    {
        $this->name = esc_html__('Simple Header', 'simp-simple-extension');
    }

    public function get_fields()
    {
        return array();
    }

    public function render($unprocessed_props, $content = null, $render_slug)
    {
    }
}

new SIMP_SimpleHeader;