<?php
/*
Plugin Name: Custom Cat
Plugin URI: http://blog.eseak.com
Description: Test
Author: R. Mohamed Asfer
Version: 0.1
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

//require_once 'custom-cat-xhr.php';

add_action('admin_enqueue_scripts', function(){
//    wp_enqueue_script('cc-chosen-js', CC_PLUGIN_URI . 'assets/library/chosen/chosen.jquery.js', ['jquery-core']);
//    wp_enqueue_script('cc-vue-js', CC_PLUGIN_URI . 'assets/library/vue.js', ['jquery-core']);
//    wp_enqueue_script('cc-main-js', CC_PLUGIN_URI . 'assets/js/main.js', ['jquery-core'], false, true);
//
//    wp_enqueue_style('cc-chosen-css', CC_PLUGIN_URI . 'assets/library/chosen/chosen.min.css');
//    wp_enqueue_style('cc-main-css', CC_PLUGIN_URI . 'assets/css/main.css');
//
//    wp_localize_script('ajax-script', 'ajaxObject', ['ajaxUrl' => admin_url('admin-ajax.php')]);
});

add_action('add_meta_boxes', function(){
//    add_meta_box('custom-cat-box', 'Categories', 'custom_cat_box_content', null, 'normal', 'high');
});

function custom_cat_box_content()
{
//    $available_taxonomies = build_available_taxonomy();
//
//    global $post;
//    $post_id = $post->ID; //fv
//
//    require_once(CC_PLUGIN_DIR_URI . 'view/custom-cat-box-content.php');
}

function build_available_taxonomy()
{
//    $available_taxonomies = array();
//    global $post;
//    $postId = $post->ID;
//    $taxonomies_of_currentPost = get_object_taxonomies($post->post_type, 'names');
//    foreach ($taxonomies_of_currentPost as $taxonomy_name) {
//        if (in_array($taxonomy_name, ['post_tag', 'post_format'])) {
//            continue;
//        }
//
//        $available_taxonomies[$taxonomy_name] = [];
//        $available_taxonomies[$taxonomy_name]['available_terms_list'] = fetch_all_available_taxonomies($taxonomy_name); //fv to populate select box
//        $available_taxonomies[$taxonomy_name]['current_terms_list'] = fetch_all_terms_of_post($postId, $taxonomy_name); // fv
//    }
//    return $available_taxonomies;
}

function fetch_all_available_taxonomies($taxonomy)
{
//    $categories = get_categories(['taxonomy' => $taxonomy, 'orderby' => 'count', 'hide_empty' => 0]);
//    $category_list = array(); //fv
//    foreach ($categories as $category) {
//        $category_list[] = ['name' => $category->name, 'value' => $category->slug];
//    }
//    return $category_list;
}

function fetch_all_terms_of_post($postId, $taxonomy)
{
//    $results = wp_get_object_terms($postId, $taxonomy, [
//        'orderby' => 'count'
//    ]);
//
//    $all_terms = array();
//    foreach ($results as $term) {
//        $all_terms[] = $term->slug;
//    }
//    return $all_terms;
}