<?php

/**
 * Responsible add custom cat meta box to post editing page
 */
class cc_post_meta extends cc_base_controller
{
    public function __construct()
    {
        $this->init_hooks();
        $this->include_styles();
        $this->include_script();
    }

    protected function include_styles()
    {
        wp_enqueue_style('cc-chosen-css', CC_PLUGIN_URI . 'assets/library/chosen/chosen.min.css');
        wp_enqueue_style('cc-main-css', CC_PLUGIN_URI . 'assets/css/main.css');
    }

    protected function include_script()
    {
        wp_enqueue_script('cc-chosen-js', CC_PLUGIN_URI . 'assets/library/chosen/chosen.jquery.js', ['jquery-core']);
        wp_enqueue_script('cc-vue-js', CC_PLUGIN_URI . 'assets/library/vue.js', ['jquery-core']);
        wp_enqueue_script('cc-main-js', CC_PLUGIN_URI . 'assets/js/main.js', ['jquery-core'], false, true);

        wp_localize_script('ajax-script', 'ajaxObject', ['ajaxUrl' => admin_url('admin-ajax.php')]);
    }

    protected function init_hooks()
    {
        add_action('add_meta_boxes', array($this, 'init_meta_boxes'));
    }

    public function init_meta_boxes()
    {
        add_meta_box('custom-cat-box', 'Custom Cat', array($this, 'custom_cat_box_content'), null, 'normal', 'high');
    }

    public function custom_cat_box_content()
    {
        $available_taxonomies = $this->build_available_taxonomy();

        global $post;
        $post_id = $post->ID; //fv

        require_once(CC_PLUGIN_DIR_URI . 'view/custom-cat-box-content.php');
    }

    private function build_available_taxonomy()
    {
        $available_taxonomies = array();
        global $post;
        $postId = $post->ID;
        $taxonomies_of_currentPost = get_object_taxonomies($post->post_type, 'names');
        foreach ($taxonomies_of_currentPost as $taxonomy_name) {
            if (in_array($taxonomy_name, ['post_tag', 'post_format'])) {
                continue;
            }

            $available_taxonomies[$taxonomy_name] = [];
            $available_taxonomies[$taxonomy_name]['available_terms_list'] = $this->fetch_all_available_taxonomies($taxonomy_name); //fv to populate select box
            $available_taxonomies[$taxonomy_name]['current_terms_list'] = $this->fetch_all_terms_of_post($postId, $taxonomy_name); // fv
        }
        return $available_taxonomies;
    }

    private function fetch_all_available_taxonomies($taxonomy)
    {
        $categories = get_categories(['taxonomy' => $taxonomy, 'orderby' => 'count', 'hide_empty' => 0]);
        $category_list = array(); //fv
        foreach ($categories as $category) {
            $category_list[] = ['name' => $category->name, 'value' => $category->slug];
        }
        return $category_list;
    }

    private function fetch_all_terms_of_post($postId, $taxonomy)
    {
        $results = wp_get_object_terms($postId, $taxonomy, [
            'orderby' => 'count'
        ]);

        $all_terms = array();
        foreach ($results as $term) {
            $all_terms[] = $term->slug;
        }
        return $all_terms;
    }
}

new cc_post_meta();