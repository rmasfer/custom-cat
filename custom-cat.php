<?php
/*
Plugin Name: Custom Cat
Description: Customised taxonomy selector for WordPress
Author: R. Mohamed Asfer
Version: 1.0.0
*/
if (!defined('CC_PLUGIN_URI')) {
    define('CC_PLUGIN_URI', plugin_dir_url(__FILE__));
}

if (!defined('CC_PLUGIN_DIR_URI')) {
    define('CC_PLUGIN_DIR_URI', plugin_dir_path(__FILE__));
}

class custom_cat {
    public function __construct()
    {
        add_action('init', array($this, 'init'), 1);
    }

    public function init()
    {
        // controller
        require_once CC_PLUGIN_DIR_URI . 'core/controller/class-base-controller.php';
        require_once CC_PLUGIN_DIR_URI . 'core/controller/class-post-meta.php';
        require_once CC_PLUGIN_DIR_URI . 'core/controller/class-post-meta-xhr.php';
    }
}

new custom_cat();