<?php declare( strict_types = 1 );


class class_main_options_page extends cc_base_controller
{
    const PAGE_SLUG = 'custom-cat';
    const OPTIONS_NAME = 'custom_cat_options';

    private $options = [];


    public function __construct() {
        add_action('admin_menu', array($this, 'add_plugin_page'));
        add_action('admin_init', array($this, 'init_fields'));
    }

    protected function include_styles() {
        // TODO: Implement include_styles() method.
    }

    protected function include_script() {
        // TODO: Implement include_script() method.
    }

    protected function init_hooks() {
        // TODO: Implement init_hooks() method.
    }

    public function add_plugin_page()
    {
        add_menu_page('Custom Cat', 'Custom Cat', 'administrator', self::PAGE_SLUG);

        add_submenu_page('Custom Cat', 'Custom Cat', 'Custom Cat', 'administrator', self::PAGE_SLUG, array($this, 'create_page'));
    }

    public function create_page()
    {
        $this->options = get_option( self::OPTIONS_NAME );
        $this->format();
        var_dump($this->options);

        echo $this->view( 'main-options-page', array()) ;
    }



    public function init_fields()
    {
        register_setting( 'custom_cat_main', self::OPTIONS_NAME );

        $section_name = 'custom_cat_main_settings';
        add_settings_section($section_name, 'Title', array($this, 'section_title_callback'), self::PAGE_SLUG);

        add_settings_field(
            'allow_one',
            'Allow One',
            array($this, 'allow_one_callback'),
            self::PAGE_SLUG,
            $section_name,
            array(
                'type' => 'input',
                'id' => 'cc-allow-one',
                'name' => self::OPTIONS_NAME . '[cc_allow_one][]',
                'taxonomies' => array(
                    array('name' => 'category'),
                    array('name' => 'category1'),
                )
            )
        );

    }

    public function section_title_callback()
    {
        echo 'Section title';
    }

    public function allow_one_callback($parameters)
    {
        $html = '';

        foreach ($parameters['taxonomies'] as $taxonomy) {
            $html .= '<input 
                        type="checkbox" 
                        ' . checked('category', $taxonomy['name'], false) . '
                        name="' . $parameters['name'] . '"
                        value="' . $taxonomy['name'] . '">' . $taxonomy['name'] . '<br>';
        }
        echo $html;
    }

    private function format() {
    }
}

if (is_admin()) {
    new class_main_options_page();
}
