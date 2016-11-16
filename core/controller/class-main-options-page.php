<?php


class cc_main_options_page extends cc_base_controller
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
        $this->format_options();

        echo $this->view( 'main-options-page', array()) ;
    }



    public function init_fields()
    {
        register_setting( 'custom_cat_main', self::OPTIONS_NAME );

        $section_name = 'custom_cat_main_settings';
        add_settings_section($section_name, 'Custom Cat Settings', array($this, 'section_title_callback'), self::PAGE_SLUG);

        add_settings_field(
            'allow_one',
            'Allow one',
            array($this, 'allow_one_callback'),
            self::PAGE_SLUG,
            $section_name,
            array(
                'type' => 'input',
                'id' => 'cc-allow-one',
                'name' => self::OPTIONS_NAME . '[cc_allow_one][]',
                'taxonomies' => (new cc_taxonomy())->fetch_all_taxonomies(),
            )
        );

        add_settings_field(
            'hide_default_category_meta',
            'Hide default',
            array($this, 'hide_default_category_meta_callback'),
            self::PAGE_SLUG,
            $section_name,
            array(
                'id' => 'cc-hide-default-category-meta',
                'name' => self::OPTIONS_NAME . '[cc_hide_default_category_meta]'
            )
        );

    }

    public function section_title_callback()
    {
        echo '';
    }

    public function allow_one_callback($parameters)
    {
        $html = '';

        foreach ($parameters['taxonomies'] as $taxonomy) {
            $current_value = '';
            if (!empty($this->options['cc_allow_one'][$taxonomy['slug']])) {
                $current_value = $this->options['cc_allow_one'][$taxonomy['slug']];
            }

            $html .= '<input 
                        type="checkbox" 
                        ' . checked($current_value, $taxonomy['slug'], false) . '
                        name="' . $parameters['name'] . '"
                        value="' . $taxonomy['slug'] . '">' . $taxonomy['name'] . '<br>';
        }

        $html .= '<span>Limit post with only one taxonomy term</span>';
        echo $html;
    }

    public function hide_default_category_meta_callback($parameters)
    {
        $html = '';

        $current_value = '';
        if (!empty($this->options['cc_hide_default_category_meta'])) {
            $current_value = $this->options['cc_hide_default_category_meta'];
        }

        $html .= '<input
                    type="checkbox"
                    name="' . $parameters['name'] . '"
                    value="1"
                    '. checked($current_value, '1', false) . '
                    > Hides default category meta box';

        echo $html;
    }

    private function format_options()
    {
        if (!empty($this->options['cc_allow_one'])) {
            $selected_items = $this->options['cc_allow_one'];
            $formattedValues = array();
            foreach($selected_items as $selected_item_key => $selected_item) {
                $formattedValues[$selected_item] = $selected_item;
            }
            if (!empty($formattedValues)) {
                $this->options['cc_allow_one'] = $formattedValues;
            }
        }
    }
}

if (is_admin()) {
    new cc_main_options_page();
}
