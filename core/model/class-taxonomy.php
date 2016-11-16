<?php

class cc_taxonomy
{
    public function fetch_all_taxonomies()
    {
        $allTaxonomies = get_taxonomies();
        $taxonomies = array();
        foreach($allTaxonomies as $taxonomy) {
            if (in_array($taxonomy, array('post_tag', 'nav_menu', 'link_category', 'post_format'))) {
                continue;
            }
            $taxonomies[] = array(
                'name' => ucfirst($taxonomy),
                'slug' => $taxonomy
            );
        }
        return $taxonomies;
    }
}