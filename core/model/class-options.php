<?php


class cc_options
{
    public function get_option($parent_section, $option, $default = false)
    {
        $parent_options = get_option($parent_section);
        if (empty($parent_options)) {
            return $default;
        }

        if (empty($parent_options[$option])) {
            return $default;
        }

        return $parent_options[$option];
    }
}