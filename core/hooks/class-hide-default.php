<?php


class cc_hide_default
{
    public function __construct()
    {
        add_action('admin_init', array($this, 'init'));
    }

    public function init()
    {
        $hide_default = (new cc_options())->get_option(cc_main_options_page::OPTIONS_NAME, 'cc_hide_default_category_meta');
        if ($hide_default == '1') {
            remove_meta_box('categorydiv', array('post', 'page'), 'normal');
        }
    }
}
(new cc_hide_default());