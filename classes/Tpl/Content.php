<?php

/**
 * Description of Layout
 *
 * @author studio
 */
class Tpl_Content {

    private /** content items  */
            $options = array('site_slug' => 'Cover Slug', 'introduction' => "Intro", 'elevator_pitch' => "Elevator Pitch"),
            $post_type = 'page',
            /** post type name */
            $post_type_name = 'Theme Content',
            /** Section id */
            $section_id = 'layout_content',
            /** post type label */
            $section_name = 'Layout Content',
            /** prefix */
            $prefix = 'lc_';

    public function set_options($options) {
        $this->options = $options;
        return $this;
    }

    public function set_section_id($type_name) {
        $this->section_id = $type_name;
        return $this;
    }

    public function set_post_type_name($post_type_name) {
        $this->post_type_name = $post_type_name;
        return $this;
    }

    public function set_post_type($post_type) {
        $this->post_type = $post_type;
        return $this;
    }

    public function set_section_name($type_name) {
        $this->section_name = $type_name;
        return $this;
    }

    public function set_prefix($prefix) {
        $this->prefix = $prefix;
        return $this;
    }

    public function __construct() {

    }

    /**
     * Factroy pattern
     * ->create_options() to use deault options
     * ->set_options()->create_options() to create your own options
     * ->set_post_type() for new post_type
     * peruse class for other options
     * @return \Basejump_Theme_Content
     */
    public static function factory() {

        $factory = new Tpl_Content();
        return $factory;
    }

    /**
     * Create options
     * @param array $options - array(pitch => Elevator Pitch, intro => Introduction);
     */
    public function create_options($options = null) {

        if (isset($options) and is_array($options))
            $this->set_options($options);

        if (!post_type_exists($this->post_type))
            $this->create_post_type();

        $this->options();
    }

    public function create_post_type() {


        Post_CustomTypes::factory($this->post_type)
                ->set_menu_postion(60)
                ->set_exclude_from_search(TRUE)
                ->set_show_in_nav_menus(FALSE)
                ->set_supports(array('title', 'editor', 'thumbnail'))
                ->set_has_archive(FALSE)
                ->register_post_type($this->post_type_name, NULL, false);
    }

    public function options() {


        /**
         * adds a section
         * if not set simply use current section id
         * section_id is required
         * */
        if (isset($this->section_name)):
            $cp_layout = Customizer_Settings::add_section($this->section_id, $this->section_name, 'Manage theme(s) layout content', 100);
        else :
            $cp_layout = $this->section_id;
        endif;


        /**
         * create fields from options
         */
        if (!is_array($this->options))
            return;
        foreach ($this->options as $id => $name) {

            /** add selections control for post(s) * */
            Customizer_Settings::add_option($cp_layout, $id, $name, '')
                    ->set_control_args(array('post_type' => $this->post_type))
                    ->customizer('post_selections');
        }
    }

    /**
     * Grabs, displays post created for use in theme(s) layout
     * @param string $option_name
     * @return post object / false
     */
    public static function get_option($option_name) {

        $option = get_theme_mod($option_name);
        $page = get_post($option);
        if (isset($page)):
            return $page;
        else :
            return false;
        endif;
    }

}

