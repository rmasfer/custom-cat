<?php

abstract class cc_base_controller
{
    abstract protected function include_styles();
    abstract protected function include_script();
    abstract protected function init_hooks();
}