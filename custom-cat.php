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

if (!defined('CC_TEXT_DOMAIN')) {
    define('CC_TEXT_DOMAIN', 'custom_cat');
}

class custom_cat {
    public function __construct()
    {
        add_action('init', array($this, 'init'), 1);
    }

    public function init()
    {
        //helpers
        require_once CC_PLUGIN_DIR_URI . 'core/model/class-vue-serializer.php';


        require_once CC_PLUGIN_DIR_URI . 'core/model/class-taxonomy.php';
        require_once CC_PLUGIN_DIR_URI . 'core/model/class-options.php';

        // controller
        require_once CC_PLUGIN_DIR_URI . 'core/controller/class-base-controller.php';
        require_once CC_PLUGIN_DIR_URI . 'core/controller/class-post-meta.php';
        require_once CC_PLUGIN_DIR_URI . 'core/controller/class-post-meta-xhr.php';
        require_once CC_PLUGIN_DIR_URI . 'core/controller/class-main-options-page.php';

        // hooks
        require_once CC_PLUGIN_DIR_URI . 'core/hooks/class-hide-default.php';

    }
}

new custom_cat();