<?php
add_action('wp_ajax_save_category', function(){
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
});

add_action('wp_ajax_insert_term', function(){
    if (empty($_POST['action']) || $_POST['action'] != 'insert_term') {
        echo json_encode(['status' => false]);
        die;
    }

    $createdTerms = wp_insert_term($_POST['term'], $_POST['taxonomy']);
    if (!is_array($createdTerms)) {
        echo json_encode(['status' => false]);
        die;
    }
    echo json_encode(['status' => true]);
    die;
});