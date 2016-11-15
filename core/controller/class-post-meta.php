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
        add_meta_box('custom-cat-box', 'Custom Cat', array($this, 'custom_cat_box_content'), 'post', 'normal', 'high');
    }

    public function custom_cat_box_content()
    {
        $available_taxonomies = $this->build_available_taxonomy();

        global $post;
        $post_id = $post->ID;

        echo $this->view('custom-cat-box-content', array(
            'available_taxonomies' => $available_taxonomies,
            'post_id' => $post_id
        ));
    }

    private function build_available_taxonomy()
    {
        global $post;
        $post_id = $post->ID;
        $available_taxonomies = array();
        $allow_one_options = (new cc_options())->get_option(cc_main_options_page::OPTIONS_NAME, 'cc_allow_one', array());
        $taxonomies_of_currentPost = get_object_taxonomies($post->post_type, 'names');
        foreach ($taxonomies_of_currentPost as $taxonomy_name) {
            if (in_array($taxonomy_name, ['post_tag', 'post_format'])) {
                continue;
            }

            $allow_one = 'false';
            if (in_array($taxonomy_name, $allow_one_options)) {
                $allow_one = 'true';
            }

            $available_taxonomies[$taxonomy_name] = [];
            $available_taxonomies[$taxonomy_name]['available_terms_list'] = $this->fetch_all_available_taxonomies(
                $taxonomy_name
            );
            $available_taxonomies[$taxonomy_name]['current_terms_list'] = $this->fetch_all_terms_of_post(
                $post_id,
                $taxonomy_name
            );
            $available_taxonomies[$taxonomy_name]['allow_one'] = $allow_one;

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