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

require_once 'custom-cat-xhr.php';

add_action('admin_enqueue_scripts', function(){
    wp_enqueue_script('cc-chosen-js', CC_PLUGIN_URI . 'assets/library/chosen/chosen.jquery.js', ['jquery-core']);
    wp_enqueue_script('cc-vue-js', CC_PLUGIN_URI . 'assets/library/vue.js', ['jquery-core']);
    wp_enqueue_script('cc-main-js', CC_PLUGIN_URI . 'assets/js/main.js', ['jquery-core'], false, true);

    wp_enqueue_style('cc-chosen-css', CC_PLUGIN_URI . 'assets/library/chosen/chosen.min.css');
    wp_enqueue_style('cc-main-css', CC_PLUGIN_URI . 'assets/css/main.css');

    wp_localize_script('ajax-script', 'ajaxObject', ['ajaxUrl' => admin_url('admin-ajax.php')]);
});

add_action('add_meta_boxes', function(){
    add_meta_box('custom-cat-box', 'Categories', 'custom_cat_box_content', null, 'normal', 'high');
});

function custom_cat_box_content()
{
    $availableTaxonomies = buildAvailableTaxonomy();

    global $post;
    $postId = $post->ID; //fv

    require_once(CC_PLUGIN_DIR_URI . 'view/custom-cat-box-content.php');
}

function buildAvailableTaxonomy()
{
    $availableTaxonomies = array();
    global $post;
    $postId = $post->ID;
    $taxonomiesOfCurrentPost = get_object_taxonomies($post->post_type, 'names');
    foreach ($taxonomiesOfCurrentPost as $taxonomyName) {
        if (in_array($taxonomyName, ['post_tag', 'post_format'])) {
            continue;
        }

        $availableTaxonomies[$taxonomyName] = [];
        $availableTaxonomies[$taxonomyName]['availableTermsList'] = fetch_all_available_taxonomies($taxonomyName); //fv to populate select box
        $availableTaxonomies[$taxonomyName]['currentTermsList'] = fetch_all_terms_of_post($postId, $taxonomyName); // fv
    }
    return $availableTaxonomies;
}

function fetch_all_available_taxonomies($taxonomy)
{
    $categories = get_categories(['taxonomy' => $taxonomy, 'orderby' => 'count', 'hide_empty' => 0]);
    $categoryList = array(); //fv
    foreach ($categories as $category) {
        $categoryList[] = ['name' => $category->name, 'value' => $category->slug];
    }
    return $categoryList;
}

function fetch_all_terms_of_post($postId, $taxonomy)
{
    $results = wp_get_object_terms($postId, $taxonomy, [
        'orderby' => 'count'
    ]);

    $allTerms = array();
    foreach ($results as $term) {
        $allTerms[] = $term->slug;
    }
    return $allTerms;
}