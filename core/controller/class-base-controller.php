<?php

abstract class cc_base_controller
{
    abstract protected function include_styles();
    abstract protected function include_script();
    abstract protected function init_hooks();

    public function view($template, $data)
    {
        extract($data);
        ob_start();
        include CC_PLUGIN_DIR_URI . 'view/' . $template . '.php';
        $content = ob_get_contents();
        ob_end_clean();
        return $content;
    }
}