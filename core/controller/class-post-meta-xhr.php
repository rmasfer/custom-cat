<?php

/**
 * Responsible to handle xhr for cc_post_meta
 */
class cc_post_meta_xhr
{
    public function __construct()
    {
        add_action('wp_ajax_save_category', array($this, 'save_category'));
        add_action('wp_ajax_insert_term', array($this, 'insert_term'));
    }

    public function save_category()
    {
        if (empty($_POST['action']) || $_POST['action'] != 'save_category') {
            echo json_encode(['status' => false]);
            die;
        }

        wp_set_object_terms($_POST['postId'], $_POST['categoriesToSave'], $_POST['taxonomy']);
        echo json_encode([
            'status' => true,
            'currentTerms' => $_POST['categoriesToSave'],
        ]);
        die;
    }

    public function insert_term()
    {
        if (empty($_POST['action']) || $_POST['action'] != 'insert_term') {
            echo json_encode(['status' => false]);
            die;
        }

        $created_terms = wp_insert_term($_POST['term'], $_POST['taxonomy'], array('slug' => $_POST['slug']));
        if (!is_array($created_terms)) {
            echo json_encode(['status' => false]);
            die;
        }
        echo json_encode(['status' => true]);
        die;
    }
}
new cc_post_meta_xhr();